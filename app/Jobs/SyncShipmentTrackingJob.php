<?php

namespace App\Jobs;

use App\Models\Shipment;
use App\Services\Logistics\Tracking\TrackingSynchronizer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncShipmentTrackingJob implements ShouldQueue
{
    use Queueable;
    use InteractsWithQueue;
    use SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public function __construct(
        public int $shipmentId
    ) {}

    public function handle(
        TrackingSynchronizer $synchronizer
    ): void {

        $shipment = Shipment::query()
            ->find($this->shipmentId);

        if (! $shipment) {
            return;
        }

        if (! $this->shouldSync($shipment)) {
            return;
        }

        $synchronizer->synchronize(
            $shipment
        );
    }

    protected function shouldSync(
        Shipment $shipment
    ): bool {

        return in_array(
            $shipment->status,
            [
                'pending',
                'confirmed',
                'awb_assigned',
                'pickup_scheduled',
                'packed',
                'picked_up',
                'shipped',
                'in_transit',
                'out_for_delivery',
            ],
            true
        );
    }
}
