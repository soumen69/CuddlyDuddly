<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\ShippingLog;
use Illuminate\Support\Facades\DB;
use App\Events\ShipmentCreated;
use App\Events\ShipmentPacked;
use App\Events\ShipmentShipped;
use App\Events\ShipmentDelivered;

class OrderStatusEngine
{
    protected OrderSummaryService $summaryService;
    public function __construct(
        OrderSummaryService $summaryService
    ) {
        $this->summaryService = $summaryService;
    }

    public function updateShipmentStatus(Shipment $shipment, string $status, array $providerPayload = []): Shipment
    {
        return DB::transaction(function () use ($shipment, $status, $providerPayload) {
            $shipment->refresh()->loadMissing(['order', 'items']);
            if (
                $shipment->status !== $status &&
                ! $this->canTransition(
                    $shipment->status,
                    $status
                )
            ) {
                throw new \RuntimeException(
                    sprintf(
                        'Invalid shipment transition [%s → %s]',
                        $shipment->status,
                        $status
                    )
                );
            }

            $shipment->update([
                'status' => $status,
                'payload_last' => array_merge(
                    $shipment->payload_last ?? [],
                    $providerPayload
                ),
            ]);

            $this->applyShipmentTimestamp(
                $shipment,
                $status
            );

            $this->updateShipmentItems(
                $shipment,
                $status
            );

            $this->createLog(
                $shipment,
                $status,
                $providerPayload
            );

            $this->dispatchEvent(
                $shipment,
                $status,
                $providerPayload
            );

            $this->handleSettlement(
                $shipment,
                $status
            );

            $this->dispatchShipmentEvent(
                $shipment,
                $status,
                $providerPayload
            );

            $this->summaryService->refresh(
                $shipment->order
            );

            return $shipment->fresh([
                'items',
                'logs',
                'order'
            ]);
        });
    }

    protected function updateShipmentItems(Shipment $shipment, string $status): void
    {
        foreach ($shipment->items as $item) {
            $this->updateItem(
                $item,
                $status
            );
        }
    }

    protected function updateItem(
        OrderItem $item,
        string $status
    ): void {
        $update = [
            'item_status' => $status
        ];
        switch ($status) {
            case 'delivered':
                $update['delivered_at'] = now();
                break;
            case 'cancelled':
                $update['cancelled_at'] = now();
                break;
            case 'returned':
                $update['returned_at'] = now();
                break;
        }
        $metadata = $item->metadata ?? [];
        $metadata['status'] = $status;
        $metadata['updated_at'] = now();
        $metadata['lifecycle'][$status . '_at'] = now();
        $update['metadata'] = $metadata;
        $item->update($update);
    }

    protected function applyShipmentTimestamp(
        Shipment $shipment,
        string $status
    ): void {
        $updates = [];
        switch ($status) {
            case 'confirmed':
                break;
            case 'packed':
                $updates['packed_at'] = now();
                break;
            case 'picked_up':
                $updates['picked_up_at'] = now();
                break;
            case 'shipped':
                $updates['shipped_at'] = now();
                break;
            case 'in_transit':
                $updates['in_transit_at'] = now();
                break;
            case 'out_for_delivery':
                $updates['out_for_delivery_at'] = now();
                break;
            case 'delivered':
                $updates['delivered_at'] = now();
                $updates['settlement_status'] = 'on_hold';
                if (!$shipment->hold_until) {
                    $updates['hold_until'] = now()->addDays(
                        config(
                            'marketplace.settlement_hold_days',
                            7
                        )
                    );
                }
                break;
            case 'cancelled':
                $updates['cancelled_at'] = now();
                $updates['settlement_status'] = 'cancelled';
                break;
            case 'rto_initiated':
                $updates['rto_initiated_at'] = now();
                break;
            case 'rto_delivered':
                $updates['rto_delivered_at'] = now();
                $updates['settlement_status'] = 'cancelled';
                break;
        }
        if (!empty($updates)) {
            $shipment->update($updates);
        }
    }

