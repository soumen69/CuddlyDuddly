<?php

namespace App\Services\Order;

use App\Domain\Order\DTO\OrderPlacementData;
use App\Domain\Order\DTO\OrderItemData;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\ShippingLog;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ShipmentBuilder
{
    /**
     * Parent order.
     */
    protected Order $order;

    /**
     * Checkout DTO.
     */
    protected OrderPlacementData $placement;

    /**
     * Created shipments.
     *
     * @var Collection<int, Shipment>
     */
    protected Collection $shipments;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->shipments = collect();
    }

    /**
     * Build every shipment required for this order.
     *
     * One shipment per seller.
     */
    public function build(
        Order $order,
        OrderPlacementData $placement
    ): Collection {

        $this->order = $order;

        $this->placement = $placement;

        foreach (

            $placement->groupedBySeller()

            as

            $sellerId => $items

        ) {

            $shipment = $this->createShipment(

                (int) $sellerId,

                $items

            );

            $this->shipments->push($shipment);
        }

        return $this->shipments;
    }

    /**
     * Create seller shipment.
     */
    protected function createShipment(
        int $sellerId,
        Collection $items
    ): Shipment {

        $shipment = Shipment::create([

            'order_id' => $this->order->id,

            'seller_id' => $sellerId,

            'provider' => config(
                'logistics.provider',
                'mock'
            ),

            'status' => 'pending',

            'settlement_status' => 'on_hold',

            'hold_until' => now()->addDays(7),

            'awb_number' => $this->generateAwb(),

            'tracking_number' => $this->generateTracking(),

            'provider_reference' => (string) Str::uuid(),

            'shipment_id' => strtoupper(
                Str::random(16)
            ),

            'provider_metadata' => [

                'mock' =>

                config(
                    'logistics.provider'
                ) === 'mock',

                'seller_id' => $sellerId,

                'items' => $items->count(),

                'quantity' => $items->sum(
                    fn(OrderItemData $item)
                    => $item->quantity
                ),

                'subtotal' => $items->sum(
                    fn(OrderItemData $item)
                    => $item->subtotal()
                ),

                'commission' => $items->sum(
                    fn(OrderItemData $item)
                    => $item->commissionAmount()
                ),

                'seller_amount' => $items->sum(
                    fn(OrderItemData $item)
                    => $item->sellerAmount()
                ),

                'created_at' => now()

            ]

        ]);

        /*
        |--------------------------------------------------------------------------
        | Initial Shipment Event
        |--------------------------------------------------------------------------
        */

        ShippingLog::create([

            'order_id' => $this->order->id,

            'shipment_id' => $shipment->id,

            'provider' => $shipment->provider,

            'event_name' => 'ORDER_CREATED',

            'internal_status' => 'pending',

            'provider_status' => 'Shipment Created',

            'remarks' => 'Shipment created successfully.',

            'event_time' => now(),

            'payload' => [

                'shipment_id' => $shipment->id,

                'seller_id' => $sellerId,

                'provider' => $shipment->provider,

                'provider_reference' =>

                $shipment->provider_reference,

                'tracking_number' =>

                $shipment->tracking_number,

                'awb_number' =>

                $shipment->awb_number

            ]

        ]);

        return $shipment;
    }

    public function buildProviderPayload(
        Shipment $shipment,
        Collection $items
    ): array {

        return [

            'order_id' => $this->order->order_number,

            'shipment_id' => $shipment->shipment_id,

            'seller_id' => $shipment->seller_id,

            'payment_method' => $this->placement->paymentMethod,

            'shipping_address_id' => $this->placement->shippingAddressId,

            'total_quantity' => $items->sum(
                fn(OrderItemData $i) => $i->quantity
            ),

            'total_amount' => $items->sum(
                fn(OrderItemData $i) => $i->subtotal()
            ),

            'weight' => $this->calculateWeight($items),

            'items' => $items->map(function (OrderItemData $item) {

                return [

                    'product_id' => $item->productId,

                    'variant_id' => $item->variantId,

                    'seller_id' => $item->sellerId,

                    'quantity' => $item->quantity,

                    'price' => $item->price,

                    'subtotal' => $item->subtotal(),

                    'commission' => $item->commissionAmount(),

                    'seller_amount' => $item->sellerAmount(),

                    'name' => $item->productName,

                ];
            })->values()->toArray()

        ];
    }

    /**
     * Calculate shipment weight.
     *
     * Uses variant weight if available.
     * Falls back to 0.50kg per item.
     */
    protected function calculateWeight(
        Collection $items
    ): float {

        $weight = 0;

        foreach ($items as $item) {

            if ($item->variantId) {

                $variant = ProductVariant::find($item->variantId);

                if ($variant && $variant->weight) {

                    $weight +=
                        $variant->weight * $item->quantity;

                    continue;
                }
            }

            /*
             * Default mock weight
             */

            $weight +=
                0.50 * $item->quantity;
        }

        return round($weight, 2);
    }

    /**
     * Generate mock AWB.
     *
     * Real provider will replace this.
     */
    protected function generateAwb(): string
    {
        return 'AWB' .
            strtoupper(Str::random(10));
    }

    /**
     * Generate tracking number.
     */
    protected function generateTracking(): string
    {
        return 'TRK' .
            now()->format('ymd') .
            strtoupper(Str::random(8));
    }

    /**
     * Decide courier.
     *
     * Mock today.
     * Shiprocket tomorrow.
     */
    protected function chooseCourier(): array
    {
        if (
            config('logistics.provider') === 'mock'
        ) {

            return [

                'name' => 'Mock Express',

                'code' => 'MOCK'

            ];
        }

        /*
         * Shiprocket provider
         */

        return [

            'name' => 'Pending',

            'code' => 'SHIPROCKET'

        ];
    }

    /**
     * Update shipment after provider response.
     *
     * Works for both Mock and Shiprocket.
     */
    public function updateFromProvider(
        Shipment $shipment,
        array $response
    ): Shipment {

        $courier = $this->chooseCourier();

        $shipment->update([

            'courier_name' => $response['courier_name']
                ?? $courier['name'],

            'courier_code' => $response['courier_code']
                ?? $courier['code'],

            'tracking_number' => $response['tracking_number']
                ?? $shipment->tracking_number,

            'awb_number' => $response['awb_number']
                ?? $shipment->awb_number,

            'tracking_url' => $response['tracking_url']
                ?? null,

            'pickup_token' => $response['pickup_token']
                ?? null,

            'provider_reference' => $response['provider_reference']
                ?? $shipment->provider_reference,

            'provider_metadata' => array_merge(

                $shipment->provider_metadata ?? [],

                $response

            )

        ]);

        ShippingLog::create([

            'order_id' => $shipment->order_id,

            'shipment_id' => $shipment->id,

            'provider' => $shipment->provider,

            'event_name' => 'AWB_ASSIGNED',

            'internal_status' => 'awb_assigned',

            'provider_status' => 'AWB Assigned',

            'remarks' => 'AWB generated successfully.',

            'event_time' => now(),

            'payload' => $response

        ]);

        return $shipment->fresh();
    }

    /**
     * Refresh shipment financial summary.
     */
    public function refreshSummary(
        Shipment $shipment,
        Collection $items
    ): void {

        $shipment->provider_metadata = array_merge(

            $shipment->provider_metadata ?? [],

            [

                'items' => $items->count(),

                'quantity' => $items->sum(
                    fn(OrderItemData $i) => $i->quantity
                ),

                'subtotal' => $items->sum(
                    fn(OrderItemData $i) => $i->subtotal()
                ),

                'commission' => $items->sum(
                    fn(OrderItemData $i) => $i->commissionAmount()
                ),

                'seller_amount' => $items->sum(
                    fn(OrderItemData $i) => $i->sellerAmount()
                ),

                'weight' => $this->calculateWeight($items),

                'updated_at' => now(),

            ]

        );

        $shipment->save();
    }

    /**
     * Shipment lookup by seller.
     */
    public function keyBySeller(): Collection
    {
        return $this->shipments->keyBy('seller_id');
    }

    /**
     * Total shipments created.
     */
    public function count(): int
    {
        return $this->shipments->count();
    }

    /**
     * Return created shipments.
     */
    public function all(): Collection
    {
        return $this->shipments;
    }

    /**
     * Get shipment for seller.
     */
    public function forSeller(
        int $sellerId
    ): ?Shipment {

        return $this->shipments

            ->firstWhere(

                'seller_id',

                $sellerId

            );
    }

    /**
     * Mock provider?
     */
    protected function isMock(): bool
    {
        return config('logistics.provider', 'mock') === 'mock';
    }

    /**
     * Build complete provider payload map.
     *
     * One payload per shipment.
     */
    public function payloads(): Collection
    {
        return $this->shipments->map(function (Shipment $shipment) {

            $items = $this->placement
                ->groupedBySeller()
                ->get($shipment->seller_id);

            return [

                'shipment' => $shipment,

                'payload' => $this->buildProviderPayload(
                    $shipment,
                    $items
                )

            ];
        });
    }
}
