<?php

namespace App\Services\Payment;

use App\Models\Shipment;
use App\Services\Order\OrderSummaryService;
use Illuminate\Support\Facades\DB;
use App\Services\Payment\PayoutService;

class SettlementService
{
    public function __construct(
        protected PayoutService $payoutService,
        protected OrderSummaryService $summaryService
    ) {}

    public function release(
        Shipment $shipment
    ): Shipment {

        return DB::transaction(function () use ($shipment) {

            $shipment->refresh();

            if (! $this->eligible($shipment)) {
                return $shipment;
            }

            $payout = $this->payoutService->pay($shipment);
            $metadata = $shipment->provider_metadata ?? [];

            $metadata['settlement'] = [
                'released_at' => now(),
                'provider' => $this->payoutService->provider(),
                'response' => $payout,
            ];

            $shipment->update([
                'settlement_status' => 'released',
                'provider_metadata' => $metadata,
            ]);

            $shipment->items()->update(['settlement_status' => 'settled']);
            $this->summaryService->refresh($shipment->order);
            return $shipment->fresh();
        });
    }

    public function eligible(
        Shipment $shipment
    ): bool {

        return

            $shipment->status === 'delivered'

            &&

            $shipment->settlement_status === 'on_hold'

            &&

            $shipment->hold_until

            &&

            now()->greaterThanOrEqualTo(
                $shipment->hold_until
            );
    }
}
