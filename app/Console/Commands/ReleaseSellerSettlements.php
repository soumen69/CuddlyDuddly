<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shipment;
use App\Services\Payment\SettlementService;

class ReleaseSellerSettlements extends Command
{
    protected $signature = 'payments:release-settlements';
    protected $description = 'Release eligible seller settlements';

    public function handle(SettlementService $service)
    {
        Shipment::query()

            ->where(
                'status',
                'delivered'
            )

            ->where(
                'settlement_status',
                'on_hold'
            )

            ->whereNotNull(
                'hold_until'
            )

            ->where(
                'hold_until',
                '<=',
                now()
            )

            ->chunkById(
                100,
                function ($shipments) use ($service) {

                    foreach (
                        $shipments as $shipment
                    ) {

                        $service->release(
                            $shipment
                        );

                        $this->info(
                            $shipment->id .
                                ' released.'
                        );
                    }
                }
            );

        return self::SUCCESS;
    }
}
