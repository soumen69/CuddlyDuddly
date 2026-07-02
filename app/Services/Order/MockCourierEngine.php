<?php

namespace App\Services\Order;

use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\ShippingLog;
use Illuminate\Support\Facades\DB;
use App\Services\Order\OrderSummaryService;

class MockCourierEngine
{
    protected OrderSummaryService $summary;
    protected OrderStatusEngine $status;

    public function __construct(OrderSummaryService $summary, OrderStatusEngine $status)
    {
        $this->summary = $summary;
        $this->status = $status;
    }

    public function start(Shipment $shipment): void
    {
        DB::transaction(function () use ($shipment) {
            $shipment->load([
                'items',
                'order'
            ]);

            $this->writeLog(
                shipment: $shipment,
                event: 'SHIPMENT_CREATED',
                internalStatus: 'pending',
                providerStatus: 'Shipment Created',
                remarks: 'Shipment initialized.'
            );
            // $this->confirm($shipment);
        });
    }

    public function confirm(Shipment $shipment): void
    {
        $this->status->updateShipmentStatus(
            $shipment,
            'confirmed',
            [
                'provider_status' => 'Confirmed'
            ]
        );
    }

    public function assignAwb(Shipment $shipment): void
    {
        $shipment->update([
            'status' => 'awb_assigned',
            'awb_number' =>
            $shipment->awb_number
                ?: 'AWB-' . strtoupper(substr(md5(uniqid()), 0, 12))
        ]);

        $this->writeLog(
            shipment: $shipment,
            event: 'AWB_ASSIGNED',
            internalStatus: 'awb_assigned',
            providerStatus: 'AWB Generated',
            remarks: 'Mock airway bill assigned.'
        );
        $this->refreshOrder($shipment);
        // $this->schedulePickup($shipment);
    }

    public function schedulePickup(Shipment $shipment): void
    {
        $shipment->update([
            'status' => 'pickup_scheduled',
            'pickup_token' =>
            strtoupper(substr(md5(now()), 0, 10))
        ]);
        $this->writeLog(
            shipment: $shipment,
            event: 'PICKUP_SCHEDULED',
            internalStatus: 'pickup_scheduled',
            providerStatus: 'Pickup Scheduled',
            remarks: 'Courier pickup scheduled.'
        );
        $this->refreshOrder($shipment);
        $this->pack($shipment);
    }

    public function pack(Shipment $shipment): void
    {
        $this->status->updateShipmentStatus(
            $shipment,
            'packed',
            [
                'provider_status' => 'Packed'
            ]
        );
    }

    public function pickup(Shipment $shipment): void
    {
        $this->status->updateShipmentStatus(
            $shipment,
            'picked_up',
            [
                'provider_status' => 'Picked Up'
            ]
        );
    }

    public function ship(Shipment $shipment): void
    {
        $this->status->updateShipmentStatus(
            $shipment,
            'shipped',
            [
                'provider_status' => 'Shipped'
            ]
        );
    }

    // public function inTransit(Shipment $shipment): void
    // {
    //     $shipment->update(['status' => 'in_transit', 'in_transit_at' => now()]);
    //     $this->updateItems(shipment: $shipment, status: 'in_transit');

    //     $this->writeLog(
    //         shipment: $shipment,
    //         event: 'IN_TRANSIT',
    //         internalStatus: 'in_transit',
    //         providerStatus: 'In Transit',
    //         remarks: 'Shipment is moving through courier network.'
    //     );

    //     $this->refreshOrder($shipment);
    //     // $this->outForDelivery($shipment);
    // }

    public function inTransit(Shipment $shipment): void
    {
        $this->status->updateShipmentStatus(
            $shipment,
            'in_transit',
            [
                'provider_status' => 'In Transit'
            ]
        );
    }

    // public function outForDelivery(Shipment $shipment): void
    // {
    //     $shipment->update([
    //         'status' => 'out_for_delivery',
    //         'out_for_delivery_at' => now(),
    //         'expected_delivery' => now()->addDay()
    //     ]);

