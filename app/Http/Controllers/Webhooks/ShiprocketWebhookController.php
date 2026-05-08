<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ShippingLog;

class ShiprocketWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();
        $event = $data['event'] ?? 'unknown';
        $orderId = $data['data']['order_id'] ?? null;
        $awb     = $data['data']['awb'] ?? null;

        // Log all webhooks
        ShippingLog::create([
            'order_id'   => $orderId,
            'event_name' => $event,
            'payload'    => $data
        ]);

        if (!$orderId) {
            return response()->json(['status' => 'order_id_missing'], 422);
        }

        $order = Order::with('shipment')->find($orderId);
        if (!$order || !$order->shipment) {
            return response()->json(['status' => 'shipment_missing'], 404);
        }

        $shipment = $order->shipment;

        return match ($event) {
            'AWB Assigned'      => $shipment->update(['status' => 'awb_assigned', 'awb_number' => $awb]),
            'Pickup Scheduled'  => $shipment->update(['status' => 'pickup_scheduled']),
            'In Transit'        => $shipment->update(['status' => 'in_transit']),
            'Out For Delivery'  => $shipment->update(['status' => 'out_for_delivery']),
            'Delivered'         => $shipment->update([
                'status' => 'delivered',
                'delivered_at' => now(),
                'settlement_status' => 'on_hold',
                'hold_until' => now()->addDays(7),
            ]),
            'RTO Initiated'     => $shipment->update([
                'status' => 'rto_initiated',
                'rto_initiated_at' => now(),
            ]),
            'RTO Delivered'     => $shipment->update([
                'status' => 'rto_delivered',
                'rto_delivered_at' => now(),
                'settlement_status' => 'cancelled'
            ]),
            'Cancelled'         => $shipment->update(['status' => 'cancelled']),
            default             => response()->json(['status' => 'ignored']),
        };
    }
}
