<?php

namespace App\Services\Payment\Providers\Mock;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentProvider;

class MockPaymentProvider implements PaymentProvider
{
    public function name(): string
    {
        return 'mock';
    }

    public function supportsCapture(): bool
    {
        return true;
    }

    public function supportsWebhook(): bool
    {
        return false;
    }

    public function createOrder(
        Order $order
    ): array {

        return [

            'provider' => 'mock',

            'order_id' => 'mock_order_' . uniqid(),

            'amount' => $order->total_amount,

            'currency' => 'INR',

            'status' => 'created',

        ];
    }

    public function verifyPayment(
        array $payload
    ): array {

        return [

            'verified' => true,

            'provider' => 'mock',

            'payment_id' =>
            'mock_payment_' . uniqid(),

        ];
    }

    public function capturePayment(
        Order $order,
        string $paymentId
    ): array {

        return [

            'provider' => 'mock',

            'payment_id' => $paymentId,

            'status' => 'captured',

            'captured_at' => now(),

        ];
    }

    public function fetchPayment(
        string $paymentId
    ): array {

        return [

            'payment_id' => $paymentId,

            'status' => 'captured',

            'provider' => 'mock',

        ];
    }

    public function webhook(
        array $payload
    ): array {

        return [

            'provider' => 'mock',

            'processed' => true,

            'payload' => $payload,

        ];
    }

    public function verifyWebhook(
        string $body,
        string $signature
    ): bool {
        return true;
    }
}
