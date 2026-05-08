@extends('admin.layouts.admin')

@section('title', 'Dashboard | CuddlyDuddly')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
    <div class="container-fluid">

        <!-- ===========================
                                     4 STAT CARDS ROW
                                     =========================== -->
        <div class="stats-grid mb-3">

            <!-- PRODUCTS (Clickable) -->
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-dark">
                <div class="stat-box dashboard-card">
                    <div class="stat-icon text-primary"><i class="bi bi-box-seam"></i></div>
                    <div class="stat-value"><span class="count-up" id="prodCount">{{ number_format($productCount) }}</span>
                    </div>
                    <div class="stat-label">Products</div>
                </div>
            </a>

            <!-- CUSTOMERS -->
            <a href="{{ route('admin.customers.index') }}" class="text-decoration-none text-dark">
                <div class="stat-box dashboard-card">
                    <div class="stat-icon text-success"><i class="bi bi-people"></i></div>
                    <div class="stat-value"><span class="count-up" id="custCount">{{ number_format($customerCount) }}</span>
                    </div>
                    <div class="stat-label">Customers</div>
                </div>
            </a>
            <!-- SELLERS -->
            <a href="{{ route('admin.sellers.index') }}" class="text-decoration-none text-dark">
                <div class="stat-box dashboard-card">
                    <div class="stat-icon text-info"><i class="bi bi-person-badge"></i></div>
                    <div class="stat-value"><span class="count-up" id="sellerCount">{{ number_format($sellerCount) }}</span>
                    </div>
                    <div class="stat-label">Sellers</div>
                </div>
            </a>
            <!-- ORDERS -->
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-dark">
                <div class="stat-box dashboard-card">
                    <div class="stat-icon text-warning"><i class="bi bi-cart-check"></i></div>
                    <div class="stat-value"><span class="count-up" id="orderCount">{{ number_format($orderCount) }}</span>
                    </div>
                    <div class="stat-label">Orders</div>
                </div>
            </a>
        </div>

        <!-- ===========================
                                     REVENUE CARD
                                     =========================== -->
        <div class="dashboard-card revenue-card mb-3">
            <div>
                <div class="text-muted">Total Revenue</div>
                <div class="revenue-amount">₹{{ number_format($revenue) }}</div>
                <div class="text-muted" style="font-size:.8rem;">(Delivered orders)</div>
            </div>
            <div class="text-end small text-muted">
                Updated<br>{{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
            </div>
        </div>

        <!-- ===========================
                                     TWO CHARTS
                                     =========================== -->
        <div class="row g-2 mb-3">
            <div class="col-lg-6">
                <div class="dashboard-card chart-card">
                    <div class="chart-title">Sales — Last 7 days</div>
                    <div id="salesSkeleton" class="skeleton" style="height:170px;"></div>
                    <canvas id="salesChart" style="display:none"></canvas>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="dashboard-card chart-card">
                    <div class="chart-title">Seller Growth — Last 6 months</div>
                    <div id="sellerSkeleton" class="skeleton" style="height:170px;"></div>
                    <canvas id="sellerChart" style="display:none"></canvas>
                </div>
            </div>
        </div>

        <!-- ===========================
                                     TOP 3 LISTS (COMPACT)
                                     =========================== -->
        <div class="row g-2 mb-4">

            <div class="col-lg-4 col-md-6">
                <div class="dashboard-card top-compact-card">
                    <div class="section-title">Best Sellers — Revenue</div>
                    <div class="title-sub">Top 5 sellers by revenue</div>

                    <div id="topSellersSkeleton">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="skeleton mb-1" style="height:34px;"></div>
                        @endfor
                    </div>

                    <ul class="list-group list-group-flush" id="topSellersList" style="display:none;">
                        @foreach ($topSellersRevenue as $s)
                            <li class="list-group-item">
                                <span>{{ $s->name }}</span>
                                <strong>₹{{ number_format($s->revenue) }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="dashboard-card top-compact-card">
                    <div class="section-title">Best Sellers — Orders</div>
                    <div class="title-sub">Top 5 sellers by orders</div>

                    <div id="topOrdersSkeleton">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="skeleton mb-1" style="height:34px;"></div>
                        @endfor
                    </div>

                    <ul class="list-group list-group-flush" id="topOrdersList" style="display:none;">
                        @foreach ($topSellersOrders as $s)
                            <li class="list-group-item">
                                <span>{{ $s->name }}</span>
                                <strong>{{ $s->total_orders }} orders</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="dashboard-card top-compact-card">
                    <div class="section-title">Most Selling Products</div>
                    <div class="title-sub">Top 5 products</div>

                    <div id="topProductsSkeleton">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="skeleton mb-1" style="height:34px;"></div>
                        @endfor
                    </div>

                    <ul class="list-group list-group-flush" id="topProductsList" style="display:none;">
                        @foreach ($topProducts as $p)
                            <li class="list-group-item">
                                <span>{{ $p->name }}<small> ({{ $p->qty }} sold)</small></span>
                                <div class="text-end">
                                    <strong>₹{{ number_format($p->total) }}</strong>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>

        <!-- ===========================
                                     RECENT ORDERS (BOTTOM)
                                     =========================== -->
        <div class="dashboard-card mb-3">
            <div class="d-flex justify-content-between mb-2">
                <div class="section-title">Recent Orders</div>
                <div class="small text-muted">Latest 10</div>
            </div>

            <div id="ordersSkeleton">
                @for ($i = 0; $i < 5; $i++)
                    <div class="skeleton mb-2" style="height:40px;"></div>
                @endfor
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="ordersTable" style="display:none;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            @php
                                $item = $order->items->first();
                                $productName =
                                    $item && $item->product ? $item->product->name : $item->product_name ?? '—';
                            @endphp

                            <tr class="order-row" data-href="{{ route('admin.orders.show', $order->id) }}">

                                <td>#{{ $order->order_number ?? $order->id }}</td>
                                <td>{{ $order->user->full_name ?? 'Guest' }}</td>
                                <td>{{ $productName }}</td>

                                <td>
                                    @php
                                        $status = $order->order_status ?? 'unknown';
                                        $cls =
                                            $status == 'delivered'
                                                ? 'bg-success'
                                                : ($status == 'pending'
                                                    ? 'bg-warning'
                                                    : ($status == 'cancelled'
                                                        ? 'bg-danger'
                                                        : 'bg-secondary'));
                                    @endphp
                                    <span class="badge {{ $cls }}">{{ ucfirst($status) }}</span>
                                </td>

                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td class="text-end">₹{{ number_format($order->total_amount) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        (function() {
            "use strict";

            /* ---------------------------------
               Helpers
            ---------------------------------- */
            const $ = s => document.querySelector(s);
            const $$ = s => Array.from(document.querySelectorAll(s));
            const hide = el => el && (el.style.display = "none");
            const show = (el, ds = "") => el && (el.style.display = ds);

            const numArray = arr => {
                try {
                    return (arr || []).map(v => v == null ? 0 : Number(v));
                } catch {
                    return [];
                }
            };

            /* ---------------------------------
               Remove any leftover dark toggle (defensive)
            ---------------------------------- */
            (function removeDarkMode() {
                const t = $("#modeToggle");
                if (t) t.remove();
                document.body.classList.remove("dark");
            })();


            /* ---------------------------------
               Count-up numbers using rAF
            ---------------------------------- */
            (function initCountUp() {
                const counters = [{
                        id: "prodCount",
                        value: Number({{ intval($productCount) }})
                    },
                    {
                        id: "custCount",
                        value: Number({{ intval($customerCount) }})
                    },
                    {
                        id: "sellerCount",
                        value: Number({{ intval($sellerCount) }})
                    },
                    {
                        id: "orderCount",
                        value: Number({{ intval($orderCount) }})
                    },
                ];

                counters.forEach(item => {
                    const el = document.getElementById(item.id);
                    if (!el) return;

                    const startVal = 0;
                    const endVal = Math.max(0, item.value);
                    const duration = 900;
                    const start = performance.now();

                    function animate(now) {
                        const t = Math.min(1, (now - start) / duration);
                        const eased = 1 - Math.pow(1 - t, 3); // easeOutCubic
                        const v = Math.round(startVal + (endVal - startVal) * eased);
                        el.textContent = v.toLocaleString();
                        if (t < 1) requestAnimationFrame(animate);
                    }
                    requestAnimationFrame(animate);
                });
            })();


            /* ---------------------------------
               Charts + 1.5s Skeleton Reveal
            ---------------------------------- */
            (function initCharts() {

                const SKELETON_DELAY = 1500;

                const salesLabels = @json($salesLabels ?? []);
                const salesValues = numArray(@json($salesValues ?? []));
                const sellerLabels = @json($sellerLabels ?? []);
                const sellerValues = numArray(@json($sellerValues ?? []));

                function safeChart(id, configFn) {
                    const canvas = document.getElementById(id);
                    if (!canvas) return;

                    try {
                        const ctx = canvas.getContext("2d");
                        if (canvas._chart) canvas._chart.destroy();

                        const chart = configFn(ctx);
                        canvas._chart = chart;

                        return chart;

                    } catch (e) {
                        console.error("Chart failed:", id, e);
                    }
                }

                setTimeout(() => {

                    /* Sales (Line) */
                    safeChart("salesChart", ctx =>
                        new Chart(ctx, {
                            type: "line",
                            data: {
                                labels: salesLabels,
                                datasets: [{
                                    data: salesValues,
                                    borderWidth: 2,
                                    tension: 0.32,
                                    fill: true,
                                    backgroundColor: "rgba(76,111,255,0.12)",
                                    borderColor: "#4c6fff",
                                    pointRadius: 2
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: v => "₹" + Number(v).toLocaleString()
                                        }
                                    }
                                }
                            }
                        })
                    );

                    /* Sellers (Bar) */
                    safeChart("sellerChart", ctx =>
                        new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: sellerLabels,
                                datasets: [{
                                    data: sellerValues,
                                    borderRadius: 6,
                                    backgroundColor: "rgba(50,200,150,0.24)"
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        precision: 0
                                    }
                                }
                            }
                        })
                    );

                    /* Reveal real content, hide skeletons */
                    [
                        ["salesSkeleton", "salesChart"],
                        ["sellerSkeleton", "sellerChart"],
                        ["ordersSkeleton", "ordersTable"],
                        ["topSellersSkeleton", "topSellersList"],
                        ["topOrdersSkeleton", "topOrdersList"],
                        ["topProductsSkeleton", "topProductsList"],
                    ].forEach(([sk, sh]) => {
                        hide(document.getElementById(sk));
                        show(document.getElementById(sh));
                    });

                }, SKELETON_DELAY);
            })();


            /* ---------------------------------
               Order Row Click (Delegated)
            ---------------------------------- */
            (function rowClickHandler() {
                const wrapper = document.querySelector(".table-responsive");
                if (!wrapper) return;

                wrapper.addEventListener("click", e => {
                    const row = e.target.closest(".order-row");
                    if (!row) return;
                    const id = row.dataset.orderId;
                    if (id) window.location.href = `/admin/orders/${id}`;
                });

                wrapper.addEventListener("keydown", e => {
                    if (e.key !== "Enter") return;
                    const row = e.target.closest(".order-row");
                    if (row?.dataset.orderId)
                        window.location.href = `/admin/orders/${row.dataset.orderId}`;
                });

                $$(".order-row").forEach(r => r.tabIndex = 0);
            })();


            /* ---------------------------------
               Chart.js Missing Fallback
            ---------------------------------- */
            (function fallbackCheck() {
                if (typeof Chart === "undefined") {
                    console.warn("Chart.js missing.");
                    ["salesSkeleton", "sellerSkeleton"].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.innerHTML = "<div class='text-muted small'>Chart unavailable</div>";
                    });
                }
            })();
            document.addEventListener("click", (e) => {
                const row = e.target.closest(".order-row");
                if (row && row.dataset.href) {
                    window.location.href = row.dataset.href;
                }
            });
        })();
    </script>
@endpush
