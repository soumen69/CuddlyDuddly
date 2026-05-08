<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;

class CheckoutController extends Controller
{

    public function saveAddress(Request $request)
    {
        if (!auth('customer')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $userId = auth('customer')->id();

        // ✅ VALIDATION (MANDATORY)
        $request->validate([
            'shipping_name'   => 'required|string|max:100',
            'shipping_phone'  => 'required|string|max:20',
            'shipping_email'  => 'nullable|email|max:100',
            'address_line1'   => 'required|string|max:255',
            'address_line2'   => 'nullable|string|max:255',
            'landmark'        => 'nullable|string|max:255',
            'city'            => 'required|string|max:100',
            'state'           => 'required|string|max:100',
            'postal_code'     => 'required|string|max:20',
            'country'         => 'required|string|max:100',
            'is_default'      => 'nullable|boolean',
        ]);

        // ✅ DEFAULT LOGIC
        $isDefault = $request->is_default ?? false;

        // 👉 If user has NO address → force default
        $hasAddress = ShippingAddress::where('user_id', $userId)->exists();

        if (!$hasAddress) {
            $isDefault = true;
        }

        // 👉 If this is default → unset previous defaults
        if ($isDefault) {
            ShippingAddress::where('user_id', $userId)
                ->update(['is_default' => 0]);
        }

        // ✅ CREATE ADDRESS
        $address = ShippingAddress::create([
            'user_id'         => $userId,
            'shipping_name'   => $request->shipping_name,
            'shipping_phone'  => $request->shipping_phone,
            'shipping_email'  => $request->shipping_email,
            'address_line1'   => $request->address_line1,
            'address_line2'   => $request->address_line2,
            'landmark'        => $request->landmark, // ✅ NEW FIELD
            'city'            => $request->city,
            'state'           => $request->state,
            'postal_code'     => $request->postal_code,
            'country'         => $request->country,
            'is_default'      => $isDefault,
        ]);

        return response()->json([
            'success' => true,
            'id' => $address->id,
            'is_default' => $address->is_default
        ]);
    }

    public function initiate(Request $request)
    {
        // 🔐 AUTH CHECK
        if (!auth('customer')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to continue'
            ], 401);
        }

        $userId = auth('customer')->id();