    //     $this->updateItems(shipment: $shipment, status: 'out_for_delivery');
    //     $this->writeLog(
    //         shipment: $shipment,
    //         event: 'OUT_FOR_DELIVERY',
    //         internalStatus: 'out_for_delivery',
    //         providerStatus: 'Out For Delivery',
    //         remarks: 'Courier is attempting delivery.'
    //     );

    //     $this->refreshOrder($shipment);
    //     // $this->deliver($shipment);
    // }

    public function outForDelivery(Shipment $shipment): void
    {
        $this->status->updateShipmentStatus(
            $shipment,
            'out_for_delivery',
            [
                'provider_status' => 'Out For Delivery'
            ]
        );
    }

    // public function deliver(Shipment $shipment): void
    // {
    //     $holdUntil = now()->addDays(config('marketplace.settlement_hold_days', 7));
    //     $shipment->update([
    //         'status' => 'delivered',
    //         'delivered_at' => now(),
    //         'settlement_status' => 'on_hold',
    //         'hold_until' => $holdUntil
    //     ]);

    //     $this->updateItems(
    //         shipment: $shipment,
    //         status: 'delivered',
    //         extra: [
    //             'delivered_at' => now()
    //         ]
    //     );

    //     $this->writeLog(
    //         shipment: $shipment,
    //         event: 'DELIVERED',
    //         internalStatus: 'delivered',
    //         providerStatus: 'Delivered',
    //         remarks: 'Shipment delivered successfully.'
    //     );
    //     $this->refreshOrder($shipment);
    // }

    public function deliver(Shipment $shipment): void
    {
        $this->status->updateShipmentStatus(
            $shipment,
            'delivered',
            [
                'provider_status' => 'Delivered'
            ]
        );
    }

    // public function cancel(Shipment $shipment, string $reason = ''): void
    // {
    //     $shipment->update([
    //         'status' => 'cancelled',
    //         'cancelled_at' => now(),
    //         'settlement_status' => 'cancelled'
    //     ]);

    //     $this->updateItems(
    //         shipment: $shipment,
    //         status: 'cancelled',
    //         extra: [
    //             'cancelled_at' => now(),
    //             'cancellation_status' => 'approved'
    //         ]
    //     );

    //     $this->writeLog(
    //         shipment: $shipment,
    //         event: 'CANCELLED',
    //         internalStatus: 'cancelled',
    //         providerStatus: 'Cancelled',
    //         remarks: $reason ?: 'Shipment cancelled.'
    //     );
    //     $this->refreshOrder($shipment);
    // }

    public function cancel(Shipment $shipment, string $reason = ''): void
    {
        $this->status->updateShipmentStatus(
            $shipment,
            'cancelled',
            [
                'provider_status' => 'Cancelled',
                'remarks' => $reason
            ]
        );
    }

    // public function rtoInitiated(Shipment $shipment): void
    // {
    //     $shipment->update(['status' => 'rto_initiated', 'rto_initiated_at' => now()]);
    //     $this->writeLog(
    //         shipment: $shipment,
    //         event: 'RTO_INITIATED',
    //         internalStatus: 'rto_initiated',
    //         providerStatus: 'RTO Initiated',
    //         remarks: 'Return to origin initiated.'
    //     );
    //     $this->refreshOrder($shipment);
    // }

    public function rtoInitiated(
        Shipment $shipment
    ): void {

        $this->status->updateShipmentStatus(
            $shipment,
            'rto_initiated',
            [
                'provider_status' => 'RTO Initiated'
            ]
        );
    }

    // public function rtoDelivered(Shipment $shipment): void
    // {
    //     $shipment->update([
    //         'status' => 'rto_delivered',
    //         'rto_delivered_at' => now(),
    //         'settlement_status' => 'cancelled'
    //     ]);

    //     $this->updateItems(
    //         shipment: $shipment,
    //         status: 'returned',
    //         extra: [
    //             'returned_at' => now(),
    //             'return_status' => 'completed'
    //         ]
    //     );

