<?php

namespace App\Services\Logistics\Tracking;

use App\Models\Shipment;
use App\Services\Logistics\Contracts\CourierProvider;
use App\Services\Order\OrderStatusEngine;

class TrackingSynchronizer
{
    public function __construct(
        protected CourierProvider $provider,
        protected StatusMapper $statusMapper,
        protected OrderStatusEngine $statusEngine,
    ) {}

    /**
     * Synchronize a single shipment with the configured courier.
     *
     * Flow
     * ----
     * Provider
     *      ↓
     * Raw Payload
     *      ↓
     * Save payload_last
     *      ↓
     * StatusMapper
     *      ↓
     * OrderStatusEngine
     *      ↓
     * OrderSummaryService
     */
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
}
