<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderCancellation;
use App\Models\OrderItem;
use App\Models\OrderReplacement;
use App\Models\OrderReturn;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderLifecycleService
{
    public function __construct(
        protected OrderStatusEngine $statusEngine,
        protected OrderSummaryService $summaryService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Cancellation
    |--------------------------------------------------------------------------
    */

    public function requestCancellation(
        OrderItem $item,
        string $reason,
        string $requestedBy = 'customer'
    ): OrderCancellation {

        return DB::transaction(function () use (
            $item,
            $reason,
            $requestedBy
        ) {

            $item->loadMissing([
                'order',
                'shipment',
            ]);

            $this->ensureCancellationAllowed($item);

            $request = OrderCancellation::create([

                'cancel_number' => $this->nextNumber('CAN'),

                'order_id' => $item->order_id,

                'order_item_id' => $item->id,

                'shipment_id' => $item->shipment_id,

                'seller_id' => $item->seller_id,

                'user_id' => $item->order->user_id,

                'cancelled_by' => $requestedBy,

                'reason' => $reason,

                'status' => 'requested',

                'refund_status' => 'pending',

                'metadata' => [
                    'requested_at' => now(),
                ],

            ]);

            $item->update([
                'cancellation_status' => 'requested',
            ]);

            return $request->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Return
    |--------------------------------------------------------------------------
    */

    public function requestReturn(
        OrderItem $item,
        string $reason
    ): OrderReturn {

        return DB::transaction(function () use (
            $item,
            $reason
        ) {

            $item->loadMissing([
                'order',
                'shipment',
            ]);

            $this->ensureReturnAllowed($item);

            $return = OrderReturn::create([

                'return_number' => $this->nextNumber('RET'),

                'order_id' => $item->order_id,

                'order_item_id' => $item->id,

                'shipment_id' => $item->shipment_id,

                'seller_id' => $item->seller_id,

                'user_id' => $item->order->user_id,

                'reason' => $reason,

                'status' => 'requested',

                'refund_status' => 'pending',

                'metadata' => [
                    'requested_at' => now(),
                ],

            ]);

            $item->update([
                'return_status' => 'requested',
            ]);

            return $return->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Replacement
    |--------------------------------------------------------------------------
    */

    public function requestReplacement(
        OrderItem $item,
        string $reason
    ): OrderReplacement {

        return DB::transaction(function () use (
            $item,
            $reason
        ) {

            $item->loadMissing([
                'order',
                'shipment',
            ]);

            $this->ensureReplacementAllowed($item);

            $replacement = OrderReplacement::create([

                'replacement_number' => $this->nextNumber('REP'),

                'order_id' => $item->order_id,

                'order_item_id' => $item->id,

                'shipment_id' => $item->shipment_id,

                'seller_id' => $item->seller_id,

                'user_id' => $item->order->user_id,

                'reason' => $reason,

                'status' => 'requested',

                'metadata' => [
                    'requested_at' => now(),
                ],

            ]);

            $item->update([
                'replacement_status' => 'requested',
            ]);

            return $replacement->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Cancellation Review
    |--------------------------------------------------------------------------
    */

    public function approveCancellation(
        OrderCancellation $cancellation,
        ?int $reviewedBy = null,
        ?string $notes = null
    ): OrderCancellation {

        return DB::transaction(function () use (
            $cancellation,
            $reviewedBy,
            $notes
        ) {

            if ($cancellation->status !== 'requested') {
                throw new RuntimeException(
                    'Cancellation request is already processed.'
                );
            }

            $cancellation->loadMissing([
                'item',
                'order',
                'shipment',
            ]);

            $cancellation->update([
                'status' => 'approved',
                'reviewed_by' => $reviewedBy,
                'reviewed_at' => now(),
                'review_notes' => $notes,
                'approved_at' => now(),
                'refund_amount' => $this->calculateRefund(
                    $cancellation->item
                ),
            ]);

            $cancellation->item->update([
                'cancellation_status' => 'approved',
            ]);

            return $cancellation->fresh();
        });
    }

    public function rejectCancellation(
        OrderCancellation $cancellation,
        ?int $reviewedBy = null,
        ?string $notes = null
    ): OrderCancellation {

        return DB::transaction(function () use (
            $cancellation,
            $reviewedBy,
            $notes
        ) {

            if ($cancellation->status !== 'requested') {
                throw new RuntimeException(
                    'Cancellation request is already processed.'
                );
            }

            $cancellation->update([
                'status' => 'rejected',
                'reviewed_by' => $reviewedBy,
                'reviewed_at' => now(),
                'review_notes' => $notes,
            ]);

            $cancellation->item->update([
                'cancellation_status' => 'rejected',
            ]);

            return $cancellation->fresh();
        });
    }

    public function completeCancellation(
        OrderCancellation $cancellation
    ): OrderCancellation {

        return DB::transaction(function () use (
            $cancellation
        ) {

            if ($cancellation->status !== 'approved') {
                throw new RuntimeException(
                    'Cancellation must be approved first.'
                );
            }

            $item = $cancellation->item;

            $item->update([
                'item_status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_status' => 'completed',
            ]);

            $cancellation->update([
                'status' => 'completed',
                'completed_at' => now(),
                'cancelled_at' => now(),
            ]);

            $this->refreshShipmentStatus(
                $item->shipment
            );

            $this->summaryService->refresh(
                $item->order
            );

            return $cancellation->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Return Review
    |--------------------------------------------------------------------------
    */

    public function approveReturn(
        OrderReturn $return,
        ?int $reviewedBy = null,
        ?string $notes = null
    ): OrderReturn {

        $return->update([
            'status' => 'approved',
            'reviewed_by' => $reviewedBy,
            'reviewed_at' => now(),
            'review_notes' => $notes,
        ]);

        $return->item->update([
            'return_status' => 'approved',
        ]);

        return $return->fresh();
    }

    public function rejectReturn(
        OrderReturn $return,
        ?int $reviewedBy = null,
        ?string $notes = null
    ): OrderReturn {

        $return->update([
            'status' => 'rejected',
            'reviewed_by' => $reviewedBy,
            'reviewed_at' => now(),
            'review_notes' => $notes,
        ]);

        $return->item->update([
            'return_status' => 'rejected',
        ]);

        return $return->fresh();
    }

    /*
    |--------------------------------------------------------------------------
    | Replacement Review
    |--------------------------------------------------------------------------
    */

    public function approveReplacement(
        OrderReplacement $replacement,
        ?int $reviewedBy = null,
        ?string $notes = null
    ): OrderReplacement {

        $replacement->update([
            'status' => 'approved',
            'reviewed_by' => $reviewedBy,
            'approved_at' => now(),
            'review_notes' => $notes,
        ]);

        $replacement->item->update([
            'replacement_status' => 'approved',
        ]);

        return $replacement->fresh();
    }

    public function rejectReplacement(
        OrderReplacement $replacement,
        ?int $reviewedBy = null,
        ?string $notes = null
    ): OrderReplacement {

        $replacement->update([
            'status' => 'rejected',
            'reviewed_by' => $reviewedBy,
            'rejected_at' => now(),
            'review_notes' => $notes,
        ]);

        $replacement->item->update([
            'replacement_status' => 'rejected',
        ]);

        return $replacement->fresh();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    protected function ensureCancellationAllowed(
        OrderItem $item
    ): void {

        if (
            $item->cancellation_status === 'requested'
            || $item->cancellation_status === 'approved'
        ) {
            throw new RuntimeException(
                'Cancellation request already exists.'
            );
        }

        if (! in_array(
            $item->item_status,
            [
                'pending',
                'confirmed',
                'packed',
            ],
            true
        )) {
            throw new RuntimeException(
                'Item is no longer eligible for cancellation.'
            );
        }
    }

    protected function ensureReturnAllowed(
        OrderItem $item
    ): void {

        if (
            $item->return_status === 'requested'
            || $item->return_status === 'approved'
        ) {
            throw new RuntimeException(
                'Return request already exists.'
            );
        }

        if (
            $item->item_status !== 'delivered'
        ) {
            throw new RuntimeException(
                'Only delivered items can be returned.'
            );
        }
    }

    protected function ensureReplacementAllowed(
        OrderItem $item
    ): void {

        if (
            $item->replacement_status === 'requested'
            || $item->replacement_status === 'approved'
        ) {
            throw new RuntimeException(
                'Replacement request already exists.'
            );
        }

        if (
            $item->item_status !== 'delivered'
        ) {
            throw new RuntimeException(
                'Only delivered items can be replaced.'
            );
        }
    }

    protected function refreshShipmentStatus(
        $shipment
    ): void {

        if (! $shipment) {
            return;
        }

        $shipment->loadMissing('items');

        $remaining = $shipment->items
            ->whereNotIn(
                'item_status',
                [
                    'cancelled',
                    'returned',
                ]
            )
            ->count();

        if ($remaining === 0) {

            $this->statusEngine
                ->updateShipmentStatus(
                    $shipment,
                    'cancelled',
                    [
                        'provider_status' => 'Cancelled',
                    ]
                );
        }
    }

    protected function calculateRefund(
        OrderItem $item
    ): float {

        /*
        |--------------------------------------------------------------------------
        | Placeholder for RefundCalculator
        |--------------------------------------------------------------------------
        |
        | This will later become:
        |
        | RefundCalculator::calculate($item)
        |
        | taking into account
        |
        | - Coupons
        | - Shipping
        | - Platform Commission
        | - Seller Penalty
        | - Taxes
        |
        */

        return (float) $item->subtotal;
    }

    protected function nextNumber(
        string $prefix
    ): string {

        return sprintf(
            '%s-%s-%06d',
            strtoupper($prefix),
            now()->format('Ym'),
            random_int(1, 999999)
        );
    }

    public function refreshOrder(
        Order $order
    ): void {

        $this->summaryService
            ->refresh($order);
    }
}
