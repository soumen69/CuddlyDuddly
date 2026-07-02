<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;

class OrderSummaryService
{
    public function refresh(Order $order): Order
    {
        $order->load(['items', 'shipments']);
        $items = $order->items;
        if ($items->isEmpty()) {
            return $order;
        }

        $summary = [
            'total_items' => $items->count(),
            'placed' => 0,
            'confirmed' => 0,
            'packed' => 0,
            'picked_up' => 0,
            'shipped' => 0,
            'in_transit' => 0,
            'out_for_delivery' => 0,
            'delivered' => 0,
            'cancelled' => 0,
            'returned' => 0,
            'refunded' => 0,
            'replacement' => 0
        ];

        foreach ($items as $item) {
            switch ($item->item_status) {
                case 'placed':
                    $summary['placed']++;
                    break;

                case 'confirmed':
                    $summary['confirmed']++;
                    break;

                case 'packed':
                    $summary['packed']++;
                    break;

                case 'picked_up':
                    $summary['picked_up']++;
                    break;

                case 'shipped':
                    $summary['shipped']++;
                    break;

                case 'in_transit':
                    $summary['in_transit']++;
                    break;

                case 'out_for_delivery':
                    $summary['out_for_delivery']++;
                    break;

                case 'delivered':
                    $summary['delivered']++;
                    break;

                case 'cancelled':
                    $summary['cancelled']++;
                    break;

                case 'returned':
                    $summary['returned']++;
                    break;

                case 'refunded':
                    $summary['refunded']++;
                    break;
            }

            if ($item->replacement_status) {
                $summary['replacement']++;
            }
        }

        $orderStatus = $this->determineOrderStatus(
            $summary
        );

        $completion = $this->determineCompletionStatus(
            $summary
        );

        $financial = $this->calculateFinancials(
            $items
        );

        $deliveredAt = null;

        if ($summary['delivered'] > 0 && $summary['delivered'] === $summary['total_items']) {
            $deliveredAt = $items
                ->max('delivered_at');
        }

        $order->update([
            'order_status' => $orderStatus,
            'completion_status' => $completion,
            'last_status_at' => now(),
            'total_amount' => $financial['subtotal']
        ]);

        foreach ($order->shipments as $shipment) {
            $shipmentItems = $items->where(
                'shipment_id',
                $shipment->id
            );

            $shipment->update([
                'provider_metadata' => array_merge(
                    $shipment->provider_metadata ?? [],
                    [
                        'item_count' =>
                        $shipmentItems->count(),
                        'quantity' =>
                        $shipmentItems->sum('quantity'),
                        'subtotal' =>
                        round(
                            $shipmentItems->sum('subtotal'),
                            2
                        ),
                        'commission' =>
                        round(
                            $shipmentItems->sum('commission_amount'),
                            2
                        ),
                        'seller_amount' =>
                        round(
                            $shipmentItems->sum('seller_amount'),
                            2
                        ),
                        'statuses' =>
                        $shipmentItems
                            ->pluck('item_status')
                            ->countBy()
                            ->toArray(),
                        'updated_at' => now()
                    ]
                )
            ]);
        }

        $order->setAttribute(
            'summary',
            [
                'status' => $summary,
                'financial' => $financial,
                'delivered_at' => $deliveredAt
            ]
        );
        return $order;
    }

    protected function determineOrderStatus(array $summary): string
    {
        $total = $summary['total_items'];
        if ($summary['cancelled'] === $total) {
            return 'cancelled';
        }

        if ($summary['returned'] === $total) {
            return 'returned';
        }

        if ($summary['delivered'] === $total) {
            return 'delivered';
        }

        if ($summary['out_for_delivery'] > 0) {
            return 'out_for_delivery';
        }

        if ($summary['in_transit'] > 0) {
            return 'in_transit';
        }

        if ($summary['shipped'] > 0) {
            return 'shipped';
        }

        if ($summary['picked_up'] > 0) {
            return 'picked_up';
        }

        if ($summary['packed'] > 0) {
            return 'packed';
        }

        if ($summary['confirmed'] > 0) {
            return 'confirmed';
        }
        return 'placed';
    }

    protected function determineCompletionStatus(array $summary): string
    {
        $total = $summary['total_items'];
        if ($summary['delivered'] === $total) {
            return 'completed';
        }

        if (($summary['cancelled'] + $summary['returned']) === $total) {
            return 'closed';
        }

        if ($summary['delivered'] + $summary['cancelled'] + $summary['returned'] === $total) {
            return 'completed';
        }
        return 'processing';
    }

    protected function calculateFinancials(Collection $items): array
    {
        return [
            'subtotal' => round(
                $items->sum('subtotal'),
                2
            ),

            'commission' => round(
                $items->sum('commission_amount'),
                2
            ),

            'seller_amount' => round(
                $items->sum('seller_amount'),
                2
            ),

            'settled' => round(
                $items
                    ->where(
                        'settlement_status',
                        'settled'
                    )
                    ->sum('seller_amount'),
                2
            ),

            'pending_settlement' => round(
                $items
                    ->where(
                        'settlement_status',
                        'pending'
                    )
                    ->sum('seller_amount'),
                2
            ),

            'refunded' => round(
                $items
                    ->where(
                        'settlement_status',
                        'refunded'
                    )
                    ->sum('seller_amount'),
                2
            ),

        ];
    }
}
