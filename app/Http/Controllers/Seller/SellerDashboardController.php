<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    /**
     * Display the seller dashboard.
     */
    public function index(Request $request, Sellers $seller)
    {
        // Security check: Ensure the logged-in seller is accessing their own slug
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $id = $seller->id;

        $totalProducts = Products::where('seller_id', $id)->count();

        $totalOrders = OrderItem::whereHas('product', function ($q) use ($id) {
            $q->where('seller_id', $id);
        })->count();

        $totalEarning = OrderItem::whereHas('product', function ($q) use ($id) {
            $q->where('seller_id', $id);
        })->sum('price');

        $recentOrders = OrderItem::with('product', 'order')
            ->whereHas('product', function ($q) use ($id) {
                $q->where('seller_id', $id);
            })->latest()
            ->take(10)
            ->get();

        return view('seller.dashboard', compact(
            'seller',
            'totalProducts',
            'totalOrders',
            'totalEarning',
            'recentOrders'
        ));
    }


}
