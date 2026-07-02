<?php

namespace App\Services\Order;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CancelOrderItemService
{
    public function __construct(
        protected OrderStatusEngine $statusEngine,
        protected OrderSummaryService $summaryService
    ) {}

    public function cancel(
        OrderItem $item,
        string $reason,
        bool $force = false
    ): OrderItem {

        return DB::transaction(function () use (
            $item,
            $reason,
            $force
        ) {

            $item->loadMissing([
                'shipment',
                'order',
                'product',
            ]);

            if (! $force && ! $this->canCancel($item)) {
                throw new RuntimeException(
                    'This item can no longer be cancelled.'
                );
            }

            $item->update([
                'item_status' => 'cancelled',
                'cancel_reason' => $reason,
                'cancelled_at' => now(),
            ]);

            $this->syncShipment(
                $item
            );

            $this->summaryService->refresh(
                $item->order
            );

            return $item->fresh();
        });
    }

    protected function canCancel(
        OrderItem $item
    ): bool {

        return in_array(
            $item->item_status,
            [
                'pending',
                'confirmed',
                'packed',
            ],
            true
        );
    }

    protected function syncShipment(
        OrderItem $item
    ): void {

        $shipment = $item->shipment;

        if (! $shipment) {
            return;
        }

        $remaining = $shipment->items()
            ->where('item_status', '!=', 'cancelled')
            ->count();

        if ($remaining === 0) {

            $this->statusEngine->updateShipmentStatus(
                $shipment,
                'cancelled',
                [
                    'provider_status' => 'Cancelled'
                ]
            );
        }
    }
}