    //     $this->writeLog(
    //         shipment: $shipment,
    //         event: 'RTO_DELIVERED',
    //         internalStatus: 'rto_delivered',
    //         providerStatus: 'RTO Delivered',
    //         remarks: 'Shipment returned back to seller.'
    //     );
    //     $this->refreshOrder($shipment);
    // }

    public function rtoDelivered(
        Shipment $shipment
    ): void {

        $this->status->updateShipmentStatus(
            $shipment,
            'rto_delivered',
            [
                'provider_status' => 'RTO Delivered'
            ]
        );
    }

    public function releaseSettlement(Shipment $shipment): void
    {
        if ($shipment->settlement_status !== 'on_hold') {
            return;
        }

        $shipment->update([
            'settlement_status' => 'released'
        ]);

        OrderItem::where('shipment_id', $shipment->id)->update(['settlement_status' => 'settled']);
        $this->writeLog(
            shipment: $shipment,
            event: 'SETTLEMENT_RELEASED',
            internalStatus: 'settled',
            providerStatus: 'Settlement Released',
            remarks: 'Seller settlement released.'
        );
        $this->refreshOrder($shipment);
    }

    protected function updateItems(Shipment $shipment, string $status, array $extra = []): void
    {
        $shipment->loadMissing('items');
        foreach ($shipment->items as $item) {
            $metadata = $item->metadata ?? [];
            $metadata['status'] = $status;
            $metadata['updated_at'] = now();
            $metadata['lifecycle'] = array_merge($metadata['lifecycle'] ?? [], [$status . '_at' => now()]);
            $payload = array_merge(['item_status' => $status, 'metadata' => $metadata], $extra);
            $item->update($payload);
        }
    }

    protected function refreshOrder(Shipment $shipment): void
    {
        $shipment->loadMissing('order');
        if (!$shipment->order) {
            return;
        }
        $this->summary->refresh($shipment->order);
    }


    protected function updateShipmentMetadata(Shipment $shipment, array $data): void
    {
        $shipment->update([
            'provider_metadata' => array_merge(
                $shipment->provider_metadata ?? [],
                $data
            )
        ]);
    }

    protected function writeLog(Shipment $shipment, string $event, string $internalStatus, string $providerStatus, string $remarks, array $payload = []): void
    {
        ShippingLog::create([
            'shipment_id' => $shipment->id,
            'order_id' => $shipment->order_id,
            'provider' => $shipment->provider,
            'event_name' => $event,
            'internal_status' => $internalStatus,
            'provider_status' => $providerStatus,
            'remarks' => $remarks,
            'event_time' => now(),
            'payload' => array_merge(
                [
                    'shipment_id' => $shipment->id,
                    'seller_id' => $shipment->seller_id,
                    'provider' => $shipment->provider,
                    'status' => $shipment->status,
                    'logged_at' => now()
                ],
                $payload
            )
        ]);
    }

    public function canReleaseSettlement(Shipment $shipment): bool
    {
        return
            $shipment->status === 'delivered'
            &&
            $shipment->settlement_status === 'on_hold'
            &&
            $shipment->hold_until
            &&
            now()->greaterThanOrEqualTo($shipment->hold_until);
    }

    public function moveTo(Shipment $shipment, string $status): void
    {
        match ($status) {
            'confirmed'
            => $this->confirm($shipment),
            'awb_assigned'
            => $this->assignAwb($shipment),
            'pickup_scheduled'
            => $this->schedulePickup($shipment),
            'packed'
            => $this->pack($shipment),
            'picked_up'
            => $this->pickup($shipment),
            'shipped'
            => $this->ship($shipment),
            'in_transit'
            => $this->inTransit($shipment),
            'out_for_delivery'
            => $this->outForDelivery($shipment),
            'delivered'
            => $this->deliver($shipment),
            'cancelled'
            => $this->cancel($shipment),
            'rto_initiated'
            => $this->rtoInitiated($shipment),
            'rto_delivered'
            => $this->rtoDelivered($shipment),
            default => null
        };
    }

    public function provider(): string
    {
        return config(
            'logistics.provider',
            'mock'
        );
    }

    public function isMock(): bool
    {
        return $this->provider() === 'mock';
    }
}
