<?php

namespace App\Console\Commands;

use App\Models\Shipment;
use App\Services\Order\MockCourierEngine;
use Illuminate\Console\Command;

class MockCourierTick extends Command
{
    protected $signature = 'mock:courier-tick';

    protected $description = 'Advance mock shipments one logistics step.';

    public function handle(
        MockCourierEngine $engine
    ): int {

        Shipment::query()
            ->where('provider', 'mock')
            ->whereNotIn('status', [
                'delivered',
                'cancelled',
                'rto_delivered',
            ])
            ->orderBy('id')
            ->chunkById(100, function ($shipments) use ($engine) {

                foreach ($shipments as $shipment) {

                    try {

                        $this->advance(
                            $engine,
                            $shipment
                        );

                        $this->info(
                            sprintf(
                                '#%d → %s',
                                $shipment->id,
                                $shipment->fresh()->status
                            )
                        );
                    } catch (\Throwable $e) {

                        report($e);

                        $this->error(
                            sprintf(
                                '#%d : %s',
                                $shipment->id,
                                $e->getMessage()
                            )
                        );
                    }
                }
            });

        return self::SUCCESS;
    }

    protected function advance(MockCourierEngine $engine, Shipment $shipment): void
    {

        match ($shipment->status) {

            'pending'
            => $engine->confirm($shipment),

            'confirmed'
            => $engine->assignAwb($shipment),

            'awb_assigned'
            => $engine->schedulePickup($shipment),

            'pickup_scheduled'
            => $engine->pack($shipment),

            'packed'
            => $engine->pickup($shipment),

            'picked_up'
            => $engine->ship($shipment),

            'shipped'
            => $engine->inTransit($shipment),

            'in_transit'
            => $engine->outForDelivery($shipment),

            'out_for_delivery'
            => $engine->deliver($shipment),

            default => null,
        };
    }
}
