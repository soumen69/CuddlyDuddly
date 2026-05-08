<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Utility;
use Razorpay\Api\Errors\SignatureVerificationError;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\SettlementsLog;

class RazorpayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        $secret    = config('services.razorpay.webhook_secret');

        try {
            Utility::verifyWebhookSignature($payload, $signature, $secret);
        } catch (SignatureVerificationError $e) {
            Log::warning('Razorpay webhook signature failed', ['err' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $data = json_decode($payload, true);
        $event = $data['event'] ?? 'unknown';

        // store raw webhook
        PaymentLog::create([
            'event' => $event,
            'payload' => $data,
            'source' => 'razorpay'
        ]);

        // idempotency: if this payment.id already processed, skip essential events
        $paymentId = $data['payload']['payment']['entity']['id'] ?? null;
        if ($paymentId && PaymentLog::where('payload->payload->payment->entity->id', $paymentId)->where('event', 'payment.captured')->exists()) {
            // Already processed capture — return success
            return response()->json(['status' => 'already_processed']);
        }

        switch ($event) {
            case 'payment.captured':
                return $this->paymentCaptured($data);
            case 'order.paid':
                return $this->orderPaid($data);
            case 'payment.failed':
                return $this->paymentFailed($data);
            case 'refund.processed':
                return $this->refundProcessed($data);
            case 'settlement.processed':
                return $this->settlementProcessed($data);
            default:
                return response()->json(['status' => 'ignored']);
        }
    }

    private function paymentCaptured(array $data)
    {
        $payment = $data['payload']['payment']['entity'] ?? null;
        if (!$payment) return response()->json(['status' => 'no_payment'], 200);

        $rzpOrderId = $payment['order_id'] ?? null;
        $paymentId  = $payment['id'] ?? null;

        $order = Order::where('razorpay_order_id', $rzpOrderId)->first();
        if (!$order) return response()->json(['status' => 'order_not_found'], 200);

        // save razorpay payment id if you want to refund later
        $order->update([
            'payment_status' => 'paid',
            'razorpay_payment_id' => $paymentId, // ensure column exists in orders table
        ]);

        return response()->json(['status' => 'payment_captured']);
    }

    private function orderPaid($data)
    {
        $rzpOrderId = $data['payload']['order']['entity']['id'];

        $order = Order::where('razorpay_order_id', $rzpOrderId)->first();

        if ($order) {
            $order->update(['payment_status' => 'paid']);
        }

        return response()->json(['status' => 'order_paid']);
    }

    private function paymentFailed($data)
    {
        $payment = $data['payload']['payment']['entity'];
        $rzpOrderId = $payment['order_id'];

        $order = Order::where('razorpay_order_id', $rzpOrderId)->first();

        if ($order) {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['status' => 'payment_failed']);
    }

    private function refundProcessed($data)
    {
        $refund = $data['payload']['refund']['entity'];
        $paymentId = $refund['payment_id'];
        $amount = $refund['amount'] / 100;

        $order = Order::where('razorpay_payment_id', $paymentId)->first();

        if ($order) {
            $order->update([
                'refund_status' => 'paid',
                'refund_amount' => $amount
            ]);
        }

        return response()->json(['status' => 'refund_processed']);
    }

    private function settlementProcessed($data)
    {
        $settlement = $data['payload']['settlement']['entity'];

        SettlementsLog::create([
            'settlement_batch_id'       => $settlement['id'] ?? null,
            'total_settlement_amount'   => ($settlement['amount'] ?? 0) / 100,
            'total_commission'          => ($settlement['fees'] ?? 0) / 100,
            'payload'                   => $data
        ]);

        return response()->json(['status' => 'settlement_logged']);
    }
}
