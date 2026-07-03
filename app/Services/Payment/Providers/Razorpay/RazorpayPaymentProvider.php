<?php

namespace App\Services\Payment\Providers\Razorpay;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentProvider;
use Razorpay\Api\Api;

class RazorpayPaymentProvider implements PaymentProvider
{
    protected Api $api;

    public function __construct()
    {
        $this->api = new Api(

            config('services.razorpay.key_id'),

            config('services.razorpay.key_secret')

        );
    }

    public function name(): string
    {
        return 'razorpay';
    }

    public function supportsCapture(): bool
    {
        return true;
    }

    public function supportsWebhook(): bool
    {
        return true;
    }

    public function createOrder(
        Order $order
    ): array {

        $response = $this->api
            ->order
            ->create([

                'receipt' =>
                $order->order_number,

                'amount' =>
                intval(
                    round(
                        $order->total_amount * 100
                    )
                ),

                'currency' => 'INR',

                'payment_capture' =>
                config(
                    'payment.capture_mode'
                ) === 'automatic'
                    ? 1
                    : 0,

            ]);

        return $response->toArray();
    }

    public function verifyPayment(
        array $payload
    ): array {

        $this->api
            ->utility
            ->verifyPaymentSignature([
                'razorpay_order_id' =>
                $payload['razorpay_order_id'],

                'razorpay_payment_id' =>
                $payload['razorpay_payment_id'],

                'razorpay_signature' =>
                $payload['razorpay_signature'],
            ]);

        return [

            'verified' => true,

            'payment_id' =>
            $payload['razorpay_payment_id'],

        ];
    }

    public function capturePayment(
        Order $order,
        string $paymentId
    ): array {

        $payment = $this->api
            ->payment
            ->fetch($paymentId)
            ->capture([

                'amount' =>
                intval(
                    round(
                        $order->total_amount * 100
                    )
                )

            ]);

        return $payment->toArray();
    }

    public function fetchPayment(
        string $paymentId
    ): array {

        return $this->api
            ->payment
            ->fetch($paymentId)
            ->toArray();
    }

    public function webhook(
        array $payload
    ): array {

        return $payload;
    }

    public function verifyWebhook(string $body, string $signature): bool
    {
        $this->api
            ->utility
            ->verifyWebhookSignature(
                $body,
                $signature,
                config('services.razorpay.webhook_secret')
            );
        return true;
    }
}
