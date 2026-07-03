<?php

namespace App\Services\Order;

use App\Models\Order;
use Illuminate\Support\Collection;

class OrderTimelineService
{
    public function build(
        Order $order
    ): Collection {

        $order->loadMissing([
            'shipments.logs',
            'cancellations',
            'returns',
            'replacements',
        ]);

        return collect()

            ->merge(
                $this->shipmentEvents($order)
            )

            ->merge(
                $this->cancellationEvents($order)
            )

            ->merge(
                $this->returnEvents($order)
            )

            ->merge(
                $this->replacementEvents($order)
            )

            ->sortBy('time')

            ->values();
    }

    protected function shipmentEvents(
        Order $order
    ): Collection {

        return $order->shipments
            ->flatMap(function ($shipment) {

                return $shipment->logs->map(function ($log) use ($shipment) {

                    return [

                        'type' => 'shipment',

                        'shipment_id' => $shipment->id,

                        'status' => $log->internal_status,

                        'title' => $log->provider_status,

                        'description' => $log->remarks,

                        'location' => $log->location,

                        'time' => $log->event_time,

                        'payload' => $log->payload,

                    ];
                });
            });
    }

    protected function cancellationEvents(
        Order $order
    ): Collection {

        return $order->cancellations
            ->map(function ($row) {

                return [

                    'type' => 'cancellation',

                    'item_id' => $row->order_item_id,

                    'status' => $row->status,

                    'title' => 'Cancellation',

                    'description' => $row->reason,

                    'location' => null,

                    'time' =>
                    $row->completed_at
                        ??
                        $row->approved_at
                        ??
                        $row->created_at,

                    'payload' => $row,

                ];
            });
    }

    protected function returnEvents(
        Order $order
    ): Collection {

        return $order->returns
            ->map(function ($row) {

                return [

                    'type' => 'return',

                    'item_id' => $row->order_item_id,

                    'status' => $row->status,

                    'title' => 'Return',

                    'description' => $row->reason,

                    'location' => null,

                    'time' =>
                    $row->closed_at
                        ??
                        $row->refunded_at
                        ??
                        $row->created_at,

                    'payload' => $row,

                ];
            });
    }

    protected function replacementEvents(
        Order $order
    ): Collection {

        return $order->replacements
            ->map(function ($row) {

                return [

                    'type' => 'replacement',

                    'item_id' => $row->order_item_id,

                    'status' => $row->status,

                    'title' => 'Replacement',

                    'description' => $row->reason,

                    'location' => null,

                    'time' =>
                    $row->completed_at
                        ??
                        $row->approved_at
                        ??
                        $row->created_at,

                    'payload' => $row,

                ];
            });
    }
}
