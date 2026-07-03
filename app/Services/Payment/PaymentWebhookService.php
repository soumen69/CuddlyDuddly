<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\OrderReturn;
use Illuminate\Support\Facades\DB;
use App\Services\Order\OrderPlacementService;

class PaymentWebhookService
{
    public function __construct(
        protected PaymentGateway $gateway,
        protected OrderPlacementService $orderPlacementService
    ) {}

    public function handle(array $payload): void
    {
        DB::transaction(function () use ($payload) {

            $event = $payload['event'] ?? '';

            match ($event) {

                'payment.captured'
                => $this->paymentCaptured($payload),

                'payment.failed'
                => $this->paymentFailed($payload),

                'refund.processed'
                => $this->refundProcessed($payload),

                default => null,
            };
        });
    }

    protected function paymentCaptured(array $payload): void
    {
        $entity = $payload['payload']['payment']['entity'] ?? [];

        $order = Order::where(
            'razorpay_order_id',
            $entity['order_id'] ?? null
        )->first();

        if (! $order) {
            return;
        }

        $order->update([
            'payment_status' => 'paid',
            'razorpay_payment_id' => $entity['id'],
        ]);
    }

    protected function paymentFailed(array $payload): void
    {
        $entity = $payload['payload']['payment']['entity'] ?? [];

        $order = Order::where(
            'razorpay_order_id',
            $entity['order_id'] ?? null
        )->first();

        if (! $order) {
            return;
        }

        $order->update([
            'payment_status' => 'failed',
        ]);
    }

    protected function refundProcessed(array $payload): void
    {
        $entity = $payload['payload']['refund']['entity'] ?? [];
        if (empty($entity)) {
            return;
        }

        $return = OrderReturn::where(
            'razorpay_refund_id',
            $entity['id']
        )->first();

        if (! $return) {
            return;
        }

        $refundStatus = match (strtolower($entity['status'] ?? '')) {

            'processed'
            => 'paid',

            'pending'
            => 'processing',

            'failed'
            => 'failed',

            default
            => 'pending',
        };

        $metadata = $return->metadata ?? [];

        $metadata['refund'] = $entity;

        $return->update([

            'refund_status' => $refundStatus,

            'metadata' => $metadata,

        ]);

        if (
            $refundStatus === 'paid'
            &&
            $return->status !== 'refunded'
        ) {

            $return->update([

                'status' => 'refunded',

            ]);
        }
    }
}
