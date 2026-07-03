<?php

namespace App\Services\Logistics\Tracking;

use App\Models\Shipment;
use App\Services\Logistics\Contracts\CourierProvider;
use App\Services\Order\OrderStatusEngine;
use App\Models\OrderReturn;

class TrackingSynchronizer
{
    public function __construct(
        protected CourierProvider $provider,
        protected StatusMapper $statusMapper,
        protected OrderStatusEngine $statusEngine,
    ) {}

    public function synchronize(Shipment $shipment): Shipment
    {
        if (! $this->provider->supportsTracking()) {
            return $shipment;
        }

        $payload = $this->provider->trackShipment($shipment);

        $shipment->update([
            'payload_last' => $payload,
        ]);

        $providerStatus = $payload['provider_status']
            ?? $payload['status']
            ?? null;

        $marketplaceStatus = $this->statusMapper->map(
            $providerStatus
        );

        if ($marketplaceStatus === null) {
            return $shipment->fresh();
        }

        if (
            $shipment->status === $marketplaceStatus
        ) {
            return $shipment->fresh();
        }

        return $this->statusEngine->updateShipmentStatus(
            $shipment,
            $marketplaceStatus,
            $payload
        );
    }

    public function synchronizeMany(iterable $shipments): void
    {
        foreach ($shipments as $shipment) {
            $this->synchronize($shipment);
        }
    }

    public function scheduleReversePickup(
        OrderReturn $return
    ): void {

        $response = $this->provider
            ->scheduleReversePickup(
                $return
            );

        $return->update([

            'pickup_awb' =>
            $response['awb_number'] ?? null,

            'pickup_status' =>
            $response['status'] ?? 'scheduled',

            'pickup_scheduled_at' => now(),

            'metadata' => array_merge(

                $return->metadata ?? [],

                [
                    'reverse_pickup' => $response
                ]

            )

        ]);
    }
}
