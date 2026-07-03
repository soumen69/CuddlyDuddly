<?php

namespace App\Services\Payment\Providers\Mock;

use App\Models\Shipment;
use App\Services\Payment\Contracts\PayoutProvider;

class MockPayoutProvider implements PayoutProvider
{
    public function name(): string
    {
        return 'mock';
    }

    public function supportsPayouts(): bool
    {
        return true;
    }

    public function payout(Shipment $shipment): array
    {
        return [
            'provider' => 'mock',
            'payout_id' => 'PAYOUT-' . strtoupper(uniqid()),
            'utr' => strtoupper(uniqid('UTR')),
            'seller_id' => $shipment->seller_id,
            'amount' => $shipment->items->sum('seller_amount'),
            'status' => 'processed',
            'processed_at' => now(),
        ];
    }

    public function status(string $payoutId): array
    {
        return [
            'provider' => 'mock',
            'payout_id' => $payoutId,
            'status' => 'processed',
        ];
    }
}
