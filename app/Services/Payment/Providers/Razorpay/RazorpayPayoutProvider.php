<?php

namespace App\Services\Payment\Providers\Razorpay;

use App\Models\Shipment;
use App\Services\Payment\Contracts\PayoutProvider;
use Razorpay\Api\Api;

class RazorpayPayoutProvider implements PayoutProvider
{
    protected Api $api;

    public function __construct()
    {
        $this->api = new Api(

            config('services.razorpayx.key'),

            config('services.razorpayx.secret')

        );
    }

    public function name(): string
    {
        return 'razorpayx';
    }

    public function supportsPayouts(): bool
    {
        return true;
    }

    public function payout(Shipment $shipment): array
    {

        /*
        Seller bank account will be used here
        after seller onboarding is complete.
        */

        return [
            'provider' => 'razorpayx',
            'status' => 'queued',
            'payout_id' => null,
            'reference_id' => $shipment->order->order_number,
            'seller_id' => $shipment->seller_id,
            'amount' => $shipment->items->sum('seller_amount'),
        ];
    }

    public function status(string $payoutId): array
    {
        return [
            'provider' => 'razorpayx',
            'status' => 'queued',
            'payout_id' => $payoutId,
        ];
    }
}
