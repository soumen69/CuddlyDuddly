<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Utility;
use App\Models\SettlementsLog;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Log;

class RazorpayXWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        $secret = config('services.razorpayx.webhook_secret');

        try {
            Utility::verifyWebhookSignature($payload, $signature, $secret);
        } catch (\Exception $e) {
            Log::error("RazorpayX Webhook Invalid Signature", [
                'signature' => $signature,
                'body' => $payload
            ]);
            return response()->json(['error' => 'Invalid Signature'], 400);
        }

        $data  = json_decode($payload, true);
        $event = $data['event'] ?? 'unknown';
        PaymentLog::create([
            'event'   => $event,
            'payload' => $data,
            'source'  => 'razorpayx'
        ]);

        try {
            match ($event) {
                'settlement.processed' => $this->recordSettlement($data),
                'settlement.failed'    => $this->recordFailed($data),
                default                => null,
            };
        } catch (\Exception $e) {
            Log::error("RazorpayX Webhook Error", [
                'event' => $event,
                'error' => $e->getMessage()
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    private function recordSettlement(array $data)
    {
        $settlement = $data['payload']['settlement']['entity'] ?? null;
        if (!$settlement) return;

        SettlementsLog::create([
            'settlement_batch_id'     => $settlement['id'],
            'total_settlement_amount' => ($settlement['amount'] ?? 0) / 100,
            'total_commission'        => ($settlement['fees'] ?? 0) / 100,
            'payload'                 => $data
        ]);
    }

    private function recordFailed(array $data)
    {
        $settlement = $data['payload']['settlement']['entity'] ?? null;
        if (!$settlement) return;

        SettlementsLog::create([
            'settlement_batch_id'     => $settlement['id'],
            'total_settlement_amount' => 0,
            'total_commission'        => 0,
            'payload'                 => $data
        ]);
    }
}
