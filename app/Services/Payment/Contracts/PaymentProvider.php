<?php

namespace App\Services\Payment\Contracts;

use App\Models\Order;

interface PaymentProvider
{
    public function createOrder(
        Order $order
    ): array;

    public function verifyPayment(
        array $payload
    ): array;

    public function capturePayment(
        Order $order,
        string $paymentId
    ): array;

    public function fetchPayment(
        string $paymentId
    ): array;

    public function webhook(
        array $payload
    ): array;

    public function supportsCapture(): bool;

    public function supportsWebhook(): bool;

    public function name(): string;

    public function verifyWebhook(string $body, string $signature): bool;
}
