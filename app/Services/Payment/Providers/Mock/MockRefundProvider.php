<?php

namespace App\Services\Payment\Providers\Mock;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Payment\Contracts\RefundProvider;

class MockRefundProvider implements RefundProvider
{
    public function refund(
        Order $order,
        OrderItem $item,
        float $amount,
        string $reason = ''
    ): array {

        return [

            'success' => true,

            'provider' => 'mock',

            'refund_id' => 'MOCK-RFD-' . uniqid(),

            'payment_id' => $order->razorpay_payment_id,

            'amount' => $amount,

            'status' => 'processed',

            'reason' => $reason,

            'processed_at' => now(),

        ];
    }
}
