<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Returns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sellers;

class SellerOrderController extends Controller
{

    public function index(Request $request, Sellers $seller)
    {
        // Security check: Ensure the logged-in seller is accessing their own slug
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $search = $request->search;
        $paymentStatus = $request->payment_status;
        $activeTab = $request->active_tab ?? 'orders';

        // Initialize variables
        $orders = collect(); // This will now hold OrderItems for the view
        $returns = collect();
        $cancellation = collect(); // This will now hold OrderItems for the view

        /*
        |--------------------------------------------------------------------------
        | FETCH DATA BASED ON TAB
        |--------------------------------------------------------------------------
        */

        if ($activeTab === 'orders' || $activeTab === 'cancellation') {
            $itemsQuery = OrderItem::with(['order.user', 'order.shippingAddress', 'product.categorySections.category'])
                ->whereHas('product', function ($q) use ($seller) {
                    $q->where('seller_id', $seller->id);
                });

            // Filter by active tab status (Status is usually on the Order table)
            if ($activeTab === 'cancellation') {
                $itemsQuery->whereHas('order', function ($q) {
                    $q->where('order_status', 'cancelled');
                });
            }

            // Search Filter
            if ($search) {
                $itemsQuery->where(function ($q) use ($search) {
                    $q->whereHas('order', function ($oq) use ($search) {
                        $oq->where('order_number', 'like', "%{$search}%");
                    })
                        ->orWhereHas('product', function ($pq) use ($search) {
                            $pq->where('name', 'like', "%{$search}%")
                                ->orWhereHas('categorySections.category', function ($cq) use ($search) {
                                    $cq->where('name', 'like', "%{$search}%");
                                });
                        });
                });
            }

            // Payment Status Filter (On the Order table)
            if ($paymentStatus) {
                $itemsQuery->whereHas('order', function ($q) use ($paymentStatus) {
                    $q->where('payment_status', $paymentStatus);
                });
            }

            if ($activeTab === 'orders') {
                $orders = $itemsQuery->latest()->paginate(20)->withQueryString();
            } else {
                $cancellation = $itemsQuery->latest()->paginate(20)->withQueryString();
            }
        } elseif ($activeTab === 'return') {
            $returnsQuery = Returns::with([
                'order',
                'orderItem.product'
            ])
                ->whereHas('orderItem.product', function ($q) use ($seller) {
                    $q->where('seller_id', $seller->id);
                });

            // Search for Returns
            if ($search) {
                $returnsQuery->where(function ($q) use ($search) {
                    $q->where('return_number', 'like', "%{$search}%")
                        ->orWhereHas('order', function ($o) use ($search) {
                            $o->where('order_number', 'like', "%{$search}%");
                        })
                        ->orWhereHas('orderItem.product', function ($p) use ($search) {
                            $p->where('name', 'like', "%{$search}%");
                        });
                });
            }

            $returns = $returnsQuery->latest()->paginate(20)->withQueryString();
        }

        /*
        |--------------------------------------------------------------------------
        | AJAX RESPONSE
        |--------------------------------------------------------------------------
        */
        if ($request->ajax()) {
            return response()->json([
                'html' => view('seller.orders.partials.tabs', compact(
                    'orders',
                    'returns',
                    'cancellation',
                    'activeTab',
                    'seller'
                ))->render()
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NORMAL VIEW
        |--------------------------------------------------------------------------
        */
        return view('seller.orders.index', compact(
            'orders',
            'returns',
            'cancellation',
            'activeTab',
            'seller'
        ));
    }


    public function show(Sellers $seller, Order $order)
    {
        // Security check: Ensure the logged-in seller is accessing their own slug
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        // Load order only if it includes this seller’s products
        $order = Order::with(['user', 'shippingAddress', 'items.product'])
            ->whereHas('items.product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })
            ->findOrFail($order->id);

        // Filter only this seller’s items for display
        $sellerItems = $order->items->filter(function ($item) use ($seller) {
            return $item->product->seller_id == $seller->id;
        });

        return view('seller.orders.show', compact('order', 'sellerItems', 'seller'));
    }

    public function update(Request $request, Sellers $seller, $id)
    {
        // Security check: Ensure the logged-in seller is accessing their own slug
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $order = Order::where('seller_id', $seller->id)->findOrFail($id);

        $request->validate([
            'status' => 'required|string',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('seller.orders.index', $seller->slug)->with('success', 'Order updated successfully.');
    }
}
