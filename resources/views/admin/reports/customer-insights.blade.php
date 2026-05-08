@extends('admin.layouts.admin')

@section('title', 'Customer Insights')

@push('styles')
    {{-- Shared report CSS + optional custom file --}}
    <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">

    <style>
        /* Top products list */
        .top-products-list {
            max-height: 300px;
            overflow: auto;
            padding: 6px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .top-product-item {
            display: flex;
            gap: 10px;
            align-items: center;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
            background: #fff;
        }

        .top-product-item img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-0 settings-wrapper">
        <div class="settings-right">
            <div class="settings-right-inner">

                {{-- Header KPIs --}}
                <div class="settings-section card mb-4">
                    <div class="card-body d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="settings-section-title">Customer Insights</h3>
                                <small class="text-muted">Overview — growth, retention, products & churn.</small>
                            </div>
                        </div>

                        <div class="view-grid mt-3">
                            <div class="view-row">
                                <div>
                                    <div class="label">Total Customers</div>
                                    <div class="value" id="kpiTotal">{{ $totalCustomers ?? 0 }}</div>
                                    <small class="text-muted">All registered users</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <div class="label">Active (30d)</div>
                                    <div class="value" id="kpiActive">{{ $activeCustomers ?? 0 }}</div>
                                    <small class="text-muted">Seen activity</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <div class="label">New (30d)</div>
                                    <div class="value" id="kpiNew">{{ $newCustomers?->count() ?? 0 }}</div>
                                    <small class="text-muted">Signups</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <div class="label">Returning</div>
                                    <div class="value" id="kpiReturning">{{ $returningCustomers ?? 0 }}</div>
                                    <small class="text-muted">≥ 2 orders</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Growth (full width single column) --}}
                <div class="settings-section card mb-4">
                    <div class="card-body chart-card position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-0">Customer Growth</h5>
                                <small class="text-muted">New vs Returning — choose a period or custom range.</small>
                            </div>
                        </div>
                        <div class="settings-section-divider"></div>

                        <div class="chart-controls" id="chartControls" aria-hidden="false">
                            <div id="periodButtons" class="period-btns btn-group" role="group" aria-label="Quick periods">
                                <button class="btn btn-outline-primary btn-sm filter-btn"
                                    data-period="lifetime">Lifetime</button>
                                <button class="btn btn-outline-primary btn-sm filter-btn" data-period="24hr">24h</button>
                                <button class="btn btn-outline-primary btn-sm filter-btn" data-period="week">Week</button>
                                <button class="btn btn-outline-primary btn-sm filter-btn" data-period="month">Month</button>
                                <button class="btn btn-outline-primary btn-sm filter-btn" data-period="3month">3 mo</button>
                                <button class="btn btn-outline-primary btn-sm filter-btn" data-period="6month">6 mo</button>
                                <button class="btn btn-outline-primary btn-sm filter-btn" data-period="year">Year</button>
                                <button class="btn btn-dark btn-sm" id="chartCustomToggle"
                                    aria-expanded="false">Custom</button>
                            </div>

                            <div class="form-check mb-0 ms-2 period-btns">
                                {{-- Added period-btns class to topN select for consistent styling --}}
                                <select id="topNSelect" class="form-select form-select-sm period-btns">
                                    <option value="5">Top 5</option>
                                    <option value="10" selected>Top 10</option>
                                    <option value="20">Top 20</option>
                                </select>
                            </div>

                            <div class="dropdown period-btns">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" id="chartExport"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export</button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartExport">
                                    <li><a class="dropdown-item" href="#" data-action="csv">Download CSV</a></li>
                                    <li><a class="dropdown-item" href="#" data-action="png">Download PNG</a></li>
                                    <li><a class="dropdown-item" href="#" data-action="print">Print</a></li>
                                </ul>
                            </div>
                        </div>

                        {{-- Custom inline --}}
                        <div id="customRangeInline" style="display:none;" class="mb-2">
                            <div class="row g-2">
                                <div class="col-4"><input type="date" id="fromDate"
                                        class="form-control form-control-sm"></div>
                                <div class="col-4"><input type="date" id="toDate"
                                        class="form-control form-control-sm"></div>
                                <div class="col-4 d-grid"><button class="btn btn-primary btn-sm"
                                        id="applyCustomRange">Apply</button></div>
                            </div>
                        </div>

                        <div id="chartWrapper" class="chart-wrap">
                            <canvas id="customersGrowthChart"></canvas>
                        </div>

                        <div class="settings-loading" id="chartLoader" aria-hidden="true">
                            <div class="spinner"></div>
                        </div>
                        <div id="chartNoResults" style="display:none" class="text-center mt-2 text-muted">No data for
                            selected range.</div>
                    </div>
                </div>

                {{-- Top Returning Products: bar chart (left) + list (right) in same row --}}
                <div class="row mb-3 g-3">
                    <div class="col-lg-7">
                        <div class="settings-section card">
                            <div class="card-body">
                                <h6 class="mb-2">Top Returning Products (bar)</h6>
                                <div style="height:260px;">
                                    <canvas id="returningProductsChart" style="height:100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="settings-section card">
                            <div class="card-body">
                                <h6 class="mb-2">Product List</h6>
                                <div id="topReturningProductsList" class="top-products-list">
                                    @php $defaultAvatar = asset('storage/images/default-avatar.png'); @endphp
                                    @foreach ($returningProductData as $idx => $row)
                                        @php
                                            $pid = $row->product_id;
                                            $units = $row->total ?? 0;
                                            $prod = $returningProducts->get($pid);
                                            $pname = $prod?->name ?? "Product #$pid";
                                            $pimg = $prod?->primaryImage?->url ?? $defaultAvatar;
                                        @endphp
                                        <div class="top-product-item">
                                            <img src="{{ $pimg }}" alt="p"
                                                onerror="this.src='{{ $defaultAvatar }}'">
                                            <div style="flex:1">
                                                <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($pname, 60) }}
                                                </div>
                                                <small class="text-muted">{{ $units }} units</small>
                                            </div>
                                            <div style="width:100px;">
                                                <div class="progress" style="height:8px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width:{{ round(100 * ($units / max($returningProductValues->toArray() ?: [1]))) }}%; background:linear-gradient(90deg,#6366f1,#4f46e5)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @unless (count($returningProductData))
                                        <div class="text-muted">No products found.</div>
                                    @endunless
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Churn Risk (full width bottom) --}}
                <div class="settings-section card mb-4">
                    <div class="card-body">
                        <h6 class="mb-2">Churn Risk</h6>
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <canvas id="churnChart" height="180"></canvas>
                            </div>
                            <div class="col-md-8">
                                <div class="small text-muted">Summary</div>
                                <div class="mt-2">
                                    <div class="d-flex justify-content-between"><small>High</small><strong
                                            id="churnHigh">{{ $highRisk ?? 0 }}</strong></div>
                                    <div class="d-flex justify-content-between"><small>Medium</small><strong
                                            id="churnMedium">{{ $mediumRisk ?? 0 }}</strong></div>
                                    <div class="d-flex justify-content-between"><small>Low</small><strong
                                            id="churnLow">{{ $lowRisk ?? 0 }}</strong></div>
                                </div>
                                <hr>
                                <small>Recommendations</small>
                                <ul class="mb-0">
                                    <li>Win-back email for high-risk</li>
                                    <li>Personalised offers & loyalty</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="settings-toast" id="settingsToast" role="status" aria-live="polite" style="display:none;">
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>

        {{-- <script>
            (function() {
                // DOM helpers
                const $ = s => document.querySelector(s);
                const $$ = s => Array.from(document.querySelectorAll(s));
                const defaultAvatar = "{{ asset('storage/images/default-avatar.png') }}";

                /* ---------------------------------------------
                   UI SYNC — MATCHES SELLER BLADE BEHAVIOR
                ----------------------------------------------*/
                function setActiveFilterUI(period) {
                    // quick-period buttons
                    $$('.filter-btn').forEach(b => {
                        const is = b.dataset.period === period;
                        b.classList.toggle('btn-primary', is);
                        b.classList.toggle('btn-outline-primary', !is);
                        b.setAttribute('aria-pressed', is ? 'true' : 'false');
                    });

                    // custom button
                    const customBtn = $('#chartCustomToggle');
                    if (customBtn) {
                        const active = period === 'custom';
                        customBtn.classList.toggle('btn-primary', active);
                        customBtn.classList.toggle('btn-dark', !active);
                        customBtn.setAttribute('aria-pressed', active ? 'true' : 'false');
                    }
                }

                // server-side fallback arrays
                const initial = {
                    labels: {
                        daily: @json($dailyLabels),
                        weekly: @json($weeklyLabels),
                        monthly: @json($months),
                        yearly: @json($yearLabels)
                    },
                    data: {
                        daily: @json($dailyNewCustomers),
                        weekly: @json($weeklyNewCustomers),
                        monthly: @json($monthlyNew),
                        yearly: @json($yearlyNew)
                    }
                };

                // Growth chart
                const ctxGrowth = $('#customersGrowthChart').getContext('2d');
                const growthChart = new Chart(ctxGrowth, {
                    type: 'line',
                    data: {
                        labels: initial.labels.monthly,
                        datasets: [{
                                label: 'New',
                                data: initial.data.monthly,
                                tension: .3,
                                fill: true,
                                backgroundColor: 'rgba(59,130,246,0.08)',
                                borderColor: 'rgba(59,130,246,1)',
                                pointRadius: 2
                            },
                            {
                                label: 'Returning',
                                data: initial.data.monthly.map(() => 0),
                                tension: .3,
                                fill: true,
                                backgroundColor: 'rgba(16,185,129,0.06)',
                                borderColor: 'rgba(16,185,129,0.9)',
                                pointRadius: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Products bar chart
                const ctxProducts = $('#returningProductsChart').getContext('2d');
                const productsChart = new Chart(ctxProducts, {
                    type: 'bar',
                    data: {
                        labels: @json($returningProductLabels),
                        datasets: [{
                            label: 'Units',
                            data: @json($returningProductValues),
                            borderRadius: 6,
                            backgroundColor: 'rgba(79,70,229,0.15)',
                            borderColor: 'rgba(79,70,229,1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    autoSkip: true
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Churn pie
                try {
                    new Chart($('#churnChart').getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: ['Low', 'Medium', 'High'],
                            datasets: [{
                                data: [
                                    @json($lowRisk ?? 0),
                                    @json($mediumRisk ?? 0),
                                    @json($highRisk ?? 0)
                                ],
                                backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                } catch (e) {
                    console.warn(e);
                }

                // Abortable fetch
                let controller = null;

                function abortFetch() {
                    if (controller) {
                        controller.abort();
                        controller = null;
                    }
                }

                function showLoader(on) {
                    const l = $('#chartLoader');
                    if (!l) return;
                    l.style.display = on ? 'flex' : 'none';
                    l.setAttribute('aria-hidden', (!on).toString());
                }

                function renderTopProductsList(list) {
                    const container = $('#topReturningProductsList');
                    if (!container) return;
                    container.innerHTML = '';
                    if (!Array.isArray(list) || !list.length) {
                        container.innerHTML = '<div class="text-muted">No products found.</div>';
                        return;
                    }
                    const max = Math.max(...list.map(x => x.units || 0), 1);
                    list.forEach(p => {
                        const img = p.image || defaultAvatar;
                        const name = p.name || `Product #${p.id||''}`;
                        const units = p.units || 0;
                        const div = document.createElement('div');
                        div.className = 'top-product-item';
                        div.innerHTML = `
                    <img src="${escapeHtml(img)}" onerror="this.src='${defaultAvatar}'" alt="">
                    <div style="flex:1">
                        <div class="fw-semibold">${escapeHtml(name)}</div>
                        <small class="text-muted">${units} units</small>
                    </div>
                    <div style="width:100px">
                        <div class="progress" style="height:8px">
                            <div class="progress-bar" role="progressbar"
                                style="width:${Math.round(100*(units/max))}%; background:linear-gradient(90deg,#6366f1,#4f46e5)">
                            </div>
                        </div>
                    </div>`;
                        container.appendChild(div);
                    });
                }

                function escapeHtml(s) {
                    return String(s || '').replace(/[&<>"']/g, m =>
                        ({
                            '&': '&amp;',
                            '<': '&lt;',
                            '>': '&gt;',
                            '"': '&quot;',
                            "'": '&#39;'
                        } [m])
                    );
                }

                /* ---------------------------------------------------
                   FETCH DATA — NOW ALSO SYNC UI LIKE SELLER BLADE
                ----------------------------------------------------*/
                async function fetchData(period = 'lifetime', from = null, to = null, limit = 10) {
                    abortFetch();
                    controller = new AbortController();

                    setActiveFilterUI(period); // <-- THE FIX

                    showLoader(true);
                    $('#chartNoResults').style.display = 'none';

                    const params = new URLSearchParams({
                        period,
                        limit
                    });
                    if (period === 'custom') {
                        if (from) params.set('from', from);
                        if (to) params.set('to', to);
                    }

                    try {
                        const res = await fetch(
                            "{{ route('admin.reports.customers.data') }}?" + params.toString(), {
                                signal: controller.signal
                            }
                        );
                        if (!res.ok) throw new Error('Network ' + res.status);

                        const payload = await res.json();

                        const labels = payload.labels || [];
                        const newSeries = payload.new_customers || [];
                        const retSeries = payload.returning_customers || [];

                        growthChart.data.labels = labels;
                        growthChart.data.datasets[0].data = newSeries;
                        growthChart.data.datasets[1].data = retSeries;
                        growthChart.update();

                        if (Array.isArray(payload.topReturningProducts) && payload.topReturningProducts.length) {
                            const names = payload.topReturningProducts.map(p => p.name);
                            const units = payload.topReturningProducts.map(p => p.units || 0);
                            productsChart.data.labels = names;
                            productsChart.data.datasets[0].data = units;
                            productsChart.update();
                            renderTopProductsList(payload.topReturningProducts);
                        }

                        const allZero = arr =>
                            !arr || arr.length === 0 || arr.every(v => Number(v) === 0);
                        $('#chartNoResults').style.display =
                            (allZero(newSeries) && allZero(retSeries)) ? 'block' : 'none';

                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            console.error(err);
                            alert('Failed to load customer data');
                        }
                    } finally {
                        showLoader(false);
                        controller = null;
                    }
                }

                /* ---------------------------------------------
                   PERIOD BUTTONS + CUSTOM RANGE
                ----------------------------------------------*/
                $('#periodButtons').addEventListener('click', e => {
                    const btn = e.target.closest('.filter-btn, #chartCustomToggle');
                    if (!btn) return;

                    const period = btn.dataset.period || (btn.id === 'chartCustomToggle' ? 'custom' : null);

                    if (period !== 'custom') {
                        $('#customRangeInline').style.display = 'none';
                        fetchData(period, null, null, Number($('#topNSelect').value));
                    } else {
                        $('#customRangeInline').style.display = 'block';
                        setActiveFilterUI('custom');
                    }
                });

                $('#chartCustomToggle').addEventListener('click', () => {
                    const box = $('#customRangeInline');
                    const open = box.style.display === 'block';
                    box.style.display = open ? 'none' : 'block';
                    $('#chartCustomToggle').setAttribute('aria-expanded', (!open).toString());
                });

                $('#applyCustomRange').addEventListener('click', () => {
                    const from = $('#fromDate').value,
                        to = $('#toDate').value;
                    if (!from || !to) return alert('Select From and To');
                    fetchData('custom', from, to, Number($('#topNSelect').value));
                });

                $('#topNSelect').addEventListener('change', () => {
                    const active = $$('.filter-btn.btn-primary')[0]?.dataset.period || 'lifetime';
                    if (active === 'custom') {
                        fetchData('custom', $('#fromDate').value, $('#toDate').value, Number($('#topNSelect')
                            .value));
                    } else {
                        fetchData(active, null, null, Number($('#topNSelect').value));
                    }
                });

                // Export handlers
                document.addEventListener('click', e => {
                    const a = e.target.closest('[data-action]');
                    if (!a) return;
                    e.preventDefault();
                    const action = a.dataset.action;
                    const chart = growthChart;

                    if (action === 'png') {
                        const url = chart.toBase64Image();
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'customers-growth.png';
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    } else if (action === 'csv') {
                        const labels = chart.data.labels || [];
                        const ds = chart.data.datasets[0]?.data || [];
                        let csv = 'label,new\n';
                        for (let i = 0; i < labels.length; i++)
                            csv += `"${labels[i]}",${ds[i]??0}\n`;
                        const blob = new Blob([csv], {
                            type: 'text/csv'
                        });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'customers-growth.csv';
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                        URL.revokeObjectURL(url);
                    } else if (action === 'print') {
                        const url = chart.toBase64Image();
                        const w = window.open('', '_blank');
                        w.document.write(`<img src="${url}" style="max-width:100%">`);
                        w.document.close();
                        w.focus();
                        w.print();
                    }
                });

                /* ---------------------------------------------
                   INIT — NOW ALSO SETS UI LIKE SELLER BLADE
                ----------------------------------------------*/
                (function init() {
                    setActiveFilterUI('lifetime'); // <-- FIX FOR INVISIBLE TEXT
                    fetchData('lifetime', null, null, Number($('#topNSelect').value));
                })();

            })();
        </script> --}}

        {{-- Optimized Version --}}
        <script>
            (function() {
                'use strict';

                // ---------- cached DOM ----------
                const $ = s => document.querySelector(s);
                const $$ = s => Array.from(document.querySelectorAll(s));

                const refs = {
                    root: document,
                    periodButtons: $('#periodButtons'),
                    customToggle: $('#chartCustomToggle'),
                    customBox: $('#customRangeInline'),
                    fromDate: $('#fromDate'),
                    toDate: $('#toDate'),
                    applyCustom: $('#applyCustomRange'),
                    cancelCustom: $('#cancelCustomRange'),
                    topN: $('#topNSelect'),
                    productsList: $('#topReturningProductsList'),
                    loader: $('#chartLoader'),
                    noResults: $('#chartNoResults'),
                    toast: $('#settingsToast'),
                    growthCanvas: $('#customersGrowthChart'),
                    productsCanvas: $('#returningProductsChart'),
                    churnCanvas: $('#churnChart'),
                    exportArea: document // delegation target
                };

                const defaultAvatar = "{{ asset('storage/images/default-avatar.png') }}";

                // ---------- small helpers & formatters ----------
                const escMap = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                };
                const escapeHtml = s => String(s || '').replace(/[&<>"']/g, m => escMap[m]);

                const nfNumber = new Intl.NumberFormat('en-IN');
                const nfCurrency = new Intl.NumberFormat('en-IN', {
                    maximumFractionDigits: 2
                });
                const fmtNumber = v => nfNumber.format(Number(v) || 0);
                const fmtCurrency = v => '₹' + nfCurrency.format(Number(v) || 0);

                const showToast = (msg, type = 'success') => {
                    const t = refs.toast;
                    if (!t) return;
                    t.textContent = msg;
                    t.className = 'settings-toast ' + (type === 'error' ? 'error' : 'success');
                    t.style.display = 'block';
                    setTimeout(() => {
                        t.style.display = 'none';
                    }, 2600);
                };

                function showLoader(on) {
                    const l = refs.loader;
                    if (!l) return;
                    l.classList.toggle('is-visible', !!on);
                    l.setAttribute('aria-hidden', (!!on).toString());
                    // maintain the inline fallback
                    l.style.display = on ? 'flex' : 'none';
                }

                // ---------- UI sync for filter buttons ----------
                const filterBtns = $$('.filter-btn');

                function setActiveFilterUI(period) {
                    const isCustom = period === 'custom';
                    for (let i = 0; i < filterBtns.length; i++) {
                        const b = filterBtns[i];
                        const active = b.dataset.period === period;
                        b.classList.toggle('btn-primary', active);
                        b.classList.toggle('btn-outline-primary', !active);
                        b.setAttribute('aria-pressed', active ? 'true' : 'false');
                    }
                    const c = refs.customToggle;
                    if (c) {
                        c.classList.toggle('btn-primary', isCustom);
                        c.classList.toggle('btn-dark', !isCustom);
                        c.setAttribute('aria-pressed', isCustom ? 'true' : 'false');
                    }
                }

                // ---------- Charts init (created once) ----------
                const initial = {
                    labels: {
                        daily: @json($dailyLabels),
                        weekly: @json($weeklyLabels),
                        monthly: @json($months),
                        yearly: @json($yearLabels)
                    },
                    data: {
                        daily: @json($dailyNewCustomers),
                        weekly: @json($weeklyNewCustomers),
                        monthly: @json($monthlyNew),
                        yearly: @json($yearlyNew)
                    }
                };

                const growthCtx = refs.growthCanvas.getContext('2d');
                const growthChart = new Chart(growthCtx, {
                    type: 'line',
                    data: {
                        labels: initial.labels.monthly,
                        datasets: [{
                                label: 'New',
                                data: initial.data.monthly,
                                tension: .3,
                                fill: true,
                                backgroundColor: 'rgba(59,130,246,0.08)',
                                borderColor: 'rgba(59,130,246,1)',
                                pointRadius: 2
                            },
                            {
                                label: 'Returning',
                                data: initial.data.monthly.map(() => 0),
                                tension: .3,
                                fill: true,
                                backgroundColor: 'rgba(16,185,129,0.06)',
                                borderColor: 'rgba(16,185,129,0.9)',
                                pointRadius: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                const productsCtx = refs.productsCanvas.getContext('2d');
                const productsChart = new Chart(productsCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($returningProductLabels),
                        datasets: [{
                            label: 'Units',
                            data: @json($returningProductValues),
                            borderRadius: 6,
                            backgroundColor: 'rgba(79,70,229,0.15)',
                            borderColor: 'rgba(79,70,229,1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    autoSkip: true
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                try {
                    new Chart(refs.churnCanvas.getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: ['Low', 'Medium', 'High'],
                            datasets: [{
                                data: [@json($lowRisk ?? 0), @json($mediumRisk ?? 0),
                                    @json($highRisk ?? 0)
                                ],
                                backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                } catch (e) {
                    // non-blocking
                    console.warn(e);
                }

                // ---------- render product list (batch HTML) ----------
                function renderTopProductsList(list) {
                    const container = refs.productsList;
                    if (!container) return;
                    if (!Array.isArray(list) || !list.length) {
                        container.innerHTML = '<div class="text-muted">No products found.</div>';
                        return;
                    }

                    let max = 1;
                    for (let i = 0; i < list.length; i++) {
                        const u = list[i].units || 0;
                        if (u > max) max = u;
                    }

                    let out = '';
                    for (let i = 0; i < list.length; i++) {
                        const p = list[i];
                        const img = p.image || defaultAvatar;
                        const name = escapeHtml(p.name || `Product #${p.id || ''}`);
                        const units = p.units || 0;
                        const percent = Math.round(100 * (units / max));
                        out += `<div class="top-product-item">
                        <img src="${img}" onerror="this.src='${defaultAvatar}'" alt="">
                        <div style="flex:1">
                            <div class="fw-semibold">${name}</div>
                            <small class="text-muted">${units} units</small>
                        </div>
                        <div style="width:100px">
                            <div class="progress" style="height:8px">
                                <div class="progress-bar" role="progressbar" style="width:${percent}%; background:linear-gradient(90deg,#6366f1,#4f46e5)"></div>
                            </div>
                        </div>
                    </div>`;
                    }
                    container.innerHTML = out;
                }

                // ---------- fetch logic (abortable) ----------
                let controller = null;

                function abortFetch() {
                    if (controller) {
                        try {
                            controller.abort();
                        } catch (e) {}
                        controller = null;
                    }
                }

                async function fetchData(period = 'lifetime', from = null, to = null, limit = 10) {
                    abortFetch();
                    controller = new AbortController();

                    setActiveFilterUI(period);
                    showLoader(true);
                    if (refs.noResults) refs.noResults.style.display = 'none';

                    const params = new URLSearchParams({
                        period,
                        limit: String(limit)
                    });
                    if (period === 'custom') {
                        if (from) params.set('from', from);
                        if (to) params.set('to', to);
                    }

                    try {
                        const res = await fetch("{{ route('admin.reports.customers.data') }}?" + params.toString(), {
                            signal: controller.signal
                        });
                        if (!res.ok) throw new Error('Network ' + res.status);
                        const payload = await res.json();

                        const labels = payload.labels || [];
                        const newSeries = payload.new_customers || [];
                        const retSeries = payload.returning_customers || [];

                        // update growth chart
                        const g = growthChart;
                        g.data.labels = labels;
                        g.data.datasets[0].data = newSeries;
                        g.data.datasets[1].data = retSeries;
                        g.update();

                        // update products chart & list
                        if (Array.isArray(payload.topReturningProducts) && payload.topReturningProducts.length) {
                            const top = payload.topReturningProducts;
                            const names = new Array(top.length),
                                vals = new Array(top.length);
                            for (let i = 0; i < top.length; i++) {
                                names[i] = top[i].name;
                                vals[i] = top[i].units || 0;
                            }
                            productsChart.data.labels = names;
                            productsChart.data.datasets[0].data = vals;
                            productsChart.update();
                            renderTopProductsList(top);
                        }

                        // no-results
                        const allZero = arr => !arr || arr.length === 0 || arr.every(v => Number(v) === 0);
                        if (refs.noResults) refs.noResults.style.display = (allZero(newSeries) && allZero(retSeries)) ?
                            'block' : 'none';
                    } catch (err) {
                        if (!err || err.name !== 'AbortError') {
                            console.error(err);
                            alert('Failed to load customer data');
                        }
                    } finally {
                        showLoader(false);
                        controller = null;
                    }
                }

                // ---------- event wiring (minimal listeners) ----------
                if (refs.periodButtons) {
                    refs.periodButtons.addEventListener('click', e => {
                        const btn = e.target.closest('.filter-btn, #chartCustomToggle');
                        if (!btn) return;
                        const period = btn.dataset.period || (btn.id === 'chartCustomToggle' ? 'custom' : null);
                        if (period !== 'custom') {
                            if (refs.customBox) refs.customBox.style.display = 'none';
                            fetchData(period, null, null, Number(refs.topN.value || 10));
                        } else {
                            if (refs.customBox) refs.customBox.style.display = 'block';
                            setActiveFilterUI('custom');
                        }
                    });
                }

                if (refs.customToggle) {
                    refs.customToggle.addEventListener('click', () => {
                        const box = refs.customBox;
                        const open = box && box.style.display === 'block';
                        if (box) box.style.display = open ? 'none' : 'block';
                        refs.customToggle.setAttribute('aria-expanded', (!open).toString());
                    });
                }

                if (refs.applyCustom) {
                    refs.applyCustom.addEventListener('click', () => {
                        const f = refs.fromDate && refs.fromDate.value,
                            t = refs.toDate && refs.toDate.value;
                        if (!f || !t) {
                            showToast('Please select both dates', 'error');
                            return;
                        }
                        if (refs.customBox) refs.customBox.style.display = 'none';
                        fetchData('custom', f, t, Number(refs.topN.value || 10));
                    });
                }

                if (refs.cancelCustom) {
                    refs.cancelCustom.addEventListener('click', () => {
                        if (refs.customBox) refs.customBox.style.display = 'none';
                        if (refs.customToggle) refs.customToggle.setAttribute('aria-expanded', 'false');
                    });
                }

                // keyboard accessibility for filter buttons
                for (let i = 0; i < filterBtns.length; i++) {
                    const b = filterBtns[i];
                    b.addEventListener('keydown', ev => {
                        if (ev.key === 'Enter' || ev.key === ' ') {
                            ev.preventDefault();
                            b.click();
                        }
                    });
                }

                // topN change
                if (refs.topN) {
                    refs.topN.addEventListener('change', () => {
                        const active = (document.querySelector('.filter-btn.btn-primary') || {}).dataset?.period ||
                            'lifetime';
                        if (active === 'custom') {
                            const f = refs.fromDate && refs.fromDate.value,
                                t = refs.toDate && refs.toDate.value;
                            fetchData('custom', f, t, Number(refs.topN.value || 10));
                        } else fetchData(active, null, null, Number(refs.topN.value || 10));
                    });
                }

                // export / print handler (delegated)
                refs.exportArea.addEventListener('click', e => {
                    const a = e.target.closest('[data-action]');
                    if (!a) return;
                    e.preventDefault();
                    const act = a.dataset.action;
                    const chart = growthChart;
                    if (act === 'png') {
                        const url = chart.toBase64Image();
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'customers-growth.png';
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    } else if (act === 'csv') {
                        const labels = chart.data.labels || [],
                            ds = chart.data.datasets[0]?.data || [];
                        let csv = 'label,new\n';
                        for (let i = 0; i < labels.length; i++) csv += `"${labels[i]}",${ds[i] ?? 0}\n`;
                        const blob = new Blob([csv], {
                            type: 'text/csv'
                        });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'customers-growth.csv';
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                        URL.revokeObjectURL(url);
                    } else if (act === 'print') {
                        const url = chart.toBase64Image();
                        const w = window.open('', '_blank');
                        w.document.write(`<img src="${url}" style="max-width:100%">`);
                        w.document.close();
                        w.focus();
                        w.print();
                    }
                });

                // no-results quick chips
                const chips = $$('.no-results-chip');
                for (let i = 0; i < chips.length; i++) {
                    chips[i].addEventListener('click', () => fetchData(chips[i].dataset.period, null, null, Number(refs.topN
                        .value || 10)));
                }

                // initial load
                (function init() {
                    setActiveFilterUI('lifetime');
                    fetchData('lifetime', null, null, Number(refs.topN.value || 10));
                })();

            })();
        </script>
    @endpush
@endsection
