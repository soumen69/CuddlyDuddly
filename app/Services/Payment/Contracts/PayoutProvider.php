<?php

namespace App\Services\Payment\Contracts;

use App\Models\Shipment;

interface PayoutProvider
{
    public function payout(
        Shipment $shipment
    ): array;

    public function status(
        string $payoutId
    ): array;

    public function supportsPayouts(): bool;

    public function name(): string;
}
