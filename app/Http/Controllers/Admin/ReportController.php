<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Returns;
use App\Models\Sellers;
use App\Models\Setting;
use App\Models\User;
use App\Models\ProductView;
use App\Models\Wishlist;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sellerPerformance(Request $request)
    {
        // We'll keep the initial load light: default period lifetime (or month if you prefer)
        $period = $request->input('period', 'month');
        $year   = $request->input('year', now()->year);
        $month  = $request->input('month', now()->month);
        $years  = range(now()->year, now()->year - 5);

        // Resolve from/to (same logic used consistently across reports)
        switch ($period) {
            case '24hr':
                $toDate = now();
                $fromDate = now()->subDay();
                break;
            case 'week':
                $toDate = now()->endOfWeek();
                $fromDate = now()->subWeek()->startOfWeek();
                break;
            case 'month':
                $toDate = now()->endOfMonth();
                $fromDate = now()->startOfMonth();
                break;
            case '3month':
                $toDate = now();
                $fromDate = now()->subMonths(3)->startOfDay();
                break;
            case '6month':
                $toDate = now();
                $fromDate = now()->subMonths(6)->startOfDay();
                break;
            case 'year':
                $toDate = Carbon::create($year, 12, 31)->endOfDay();
                $fromDate = Carbon::create($year, 1, 1)->startOfDay();
                break;
            case 'custom':
                $fromDate = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : now()->startOfMonth();
                $toDate   = $request->filled('to') ? Carbon::parse($request->to)->endOfDay() : now()->endOfDay();
                break;
            default: // lifetime
                $fromDate = Order::min('created_at') ? Carbon::parse(Order::min('created_at'))->startOfDay() : now()->subYear()->startOfDay();
                $toDate = now();
                break;
        }

        // KPIs (light queries)
        $totalSellers = Sellers::count();
        $activeSellers = Sellers::where('is_active', 1)->count();
        $newSellers = Sellers::whereBetween('created_at', [$fromDate, $toDate])->count();

        $inactiveSellers = Sellers::whereDoesntHave('products.orderItems.order', function ($q) use ($fromDate, $toDate) {
            $q->whereBetween('orders.created_at', [$fromDate, $toDate]);
        })->count();


        // Provide the blade with basic placeholders; data charts will be fetched via AJAX
        return view('admin.reports.sellers-performance', compact(
            'period',
            'year',
            'month',
            'years',
            'fromDate',
            'toDate',
            'totalSellers',
            'activeSellers',
            'newSellers',
            'inactiveSellers'
        ));
    }

    public function fetchSellerPerformanceData(Request $request)
    {
        $period = $request->input('period', 'lifetime');

        // Resolve date range
        switch ($period) {
            case '24hr':
                $toDate = now();
                $fromDate = now()->subDay();
                break;
            case 'week':
                $toDate = now()->endOfWeek();
                $fromDate = now()->subWeek()->startOfWeek();
                break;
            case 'month':
                $toDate = now()->endOfMonth();
                $fromDate = now()->startOfMonth();
                break;
            case '3month':
                $toDate = now();
                $fromDate = now()->subMonths(3)->startOfDay();
                break;
            case '6month':
                $toDate = now();
                $fromDate = now()->subMonths(6)->startOfDay();
                break;
            case 'year':
                $year = $request->input('year', now()->year);
                $fromDate = Carbon::create($year, 1, 1)->startOfDay();
                $toDate = Carbon::create($year, 12, 31)->endOfDay();
                break;
            case 'custom':
                $fromDate = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : now()->startOfMonth();
                $toDate   = $request->filled('to') ? Carbon::parse($request->to)->endOfDay() : now()->endOfDay();
                break;
            default:
                $fromDate = Order::min('created_at') ? Carbon::parse(Order::min('created_at'))->startOfDay() : now()->subYear()->startOfDay();
                $toDate = now();
                break;
        }

        // Ensure Carbon instances
        $fromDate = $fromDate instanceof Carbon ? $fromDate : Carbon::parse($fromDate);
        $toDate = $toDate instanceof Carbon ? $toDate : Carbon::parse($toDate);

        $commissionRate = Setting::getValue('default_commission_percent') / 100;

        // ---------------------------
        // Top sellers by revenue (limit 10; client can request different via param)
        // ---------------------------
        $limit = (int) $request->input('limit', 10);

        $topSellersQuery = Sellers::select(
            'sellers.id',
            'sellers.name',
            'sellers.email',
            DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
            DB::raw('SUM(order_items.price * order_items.quantity) as revenue')
        )
            ->join('products', 'products.seller_id', 'sellers.id')
            ->join('order_items', 'order_items.product_id', 'products.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->whereIn('orders.payment_status', ['paid', 'delivered'])
            ->groupBy('sellers.id', 'sellers.name', 'sellers.email')
            ->orderByDesc('revenue')
            ->limit($limit);

        $topSellers = $topSellersQuery->get()->map(fn($s) => [
            'id' => $s->id,
            'name' => $s->name,
            'email' => $s->email,
            'orders' => (int)$s->orders_count,
            'revenue' => (float)$s->revenue,
            'commission' => round((float)$s->revenue * $commissionRate, 2),
            'net_payout' => round((float)$s->revenue * (1 - $commissionRate), 2),
        ])->toArray();

        // ---------------------------
        // Top products across period (limit 10)
        // ---------------------------
        $topProducts = Products::select('products.id', 'products.name', DB::raw('SUM(order_items.quantity) as units_sold'), DB::raw('SUM(order_items.price * order_items.quantity) as revenue'))
            ->join('order_items', 'order_items.product_id', 'products.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->whereIn('orders.payment_status', ['paid', 'delivered'])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('units_sold')
            ->limit(10)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'units' => (int)$p->units_sold,
                'revenue' => (float)$p->revenue
            ])->toArray();

        // ---------------------------
        // KPI totals for this range: revenue, refunds, etc.
        // ---------------------------
        $totalRevenue = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->whereIn('payment_status', ['paid', 'delivered'])
            ->sum('total_amount');

        $refundStatuses = ['approved', 'received', 'refunded', 'completed'];
        $refundsTotal = Returns::whereBetween('created_at', [$fromDate, $toDate])
            ->whereIn('status', $refundStatuses)
            ->sum('refund_amount');

        // Commission estimate (platform)
        $platformCommission = round($totalRevenue * $commissionRate, 2);
        $netPayoutTotal = round($totalRevenue - $platformCommission - $refundsTotal, 2);

        // ---------------------------
        // Build chart labels + datasets (Top sellers ordering)
        // ---------------------------
        $labels = array_map(fn($s) => $s['name'], $topSellers);
        $revenueData = array_map(fn($s) => $s['revenue'], $topSellers);
        $ordersData = array_map(fn($s) => $s['orders'], $topSellers);

        // if there are fewer sellers than limit, it's fine — front-end will show no-results if empty.

        // ---------------------------
        // Also return a lightweight "all sellers" paginated table endpoint possibility (not here)
        // ---------------------------

        return response()->json([
            'labels' => $labels,                    // for bar x-axis
            'revenue' => $revenueData,              // revenue dataset
            'orders' => $ordersData,                // orders dataset
            'topSellers' => $topSellers,
            'topProducts' => $topProducts,
            'totalRevenue' => (float)$totalRevenue,
            'refunds' => (float)$refundsTotal,
            'platformCommission' => (float)$platformCommission,
            'netPayoutTotal' => (float)$netPayoutTotal,
            'from' => $fromDate->toDateString(),
            'to' => $toDate->toDateString(),
        ]);
    }

    protected function getCustomerSegments(int $year)
    {
        $now = Carbon::now();

        $newCustomers = User::whereYear('created_at', $year)
            ->latest('created_at')
            ->limit(5)
            ->get(['id', 'name', 'email', 'created_at', 'profile_image']);

        $returningCustomerList = User::whereHas('orders', function ($q) {
            $q->groupBy('user_id')->havingRaw('COUNT(*) > 1');
        })
            ->with(['orders' => function ($q) {
                $q->select('id', 'user_id', 'total_amount', 'created_at');
            }])
            ->latest('created_at')
            ->limit(5)
            ->get(['id', 'name', 'email', 'created_at', 'profile_image']);

        $highValueThreshold = 10000;

        // Compute high value customers using aggregated query to reduce memory
        $highValueCustomers = User::select(
            'users.id',
            'users.name',
            'users.email',
            DB::raw('SUM(orders.total_amount) as total_spent')
        )
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->havingRaw('SUM(orders.total_amount) >= ?', [$highValueThreshold])
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();


        $inactiveCustomerList = User::where('updated_at', '<', $now->copy()->subDays(60))
            ->limit(5)
            ->get(['id', 'name', 'email', 'updated_at', 'profile_image']);

        return compact(
            'newCustomers',
            'returningCustomerList',
            'highValueCustomers',
            'inactiveCustomerList'
        );
    }

    protected function getHeatmapSet(array $returningUserIds, int $monthsBack, Carbon $now)
    {
        $products = [];
        $months = [];
        $matrix = [];

        if (empty($returningUserIds)) {
            return ['products' => $products, 'months' => $months, 'matrix' => $matrix];
        }

        for ($i = $monthsBack - 1; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $months[] = $m->format('Y-m');
        }

        // top products purchased by returning users (limited)
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.user_id', $returningUserIds)
            ->select('order_items.product_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('order_items.product_id')
            ->orderByDesc('cnt')
            ->limit(30)
            ->pluck('product_id')
            ->toArray();

        if (empty($topProducts)) {
            return ['products' => $products, 'months' => $months, 'matrix' => $matrix];
        }

        $productNames = Products::whereIn('id', $topProducts)->pluck('name', 'id')->toArray();

        foreach ($topProducts as $pid) {
            $products[] = [
                'id' => $pid,
                'name' => $productNames[$pid] ?? "Product #$pid",
            ];
        }

        $rows = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.user_id', $returningUserIds)
            ->whereIn('order_items.product_id', $topProducts)
            ->whereBetween('orders.created_at', [
                $now->copy()->subMonths($monthsBack - 1)->startOfMonth(),
                $now->copy()->endOfMonth(),
            ])
            ->select(
                'order_items.product_id',
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m') as ym"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('order_items.product_id', 'ym')
            ->get();

        $baseMatrix = [];
        foreach ($products as $p) {
            $baseMatrix[$p['id']] = array_fill(0, count($months), 0);
        }

        foreach ($rows as $r) {
            $pid = $r->product_id;
            $ym = $r->ym;
            $idx = array_search($ym, $months);
            if ($idx !== false && isset($baseMatrix[$pid])) {
                $baseMatrix[$pid][$idx] = (int) $r->total;
            }
        }

        foreach ($products as $p) {
            $matrix[] = [
                'product_id' => $p['id'],
                'product_name' => $p['name'],
                'counts' => $baseMatrix[$p['id']],
            ];
        }

        return ['products' => $products, 'months' => $months, 'matrix' => $matrix];
    }

    public function customerInsights(Request $request)
    {
        // renders blade with initial KPIs and arrays for JS initial render
        $now = Carbon::now();
        $selectedYear = (int) $request->input('year', $now->year);
        $selectedMonth = (int) $request->input('month', $now->month);

        // core KPIs
        $totalCustomers = User::count();

        $activeSince = $now->copy()->subDays(30);
        $activeByUpdate = User::where('updated_at', '>=', $activeSince)->pluck('id')->toArray();
        $activeByViews = ProductView::where('viewed_at', '>=', $activeSince)->pluck('user_id')->toArray();
        $activeByCart = Cart::where('updated_at', '>=', $activeSince)->pluck('user_id')->toArray();

        $activeCustomers = collect(array_merge($activeByUpdate, $activeByViews, $activeByCart))
            ->filter()->unique()->count();

        $returningCustomers = User::whereHas('orders', function ($q) {
            $q->groupBy('user_id')->havingRaw('COUNT(*) > 1');
        })->count();

        $highValue = User::whereHas('orders', function ($q) {
            $q->groupBy('user_id')->havingRaw('SUM(total_amount) > 500');
        })->count();

        $inactiveCustomers = User::where('updated_at', '<', $now->copy()->subDays(60))->count();

        // segments + returning user ids
        $segments = $this->getCustomerSegments($selectedYear);

        $returningUserIds = User::whereHas('orders', function ($q) {
            $q->groupBy('user_id')->havingRaw('COUNT(*) > 1');
        })->pluck('id')->toArray();

        // returning products (top 10)
        $returningProductData = OrderItem::select('product_id', DB::raw('COUNT(*) as total'))
            ->whereHas('order', fn($q) => $q->whereIn('user_id', $returningUserIds))
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $productMap = Products::whereIn('id', $returningProductData->pluck('product_id'))->pluck('name', 'id');

        $returningProductLabels = $returningProductData->map(fn($item) => $productMap[$item->product_id] ?? "Product #{$item->product_id}");
        $returningProductValues = $returningProductData->pluck('total');

        // heatmap
        $monthsBack = (int) $request->input('monthsBack', 6);
        $heatmapSet = $this->getHeatmapSet($returningUserIds, $monthsBack, $now);

        // behaviour & churn
        $wishlistUsers = Wishlist::distinct('user_id')->count('user_id');
        $cartAdded = Cart::count();
        $cartOrdered = Cart::where('is_ordered', true)->count();
        $cartAbandonRate = $cartAdded ? round((($cartAdded - $cartOrdered) / $cartAdded) * 100, 2) : 0;

        $mostViewedProduct = ProductView::select('product_id')
            ->groupBy('product_id')
            ->orderByRaw('SUM(views) DESC')
            ->first();

        $highRisk = User::where('updated_at', '<', $now->copy()->subDays(90))->count();
        $mediumRisk = User::whereBetween('updated_at', [$now->copy()->subDays(90), $now->copy()->subDays(60)])->count();
        $lowRisk = max(0, $totalCustomers - $highRisk - $mediumRisk);

        // charts initial arrays (daily/monthly/weekly/yearly)
        $daysInMonth = Carbon::create($selectedYear, $selectedMonth, 1)->daysInMonth;
        $start = Carbon::create($selectedYear, $selectedMonth, 1)->startOfDay();
        $end = Carbon::create($selectedYear, $selectedMonth, $daysInMonth)->endOfDay();

        $dailyNew = User::whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $dailyLabels = [];
        $dailyNewCustomers = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::create($selectedYear, $selectedMonth, $i)->toDateString();
            $dailyLabels[] = $i;
            $dailyNewCustomers[] = $dailyNew[$date] ?? 0;
        }

        $weekly = User::whereYear('created_at', $now->year)
            ->selectRaw('WEEK(created_at) as w, COUNT(*) as total')
            ->groupBy('w')
            ->pluck('total', 'w');

        $weeklyLabels = [];
        $weeklyNewCustomers = [];
        for ($w = 1; $w <= 52; $w++) {
            $weeklyLabels[] = "W" . $w;
            $weeklyNewCustomers[] = $weekly[$w] ?? 0;
        }

        $months = [];
        $monthlyNew = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $months[] = $m->format('M');
            $monthlyNew[] = User::whereBetween('created_at', [$m->copy()->startOfMonth(), $m->copy()->endOfMonth()])->count();
        }

        $yearLabels = [];
        $yearlyNew = [];
        for ($i = 4; $i >= 0; $i--) {
            $y = $now->copy()->subYears($i)->year;
            $yearLabels[] = $y;
            $yearlyNew[] = User::whereYear('created_at', $y)->count();
        }

        return view('admin.reports.customer-insights', array_merge([
            'totalCustomers' => $totalCustomers,
            'activeCustomers' => $activeCustomers,
            'returningCustomers' => $returningCustomers,
            'highValue' => $highValue,
            'inactiveCustomers' => $inactiveCustomers,
            'wishlistUsers' => $wishlistUsers,
            'cartAbandonRate' => $cartAbandonRate,
            'mostViewedProduct' => $mostViewedProduct,
            'lowRisk' => $lowRisk,
            'mediumRisk' => $mediumRisk,
            'highRisk' => $highRisk,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'dailyLabels' => $dailyLabels,
            'dailyNewCustomers' => $dailyNewCustomers,
            'weeklyLabels' => $weeklyLabels,
            'weeklyNewCustomers' => $weeklyNewCustomers,
            'returningProductLabels' => $returningProductLabels,
            'returningProductValues' => $returningProductValues,
            'returningProductData' => $returningProductData,
            'returningProducts' => $products ?? collect(),
            'behaviourTopViewed' => ProductView::where('viewed_at', '>=', $now->copy()->subDays(30))->limit(10)->get(),
            'topViewedProductsWithInfo' => $topViewedProductsWithInfo ?? collect(),
            'heatmapProducts' => $heatmapSet['products'],
            'heatmapMonths' => $heatmapSet['months'],
            'heatmapMatrix' => $heatmapSet['matrix'],
            'months' => $months,
            'monthlyNew' => $monthlyNew,
            'yearLabels' => $yearLabels,
            'yearlyNew' => $yearlyNew,
        ], $segments));
    }

    // // inside ReportsController.php (add this method)
    // public function fetchCustomerPerformanceData(Request $request)
    // {
    //     $request->validate([
    //         'period' => 'nullable|string',
    //         'from' => 'nullable|date',
    //         'to' => 'nullable|date',
    //         'limit' => 'nullable|integer|min:1|max:200'
    //     ]);

    //     $period = $request->input('period', 'lifetime');
    //     $limit = (int) $request->input('limit', 10);

    //     // resolve from/to same logic used in seller endpoint
    //     switch ($period) {
    //         case '24hr':
    //             $toDate = now();
    //             $fromDate = now()->subDay();
    //             break;
    //         case 'week':
    //             $toDate = now();
    //             $fromDate = now()->subWeek();
    //             break;
    //         case 'month':
    //             $toDate = now();
    //             $fromDate = now()->startOfMonth();
    //             break;
    //         case '3month':
    //             $toDate = now();
    //             $fromDate = now()->subMonths(3)->startOfDay();
    //             break;
    //         case '6month':
    //             $toDate = now();
    //             $fromDate = now()->subMonths(6)->startOfDay();
    //             break;
    //         case 'year':
    //             $year = $request->input('year', now()->year);
    //             $fromDate = Carbon::create($year, 1, 1)->startOfDay();
    //             $toDate = Carbon::create($year, 12, 31)->endOfDay();
    //             break;
    //         case 'custom':
    //             $fromDate = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : now()->startOfMonth();
    //             $toDate = $request->filled('to') ? Carbon::parse($request->to)->endOfDay() : now()->endOfDay();
    //             break;
    //         default:
    //             $min = Order::min('created_at');
    //             $fromDate = $min ? Carbon::parse($min)->startOfDay() : now()->subYear()->startOfDay();
    //             $toDate = now();
    //             break;
    //     }

    //     // ensure Carbon
    //     $fromDate = $fromDate instanceof \Carbon\Carbon ? $fromDate : Carbon::parse($fromDate);
    //     $toDate = $toDate instanceof \Carbon\Carbon ? $toDate : Carbon::parse($toDate);

    //     // Top customers by revenue (join orders->order_items)
    //     $topCustomersQuery = \App\Models\User::select(
    //         'users.id',
    //         DB::raw("COALESCE(users.first_name,'') as first_name"),
    //         DB::raw("COALESCE(users.last_name,'') as last_name"),
    //         'users.email',
    //         DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
    //         DB::raw('SUM(order_items.price * order_items.quantity) as revenue')
    //     )
    //         ->join('orders', 'orders.user_id', 'users.id')
    //         ->join('order_items', 'order_items.order_id', 'orders.id')
    //         ->whereBetween('orders.created_at', [$fromDate, $toDate])
    //         ->whereIn('orders.payment_status', ['paid', 'delivered'])
    //         ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.email')
    //         ->orderByDesc('revenue')
    //         ->limit($limit);

    //     $topCustomers = $topCustomersQuery->get()->map(function ($u) {
    //         return [
    //             'id' => $u->id,
    //             'name' => trim(($u->first_name ?? '') . ' ' . ($u->last_name ?? '')) ?: $u->email,
    //             'email' => $u->email,
    //             'orders' => (int) $u->orders_count,
    //             'revenue' => (float) $u->revenue,
    //         ];
    //     })->toArray();

    //     $labels = array_map(fn($c) => $c['name'], $topCustomers);
    //     $revenueData = array_map(fn($c) => $c['revenue'], $topCustomers);
    //     $ordersData = array_map(fn($c) => $c['orders'], $topCustomers);

    //     // Totals for KPIs (lightweight)
    //     $totalRevenue = Order::whereBetween('created_at', [$fromDate, $toDate])
    //         ->whereIn('payment_status', ['paid', 'delivered'])
    //         ->sum('total_amount');

    //     return response()->json([
    //         'labels' => $labels,
    //         'revenue' => $revenueData,
    //         'orders' => $ordersData,
    //         'topCustomers' => $topCustomers,
    //         'totalRevenue' => (float) $totalRevenue,
    //         'from' => $fromDate->toDateString(),
    //         'to' => $toDate->toDateString(),
    //     ]);
    // }

    public function customerInsightsData(Request $request)
    {
        $request->validate([
            'period' => 'nullable|string',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'limit' => 'nullable|integer|min:1|max:100'
        ]);

        $period = $request->input('period', 'lifetime');
        $limit  = (int) $request->input('limit', 10);

        $now = Carbon::now();
        $from = null;
        $to = null;

        switch ($period) {
            case '24hr':
                $from = $now->copy()->subDay();
                $to = $now;
                break;
            case 'week':
                $from = $now->copy()->startOfWeek();
                $to = $now->copy()->endOfWeek();
                break;
            case 'month':
                $from = $now->copy()->startOfMonth();
                $to = $now->copy()->endOfMonth();
                break;
            case '3month':
                $from = $now->copy()->subMonths(3)->startOfDay();
                $to = $now;
                break;
            case '6month':
                $from = $now->copy()->subMonths(6)->startOfDay();
                $to = $now;
                break;
            case 'year':
                $from = $now->copy()->startOfYear();
                $to = $now->copy()->endOfYear();
                break;
            case 'custom':
                $from = Carbon::parse($request->input('from'));
                $to = Carbon::parse($request->input('to'));
                break;
            case 'lifetime':
            default:
                $min = User::min('created_at');
                $from = $min ? Carbon::parse($min) : $now->copy()->subYears(5);
                $to = $now;
                break;
        }

        // ensure from <= to
        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        // build daily series between from/to
        $rangeQuery = User::whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day');

        $returningQuery = User::whereHas('orders', function ($q) use ($from, $to) {
            $q->whereBetween('created_at', [$from, $to])
                ->groupBy('user_id')
                ->havingRaw('COUNT(*) > 1');
        })
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day');

        $newRaw = $rangeQuery->pluck('total', 'day');
        $returningRaw = $returningQuery->pluck('total', 'day');

        $labels = [];
        $newArr = [];
        $retArr = [];

        $cursor = $from->copy()->startOfDay();
        $toEnd = $to->copy()->endOfDay();
        while ($cursor->lte($toEnd)) {
            $day = $cursor->toDateString();
            $labels[] = $cursor->format('d M');
            $newArr[] = (int) ($newRaw[$day] ?? 0);
            $retArr[] = (int) ($returningRaw[$day] ?? 0);
            $cursor->addDay();
        }

        // Top customers in period
        $topCustomers = User::withCount(['orders' => function ($q) use ($from, $to) {
            $q->whereBetween('created_at', [$from, $to]);
        }])
            ->withSum(['orders as total_spent' => function ($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from, $to]);
            }], 'total_amount')
            ->orderByDesc('total_spent')
            ->limit($limit)
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->full_name ?? $u->email,
                    'email' => $u->email,
                    'orders' => (int) ($u->orders_count ?? 0),
                    'total_spent' => (float) ($u->total_spent ?? 0),
                ];
            })->values();

        // Top returning products in period
        $returningUserIds = User::whereHas('orders', function ($q) use ($from, $to) {
            $q->whereBetween('created_at', [$from, $to])
                ->groupBy('user_id')
                ->havingRaw('COUNT(*) > 1');
        })->pluck('id')->toArray();

        $topReturningProducts = [];
        if (!empty($returningUserIds)) {
            $rp = OrderItem::select('order_items.product_id', DB::raw('COUNT(*) as total'))
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->whereIn('orders.user_id', $returningUserIds)
                ->whereBetween('orders.created_at', [$from, $to])
                ->groupBy('order_items.product_id')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            $productNames = Products::whereIn('id', $rp->pluck('product_id'))->pluck('name', 'id')->toArray();
            foreach ($rp as $r) {
                $topReturningProducts[] = [
                    'product_id' => $r->product_id,
                    'name' => $productNames[$r->product_id] ?? "Product #{$r->product_id}",
                    'units' => (int) $r->total
                ];
            }
        }

        // heatmap optionally (lightweight)
        $heatmap = $this->getHeatmapSet($returningUserIds, (int) $request->input('monthsBack', 6), $now);

        return response()->json([
            'period' => $period,
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'labels' => $labels,
            'new_customers' => $newArr,
            'returning_customers' => $retArr,
            'topCustomers' => $topCustomers,
            'topReturningProducts' => $topReturningProducts,
            'heatmap' => $heatmap,
        ]);
    }


    public function revenue()
    {
        return view('admin.reports.revenue');
    }

    public function fetchRevenueData(Request $request)
    {
        $period = $request->period ?? 'lifetime';

        // Resolve date ranges + previous period ranges for growth
        switch ($period) {
            case '24hr':
                $toDate   = now();
                $fromDate = now()->subDay();
                $prevFrom = now()->subDays(2);
                $prevTo   = now()->subDay();
                break;

            case 'week':
                $toDate   = now()->endOfDay();
                $fromDate = now()->subDays(7)->startOfDay();
                $prevFrom = now()->subDays(14)->startOfDay();
                $prevTo   = now()->subDays(7)->endOfDay();
                break;

            case 'month':
                $toDate   = now()->endOfMonth();
                $fromDate = now()->startOfMonth();
                $prevFrom = $fromDate->copy()->subMonth()->startOfMonth();
                $prevTo   = $fromDate->copy()->subMonth()->endOfMonth();
                break;

            case '3month':
                $toDate   = now();
                $fromDate = now()->subMonths(3)->startOfDay();
                $prevFrom = now()->subMonths(6)->startOfDay();
                $prevTo   = now()->subMonths(3)->endOfDay();
                break;

            case '6month':
                $toDate   = now();
                $fromDate = now()->subMonths(6)->startOfDay();
                $prevFrom = now()->subMonths(12)->startOfDay();
                $prevTo   = now()->subMonths(6)->endOfDay();
                break;

            case 'year':
                $toDate   = now()->endOfYear();
                $fromDate = now()->startOfYear();
                $prevFrom = $fromDate->copy()->subYear()->startOfYear();
                $prevTo   = $fromDate->copy()->subYear()->endOfYear();
                break;

            case 'custom':
                $fromDate = $request->has('from') ? Carbon::parse($request->from)->startOfDay() : now()->startOfMonth();
                $toDate   = $request->has('to')   ? Carbon::parse($request->to)->endOfDay()   : now()->endOfDay();

                // previous window equal to length of custom period
                $interval = $fromDate->diffInSeconds($toDate);
                $prevTo   = $fromDate->copy()->subSecond(1);
                $prevFrom = $prevTo->copy()->subSeconds($interval);
                break;

            default: // lifetime
                $minCreated = Order::min('created_at');
                $fromDate = $minCreated ? Carbon::parse($minCreated)->startOfDay() : now()->subYear()->startOfDay();
                $toDate   = now();
                // prev: same length before fromDate
                $interval = $fromDate->diffInSeconds($toDate);
                $prevTo   = $fromDate->copy()->subSecond(1);
                $prevFrom = $prevTo->copy()->subSeconds($interval);
                break;
        }

        // ensure Carbon instances
        $fromDate = Carbon::parse($fromDate);
        $toDate   = Carbon::parse($toDate);
        $prevFrom = isset($prevFrom) ? Carbon::parse($prevFrom) : null;
        $prevTo   = isset($prevTo) ? Carbon::parse($prevTo) : null;

        // Paid statuses we consider for revenue
        $paidStatuses = ['paid', 'complete', 'delivered'];

        // 1) Totals: gross revenue, refunds, net revenue, platform profit (commissions)
        $totalRevenue = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->whereIn('payment_status', $paidStatuses)
            ->sum('total_amount');

        $refundsTotal = Returns::whereBetween('created_at', [$fromDate, $toDate])
            ->whereIn('status', ['approved', 'received', 'refunded', 'completed'])
            ->sum('refund_amount');

        // Platform profit = sum of commission_amount on order_items for orders in timeframe
        $platformProfit = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->whereIn('orders.payment_status', $paidStatuses)
            ->sum('order_items.commission_amount');

        $netRevenue = (float)$totalRevenue - (float)$refundsTotal;

        // 2) counts & averages
        $orderCount = Order::whereBetween('created_at', [$fromDate, $toDate])->count();
        $averageOrder = $orderCount ? ($totalRevenue / $orderCount) : 0;

        // 3) previous period revenue & growth
        $prevRevenue = 0;
        if ($prevFrom && $prevTo) {
            $prevRevenue = Order::whereBetween('created_at', [$prevFrom, $prevTo])
                ->whereIn('payment_status', $paidStatuses)
                ->sum('total_amount');
        }
        $revenueGrowth = $prevRevenue ? ((($totalRevenue - $prevRevenue) / (float)$prevRevenue) * 100) : null;

        // 4) Order status breakdown (counts)
        $orderStatusCounts = Order::select('order_status', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->groupBy('order_status')
            ->pluck('total', 'order_status')
            ->toArray();

        // 5) Revenue trend (chart data)
        if ($period === '24hr') {
            // group by hour (strict-mode safe using alias)
            $salesData = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as formatted_hour"),
                DB::raw("SUM(total_amount) as revenue")
            )
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->whereIn('payment_status', $paidStatuses)
                ->groupBy('formatted_hour')
                ->orderBy('formatted_hour')
                ->get();

            $labels = $salesData->pluck('formatted_hour')->map(fn($d) => Carbon::parse($d)->format('H:i'))->values()->all();
            $data   = $salesData->pluck('revenue')->map(fn($v) => (float)$v)->values()->all();
        } else {
            // group by date
            $salesData = Order::select(
                DB::raw("DATE(created_at) as date"),
                DB::raw("SUM(total_amount) as revenue")
            )
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->whereIn('payment_status', $paidStatuses)
                ->groupBy(DB::raw("DATE(created_at)"))
                ->orderBy('date')
                ->get();

            // label format varies by period
            $labelFormat = match ($period) {
                'week' => 'D d M', // Mon 01 Jan
                'month', '3month', '6month', 'custom', 'lifetime' => 'd M',
                'year' => 'M Y',
                default => 'd M'
            };

            $labels = $salesData->pluck('date')->map(fn($d) => Carbon::parse($d)->format($labelFormat))->values()->all();
            $data   = $salesData->pluck('revenue')->map(fn($v) => (float)$v)->values()->all();
        }

        // 6) Top products by revenue
        $topProducts = Products::select('products.id', 'products.name', DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
            ->join('order_items', 'order_items.product_id', 'products.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->whereIn('orders.payment_status', $paidStatuses)
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'revenue' => (float)$p->revenue,
            ]);

        // 7) Category revenue (grouped)
        $categoryRevenue = Products::select(
            'categories.name as category_name',
            DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
        )
            ->join('order_items', 'order_items.product_id', 'products.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->join('product_category_section', 'product_category_section.product_id', '=', 'products.id')
            ->join('master_category_sections', 'master_category_sections.id', '=', 'product_category_section.master_category_section_id')
            ->join('categories', 'categories.id', '=', 'master_category_sections.category_id')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->whereIn('orders.payment_status', $paidStatuses)
            ->groupBy('categories.name')
            ->orderByDesc('revenue')
            ->get()
            ->map(fn($r) => [
                'category' => $r->category_name,
                'revenue' => (float)$r->revenue,
            ]);

        // 8) Top sellers by revenue (optional for admin insight)
        $topSellers = Sellers::select(
            'sellers.id',
            'sellers.name',
            'sellers.email',
            DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
        )
            ->join('products', 'products.seller_id', 'sellers.id')
            ->join('order_items', 'order_items.product_id', 'products.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->whereIn('orders.payment_status', $paidStatuses)
            ->groupBy('sellers.id', 'sellers.name', 'sellers.email')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'email' => $s->email,
                'revenue' => (float)$s->revenue,
            ]);

        // 9) Pending payouts (count) — simple metric for admin to monitor
        $pendingPayoutsCount = OrderItem::whereHas('order', function ($q) use ($fromDate, $toDate, $paidStatuses) {
            $q->whereBetween('created_at', [$fromDate, $toDate])
                ->whereIn('payment_status', $paidStatuses)
                ->where('order_status', 'delivered');
        })->where('settlement_status', 'pending')
            ->count();

        // 10) final response — shape similar to Sales for frontend reuse
        return response()->json([
            'labels'         => $labels,
            'data'           => $data,
            'totalRevenue'   => (float)$totalRevenue,
            'refunds'        => (float)$refundsTotal,
            'netRevenue'     => (float)$netRevenue,
            'platformProfit' => (float)$platformProfit,
            'orderCount'     => (int)$orderCount,
            'averageOrder'   => (float)$averageOrder,
            'revenueGrowth'  => is_null($revenueGrowth) ? null : round($revenueGrowth, 2),
            'orderStatus'    => $orderStatusCounts,
            'topProducts'    => $topProducts,
            'categoryRevenue' => $categoryRevenue,
            'topSellers'     => $topSellers,
            'pendingPayouts' => $pendingPayoutsCount,
            'from'           => $fromDate->toDateString(),
            'to'             => $toDate->toDateString(),
        ]);
    }

    public function sales()
    {
        return view('admin.reports.sales');
    }


    public function fetchSalesData(Request $request)
    {
        $period = $request->period ?? 'lifetime';

        // --------------------------
        // Resolve Dates
        // ---------------------------
        [$fromDate, $toDate] = match ($period) {

            '24hr'   => [now()->subDay(), now()],
            'week'   => [now()->subWeek()->startOfWeek(), now()->endOfWeek()],
            'month'  => [now()->startOfMonth(), now()->endOfMonth()],
            '3month' => [now()->subMonths(3)->startOfDay(), now()],
            '6month' => [now()->subMonths(6)->startOfDay(), now()],
            'year'   => [now()->startOfYear(), now()->endOfYear()],

            'custom' => [
                Carbon::parse($request->from)->startOfDay(),
                Carbon::parse($request->to)->endOfDay()
            ],

            default => [
                // lifetime
                Order::min('created_at') ? Carbon::parse(Order::min('created_at'))->startOfDay() : now()->startOfYear(),
                now()
            ],
        };

        // Force Carbon instances
        $fromDate = Carbon::parse($fromDate);
        $toDate   = Carbon::parse($toDate);


        // ===========================================================
        // Total Sales
        // ===========================================================
        $totalSales = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->whereIn('payment_status', ['paid', 'delivered'])
            ->sum('total_amount');


        // ===========================================================
        // Sales Chart Data
        // ===========================================================
        if ($period === '24hr') {

            $salesData = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as formatted_hour"),
                DB::raw("SUM(total_amount) as total")
            )
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->whereIn('payment_status', ['paid', 'delivered'])
                ->groupBy('formatted_hour')
                ->orderBy('formatted_hour')
                ->get();

            $labels = $salesData->pluck('formatted_hour')
                ->map(fn($d) => Carbon::parse($d)->format('H:i'));
        } else {

            $salesData = Order::select(
                DB::raw("DATE(created_at) as date"),
                DB::raw("SUM(total_amount) as total")
            )
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->whereIn('payment_status', ['paid', 'delivered'])
                ->groupBy(DB::raw("DATE(created_at)"))
                ->orderBy('date')
                ->get();

            $labels = $salesData->pluck('date')
                ->map(fn($d) => Carbon::parse($d)->format(
                    match ($period) {
                        'week'   => 'D d M',
                        'month'  => 'd M',
                        '3month',
                        '6month',
                        'year',
                        'custom' => 'd M',
                        default  => 'd M'
                    }
                ));
        }

        $values = $salesData->pluck('total')->map(fn($v) => (float) $v);


        // ===========================================================
        // Order Status Breakdown
        // ===========================================================
        $status = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->select('order_status', DB::raw('COUNT(*) as total'))
            ->groupBy('order_status')
            ->pluck('total', 'order_status');


        // ===========================================================
        // Refund summary
        // ===========================================================
        $refundsTotal = Returns::whereBetween('created_at', [$fromDate, $toDate])
            ->whereIn('status', ['approved', 'received', 'refunded', 'completed'])
            ->sum('refund_amount');


        // ===========================================================
        // Top Products
        // ===========================================================
        $topProducts = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->whereIn('orders.payment_status', ['paid', 'delivered'])
            ->groupBy('products.id', 'products.name')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as qty'),
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
            )
            ->orderByDesc('qty')
            ->limit(10)
            ->get();


        // ===========================================================
        // Response
        // ===========================================================
        return response()->json([
            'labels'      => $labels,
            'data'        => $values,
            'totalSales'  => $totalSales,
            'refunds'     => $refundsTotal,
            'orderStatus' => $status,
            'topProducts' => $topProducts,
            'from'        => $fromDate->toDateString(),
            'to'          => $toDate->toDateString(),
        ]);
    }
}
