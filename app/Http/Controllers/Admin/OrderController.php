<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Products;
use App\Models\User;
use App\Models\ShippingAddress;
use App\Models\OrderItem;
use App\Models\Cancellation;
use DateTime;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'shippingAddress']);

        // 🔍 Search filter (by order number or customer name)
        if ($search = $request->input('search')) {
            $query->where('order_number', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // 🧾 Payment status filter
        if ($paymentStatus = $request->input('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }

        // 🚚 Order status filter
        if ($orderStatus = $request->input('order_status')) {
            $query->where('order_status', $orderStatus);
        }

        // 👤 Filter by customer
        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }

        // 🕓 Sort
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'amount_high_low':
                $query->orderBy('total_amount', 'desc');
                break;
            case 'amount_low_high':
                $query->orderBy('total_amount', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $orders = $query->paginate(15);

        $customers = User::has('orders')->get(['id', 'name']);
        return view('admin.orders.index', compact('orders', 'customers'));
    }

    // show method (update to eager-load shipment)
    public function show($id)
    {
        $order = Order::with(['user', 'shippingAddress', 'items.product', 'shipment'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function shippingStatus($id)
    {
        $order = Order::with(['shipment.shipmentLogs'])->findOrFail($id);

        $shipment = $order->shipment;

        if (!$shipment) {
            return response()->json([
                'status' => 'no_shipment',
            ]);
        }

        // transform logs for UI
        $logs = $shipment->shipmentLogs->map(function ($log) {
            return [
                'event' => \App\Models\Shipment::readableStatus($log->event_name),
                'raw_event' => $log->event_name,
                'payload' => $log->payload,
                'time' => $log->created_at->toDateTimeString()
            ];
        });

        return response()->json([
            'status'   => 'ok',
            'shipment' => $shipment,
            'logs'     => $logs,
        ]);
    }


    public function quickView($id)
    {
        try {
            $order = Order::with(['user', 'shippingAddress', 'items.product'])->findOrFail($id);

            // 🧩 If the logged-in user is a seller, filter items belonging only to their products
            if (Auth::guard('seller')->check()) {
                $sellerId = Auth::guard('seller')->id();

                // Filter only items that belong to this seller’s products
                $order->setRelation('items', $order->items->filter(function ($item) use ($sellerId) {
                    return $item->product && $item->product->seller_id == $sellerId;
                }));

                // 💡 Optional: If seller somehow tries to view an order they’re not part of
                if ($order->items->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to view this order.'
                    ], 403);
                }

                // 💰 Recalculate total for this seller’s portion only
                $order->total_amount = $order->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
            }

            // Render HTML with filtered or full order data
            $html = view('admin.partials.order_card', compact('order'))->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load order details: ' . $e->getMessage()
            ], 500);
        }
    }


    public function create()
    {
        // Get customers who can place orders (active ones preferred)
        $customers = User::where('status', 'active')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        // Get available products
        $products = Products::select('id', 'name', 'price', 'stock')
            ->where('featured', 1)
            ->orderBy('name')
            ->get();

        // Static options (these won’t change often)
        $paymentMethods = [
            'cod' => 'Cash on Delivery',
            'online' => 'Online Payment',
        ];

        $paymentStatuses = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
        ];

        $orderStatuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];

        return view('admin.orders.create', compact(
            'customers',
            'products',
            'paymentMethods',
            'paymentStatuses',
            'orderStatuses'
        ));
    }

    public function getAddresses($userId)
    {
        $addresses = ShippingAddress::where('user_id', $userId)
            ->select(
                'id',
                'shipping_name',
                'shipping_phone',
                'shipping_email',
                'address_line1',
                'address_line2',
                'city',
                'state',
                'country',
                'postal_code',
                'landmark',
                'is_default'
            )
            ->get();

        return response()->json($addresses);
    }

    public function ShippingAddressshow($id)
    {
        $address = ShippingAddress::findOrFail($id);
        return response()->json($address);
    }

    public function ShippingAddressupdate(Request $request, $id)
    {
        $address = ShippingAddress::findOrFail($id);
        $address->update($request->only([
            'shipping_name',
            'shipping_phone',
            'shipping_email',
            'landmark',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'postal_code'
        ]));

        return response()->json(['success' => true]);
    }

    public function ShippingAddressdestroy($id)
    {
        $address = ShippingAddress::findOrFail($id);
        $address->delete();

        return response()->json(['success' => true]);
    }

    private function generateOrderNumber($userId)
    {
        $datePart = now()->format('ymd'); // e.g. 251016
        $userHash = strtoupper(substr(base_convert($userId * 12345, 10, 36), 0, 3)); // encodes user ID
        $sequence = str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT); // running count
        $timeHash = strtoupper(substr(md5(microtime(true)), 0, 3)); // short hash for randomness

        // Combine all parts
        $rawCode = "OD{$datePart}{$userHash}X{$sequence}{$timeHash}";

        // Optional checksum (simple numeric sum of digits mod 9)
        $digitsOnly = preg_replace('/\D/', '', $rawCode);
        $checksum = substr(array_sum(str_split($digitsOnly)) % 9, 0, 1);

        return "{$rawCode}X{$checksum}";
    }

    // public function store(Request $request)
    // {
    //     $rules = [
    //         'user_id'          => 'required|exists:users,id',
    //         'payment_method'   => 'required|in:cod,online',
    //         'payment_status'   => 'required|in:pending,paid,failed',
    //         'order_status'     => 'required|in:pending,processing,shipped,delivered,cancelled',
    //         'product_id'       => 'required|array|min:1',
    //         'product_id.*'     => 'exists:products,id',
    //         'quantity'         => 'required|array|min:1',
    //         'quantity.*'       => 'integer|min:1'
    //     ];

    //     if ($request->filled('selected_address_id')) {
    //         $rules['selected_address_id'] = 'required|exists:shipping_addresses,id';
    //     } else {
    //         $rules += [
    //             'shipping_name'    => 'required|string|max:255',
    //             'shipping_phone'   => ['required', 'regex:/^[6-9]\d{9}$/'],
    //             'shipping_email'   => 'nullable|email|max:255',
    //             'landmark'         => 'nullable|string|max:255',
    //             'address_line1'    => 'required|string|max:255',
    //             'address_line2'    => 'nullable|string|max:255',
    //             'city'             => 'required|string|max:100',
    //             'state'            => 'required|string|max:100',
    //             'postal_code'      => 'required|string|max:20',
    //             'country'          => 'nullable|string|max:100'
    //         ];
    //     }

    //     $validated = $request->validate($rules);

    //     try {
    //         DB::beginTransaction();

    //         $totalAmount = 0;
    //         $products = [];

    //         foreach ($request->product_id as $i => $pid) {
    //             $product = Products::findOrFail($pid);
    //             $products[] = $product;
    //             $totalAmount += $product->price * $request->quantity[$i];
    //         }

    //         // Shipping address
    //         if ($request->filled('selected_address_id')) {
    //             $shippingAddressId = $request->selected_address_id;
    //         } else {
    //             $hasAddress = ShippingAddress::where('user_id', $request->user_id)->exists();

    //             $shipping = ShippingAddress::create([
    //                 'user_id'        => $request->user_id,
    //                 'shipping_name'  => $request->shipping_name,
    //                 'shipping_email' => $request->shipping_email,
    //                 'shipping_phone' => $request->shipping_phone,
    //                 'landmark'       => $request->landmark,
    //                 'address_line1'  => $request->address_line1,
    //                 'address_line2'  => $request->address_line2,
    //                 'city'           => $request->city,
    //                 'state'          => $request->state,
    //                 'postal_code'    => $request->postal_code,
    //                 'country'        => $request->country ?? 'India',
    //                 'is_default'     => $hasAddress ? 0 : 1
    //             ]);

    //             $shippingAddressId = $shipping->id;
    //         }

    //         $orderNumber = $this->generateOrderNumber($request->user_id);

    //         $order = Order::create([
    //             'user_id'             => $request->user_id,
    //             'shipping_address_id' => $shippingAddressId,
    //             'order_number'        => $orderNumber,
    //             'order_status'        => $request->order_status,
    //             'payment_method'      => $request->payment_method,
    //             'payment_status'      => $request->payment_status,
    //             'total_amount'        => $totalAmount,
    //             'notes'                => $request->note,
    //         ]);

    //         // Create items with commission logic
    //         foreach ($products as $index => $product) {
    //             $qty      = $request->quantity[$index];
    //             $subtotal = $product->price * $qty;

    //             $seller = $product->seller;
    //             $commissionPercent = $seller->commission_rate ?? 0;
    //             $commissionAmount  = ($subtotal * $commissionPercent) / 100;
    //             $sellerAmount      = $subtotal - $commissionAmount;

    //             OrderItem::create([
    //                 'order_id'           => $order->id,
    //                 'product_id'         => $product->id,
    //                 'quantity'           => $qty,
    //                 'price'              => $product->price,
    //                 'subtotal'           => $subtotal,
    //                 'commission_percent' => $commissionPercent,
    //                 'commission_amount'  => $commissionAmount,
    //                 'seller_amount'      => $sellerAmount,
    //                 'settlement_status'  => 'pending'
    //             ]);
    //         }

    //         DB::commit();

    //         return redirect()
    //             ->route('admin.orders.index')
    //             ->with('success', 'Order created successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    //     }
    // }


    public function store(Request $request)
    {
        // -------------------------------
        //  VALIDATION
        // -------------------------------
        $rules = [
            'user_id'          => 'required|exists:users,id',
            'payment_method'   => 'required|in:cod,online',
            'payment_status'   => 'required|in:pending,paid,failed',
            'order_status'     => 'required|in:pending,processing,shipped,delivered,cancelled',
            'product_id'       => 'required|array|min:1',
            'product_id.*'     => 'exists:products,id',
            'quantity'         => 'required|array|min:1',
            'quantity.*'       => 'integer|min:1'
        ];
        // Address validation
        if ($request->filled('selected_address_id')) {
            $rules['selected_address_id'] = 'required|exists:shipping_addresses,id';
        } else {
            $rules += [
                'shipping_name'    => 'required|string|max:255',
                'shipping_phone'   => ['required', 'regex:/^[6-9]\d{9}$/'],
                'shipping_email'   => 'nullable|email|max:255',
                'landmark'         => 'nullable|string|max:255',
                'address_line1'    => 'required|string|max:255',
                'address_line2'    => 'nullable|string|max:255',
                'city'             => 'required|string|max:100',
                'state'            => 'required|string|max:100',
                'postal_code'      => 'required|string|max:20',
                'country'          => 'nullable|string|max:100'
            ];
        }

        $validated = $request->validate($rules);


        try {
            DB::beginTransaction();

            // -------------------------------
            //  CALCULATE TOTAL
            // -------------------------------
            $products   = [];
            $totalAmount = 0;

            foreach ($request->product_id as $i => $pid) {
                $product = Products::findOrFail($pid);
                $products[] = $product;
                $totalAmount += $product->price * $request->quantity[$i];
            }

            // -------------------------------
            //  SHIPPING ADDRESS
            // -------------------------------
            if ($request->filled('selected_address_id')) {
                $shippingAddressId = $request->selected_address_id;
            } else {
                $hasAddress = ShippingAddress::where('user_id', $request->user_id)->exists();

                $shipping = ShippingAddress::create([
                    'user_id'        => $request->user_id,
                    'shipping_name'  => $request->shipping_name,
                    'shipping_email' => $request->shipping_email,
                    'shipping_phone' => $request->shipping_phone,
                    'landmark'       => $request->landmark,
                    'address_line1'  => $request->address_line1,
                    'address_line2'  => $request->address_line2,
                    'city'           => $request->city,
                    'state'          => $request->state,
                    'postal_code'    => $request->postal_code,
                    'country'        => $request->country ?? 'India',
                    'is_default'     => $hasAddress ? 0 : 1
                ]);

                $shippingAddressId = $shipping->id;
            }

            // -------------------------------
            //  CREATE ORDER
            // -------------------------------
            $order = Order::create([
                'user_id'             => $request->user_id,
                'shipping_address_id' => $shippingAddressId,
                'order_number'        => $this->generateOrderNumber($request->user_id),
                'order_status'        => $request->order_status,
                'payment_method'      => $request->payment_method,
                'payment_status'      => $request->payment_status,
                'total_amount'        => $totalAmount,
                'notes'               => $request->notes,
            ]);

            // -------------------------------
            //  ADD ORDER ITEMS (with commission)
            // -------------------------------
            foreach ($products as $index => $product) {
                $qty = $request->quantity[$index];
                $subtotal = $product->price * $qty;

                $seller = $product->seller;
                $commissionPercent = $seller->commission_rate ?? 0;

                $commissionAmount = ($subtotal * $commissionPercent) / 100;
                $sellerAmount     = $subtotal - $commissionAmount;

                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_id'         => $product->id,
                    'quantity'           => $qty,
                    'price'              => $product->price,
                    'subtotal'           => $subtotal,
                    'commission_percent' => $commissionPercent,
                    'commission_amount'  => $commissionAmount,
                    'seller_amount'      => $sellerAmount,
                    'settlement_status'  => 'pending',
                ]);
            }

            DB::commit();

            // -------------------------------
            //  CREATE RAZORPAY ORDER IMMEDIATELY
            // -------------------------------
            if ($request->payment_method === 'online') {
                app(\App\Services\Payment\RazorpayRouteService::class)
                    ->createOrder($order);
            }

            return redirect()
                ->route('admin.orders.index')
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function edit($id)
    {
        // Fetch the order with relations
        $order = Order::with([
            'user:id,name,email',
            'items.product:id,name,price,stock',
            'shippingAddress'
        ])->findOrFail($id);

        // Get all active customers (same as in create)
        $customers = User::where('status', 'active')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        // Get all available products
        $products = Products::select('id', 'name', 'price', 'stock')
            ->where('featured', 1)
            ->orderBy('name')
            ->get();

        // Get all saved shipping addresses of this customer
        $shippingAddresses = ShippingAddress::where('user_id', $order->user_id)
            ->orderByDesc('is_default')
            ->get();

        // Static dropdowns
        $paymentMethods = [
            'cod' => 'Cash on Delivery',
            'online' => 'Online Payment',
        ];

        $paymentStatuses = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
        ];

        $orderStatuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];

        // Pass data to edit view
        return view('admin.orders.edit', compact(
            'order',
            'customers',
            'products',
            'shippingAddresses',
            'paymentMethods',
            'paymentStatuses',
            'orderStatuses'
        ));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'user_id'          => 'required|exists:users,id',
            'payment_method'   => 'required|in:cod,online',
            'payment_status'   => 'required|in:pending,paid,failed',
            'order_status'     => 'required|in:pending,processing,shipped,delivered,cancelled',
            'product_id'       => 'required|array|min:1',
            'product_id.*'     => 'exists:products,id',
            'quantity'         => 'required|array|min:1',
            'quantity.*'       => 'integer|min:1'
        ];

        if ($request->filled('selected_address_id')) {
            $rules['selected_address_id'] = 'required|exists:shipping_addresses,id';
        } else {
            $rules += [
                'shipping_name'    => 'required|string|max:255',
                'shipping_phone'   => ['required', 'regex:/^[6-9]\d{9}$/'],
                'shipping_email'   => 'nullable|email|max:255',
                'landmark'         => 'nullable|string|max:255',
                'address_line1'    => 'required|string|max:255',
                'address_line2'    => 'nullable|string|max:255',
                'city'             => 'required|string|max:100',
                'state'            => 'required|string|max:100',
                'postal_code'      => 'required|string|max:20',
                'country'          => 'nullable|string|max:100',
            ];
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            $order = Order::with('items')->findOrFail($id);

            if (in_array($order->order_status, ['shipped', 'delivered'])) {
                return back()->withErrors(['error' => 'Cannot modify order after it is shipped/delivered.']);
            }

            // Recalculate totals
            $totalAmount = 0;
            $products = [];

            foreach ($request->product_id as $i => $pid) {
                $product = Products::findOrFail($pid);
                $products[] = $product;
                $totalAmount += $product->price * $request->quantity[$i];
            }

            // Shipping logic
            if ($request->filled('selected_address_id')) {
                $shippingAddressId = $request->selected_address_id;
            } else {
                $shipping = ShippingAddress::create([
                    'user_id'        => $request->user_id,
                    'shipping_name'  => $request->shipping_name,
                    'shipping_email' => $request->shipping_email,
                    'shipping_phone' => $request->shipping_phone,
                    'landmark'       => $request->landmark,
                    'address_line1'  => $request->address_line1,
                    'address_line2'  => $request->address_line2,
                    'city'           => $request->city,
                    'state'          => $request->state,
                    'postal_code'    => $request->postal_code,
                    'country'        => $request->country ?? 'India',
                    'is_default'     => 0
                ]);

                $shippingAddressId = $shipping->id;
            }

            // Update order
            $order->update([
                'user_id'             => $request->user_id,
                'shipping_address_id' => $shippingAddressId,
                'order_status'        => $request->order_status,
                'payment_method'      => $request->payment_method,
                'payment_status'      => $request->payment_status,
                'total_amount'        => $totalAmount,
                'note'                => $request->note
            ]);

            // Sync Items with Commission
            $existing = $order->items->keyBy('product_id');

            foreach ($products as $i => $product) {
                $qty      = $request->quantity[$i];
                $subtotal = $product->price * $qty;

                $seller = $product->seller;
                $commissionPercent = $seller->commission_rate ?? 0;
                $commissionAmount  = ($subtotal * $commissionPercent) / 100;
                $sellerAmount      = $subtotal - $commissionAmount;

                if ($existing->has($product->id)) {
                    $existing[$product->id]->update([
                        'quantity'           => $qty,
                        'price'              => $product->price,
                        'subtotal'           => $subtotal,
                        'commission_percent' => $commissionPercent,
                        'commission_amount'  => $commissionAmount,
                        'seller_amount'      => $sellerAmount
                    ]);

                    $existing->forget($product->id);
                } else {
                    OrderItem::create([
                        'order_id'           => $order->id,
                        'product_id'         => $product->id,
                        'quantity'           => $qty,
                        'price'              => $product->price,
                        'subtotal'           => $subtotal,
                        'commission_percent' => $commissionPercent,
                        'commission_amount'  => $commissionAmount,
                        'seller_amount'      => $sellerAmount,
                        'settlement_status'  => 'pending'
                    ]);
                }
            }

            // Remove removed items
            if ($existing->isNotEmpty()) {
                OrderItem::whereIn('id', $existing->pluck('id'))->delete();
            }

            DB::commit();
            return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }


    // public function cancel(Request $request, $id)
    // {
    //     $order = Order::findOrFail($id);

    //     if ($order->order_status === 'cancelled') {
    //         return response()->json(['message' => 'Order is already cancelled.'], 400);
    //     }

    //     $reason = $request->input('reason', 'No reason provided.');

    //     Cancellation::create([
    //         'order_id'    => $order->id,
    //         'user_id'     => $order->user_id,
    //         'reason'      => $reason,
    //         'status'      => 'approved',
    //         'approved_by' => Auth::id(),
    //     ]);

    //     $order->update([
    //         'order_status' => 'cancelled',
    //     ]);

    //     return response()->json(['message' => 'Order cancelled successfully.']);
    // }
}
