<?php

namespace App\Services\Payment;

use App\Models\Shipment;
use App\Services\Payment\Contracts\PayoutProvider;

class PayoutService
{
    public function __construct(
        protected PayoutProvider $provider
    ) {}

    public function pay(
        Shipment $shipment
    ): array {

        return $this->provider
            ->payout($shipment);
    }

    public function status(
        string $payoutId
    ): array {

        return $this->provider
            ->status($payoutId);
    }

    public function provider(): string
    {
        return $this->provider->name();
    }
}
