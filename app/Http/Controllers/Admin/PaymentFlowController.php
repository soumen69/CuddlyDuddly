<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payment\RazorpayRouteService;

class PaymentFlowController extends Controller
{
    public function forceSettle($orderId, RazorpayRouteService $service)
    {
        $order = Order::findOrFail($orderId);

        $service->settle($order);

        return back()->with('success', 'Order settlement completed (mock).');
    }

    public function forceRefund($orderId, RazorpayRouteService $service)
    {
        $order = Order::findOrFail($orderId);

        $service->refund($order, $order->total_amount);

        return back()->with('success', 'Order refunded (mock).');
    }
}
