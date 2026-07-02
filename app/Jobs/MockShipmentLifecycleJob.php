<?php

namespace App\Jobs;

use App\Models\Shipment;
use App\Services\Order\MockCourierEngine;
use App\Services\Order\OrderStatusEngine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MockShipmentLifecycleJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Shipment ID.
     */
    public int $shipmentId;

    /**
     * Retry attempts.
     */
    public $tries = 5;

    /**
     * Timeout.
     */
    public $timeout = 120;

    /**
     * Backoff.
     */
    public $backoff = 30;

    /**
     * Constructor.
     */
    public function __construct(
        int $shipmentId
    ) {

        $this->shipmentId = $shipmentId;
    }

    public function handle(MockCourierEngine $mock): void
    {
        $shipment = Shipment::find(
            $this->shipmentId
        );

        if (!$shipment) {
            return;
        }

        if (
            in_array(
                $shipment->status,
                [
                    'delivered',
                    'cancelled',
                    'rto_delivered'
                ]
            )
        ) {
            return;
        }

        $next = match ($shipment->status) {

            'pending'             => 'confirmed',

            'confirmed'           => 'awb_assigned',

            'awb_assigned'        => 'pickup_scheduled',

            'pickup_scheduled'    => 'packed',

            'packed'              => 'picked_up',

            'picked_up'           => 'shipped',

            'shipped'             => 'in_transit',

            'in_transit'          => 'out_for_delivery',

            'out_for_delivery'    => 'delivered',

            default               => null,
        };

        if (!$next) {
            return;
        }

        $mock->moveTo(
            $shipment,
            $next
        );

        if ($next !== 'delivered') {

            self::dispatch(
                $shipment->id
            )->delay(
                now()->addSeconds(
                    config(
                        'logistics.mock.delay',
                        10
                    )
                )
            );
        }
    }

    public function failed(

        \Throwable $exception

    ): void {

        $shipment = Shipment::find(

            $this->shipmentId

        );

        if (!$shipment) {

            return;
        }

        $payload =

            $shipment->payload_last ?? [];

        $payload['mock_failure'] = [

            'message' => $exception->getMessage(),

            'time' => now(),

            'job' => static::class,

            'attempts' => $this->attempts()

        ];

        $shipment->update([

            'payload_last' => $payload

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Queue Tags
    |--------------------------------------------------------------------------
    */

    public function tags(): array
    {

        return [

            'shipment',

            'mock',

            'shipment:' . $this->shipmentId

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Queue Display Name
    |--------------------------------------------------------------------------
    */

    public function displayName(): string
    {

        return

            'Mock Shipment Lifecycle #' .

            $this->shipmentId;
    }
}
