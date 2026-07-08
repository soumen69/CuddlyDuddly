<?php

namespace App\Listeners;

use App\Events\ShipmentCreated;
use App\Events\ShipmentDelivered;
use App\Events\ShipmentPacked;
use App\Events\ShipmentShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Notification\NotificationManager;
use App\Services\Notification\DTO\NotificationData;

class NotifyCustomer implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        protected NotificationManager $notifications
    ) {}

    public function handle(object $event): void
    {
        match (true) {
            $event instanceof ShipmentCreated => $this->shipmentCreated($event),
            $event instanceof ShipmentPacked => $this->shipmentPacked($event),
            $event instanceof ShipmentShipped => $this->shipmentShipped($event),
            $event instanceof ShipmentDelivered => $this->shipmentDelivered($event),
            default => null,
        };
    }

    protected function shipmentCreated(ShipmentCreated $event): void
    {
        $this->notifications->send(
            new NotificationData(
                title: 'Order Confirmed',
                message: 'Your order has been confirmed.',
                recipient: $event->shipment
                    ->order
                    ->user,

                data: [
                    'shipment_id' => $event->shipment->id,
                    'order_id' => $event->shipment->order_id,
                ]
            )
        );
    }

    protected function shipmentPacked(ShipmentPacked $event): void
    {
        $this->notifications->send(
            new NotificationData(
                title: 'Order Packed',
                message: 'Your order has been packed.',
                recipient: $event->shipment
                    ->order
                    ->user,
                data: [
                    'shipment_id'
                    => $event->shipment->id,
                    'order_id'
                    => $event->shipment->order_id,
                ]
            )
        );
    }

    protected function shipmentShipped(ShipmentShipped $event): void
    {
        $this->notifications->send(
            new NotificationData(
                title: 'Order Shipped',
                message: 'Your order has been shipped.',
                recipient: $event->shipment->order->user,
                data: [
                    'shipment_id' => $event->shipment->id,
                    'order_id' => $event->shipment->order_id,
                ]
            )
        );
    }

    protected function shipmentDelivered(ShipmentDelivered $event): void
    {
        $this->notifications->send(

            new NotificationData(
                title: 'Order Delivered',
                message: 'Your order has been delivered.',
                recipient: $event->shipment
                    ->order
                    ->user,

                data: [
                    'shipment_id' => $event->shipment->id,
                    'order_id' => $event->shipment->order_id,
                ]
            )
        );
    }
}
