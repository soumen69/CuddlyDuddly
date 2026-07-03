<?php

namespace App\Services\Logistics\Providers;

use App\Models\Shipment;
use App\Services\Logistics\Contracts\CourierProvider;
use Illuminate\Support\Str;
use App\Models\OrderReturn;

class MockCourierProvider implements CourierProvider
{
    public function name(): string
    {
        return 'mock';
    }

    public function enabled(): bool
    {
        return true;
    }

    public function createShipment(Shipment $shipment): array
    {
        $trackingNumber = 'MOCK' . now()->format('Ymd') . strtoupper(Str::random(8));

        return [
            'provider' => $this->name(),
            'provider_shipment_id' => (string) Str::uuid(),
            'tracking_number' => $trackingNumber,
            'awb_number' => $trackingNumber,
            'label_url' => null,
            'invoice_url' => null,
            'tracking_url' => null,
            'pickup_scheduled' => false,
            'status' => 'pending',
            'raw' => [],
        ];
    }

    public function cancelShipment(Shipment $shipment): array
    {
        return [
            'provider' => $this->name(),
            'provider_shipment_id' => $shipment->provider_shipment_id,
            'tracking_number' => $shipment->tracking_number,
            'awb_number' => $shipment->awb_number,
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'raw' => [],
        ];
    }

    public function trackShipment(Shipment $shipment): array
    {
        return [
            'provider' => $this->name(),
            'provider_shipment_id' => $shipment->provider_shipment_id,
            'tracking_number' => $shipment->tracking_number,
            'awb_number' => $shipment->awb_number,
            'status' => $shipment->status,
            'status_at' => optional($shipment->updated_at)?->toDateTimeString(),
            'location' => null,
            'message' => null,
            'events' => [],
            'raw' => [],
        ];
    }

    public function shippingLabel(Shipment $shipment): array
    {
        return [
            'label_url' => null,
            'raw' => [],
        ];
    }

    public function invoice(Shipment $shipment): array
    {
        return [
            'invoice_url' => null,
            'raw' => [],
        ];
    }

    public function schedulePickup(Shipment $shipment): array
    {
        return [
            'provider' => $this->name(),
            'provider_shipment_id' => $shipment->provider_shipment_id,
            'tracking_number' => $shipment->tracking_number,
            'awb_number' => $shipment->awb_number,
            'pickup_scheduled' => true,
            'pickup_reference' => 'PICKUP-' . strtoupper(Str::random(10)),
            'scheduled_at' => now()->toDateTimeString(),
            'raw' => [],
        ];
    }

    public function scheduleReversePickup(
        OrderReturn $return
    ): array {

        return [

            'success' => true,

            'status' => 'scheduled',

            'awb_number' =>
            'RAWB-' . strtoupper(
                substr(md5(uniqid()), 0, 10)
            ),

            'provider' => 'mock',

        ];
    }

    public function supportsTracking(): bool
    {
        return true;
    }

    public function supportsShipmentCreation(): bool
    {
        return true;
    }

    public function supportsPickupScheduling(): bool
    {
        return true;
    }

    public function supportsCancellation(): bool
    {
        return true;
    }
}
