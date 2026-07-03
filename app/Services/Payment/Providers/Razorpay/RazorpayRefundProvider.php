<?php

namespace App\Services\Payment\Providers\Razorpay;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Payment\Contracts\RefundProvider;
use Razorpay\Api\Api;

class RazorpayRefundProvider implements RefundProvider
{
    public function refund(
        Order $order,
        OrderItem $item,
        float $amount,
        string $reason = ''
    ): array {

        $api = new Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );

        $refund = $api
            ->payment
            ->fetch($order->razorpay_payment_id)
            ->refund([
                'amount' => (int) round($amount * 100),
                'notes' => [
                    'order' => $order->order_number,
                    'item' => $item->id,
                    'reason' => $reason,
                ]
            ]);

        return [

            'success' => true,

            'provider' => 'razorpay',

            'refund_id' => $refund['id'],

            'payment_id' => $order->razorpay_payment_id,

            'amount' => $amount,

            'status' => $refund['status'],

            'reason' => $reason,

            'processed_at' => now(),

        ];
    }
}
