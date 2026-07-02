<?php

namespace App\Console\Commands;

use App\Jobs\SyncShipmentTrackingJob;
use App\Models\Shipment;
use Illuminate\Console\Command;

class SyncShipmentTracking extends Command
{
    protected $signature = 'logistics:sync';

    protected $description = 'Synchronize active shipment tracking from logistics providers.';

    public function handle(): int
    {
        Shipment::query()
            ->whereNotIn('status', [
                'delivered',
                'cancelled',
                'rto_delivered',
            ])
            ->orderBy('id')
            ->chunkById(100, function ($shipments) {
                foreach ($shipments as $shipment) {
                    SyncShipmentTrackingJob::dispatch(
                        $shipment->id
                    );
                }
            });

        $this->info(
            'Shipment synchronization queued.'
        );
        return self::SUCCESS;
    }
}
