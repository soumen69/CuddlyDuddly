<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Sellers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Counts
        $productCount  = Products::count();
        $customerCount = User::count();
        $sellerCount   = Sellers::count();
        $orderCount    = Order::count();

        // Revenue (sum of completed orders — using order_status === 'completed')
        $revenue = Order::where('order_status', 'delivered')->sum('total_amount');

        // Recent orders (latest 10) — eager load user and items -> product
        $recentOrders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // --- Sales chart: last 7 days (including today)
        $days = collect(range(6, 0))->map(function ($i) {
            return Carbon::today()->subDays($i)->format('Y-m-d'); // YYYY-MM-DD
        })->values(); // oldest -> newest

        $salesRaw = Order::selectRaw("DATE(created_at) as date, SUM(total_amount) as total")
            ->where('order_status', 'delivered')
            ->whereDate('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $salesLabels = $days->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray();
        $salesValues = $days->map(fn($d) => isset($salesRaw[$d]) ? (float)$salesRaw[$d] : 0)->toArray();

        // --- Seller growth: last 6 months (month labels like "Jun 2025")
        $months = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->startOfMonth()->subMonths($i);
        });

        $monthKeys = $months->map(fn($c) => $c->format('Y-m'))->toArray(); // e.g. 2025-06
        $sellerRaw = Sellers::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth()->subMonths(5))
            ->groupBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        $sellerLabels = $months->map(fn($c) => $c->format('M Y'))->toArray();
        $sellerValues = collect($monthKeys)->map(fn($k) => isset($sellerRaw[$k]) ? (int)$sellerRaw[$k] : 0)->toArray();
        // TOP 5 SELLERS BY REVENUE
        $topSellersRevenue = Sellers::select(
            'sellers.id',
            'sellers.name',
            DB::raw('SUM(order_items.price * order_items.quantity) as revenue')
        )
            ->join('products', 'products.seller_id', '=', 'sellers.id')
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.order_status', 'delivered')
            ->groupBy('sellers.id', 'sellers.name')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();


        // TOP 5 SELLERS BY NUMBER OF ORDERS
        $topSellersOrders = Sellers::select(
            'sellers.id',
            'sellers.name',
            DB::raw('COUNT(order_items.id) as total_orders')
        )
            ->join('products', 'products.seller_id', '=', 'sellers.id')
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.order_status', 'delivered')
            ->groupBy('sellers.id', 'sellers.name')
            ->orderByDesc('total_orders')
            ->take(5)
            ->get();


        // TOP 5 BEST-SELLING PRODUCTS
        $topProducts = OrderItem::select(
            'products.name',
            DB::raw('SUM(order_items.quantity) as qty'),
            DB::raw('SUM(order_items.price * order_items.quantity) as total')
        )
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.order_status', 'delivered')
            ->groupBy('products.name')
            ->orderByDesc('qty')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'productCount',
            'customerCount',
            'sellerCount',
            'orderCount',
            'revenue',
            'recentOrders',
            'salesLabels',
            'salesValues',
            'sellerLabels',
            'sellerValues',
            'topSellersRevenue',
            'topSellersOrders',
            'topProducts'
        ));
    }
}
