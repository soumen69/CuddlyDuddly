<?php

namespace App\Services\Order;

use App\Domain\Order\DTO\OrderPlacementData;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\ProductVariant;
use App\Models\Shipment;
use App\Models\ShippingLog;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\Order\OrderSummaryService;

class OrderPlacementService
{
    public function place(OrderPlacementData $data): Order
    {
        return DB::transaction(function () use ($data) {

            /*
            |--------------------------------------------------------------------------
            | Duplicate Payment Protection
            |--------------------------------------------------------------------------
            */

            if ($data->razorpayPaymentId) {

                $existing = Order::where(
                    'razorpay_payment_id',
                    $data->razorpayPaymentId
                )->first();

                if ($existing) {
                    return $this->hydrate($existing);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Amount Validation
            |--------------------------------------------------------------------------
            */

            if (!$data->isAmountValid()) {
                throw new Exception('Order amount mismatch.');
            }

            /*
            |--------------------------------------------------------------------------
            | Stock Validation
            |--------------------------------------------------------------------------
            */

            foreach ($data->items as $item) {

                if (!$item->hasEnoughStock()) {
                    throw new Exception(
                        "{$item->productName} is out of stock."
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Create Parent Order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([

                'user_id' => $data->userId,

                'shipping_address_id' => $data->shippingAddressId,

                'order_number' => $this->generateOrderNumber(),

                'total_amount' => $data->amount,

                'payment_method' => $data->paymentMethod,

                'payment_status' => $data->paymentStatus,

                'order_status' => 'placed',

                'razorpay_order_id' => $data->razorpayOrderId,

                'razorpay_payment_id' => $data->razorpayPaymentId,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Shipments (One Shipment Per Seller)
            |--------------------------------------------------------------------------
            */

            $shipmentBuilder = app(ShipmentBuilder::class);

            $shipmentCollection = $shipmentBuilder->build(
                $order,
                $data
            );

            $shipments = $shipmentCollection
                ->keyBy('seller_id')
                ->all();

            /*
            |--------------------------------------------------------------------------
            | Create Order Items
            |--------------------------------------------------------------------------
            */

            foreach ($data->items as $item) {

                /** @var Shipment $shipment */
                $shipment = $shipments[$item->sellerId];

                $orderItem = OrderItem::create([

                    'order_id' => $order->id,

                    'seller_id' => $item->sellerId,

                    'shipment_id' => $shipment->id,

                    'product_id' => $item->productId,

                    'product_variant_id' => $item->variantId,

                    'quantity' => $item->quantity,

                    'price' => $item->price,

                    'subtotal' => $item->subtotal(),

                    'commission_percent' => $item->commissionPercent,

                    'commission_snapshot' => $item->commissionPercent,

                    'commission_amount' => $item->commissionAmount(),

                    'seller_amount' => $item->sellerAmount(),

                    'settlement_status' => 'pending',

                    'item_status' => 'placed',

                    'metadata' => [

                        'shipment_id' => $shipment->id,

                        'seller_id' => $shipment->seller_id,

                        'provider' => $shipment->provider,

                        'ordered_at' => now(),

                        'status' => 'placed',

                        'lifecycle' => [

                            'confirmed_at' => null,

                            'packed_at' => null,

                            'picked_up_at' => null,

                            'shipped_at' => null,

                            'in_transit_at' => null,

                            'out_for_delivery_at' => null,

                            'delivered_at' => null,

                            'cancelled_at' => null,

                            'returned_at' => null,

                            'refunded_at' => null,

                            'replacement_at' => null,

                        ]

                    ]

                ]);

                /*
                |--------------------------------------------------------------------------
                | Deduct Inventory
                |--------------------------------------------------------------------------
                */

                if ($item->variantId) {

                    ProductVariant::where(
                        'id',
                        $item->variantId
                    )->decrement(
                        'stock',
                        $item->quantity
                    );
                } else {

                    Products::where(
                        'id',
                        $item->productId
                    )->decrement(
                        'stock',
                        $item->quantity
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update Shipment Financial Snapshot
            |--------------------------------------------------------------------------
            */

            foreach ($shipments as $shipment) {

                $shipmentItems = OrderItem::where(
                    'shipment_id',
                    $shipment->id
                )->get();

                $shipment->update([

                    'provider_metadata' => array_merge(

                        $shipment->provider_metadata ?? [],

                        [

                            'item_count' => $shipmentItems->count(),

                            'quantity' => $shipmentItems->sum('quantity'),

                            'subtotal' => $shipmentItems->sum('subtotal'),

                            'commission' => $shipmentItems->sum('commission_amount'),

                            'seller_amount' => $shipmentItems->sum('seller_amount'),

                            'updated_at' => now(),

                        ]

                    )

                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Update Parent Order Summary
            |--------------------------------------------------------------------------
            */

            app(OrderSummaryService::class)
                ->refresh($order);

            /*
            |--------------------------------------------------------------------------
            | Mark Cart Ordered
            |--------------------------------------------------------------------------
            */

            Cart::whereIn(
                'id',
                $data->items->pluck('cartId')
            )->update([
                'is_ordered' => true
            ]);

            Cart::where(
                'user_id',
                $data->userId
            )
                ->where(
                    'is_ordered',
                    true
                )
                ->delete();
            /*
            |--------------------------------------------------------------------------
            | Start Shipment Lifecycle
            |--------------------------------------------------------------------------
            */

            foreach ($shipments as $shipment) {

                if ($this->usingMockProvider()) {

                    app(MockCourierEngine::class)
                        ->start($shipment);
                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Real Provider
                    |--------------------------------------------------------------------------
                    |
                    | Shiprocket implementation will be plugged here.
                    | No business logic changes required.
                    |
                    */

                    // app(ShiprocketService::class)
                    //     ->createShipment($shipment);

                }
            }

            /*
            |--------------------------------------------------------------------------
            | Refresh Order Summary Again
            |--------------------------------------------------------------------------
            */

            app(OrderSummaryService::class)
                ->refresh($order);

            /*
            |--------------------------------------------------------------------------
            | Return Hydrated Order
            |--------------------------------------------------------------------------
            */

            return $this->hydrate($order);
        });
    }

    /**
     * Generate Marketplace Order Number.
     */
    protected function generateOrderNumber(): string
    {
        do {

            $number =
                'ORD-' .
                now()->format('ymd') .
                '-' .
                strtoupper(Str::random(8));
        } while (

            Order::where(
                'order_number',
                $number
            )->exists()

        );

        return $number;
    }

    /**
     * Reload complete order graph.
     */
    protected function hydrate(
        Order $order
    ): Order {

        return $order->load([

            'shippingAddress',

            'shipments',

            'shipments.logs',

            'items',

            'items.product.primaryImage',

            'items.variant',

            'items.seller'

        ]);
    }

    /**
     * Detect logistics provider.
     */
    protected function usingMockProvider(): bool
    {
        return in_array(

            config(
                'logistics.provider',
                'mock'
            ),

            [

                'mock',

                'fake',

                'testing'

            ]

        );
    }

    /**
     * Shipment Metadata Builder.
     */
    protected function buildShipmentMetadata(
        Shipment $shipment,
        OrderPlacementData $data
    ): array {

        return [

            'provider' =>
            config('logistics.provider'),

            'environment' =>
            app()->environment(),

            'payment_method' =>
            $data->paymentMethod,

            'payment_status' =>
            $data->paymentStatus,

            'razorpay_order_id' =>
            $data->razorpayOrderId,

            'is_mock' =>
            $this->usingMockProvider(),

            'marketplace_version' =>
            'v1',

            'provider_version' =>
            1,

            'created_at' =>
            now(),

        ];
    }

    /**
     * Update provider metadata.
     */
    protected function updateShipmentMetadata(
        Shipment $shipment,
        array $data
    ): void {

        $shipment->update([

            'provider_metadata' => array_merge(

                $shipment->provider_metadata ?? [],

                $data

            )

        ]);
    }

    /**
     * Generic Shipment Logger.
     */
    protected function logShipment(
        Shipment $shipment,
        string $event,
        array $payload = []
    ): void {

        ShippingLog::create([

            'shipment_id' => $shipment->id,

            'order_id' => $shipment->order_id,

            'provider' => $shipment->provider,

            'event_name' => $event,

            'internal_status' => $shipment->status,

            'provider_status' => $event,

            'event_time' => now(),

            'payload' => array_merge(

                [

                    'provider' =>
                    $shipment->provider,

                    'shipment_status' =>
                    $shipment->status,

                    'logged_at' =>
                    now()

                ],

                $payload

            )

        ]);
    }
}