    protected function createLog(
        Shipment $shipment,
        string $status,
        array $payload = []
    ): void {
        ShippingLog::create([
            'shipment_id' => $shipment->id,
            'order_id' => $shipment->order_id,
            'provider' => $shipment->provider,
            'event_name' => strtoupper($status),
            'internal_status' => $status,
            'provider_status' =>
            $payload['provider_status']
                ??
                ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $status
                    )
                ),
            'location' =>
            $payload['location']
                ??
                null,
            'remarks' =>
            $payload['remarks']
                ??
                null,
            'event_time' =>
            $payload['event_time']
                ??
                now(),
            'payload' => array_merge(
                [
                    'shipment_id' =>
                    $shipment->id,
                    'seller_id' =>
                    $shipment->seller_id,
                    'provider' =>
                    $shipment->provider,
                    'tracking_number' =>
                    $shipment->tracking_number,
                    'awb_number' =>
                    $shipment->awb_number,
                    'shipment_status' =>
                    $status,
                ],
                $payload
            )
        ]);
    }

    protected function handleSettlement(
        Shipment $shipment,
        string $status
    ): void {
        switch ($status) {
            case 'delivered':
                $shipment->update([
                    'settlement_status' => 'on_hold',
                    'hold_until' =>
                    $shipment->hold_until
                        ??
                        now()->addDays(
                            config(
                                'marketplace.settlement_hold_days',
                                7
                            )
                        )
                ]);

                break;
            case 'cancelled':
                $shipment->update([
                    'settlement_status' => 'cancelled'
                ]);

                $shipment->items()->update([
                    'settlement_status' => 'refunded'
                ]);

                break;
            case 'rto_delivered':
                $shipment->update([
                    'settlement_status' => 'cancelled'
                ]);
                $shipment->items()->update([
                    'settlement_status' => 'refunded'
                ]);
                break;

            case 'returned':
                $shipment->items()->update([
                    'settlement_status' => 'refunded'
                ]);
                break;
        }

        if (
            $shipment->status === 'delivered'
            &&
            $shipment->settlement_status === 'on_hold'
            &&
            $shipment->hold_until
            &&
            now()->greaterThanOrEqualTo(
                $shipment->hold_until
            )
        ) {
            $shipment->update([
                'settlement_status' => 'released'
            ]);

            $shipment->items()->update([
                'settlement_status' => 'settled'
            ]);

            ShippingLog::create([
                'shipment_id' => $shipment->id,
                'order_id' => $shipment->order_id,
                'provider' => $shipment->provider,
                'event_name' => 'SETTLEMENT_RELEASED',
                'internal_status' => 'released',
                'provider_status' => 'Released',
                'remarks' => 'Settlement released to seller.',
                'event_time' => now(),
                'payload' => [
                    'seller_id' => $shipment->seller_id,
                    'released_at' => now(),
                    'hold_until' => $shipment->hold_until
                ]
            ]);
        }
    }

    protected function dispatchShipmentEvent(Shipment $shipment, string $status, array $payload = []): void
    {
        match ($status) {

            'pending',
            'confirmed' =>
            event(new ShipmentCreated(
                $shipment,
                $payload
            )),

            'packed' =>
            event(new ShipmentPacked(
                $shipment,
                $payload
            )),

            'shipped' =>
            event(new ShipmentShipped(
                $shipment,
                $payload
            )),

            'delivered' =>
            event(new ShipmentDelivered(
                $shipment,
                $payload
            )),

            default => null,
        };
    }

    public function canTransition(
        string $from,
        string $to
    ): bool {
        $graph = [
            'pending' => [
                'confirmed',
                'cancelled'
            ],
            'confirmed' => [
                'packed',
                'cancelled'
            ],
            'packed' => [
                'picked_up',
                'cancelled'
            ],
            'picked_up' => [
                'shipped'
            ],
            'shipped' => [
                'in_transit'
            ],
            'in_transit' => [
                'out_for_delivery',
                'rto_initiated'
            ],
            'out_for_delivery' => [
                'delivered',
                'rto_initiated'
            ],
            'delivered' => [
                'returned'
            ],
            'returned' => [
                'refunded'
            ],
            'rto_initiated' => [
                'rto_delivered'
            ]
        ];
        return in_array(
            $to,
            $graph[$from] ?? []
        );
    }

    public function forceStatus(
        Shipment $shipment,
        string $status,
        array $payload = []
    ): Shipment {
        return $this->updateShipmentStatus(
            $shipment,
            $status,
            $payload
        );
    }

    protected function dispatchEvent(Shipment $shipment, string $status, array $payload = []): void
    {
        match ($status) {
            'confirmed',
            'pending'
            => event(
                new ShipmentCreated(
                    $shipment,
                    $payload
                )
            ),

            'packed'
            => event(
                new ShipmentPacked(
                    $shipment,
                    $payload
                )
            ),

            'shipped'
            => event(
                new ShipmentShipped(
                    $shipment,
                    $payload
                )
            ),

            'delivered'
            => event(
                new ShipmentDelivered(
                    $shipment,
                    $payload
                )
            ),

            default => null,
        };
    }
}
