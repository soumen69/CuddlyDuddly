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
use App\Services\Order\OrderPlacementService;
use App\Services\Payment\PaymentGateway;

class CheckoutController extends Controller
{

    protected OrderPlacementService $orderPlacementService;
    protected PaymentGateway $paymentGateway;

    public function __construct(
        OrderPlacementService $orderPlacementService,
        PaymentGateway $paymentGateway
    ) {
        $this->orderPlacementService = $orderPlacementService;
        $this->paymentGateway = $paymentGateway;
    }

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
        if (config('payment.provider') === 'mock') {

            return response()->json([
                'success' => true,
                'mode' => 'mock'
            ]);
        }

        $order = new Order();

        $order->order_number =
            'TEMP-' . strtoupper(Str::random(12));

        $order->total_amount = $total;

        $response = $this->paymentGateway
            ->createOrder($order);

        session()->put(

            'pending_order.razorpay_order_id',

            $response['id']
                ??
                $response['order_id']

        );

        return response()->json([
            'success' => true,
            'mode' => $this->paymentGateway->provider(),
            'order_id' => $response['id'] ?? $response['order_id'],
            'amount' => intval(round($total * 100)),
            'key' => config('services.razorpay.key_id'),
        ]);
    }

    public function success(Request $request)
    {
        $pending = session('pending_order');

        if (!$pending) {
            return response()->json(['success' => false, 'message' => 'Session expired']);
        }

        // ✅ MOCK MODE
        if (config('payment.provider') === 'mock') {
            $order = $this->orderPlacementService->place($pending, $request);

            session()->forget('pending_order');

            return response()->json([
                'success' => true,
                'order' => $this->formatOrder($order),
            ]);
        }

        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        if ($pending['razorpay_order_id'] != $request->razorpay_order_id) {

            return response()->json([
                'success' => false,
                'message' => 'Order mismatch'
            ]);
        }

        $this->paymentGateway->verify(
            $request->only([
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
            ])
        );

        $tempOrder = new Order();

        $tempOrder->total_amount = $pending['amount'];
        $this->paymentGateway->capture($tempOrder, $request->razorpay_payment_id);
        $order = $this->orderPlacementService->place($pending, $request);
        session()->forget('pending_order');

        return response()->json([
            'success' => true,
            'order' => $this->formatOrder($order),
        ]);
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


    public function orderHistory(Request $request)
    {
        $orders = Order::query()
            ->where('user_id', auth('customer')->id())
            ->with([
                'shipment',
                'items.product.primaryImage',
                'items.variant.variantAttributeValues.attributeValue.images',
                'items.variant.variantAttributeValues.attributeValue.attribute',
            ])

            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%");
            })

            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('order_status', $request->status);
            })

            ->when($request->filled('period'), function ($q) use ($request) {

                $days = match ($request->period) {
                    '30' => 30,
                    '60' => 60,
                    '90' => 90,
                    default => null,
                };

                if ($days) {
                    $q->where('created_at', '>=', now()->subDays($days));
                }
            })

            ->when($request->sort === 'oldest', function ($q) {
                $q->oldest();
            }, function ($q) {
                $q->latest();
            })

            ->paginate(10)
            ->withQueryString();

        return view('website.order-history', compact('orders'));
    }
}
