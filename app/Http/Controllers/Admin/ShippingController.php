<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\Shipping\ShiprocketService;
use App\Models\ShippingLog;
use Illuminate\Support\Facades\Log;

class ShippingController extends Controller
{
    public function createShipment(Request $request, Order $order, ShiprocketService $ship)
    {
        try {
            $resp = $ship->createShipment($order);
            return back()->with('success', 'Shipment created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function markDelivered(Request $request, Order $order, ShiprocketService $ship)
    {
        try {
            $resp = $ship->markDelivered($order);
            return back()->with('success', 'Order marked delivered (mock mode)');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // View shipping logs for the order
    public function logs(Order $order)
    {
        $logs = ShippingLog::where('order_id', $order->id)->latest()->paginate(50);

        return view('admin.shippinglogs.order_logs', compact('order', 'logs'));
    }
}
