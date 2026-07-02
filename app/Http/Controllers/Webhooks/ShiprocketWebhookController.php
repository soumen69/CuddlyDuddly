<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Jobs\SyncShipmentTrackingJob;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShiprocketWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->verifySignature($request);

        Log::info('Shiprocket Webhook', $request->all());

        $awb = data_get($request->all(), 'awb')
            ?? data_get($request->all(), 'data.awb')
            ?? data_get($request->all(), 'tracking_data.awb_code');

        if (blank($awb)) {
            return response()->json([
                'message' => 'Webhook received.'
            ]);
        }

        $shipment = Shipment::query()
            ->where('awb_number', $awb)
            ->first();

        if (!$shipment) {
            return response()->json([
                'message' => 'Shipment not found.'
            ]);
        }

        SyncShipmentTrackingJob::dispatch(
            $shipment->id
        );

        return response()->json([
            'message' => 'Tracking synchronization queued.'
        ]);
    }

    protected function verifySignature(Request $request): void
    {
        $configured = config(
            'services.shiprocket.webhook_secret'
        );

        if (blank($configured)) {
            return;
        }

        $signature = $request->header(
            'X-Shiprocket-Signature'
        );

        $expected = hash_hmac(
            'sha256',
            $request->getContent(),
            $configured
        );

        abort_unless(
            hash_equals(
                $expected,
                (string) $signature
            ),
            401,
            'Invalid webhook signature.'
        );
    }
}