        // 🛒 FETCH CART FROM DB (NOT SESSION)
        $cartItems = Cart::with([
            'product',
            'variant'
        ])
            ->where('user_id', $userId)
            ->where('is_ordered', false)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ]);
        }

        // 📍 ADDRESS VALIDATION
        if (!$request->address_id) {
            return response()->json([
                'success' => false,
                'message' => 'Address is required'
            ]);
        }

        $addressExists = ShippingAddress::where('id', $request->address_id)
            ->where('user_id', $userId)
            ->exists();

        if (!$addressExists) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid address'
            ]);
        }

        // 💰 CALCULATE TOTAL + STOCK CHECK
        $total = 0;
        $cartSnapshot = [];

        foreach ($cartItems as $item) {

            $product = $item->product;
            $variant = $item->variant;

            $price = $variant?->price ?? $product->price;
            $stock = $variant?->stock ?? $product->stock;

            if ($stock < $item->quantity)
                $total += $price * $item->quantity;

            $cartSnapshot[] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'qty' => $item->quantity, // API consistency
                'price' => $price
            ];
        }

        // 🔐 STORE PENDING ORDER IN SESSION
        session([
            'pending_order' => [
                'user_id' => $userId,
                'address_id' => $request->address_id,
                'amount' => $total,
                'cart_hash' => md5(json_encode($cartSnapshot)),
            ]
        ]);

        // 🧪 MOCK MODE (DEV SAFE)
        if (app()->environment('local') || config('services.payment_mode') === 'mock') {

            return response()->json([
                'success' => true,
                'mode' => 'mock'
            ]);
        }

        // 💳 REAL MODE (RAZORPAY)
        try {

            $api = new \Razorpay\Api\Api(
                config('services.razorpay.key_id'),
                config('services.razorpay.key_secret')
            );

            $razorpayOrder = $api->order->create([
                'amount' => (int) round($total * 100), // 🔥 always integer
                'currency' => 'INR',
                'receipt' => 'order_' . uniqid(), // optional but good
            ]);
        } catch (\Exception $e) {

            Log::error('Razorpay Initiate Failed', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment initialization failed. Please try again.'
            ]);
        }

        // 🧠 STORE ORDER ID
        session()->put('pending_order.razorpay_order_id', $razorpayOrder['id']);

        // 📤 RESPONSE
        return response()->json([
            'success' => true,
            'mode' => 'razorpay',
            'order_id' => $razorpayOrder['id'],
            'amount' => (int) round($total * 100),
            'key' => config('services.razorpay.key_id')
        ]);
    }

    public function success(Request $request)
    {
        $pending = session('pending_order');

        if (!$pending) {
            return response()->json(['success' => false, 'message' => 'Session expired']);
        }

        // ✅ MOCK MODE
        if (app()->environment('local') || config('services.payment_mode') === 'mock') {
            return $this->createOrder($pending, $request);
        }

        // ✅ VALIDATE REQUEST
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        // ✅ MATCH ORDER ID
        if ($pending['razorpay_order_id'] !== $request->razorpay_order_id) {
            return response()->json(['success' => false, 'message' => 'Order mismatch']);
        }

        $api = new \Razorpay\Api\Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );

        // ✅ VERIFY SIGNATURE
        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed'
            ]);
        }

        // ✅ VERIFY PAYMENT STATUS
        try {
            $payment = $api->payment->fetch($request->razorpay_payment_id);

            if ($payment->status !== 'captured') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not captured'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment validation failed'
            ]);
        }

        return $this->createOrder($pending, $request);
    }

    private function createOrder($pending, $request)
    {
        return DB::transaction(function () use ($pending, $request) {

            // 🚫 DUPLICATE PROTECTION
            if (!empty($request->razorpay_payment_id)) {
                $existing = Order::where('razorpay_payment_id', $request->razorpay_payment_id)->first();

                if ($existing) {
                    $existing->load(['items.product.images', 'shippingAddress']);

                    return response()->json([
                        'success' => true,
                        'order' => $this->formatOrder($existing)
                    ]);
                }
            }

            $userId = $pending['user_id'];

            $cartItems = Cart::with(['product', 'variant'])
                ->where('user_id', $userId)
                ->where('is_ordered', false)
                ->get();

            // ✅ FIXED
            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart empty');
            }

            // 🔐 CART SNAPSHOT VALIDATION
            $cartSnapshot = [];

            foreach ($cartItems as $item) {
                $price = $item->variant?->price ?? $item->product->price;

                $cartSnapshot[] = [
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'qty' => $item->quantity,
                    'price' => $price
                ];
            }

            if (md5(json_encode($cartSnapshot)) !== $pending['cart_hash']) {
                throw new \Exception('Cart modified');
            }

            // 🔒 STOCK CHECK
            foreach ($cartItems as $item) {
                $stock = $item->variant?->stock ?? $item->product->stock;

                if ($stock < $item->quantity) {
                    throw new \Exception("Item out of stock");
                }
            }

            // ✅ CREATE ORDER
            $order = Order::create([
                'user_id' => $userId,
                'shipping_address_id' => $pending['address_id'],
                'order_number' => 'ORD-' . strtoupper(Str::random(12)),
                'total_amount' => $pending['amount'],
                'payment_method' => 'online',
                'payment_status' => 'paid',
                'order_status' => 'placed',
                'razorpay_order_id' => $pending['razorpay_order_id'] ?? null,
                'razorpay_payment_id' => $request->razorpay_payment_id ?? null,
            ]);

            foreach ($cartItems as $item) {

                // ✅ FIXED PRICE SOURCE
                $price = $item->variant?->price ?? $item->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'subtotal' => $price * $item->quantity,
                ]);

                // 🔻 REDUCE STOCK
                if ($item->variant) {
                    $item->variant->decrement('stock', $item->quantity);
                } else {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // 🧹 CLEAR CART
            Cart::where('user_id', $userId)
                ->where('is_ordered', false)
                ->delete();

            session()->forget('pending_order');

            // ✅ LOAD RELATIONS (FIXED)
            $order->load([
                'items.product.images',
                'shippingAddress'
            ]);

            return response()->json([
                'success' => true,
                'order' => $this->formatOrder($order) ?? []
            ]);
        });
    }

    private function formatOrder($order)
    {
        $addr = $order->shippingAddress;

        return [
            'id' => $order->order_number,
            'date' => $order->created_at->format('M d, Y'),
            'payment_method' => 'Online',
            'address' => "{$addr->address_line1}, {$addr->city}, {$addr->state} - {$addr->postal_code}",
            'total' => $order->total_amount,
            'items' => $order->items->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'qty' => (int) $item->quantity, // 🔥 force integer
                    'price' => (float) $item->price,
                    'image' => optional($item->product->images->first())->image_path
                ];
            })->values(),
        ];
    }

    public function orderHistory()
    {
        return view('website.order-history');
    }
}
