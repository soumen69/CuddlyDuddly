<?php

namespace App\Services\Shipping;

use App\Models\Order;
use App\Models\Shipment;
use App\Models\ShippingLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ShiprocketService
{
    protected $token;
    protected $mock;

    public function __construct()
    {
        $this->mock = !app()->environment('production');

        if ($this->mock) {
            return;
        }

        $this->token = config('services.shiprocket.token')
            ?: $this->login();
    }

    private function login()
    {
        $cacheKey = 'shiprocket.token';

        if ($t = Cache::get($cacheKey)) {
            return $t;
        }

        $response = Http::post(
            config('services.shiprocket.base_url') . '/auth/login',
            [
                'email' => config('services.shiprocket.email'),
                'password' => config('services.shiprocket.password'),
            ]
        );

        if ($response->failed()) {
            throw new \Exception("Shiprocket Login Failed: " . $response->body());
        }

        $token = $response->json('token');
        Cache::put($cacheKey, $token, now()->addMinutes(50));

        return $token;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE SHIPMENT
    |--------------------------------------------------------------------------
    */
    public function createShipment(Order $order)
    {
        // Ensure shipment row exists
        $shipment = $order->shipment()->firstOrCreate([
            'order_id' => $order->id,
            'provider' => 'shiprocket',
            'status'   => 'pending',
        ]);

        if ($this->mock) {

            $awb = 'AWB' . rand(100000, 999999);
            $sid = 'SHIP' . uniqid();

            $shipment->update([
                'awb_number'  => $awb,
                'shipment_id' => $sid,
                'status'      => 'awb_assigned',
            ]);

            ShippingLog::create([
                'order_id'   => $order->id,
                'event_name' => 'MOCK_AWB_CREATED',
                'payload'    => ['awb' => $awb, 'shipment_id' => $sid],
            ]);

            return ['mock' => true, 'awb_number' => $awb];
        }

        // REAL MODE
        $url = config('services.shiprocket.base_url') . '/shipments/create/forward-shipment';

        $response = Http::withToken($this->token)
            ->post($url, [
                "order_id"   => $order->order_number,
                "order_date" => now()->toDateString(),
                "pickup_location" => "Primary",

                "billing_customer_name" => $order->shippingAddress->shipping_name,
                "billing_address"       => $order->shippingAddress->address_line1,
                "billing_city"          => $order->shippingAddress->city,
                "billing_pincode"       => $order->shippingAddress->postal_code,
                "billing_state"         => $order->shippingAddress->state,
                "billing_country"       => "India",
                "billing_email"         => $order->shippingAddress->shipping_email,
                "billing_phone"         => $order->shippingAddress->shipping_phone,

                "order_items" => $order->items->map(fn($i) => [
                    "name"     => $i->product->name,
                    "sku"      => "SKU-" . $i->product_id,
                    "units"    => $i->quantity,
                    "selling_price" => $i->price,
                ])->toArray(),

                "payment_method" => $order->payment_method === 'cod' ? "COD" : "Prepaid",
                "sub_total"      => (float) $order->total_amount,

                "length"  => 10,
                "breadth" => 10,
                "height"  => 10,
                "weight"  => 1,
            ]);

        if ($response->failed()) {
            throw new \Exception("Shipment creation failed: " . $response->body());
        }

        $json = $response->json();

        $shipment->update([
            'awb_number'  => $json['awb_code'] ?? null,
            'shipment_id' => $json['shipment_id'] ?? null,
            'status'      => 'awb_assigned',
            'payload_last' => $json,
        ]);

        ShippingLog::create([
            'order_id'   => $order->id,
            'event_name' => 'AWB_CREATED',
            'payload'    => $json,
        ]);

        return $json;
    }

    /*
    |--------------------------------------------------------------------------
    | MARK DELIVERED (MOCK MODE ONLY)
    |--------------------------------------------------------------------------
    */
    public function markDelivered(Order $order)
    {
        $shipment = $order->shipment;

        if ($this->mock) {
            $shipment->update([
                'status'         => 'delivered',
                'delivered_at'   => now(),
                'settlement_status' => 'on_hold',
                'hold_until'     => now()->addDays(7),
            ]);

            ShippingLog::create([
                'order_id'   => $order->id,
                'event_name' => 'MOCK_DELIVERED',
                'payload'    => []
            ]);

            return ['mock' => true, 'status' => 'delivered'];
        }

        return ['status' => 'use_webhook'];
    }


    public function checkPincode(string $pincode, $weight = 0.5)
    {
        // ================= MOCK MODE =================
        if ($this->mock) {

            // simulate realistic behavior
            if (in_array($pincode, ['700001', '110001', '560001'])) {
                return [
                    'serviceable' => true,
                    'delivery_days' => rand(1, 3),
                    'cod' => true,
                ];
            }

            return [
                'serviceable' => rand(0, 1) ? true : false,
                'delivery_days' => rand(3, 7),
                'cod' => rand(0, 1) ? true : false,
            ];
        }

        // ================= REAL MODE =================
        $url = config('services.shiprocket.base_url') . '/courier/serviceability';

        $response = Http::withToken($this->token)->get($url, [
            'pickup_postcode'   => config('services.shiprocket.pickup_pincode'),
            'delivery_postcode' => $pincode,
            'weight'            => $weight,
            'cod'               => 1
        ]);

        if ($response->failed()) {
            return ['serviceable' => false];
        }

        $data = $response->json();

        $couriers = $data['data']['available_courier_companies'] ?? [];

        if (empty($couriers)) {
            return ['serviceable' => false];
        }

        // pick best courier (fastest)
        $best = collect($couriers)->sortBy('estimated_delivery_days')->first();

        return [
            'serviceable' => true,
            'delivery_days' => $best['estimated_delivery_days'] ?? 5,
            'cod' => true // you can refine later
        ];
    }
}
