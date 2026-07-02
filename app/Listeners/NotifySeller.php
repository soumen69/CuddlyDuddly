<?php

namespace App\Listeners;

use App\Events\ShipmentCreated;
use App\Events\ShipmentDelivered;
use App\Events\ShipmentPacked;
use App\Events\ShipmentShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifySeller implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(object $event): void
    {
        match (true) {

            $event instanceof ShipmentCreated =>
            $this->shipmentCreated($event),

            $event instanceof ShipmentPacked =>
            $this->shipmentPacked($event),

            $event instanceof ShipmentShipped =>
            $this->shipmentShipped($event),

            $event instanceof ShipmentDelivered =>
            $this->shipmentDelivered($event),

            default => null,
        };
    }

    protected function shipmentCreated(
        ShipmentCreated $event
    ): void {
        // TODO
    }

    protected function shipmentPacked(
        ShipmentPacked $event
    ): void {
        // TODO
    }

    protected function shipmentShipped(
        ShipmentShipped $event
    ): void {
        // TODO
    }

    protected function shipmentDelivered(
        ShipmentDelivered $event
    ): void {
        // TODO
    }
}
