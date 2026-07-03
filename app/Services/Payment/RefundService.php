<?php

namespace App\Services\Payment;

use App\Models\OrderCancellation;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Services\Order\OrderSummaryService;
use App\Services\Payment\Contracts\RefundProvider;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RefundService
{
    public function __construct(
        protected RefundCalculator $calculator,
        protected RefundProvider $provider,
        protected OrderSummaryService $summaryService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Cancellation Refund
    |--------------------------------------------------------------------------
    */

    public function refundCancellation(
        OrderCancellation $cancellation
    ): array {

        return DB::transaction(function () use ($cancellation) {

            if ($cancellation->refund_status === 'paid') {
                throw new RuntimeException(
                    'Refund already processed.'
                );
            }

            $cancellation->loadMissing([
                'order',
                'item',
            ]);

            $item = $cancellation->item;

            $amount = $this->calculator
                ->calculate($item);

            $providerResponse = $this->provider
                ->refund(
                    $cancellation->order,
                    $item,
                    $amount,
                    'Order Cancellation'
                );

            $cancellation->update([

                'refund_amount' => $amount,

                'refund_status' => 'paid',

                'razorpay_refund_id' =>
                $providerResponse['refund_id'] ?? null,

                'metadata' => array_merge(
                    $cancellation->metadata ?? [],
                    [
                        'refund' => $providerResponse,
                    ]
                ),

            ]);

            $item->update([
                'settlement_status' => 'refunded',
            ]);

            $this->summaryService->refresh(
                $cancellation->order
            );

            return $providerResponse;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Return Refund
    |--------------------------------------------------------------------------
    */

    public function refundReturn(
        OrderReturn $return
    ): array {

        return DB::transaction(function () use ($return) {

            if ($return->refund_status === 'paid') {
                throw new RuntimeException(
                    'Refund already processed.'
                );
            }

            $return->loadMissing([
                'order',
                'item',
            ]);

            $item = $return->item;

            $amount = $this->calculator
                ->calculate($item);

            $providerResponse = $this->provider
                ->refund(
                    $return->order,
                    $item,
                    $amount,
                    'Order Return'
                );

            $return->update([

                'refund_amount' => $amount,

                'refund_status' => 'paid',

                'status' => 'refunded',

                'refunded_at' => now(),

                'razorpay_refund_id' =>
                $providerResponse['refund_id'] ?? null,

                'metadata' => array_merge(
                    $return->metadata ?? [],
                    [
                        'refund' => $providerResponse,
                    ]
                ),

            ]);

            $item->update([
                'settlement_status' => 'refunded',
            ]);

            $this->summaryService->refresh(
                $return->order
            );

            return $providerResponse;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Manual Refund
    |--------------------------------------------------------------------------
    */

    public function refundItem(
        OrderItem $item,
        string $reason
    ): array {

        return $this->provider->refund(

            $item->order,

            $item,

            $this->calculator->calculate(
                $item
            ),

            $reason

        );
    }
}
