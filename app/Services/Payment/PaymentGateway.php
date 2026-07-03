<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentProvider;

class PaymentGateway
{
    public function __construct(
        protected PaymentProvider $provider
    ) {}

    public function provider(): string
    {
        return $this->provider->name();
    }

    public function createOrder(
        Order $order
    ): array {

        $response = $this->provider
            ->createOrder($order);

        $order->update([

            'razorpay_order_id' =>
            $response['id']
                ??
                $response['order_id']
                ??
                null,

        ]);

        return $response;
    }

    public function verify(
        array $payload
    ): array {

        return $this->provider
            ->verifyPayment($payload);
    }

    public function capture(
        Order $order,
        string $paymentId
    ): array {

        $response = $this->provider
            ->capturePayment(
                $order,
                $paymentId
            );

        $order->update([

            'payment_status' => 'paid',

            'razorpay_payment_id' =>
            $paymentId,

        ]);

        return $response;
    }

    public function payment(
        string $paymentId
    ): array {

        return $this->provider
            ->fetchPayment(
                $paymentId
            );
    }

    public function webhook(
        array $payload
    ): array {

        return $this->provider
            ->webhook(
                $payload
            );
    }

    public function supportsCapture(): bool
    {
        return $this->provider
            ->supportsCapture();
    }

    public function supportsWebhook(): bool
    {
        return $this->provider
            ->supportsWebhook();
    }

    public function verifyWebhook(
        string $body,
        string $signature
    ): bool {
        return $this->provider->verifyWebhook(
            $body,
            $signature
        );
    }
}
