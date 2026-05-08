<?php

namespace App\Services\Payment;

use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\SettlementsLog;

class RazorpayRouteService
{
    protected $api;
    protected $mock;

    public function __construct()
    {
        $this->mock = !app()->environment('production');
        if (!$this->mock) {
            $this->api = new Api(
                config('services.razorpay.key_id'),
                config('services.razorpay.key_secret')
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 1. CREATE RAZORPAY ORDER
    |--------------------------------------------------------------------------
    */
    public function createOrder(Order $order)
    {
        if ($this->mock) {
            $fakeOrderId = 'order_' . uniqid();
            $order->update(['razorpay_order_id' => $fakeOrderId]);

            PaymentLog::create([
                'event' => 'mock.order.created',
                'payload' => ['razorpay_order_id' => $fakeOrderId]
            ]);

            return ['razorpay_order_id' => $fakeOrderId];
        }

        // REAL Razorpay order
        $rzpOrder = $this->api->order->create([
            'amount'   => $order->total_amount * 100,
            'currency' => 'INR',
            'receipt'  => $order->order_number,
        ]);

        $order->update(['razorpay_order_id' => $rzpOrder['id']]);

        PaymentLog::create([
            'event'   => 'rzp.order.created',
            'payload' => $rzpOrder
        ]);

        return $rzpOrder;
    }

    /*
    |--------------------------------------------------------------------------
    | 2. CAPTURE PAYMENT
    |--------------------------------------------------------------------------
    */
    public function capturePayment($paymentId, Order $order)
    {
        if ($this->mock) {
            $order->update(['payment_status' => 'paid']);

            PaymentLog::create([
                'event'   => 'mock.payment.captured',
                'payload' => ['payment_id' => $paymentId],
            ]);

            return ['status' => 'paid'];
        }

        try {
            // Razorpay REAL payment capture
            $payment = $this->api->payment
                ->fetch($paymentId)
                ->capture([
                    'amount' => $order->total_amount * 100,
                ]);

            // Mark order as paid AFTER successful capture
            $order->update([
                'payment_status'        => 'paid',
                'razorpay_payment_id'   => $paymentId, // if you added this column
            ]);

            PaymentLog::create([
                'event'   => 'rzp.payment.captured',
                'payload' => $payment,
            ]);

            return $payment;
        } catch (\Exception $e) {

            // Log what failed — DO NOT mark paid
            PaymentLog::create([
                'event'   => 'rzp.payment.capture_failed',
                'payload' => [
                    'payment_id' => $paymentId,
                    'order_id'   => $order->id,
                    'error'      => $e->getMessage(),
                ],
            ]);

            // rethrow so your system knows capture failed
            throw $e;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HOLD, REFUND, SETTLEMENT (use your existing mock logic here)
    |--------------------------------------------------------------------------
    */

    public function startHold(Order $order)
    {
        $order->update([
            'settlement_status' => 'on_hold',
            'hold_until' => now()->addDays(7)
        ]);
    }

    public function refund(Order $order, $amount)
    {
        if (!$this->mock) {
            $this->api->payment
                ->fetch($order->razorpay_payment_id)
                ->refund(['amount' => $amount * 100]);
        }

        $order->update([
            'refund_status' => 'refunded',
            'refund_amount' => $amount
        ]);
    }

    public function settle(Order $order)
    {
        foreach ($order->items as $item) {
            $item->update([
                'settlement_status' => 'settled'
            ]);
        }

        SettlementsLog::create([
            'settlement_batch_id'     => 'mock_batch_' . uniqid(),
            'total_settlement_amount' => $order->items->sum('seller_amount'),
            'total_commission'        => $order->items->sum('commission_amount'),
            'payload'                 => []
        ]);

        $order->update([
            'settlement_status' => 'settled'
        ]);

        PaymentLog::create([
            'event'   => 'mock.settlement.completed',
            'payload' => ['order_id' => $order->id]
        ]);
    }
}
