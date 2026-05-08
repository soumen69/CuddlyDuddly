@extends('admin.layouts.admin')

@section('title', 'Seller Performance')

@section('content')
    <div class="container-fluid py-0 settings-wrapper">
        <div class="settings-right">
            <div class="settings-right-inner">

                {{-- Header --}}
                <div class="settings-section card mb-4">
                    <div class="card-body">
                        <div class="settings-section-header">
                            <div>
                                <h3 class="settings-section-title">Seller Performance</h3>
                                <div class="settings-section-subtitle">Top sellers, revenue and order volumes — use filters
                                    to drill down.</div>
                            </div>
                        </div>

                        <div class="view-grid">
                            <div class="view-row">
                                <div>
                                    <span class="label">Total Sellers</span>
                                    <div class="value" id="totalSellers">{{ $totalSellers ?? 0 }}</div>
                                    <small class="text-muted">All sellers</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <span class="label">Active Sellers</span>
                                    <div class="value" id="activeSellers">{{ $activeSellers ?? 0 }}</div>
                                    <small class="text-muted">Active</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <span class="label">New Sellers</span>
                                    <div class="value" id="newSellers">{{ $newSellers ?? 0 }}</div>
                                    <small class="text-muted">Added in range</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <span class="label">Inactive Sellers</span>
                                    <div class="value" id="inactiveSellers">{{ $inactiveSellers ?? 0 }}</div>
                                    <small class="text-muted">No orders in range</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Chart/Card --}}
                <div class="settings-section card mb-4 position-relative">
                    <div class="card-body chart-card" style="min-height:520px; position:relative;">

                        <div class="settings-section-header">
                            <div>
                                <h4 class="settings-section-title">Top Sellers</h4>
                                <div class="settings-section-subtitle">Switch between Revenue and Orders views.</div>
                            </div>
                            <div class="section-actions"></div>
                        </div>

                        <div class="settings-section-divider"></div>

                        {{-- Chart controls --}}
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

                        {{-- Inline custom date picker --}}
                        <div id="customRangeInline" class="custom-range-box" style="display:none;">
                            <div class="row g-2 align-items-end">
                                <div class="col-6">
                                    <label class="form-label mb-1">From</label>
                                    <input type="date" id="fromDate" class="form-control form-control-sm">
                                </div>

                                <div class="col-6">
                                    <label class="form-label mb-1">To</label>
                                    <input type="date" id="toDate" class="form-control form-control-sm">
                                </div>

                                <div class="col-12 d-flex gap-2 mt-1">
                                    <button class="btn btn-primary btn-sm w-50" id="applyCustomRange">Apply</button>
                                    <button class="btn btn-outline-secondary btn-sm w-50"
                                        id="cancelCustomRange">Cancel</button>
                                </div>
                            </div>
                        </div>

                        {{-- Chart wrapper --}}
                        <div id="chartWrapper" class="chart-wrap" style="height:360px;">
                            <canvas id="sellersRevenueChart" style="display:block; height:100%;"></canvas>
                            <canvas id="sellersOrdersChart" style="display:none; height:100%;"></canvas>
                        </div>

                        {{-- Chart tab toggles moved to bottom-left, and given period-btns class --}}
                        <div class="chart-tabs-bottom period-btns" id="chartTabsBottom" role="toolbar"
                            aria-label="Chart view toggles">
                            <button class="btn btn-sm btn-primary chart-tab active period-btns"
                                data-tab="revenue">Revenue</button>
                            <button class="btn btn-sm btn-outline-secondary chart-tab period-btns"
                                data-tab="orders">Orders</button>
                        </div>

                        {{-- loader / no-results --}}
                        <div class="settings-loading" id="chartLoader" aria-hidden="true">
                            <div class="spinner"></div>
                        </div>

                        <div class="no-results" id="chartNoResults" style="display:none;">
                            <div class="no-results-title">No data</div>
                            <div class="no-results-hint">No seller transactions found for the selected period.</div>
                            <div class="no-results-suggestions">
                                <div class="no-results-chip" data-period="24hr">Last 24 Hrs</div>
                                <div class="no-results-chip" data-period="week">Last Week</div>
                                <div class="no-results-chip" data-period="month">Last Month</div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Top sellers table --}}
                <div class="settings-section card mb-4">
                    <div class="card-body">
                        <div class="settings-section-header">
                            <div>
                                <h5 class="settings-section-title">Top Sellers</h5>
                                <div class="settings-section-subtitle">Top sellers for the chosen range.</div>
                            </div>
                        </div>

                        <div class="settings-section-divider"></div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="topSellersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Seller</th>
                                        <th>Orders</th>
                                        <th>Revenue</th>
                                        <th>Commission</th>
                                        <th>Net Payout</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Toast --}}
                <div class="settings-toast" id="settingsToast" role="status" aria-live="polite"></div>

            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">
        <style>
            /* tiny nudge for export alignment */
            .chart-controls>.dropdown {
                transform: translateY(-2px);
            }

            /* bottom tab placement */
            .chart-tabs-bottom {
                position: absolute;
                left: 16px;
                bottom: 14px;
                display: flex;
                gap: 6px;
                z-index: 20;
            }

            /* loader overlay centered */
            .settings-loading {
                display: none;
                position: absolute;
                inset: 0;
                background: rgba(255, 255, 255, 0.6);
                align-items: center;
                justify-content: center;
                z-index: 30;
            }

            .settings-loading.is-visible {
                display: flex;
            }

            .settings-loading .spinner {
                width: 44px;
                height: 44px;
                border: 4px solid #e9ecef;
                border-top-color: #0d6efd;
                border-radius: 50%;
                animation: spin 0.9s linear infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            /* ensure period-btns look consistent when applied to select */
            select.period-btns {
                padding-top: .28rem;
                padding-bottom: .28rem;
            }

            .chart-tab.period-btns {
                padding-left: .6rem;
                padding-right: .6rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
        {{-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                /* ------------------------------
                   Cached DOM + helpers
                -------------------------------*/
                const root = document.querySelector('.settings-right-inner');
                const $ = s => root.querySelector(s);
                const qa = s => Array.from(root.querySelectorAll(s));

                // elements
                const loader = $('#chartLoader');
                const noResults = $('#chartNoResults');
                const toast = $('#settingsToast');
                const revenueCanvas = $('#sellersRevenueChart');
                const ordersCanvas = $('#sellersOrdersChart');
                const topSellersTbody = $('#topSellersTable tbody');
                const periodButtons = $('#periodButtons');
                const customToggle = $('#chartCustomToggle');
                const customBox = $('#customRangeInline');
                const fromDateEl = $('#fromDate');
                const toDateEl = $('#toDate');
                const applyCustom = $('#applyCustomRange');
                const cancelCustom = $('#cancelCustomRange');
                const topNSelect = $('#topNSelect');
                const chartTabs = qa('.chart-tab');

                // state
                let revenueChart = null,
                    ordersChart = null;
                let activeTab = 'revenue';
                let activePeriod = 'lifetime';
                let controller = null;

                // formatters
                const fmtCurrency = v => '₹' + (Number(v) || 0).toLocaleString('en-IN', {
                    maximumFractionDigits: 2
                });
                const fmtNumber = v => (Number(v) || 0).toLocaleString('en-IN');

                const showToast = (msg, type = 'success') => {
                    if (!toast) return;
                    toast.textContent = msg;
                    toast.className = 'settings-toast ' + (type === 'error' ? 'error' : 'success');
                    toast.style.display = 'block';
                    setTimeout(() => toast.style.display = 'none', 2600);
                };

                const showLoader = visible => {
                    if (!loader) return;
                    loader.classList.toggle('is-visible', !!visible);
                    loader.setAttribute('aria-hidden', visible ? 'false' : 'true');
                };

                const cancelOngoing = () => {
                    if (controller) {
                        try {
                            controller.abort();
                        } catch (e) {}
                        controller = null;
                    }
                };

                /* ------------------------------
                   Chart creation / update - DRY
                -------------------------------*/
                function createGradient(ctx, fromColor, toColor) {
                    const g = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height || 300);
                    g.addColorStop(0, fromColor);
                    g.addColorStop(1, toColor);
                    return g;
                }

                function upsertChart(instanceRef, canvas, opts = {}) {
                    // opts: { type, label, labels, data, background, tooltipFormatter, yTickFormatter }
                    if (!canvas) return null;
                    const ctx = canvas.getContext('2d');
                    const labels = Array.isArray(opts.labels) ? opts.labels : [];
                    const dataArr = Array.isArray(opts.data) ? opts.data.map(v => Number(v) || 0) : [];

                    // create dataset config (background may be a function or a color string)
                    const dataset = {
                        label: opts.label || '',
                        data: dataArr,
                        borderRadius: 6,
                        backgroundColor: typeof opts.background === 'function' ? opts.background({
                            chart: {
                                ctx,
                                canvas
                            }
                        }) : (opts.background || 'rgba(0,0,0,0.1)'),
                    };

                    if (!instanceRef.instance) {
                        const cfg = {
                            type: opts.type || 'bar',
                            data: {
                                labels,
                                datasets: [dataset]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: ctx => (opts.tooltipFormatter ? opts.tooltipFormatter(ctx) :
                                                String(ctx.raw ?? ctx.parsed?.y))
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: {
                                            autoSkip: false
                                        },
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: v => (opts.yTickFormatter ? opts.yTickFormatter(v) : v)
                                        }
                                    }
                                }
                            }
                        };
                        instanceRef.instance = new Chart(ctx, cfg);
                    } else {
                        // update in-place
                        try {
                            instanceRef.instance.data.labels = labels;
                            instanceRef.instance.data.datasets[0].data = dataArr;
                            instanceRef.instance.update();
                            instanceRef.instance.resize();
                        } catch (e) {
                            // fallback: destroy and recreate
                            try {
                                instanceRef.instance.destroy();
                            } catch (e) {}
                            instanceRef.instance = null;
                            return upsertChart(instanceRef, canvas, opts);
                        }
                    }
                    return instanceRef.instance;
                }

                /* ------------------------------
                   Render helpers
                -------------------------------*/
                function renderTopSellers(list = []) {
                    if (!topSellersTbody) return;
                    topSellersTbody.innerHTML = '';
                    if (!Array.isArray(list) || list.length === 0) {
                        topSellersTbody.innerHTML =
                            '<tr><td colspan="6" class="text-center text-muted">No sellers</td></tr>';
                        return;
                    }
                    const frag = document.createDocumentFragment();
                    list.forEach((s, i) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `<td>${i+1}</td>
                            <td>${escapeHtml(s.name)}<div class="text-muted small">${escapeHtml(s.email)}</div></td>
                            <td>${fmtNumber(s.orders)}</td>
                            <td>${fmtCurrency(s.revenue)}</td>
                            <td>${fmtCurrency(s.commission)}</td>
                            <td>${fmtCurrency(s.net_payout)}</td>`;
                        frag.appendChild(tr);
                    });
                    topSellersTbody.appendChild(frag);
                }

                function escapeHtml(s) {
                    return String(s || '').replace(/[&<>"']/g, m => ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#39;'
                    })[m]);
                }

                /* ------------------------------
                   Fetch and update flow
                -------------------------------*/
                async function fetchSellerData(period = 'lifetime', from = null, to = null, limit = 10) {
                    cancelOngoing();
                    controller = new AbortController();
                    activePeriod = period;
                    setActiveFilterUI(period);

                    // show loader while fetching + chart redraw
                    showLoader(true);
                    if (noResults) noResults.style.display = 'none';

                    const params = new URLSearchParams({
                        period,
                        limit
                    });
                    if (period === 'custom') {
                        if (from) params.set('from', from);
                        if (to) params.set('to', to);
                    }
                    const url = "{{ route('admin.reports.sellers.data') }}?" + params.toString();

                    try {
                        const res = await fetch(url, {
                            signal: controller.signal
                        });
                        if (!res.ok) throw new Error('Network ' + res.status);
                        const payload = await res.json();

                        // coerce arrays and numbers
                        const labels = Array.isArray(payload.labels) ? payload.labels : [];
                        const revenue = (Array.isArray(payload.revenue) ? payload.revenue : []).map(v => Number(
                            v) || 0);
                        const orders = (Array.isArray(payload.orders) ? payload.orders : []).map(v => Number(v) ||
                            0);

                        // KPIs
                        const totalRevenue = payload.totalRevenue ?? 0;
                        const totalRevEl = document.getElementById('totalRevenue');
                        if (totalRevEl) totalRevEl.textContent = fmtCurrency(totalRevenue);

                        // if no labels or all-zero, show no-results
                        const allZero = arr => Array.isArray(arr) && arr.length > 0 && arr.every(v => Number(v) ===
                            0);
                        if (labels.length === 0 || (allZero(revenue) && allZero(orders))) {
                            // destroy charts to free memory
                            try {
                                if (revenueChart) revenueChart.instance?.destroy();
                            } catch (e) {}
                            try {
                                if (ordersChart) ordersChart.instance?.destroy();
                            } catch (e) {}
                            revenueChart = {
                                instance: null
                            };
                            ordersChart = {
                                instance: null
                            };
                            if (noResults) noResults.style.display = 'flex';
                        } else {
                            if (noResults) noResults.style.display = 'none';

                            // create gradient function for revenue background
                            const revenueBg = ({
                                chart
                            }) => {
                                const ctx = chart.ctx;
                                return createGradient(ctx, 'rgba(13,110,253,0.85)', 'rgba(13,110,253,0.45)');
                            };

                            // upsert revenue chart
                            upsertChart(
                                (revenueChart = revenueChart || {}),
                                revenueCanvas, {
                                    type: 'bar',
                                    label: 'Revenue',
                                    labels,
                                    data: revenue,
                                    background: revenueBg,
                                    tooltipFormatter: ctx => fmtCurrency(ctx.raw ?? ctx.parsed?.y),
                                    yTickFormatter: v => fmtNumber(v)
                                }
                            );

                            // upsert orders chart
                            upsertChart(
                                (ordersChart = ordersChart || {}),
                                ordersCanvas, {
                                    type: 'bar',
                                    label: 'Orders',
                                    labels,
                                    data: orders,
                                    background: 'rgba(75,192,192,0.8)',
                                    tooltipFormatter: ctx => (fmtNumber(ctx.raw ?? ctx.parsed?.y) + ' orders'),
                                    yTickFormatter: v => fmtNumber(v)
                                }
                            );
                        }

                        // populate table
                        renderTopSellers(payload.topSellers || []);

                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            console.error(err);
                            showToast('Failed to load seller data', 'error');
                        }
                    } finally {
                        // hide loader after charts are updated
                        showLoader(false);
                        controller = null;
                    }
                }

                /* ------------------------------
                   UI helpers / wiring
                -------------------------------*/
                function setActiveFilterUI(period) {
                    qa('.filter-btn').forEach(b => {
                        const is = b.dataset.period === period;
                        b.classList.toggle('btn-primary', is);
                        b.classList.toggle('btn-outline-primary', !is);
                        b.setAttribute('aria-pressed', is ? 'true' : 'false');
                    });
                }

                // period buttons (delegated)
                periodButtons && periodButtons.addEventListener('click', e => {
                    const btn = e.target.closest('.filter-btn');
                    if (!btn) return;
                    customBox.style.display = 'none';
                    const limit = Number(topNSelect.value) || 10;
                    fetchSellerData(btn.dataset.period, null, null, limit);
                });

                // keyboard accessibility for filter buttons
                qa('.filter-btn').forEach(btn => btn.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        btn.click();
                    }
                }));

                // custom toggle
                customToggle && customToggle.addEventListener('click', () => {
                    const open = customBox.style.display === 'block';
                    customBox.style.display = open ? 'none' : 'block';
                    customToggle.setAttribute('aria-expanded', (!open).toString());
                });

                cancelCustom && cancelCustom.addEventListener('click', () => {
                    customBox.style.display = 'none';
                    customToggle.setAttribute('aria-expanded', 'false');
                });

                applyCustom && applyCustom.addEventListener('click', () => {
                    const from = fromDateEl.value,
                        to = toDateEl.value;
                    if (!from || !to) {
                        showToast('Please select both dates', 'error');
                        return;
                    }
                    customBox.style.display = 'none';
                    fetchSellerData('custom', from, to, Number(topNSelect.value) || 10);
                });

                // topN change
                topNSelect && topNSelect.addEventListener('change', () => {
                    fetchSellerData(activePeriod, fromDateEl.value || null, toDateEl.value || null, Number(
                        topNSelect.value) || 10);
                });

                // chart tabs (bottom-left)
                chartTabs.forEach(tab => tab.addEventListener('click', () => {
                    chartTabs.forEach(t => t.classList.remove('btn-primary'));
                    chartTabs.forEach(t => t.classList.add('btn-outline-secondary'));
                    tab.classList.remove('btn-outline-secondary');
                    tab.classList.add('btn-primary');

                    const tname = tab.dataset.tab;
                    activeTab = tname;
                    if (tname === 'revenue') {
                        revenueCanvas.style.display = 'block';
                        ordersCanvas.style.display = 'none';
                        try {
                            revenueChart?.instance?.resize?.();
                        } catch (e) {}
                    } else {
                        revenueCanvas.style.display = 'none';
                        ordersCanvas.style.display = 'block';
                        try {
                            ordersChart?.instance?.resize?.();
                        } catch (e) {}
                    }
                }));

                // no-results chips quick filters
                qa('.no-results-chip').forEach(chip => chip.addEventListener('click', () => {
                    fetchSellerData(chip.dataset.period, null, null, Number(topNSelect.value) || 10);
                }));

                // export handlers
                document.addEventListener('click', e => {
                    const a = e.target.closest('[data-action]');
                    if (!a) return;
                    e.preventDefault();
                    const act = a.getAttribute('data-action');
                    if (act === 'csv') exportCSV();
                    else if (act === 'png') exportPNG();
                    else if (act === 'print') printChart();
                });

                function exportCSV() {
                    const chart = (activeTab === 'revenue' ? revenueChart?.instance : ordersChart?.instance);
                    if (!chart) {
                        showToast('No chart to export', 'error');
                        return;
                    }
                    const labels = chart.data.labels || [],
                        vals = chart.data.datasets[0]?.data || [];
                    let csv = 'label,value\r\n';
                    for (let i = 0; i < labels.length; i++) csv += `"${labels[i]}",${vals[i] ?? 0}\r\n`;
                    const blob = new Blob([csv], {
                        type: 'text/csv;charset=utf-8;'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `sellers-${activeTab}-${Date.now()}.csv`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    URL.revokeObjectURL(url);
                }

                function exportPNG() {
                    const chart = (activeTab === 'revenue' ? revenueChart?.instance : ordersChart?.instance);
                    if (!chart) {
                        showToast('No chart to export', 'error');
                        return;
                    }
                    const url = chart.toBase64Image();
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `sellers-${activeTab}.png`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                }

                function printChart() {
                    const chart = (activeTab === 'revenue' ? revenueChart?.instance : ordersChart?.instance);
                    if (!chart) {
                        window.print();
                        return;
                    }
                    const url = chart.toBase64Image();
                    const w = window.open('', '_blank');
                    w.document.write(`<img src="${url}" style="max-width:100%;">`);
                    w.document.close();
                    w.focus();
                    w.print();
                }

                /* ------------------------------
                   Initial load
                -------------------------------*/
                // initial minimal state to prevent flash
                revenueChart = {
                    instance: null
                };
                ordersChart = {
                    instance: null
                };
                fetchSellerData('lifetime', null, null, Number(topNSelect.value) || 10);
            });
        </script> --}}

        {{-- Optimized version --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // ---------- cached DOM & helpers ----------
                const root = document.querySelector('.settings-right-inner');
                const $ = sel => root.querySelector(sel);
                const $$ = sel => Array.from(root.querySelectorAll(sel));

                const loader = $('#chartLoader');
                const noResults = $('#chartNoResults');
                const toast = $('#settingsToast');
                const revenueCanvas = $('#sellersRevenueChart');
                const ordersCanvas = $('#sellersOrdersChart');
                const topSellersTbody = $('#topSellersTable tbody');
                const periodButtons = $('#periodButtons');
                const customToggle = $('#chartCustomToggle');
                const customBox = $('#customRangeInline');
                const fromDateEl = $('#fromDate');
                const toDateEl = $('#toDate');
                const applyCustom = $('#applyCustomRange');
                const cancelCustom = $('#cancelCustomRange');
                const topNSelect = $('#topNSelect');
                const chartTabs = $$('.chart-tab');
                const noResultsChips = $$('.no-results-chip');
                const filterBtns = $$('.filter-btn');

                // state
                let revenueChart = {
                        instance: null
                    },
                    ordersChart = {
                        instance: null
                    };
                let activeTab = 'revenue',
                    activePeriod = 'lifetime';
                let controller = null;

                // formatters (create once)
                const nfNumber = new Intl.NumberFormat('en-IN');
                const nfCurrency = new Intl.NumberFormat('en-IN', {
                    maximumFractionDigits: 2
                });
                const fmtNumber = v => nfNumber.format(Number(v) || 0);
                const fmtCurrency = v => '₹' + nfCurrency.format(Number(v) || 0);

                // utility
                const rAF = cb => requestAnimationFrame(cb);
                const safe = fn => {
                    try {
                        return fn();
                    } catch (e) {
                        return null;
                    }
                };

                const showToast = (msg, type = 'success') => {
                    if (!toast) return;
                    toast.textContent = msg;
                    toast.className = 'settings-toast ' + (type === 'error' ? 'error' : 'success');
                    toast.style.display = 'block';
                    setTimeout(() => {
                        toast.style.display = 'none';
                    }, 2600);
                };

                const showLoader = visible => {
                    if (!loader) return;
                    // toggle class + aria in one DOM update
                    loader.classList.toggle('is-visible', !!visible);
                    loader.setAttribute('aria-hidden', visible ? 'false' : 'true');
                };

                const cancelOngoing = () => {
                    if (controller) {
                        try {
                            controller.abort();
                        } catch (e) {}
                        controller = null;
                    }
                };

                function createGradient(ctx, fromColor, toColor) {
                    const g = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height || 300);
                    g.addColorStop(0, fromColor);
                    g.addColorStop(1, toColor);
                    return g;
                }

                // upsertChart: reuse Chart instance or recreate only if necessary
                function upsertChart(ref, canvas, opts = {}) {
                    if (!canvas) return null;
                    const ctx = canvas.getContext('2d');
                    const labels = Array.isArray(opts.labels) ? opts.labels : [];
                    const dataArr = Array.isArray(opts.data) ? opts.data.map(v => Number(v) || 0) : [];

                    const bg = typeof opts.background === 'function' ?
                        opts.background({
                            chart: {
                                ctx,
                                canvas
                            }
                        }) :
                        (opts.background || 'rgba(0,0,0,0.1)');

                    const dataset = {
                        label: opts.label || '',
                        data: dataArr,
                        borderRadius: 6,
                        backgroundColor: bg
                    };

                    if (!ref.instance) {
                        const cfg = {
                            type: opts.type || 'bar',
                            data: {
                                labels,
                                datasets: [dataset]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: ctx => (opts.tooltipFormatter ? opts.tooltipFormatter(ctx) :
                                                String(ctx.raw ?? ctx.parsed?.y))
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: {
                                            autoSkip: false
                                        },
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: v => (opts.yTickFormatter ? opts.yTickFormatter(v) : v)
                                        }
                                    }
                                }
                            }
                        };
                        ref.instance = new Chart(ctx, cfg);
                    } else {
                        try {
                            const inst = ref.instance;
                            inst.data.labels = labels;
                            inst.data.datasets[0].data = dataArr;
                            inst.update();
                            inst.resize();
                        } catch (e) {
                            // destroy & recreate if update failed
                            try {
                                ref.instance.destroy();
                            } catch (er) {}
                            ref.instance = null;
                            return upsertChart(ref, canvas, opts);
                        }
                    }
                    return ref.instance;
                }

                // renderTopSellers: build fragment then append once
                function escapeHtml(s) {
                    return String(s || '').replace(/[&<>"']/g, m => ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#39;'
                    } [m]));
                }

                function renderTopSellers(list = []) {
                    if (!topSellersTbody) return;
                    // build innerHTML string (faster than many element ops for table rows)
                    if (!Array.isArray(list) || list.length === 0) {
                        topSellersTbody.innerHTML =
                            '<tr><td colspan="6" class="text-center text-muted">No sellers</td></tr>';
                        return;
                    }
                    let html = '';
                    for (let i = 0; i < list.length; i++) {
                        const s = list[i];
                        html += `<tr>
                <td>${i + 1}</td>
                <td>${escapeHtml(s.name)}<div class="text-muted small">${escapeHtml(s.email)}</div></td>
                <td>${fmtNumber(s.orders)}</td>
                <td>${fmtCurrency(s.revenue)}</td>
                <td>${fmtCurrency(s.commission)}</td>
                <td>${fmtCurrency(s.net_payout)}</td>
            </tr>`;
                    }
                    topSellersTbody.innerHTML = html;
                }

                // UI helper to sync filter button visuals (very cheap)
                function setActiveFilterUI(period) {
                    activePeriod = period || 'lifetime';
                    for (let i = 0; i < filterBtns.length; i++) {
                        const b = filterBtns[i];
                        const is = b.dataset.period === activePeriod;
                        b.classList.toggle('btn-primary', is);
                        b.classList.toggle('btn-outline-primary', !is);
                        b.setAttribute('aria-pressed', is ? 'true' : 'false');
                    }
                    if (customToggle) {
                        const active = activePeriod === 'custom';
                        customToggle.classList.toggle('btn-primary', active);
                        customToggle.classList.toggle('btn-dark', !active);
                        customToggle.setAttribute('aria-pressed', active ? 'true' : 'false');
                    }
                }

                // fetcher
                async function fetchSellerData(period = 'lifetime', from = null, to = null, limit = 10) {
                    cancelOngoing();
                    controller = new AbortController();

                    setActiveFilterUI(period);
                    showLoader(true);
                    if (noResults) noResults.style.display = 'none';

                    const params = new URLSearchParams({
                        period,
                        limit
                    });
                    if (period === 'custom') {
                        if (from) params.set('from', from);
                        if (to) params.set('to', to);
                    }
                    const url = "{{ route('admin.reports.sellers.data') }}?" + params.toString();

                    try {
                        const res = await fetch(url, {
                            signal: controller.signal
                        });
                        if (!res.ok) throw new Error('Network ' + res.status);
                        const payload = await res.json();

                        const labels = Array.isArray(payload.labels) ? payload.labels : [];
                        const revenue = Array.isArray(payload.revenue) ? payload.revenue.map(v => Number(v) || 0) :
                            [];
                        const orders = Array.isArray(payload.orders) ? payload.orders.map(v => Number(v) || 0) : [];

                        // KPIs - update only if present
                        const totalRevEl = document.getElementById('totalRevenue');
                        if (totalRevEl && payload.totalRevenue != null) totalRevEl.textContent = fmtCurrency(payload
                            .totalRevenue);

                        const isAllZero = arr => Array.isArray(arr) && arr.length > 0 && arr.every(v => Number(
                            v) === 0);
                        if (labels.length === 0 || (isAllZero(revenue) && isAllZero(orders))) {
                            // destroy charts if exist
                            safe(() => revenueChart.instance?.destroy());
                            safe(() => ordersChart.instance?.destroy());
                            revenueChart.instance = null;
                            ordersChart.instance = null;
                            if (noResults) noResults.style.display = 'flex';
                        } else {
                            if (noResults) noResults.style.display = 'none';

                            const revenueBg = ({
                                chart
                            }) => createGradient(chart.ctx, 'rgba(13,110,253,0.85)', 'rgba(13,110,253,0.45)');

                            upsertChart(revenueChart, revenueCanvas, {
                                type: 'bar',
                                label: 'Revenue',
                                labels,
                                data: revenue,
                                background: revenueBg,
                                tooltipFormatter: ctx => fmtCurrency(ctx.raw ?? ctx.parsed?.y),
                                yTickFormatter: v => fmtNumber(v)
                            });

                            upsertChart(ordersChart, ordersCanvas, {
                                type: 'bar',
                                label: 'Orders',
                                labels,
                                data: orders,
                                background: 'rgba(75,192,192,0.8)',
                                tooltipFormatter: ctx => (fmtNumber(ctx.raw ?? ctx.parsed?.y) + ' orders'),
                                yTickFormatter: v => fmtNumber(v)
                            });
                        }

                        renderTopSellers(payload.topSellers || []);
                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            console.error(err);
                            showToast('Failed to load seller data', 'error');
                        }
                    } finally {
                        showLoader(false);
                        controller = null;
                    }
                }

                // ------- consolidated handlers (delegation where possible) -------
                // Period buttons (delegation)
                if (periodButtons) {
                    periodButtons.addEventListener('click', e => {
                        const btn = e.target.closest('.filter-btn');
                        if (!btn) return;
                        customBox.style.display = 'none';
                        const limit = Number(topNSelect.value) || 10;
                        fetchSellerData(btn.dataset.period, null, null, limit);
                    });
                }

                // keyboard accessibility
                for (let i = 0; i < filterBtns.length; i++) {
                    const btn = filterBtns[i];
                    btn.addEventListener('keydown', e => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            btn.click();
                        }
                    });
                }

                // custom toggle
                if (customToggle) {
                    customToggle.addEventListener('click', () => {
                        const open = customBox.style.display === 'block';
                        customBox.style.display = open ? 'none' : 'block';
                        customToggle.setAttribute('aria-expanded', (!open).toString());
                        if (!open) setActiveFilterUI('custom');
                    });
                }
                if (cancelCustom) cancelCustom.addEventListener('click', () => {
                    customBox.style.display = 'none';
                    customToggle.setAttribute('aria-expanded', 'false');
                });
                if (applyCustom) applyCustom.addEventListener('click', () => {
                    const from = fromDateEl.value,
                        to = toDateEl.value;
                    if (!from || !to) {
                        showToast('Please select both dates', 'error');
                        return;
                    }
                    customBox.style.display = 'none';
                    fetchSellerData('custom', from, to, Number(topNSelect.value) || 10);
                });

                // topN change
                if (topNSelect) {
                    topNSelect.addEventListener('change', () => {
                        fetchSellerData(activePeriod, fromDateEl.value || null, toDateEl.value || null, Number(
                            topNSelect.value) || 10);
                    });
                }

                // chart tabs (bottom-left)
                if (chartTabs.length) {
                    chartTabs.forEach(tab => tab.addEventListener('click', () => {
                        // swap classes once
                        for (let i = 0; i < chartTabs.length; i++) {
                            chartTabs[i].classList.remove('btn-primary');
                            chartTabs[i].classList.add('btn-outline-secondary');
                        }
                        tab.classList.remove('btn-outline-secondary');
                        tab.classList.add('btn-primary');

                        const tname = tab.dataset.tab;
                        activeTab = tname;
                        if (tname === 'revenue') {
                            revenueCanvas.style.display = 'block';
                            ordersCanvas.style.display = 'none';
                            safe(() => revenueChart.instance?.resize?.());
                        } else {
                            revenueCanvas.style.display = 'none';
                            ordersCanvas.style.display = 'block';
                            safe(() => ordersChart.instance?.resize?.());
                        }
                    }));
                }

                // no-results chips
                for (let i = 0; i < noResultsChips.length; i++) {
                    const chip = noResultsChips[i];
                    chip.addEventListener('click', () => {
                        fetchSellerData(chip.dataset.period, null, null, Number(topNSelect.value) || 10);
                    });
                }

                // export/print delegation (single handler)
                document.addEventListener('click', e => {
                    const a = e.target.closest('[data-action]');
                    if (!a) return;
                    e.preventDefault();
                    const action = a.dataset.action;
                    const chart = (activeTab === 'revenue' ? revenueChart.instance : ordersChart.instance);
                    if (!chart) {
                        showToast('No chart to export', 'error');
                        return;
                    }

                    if (action === 'csv') {
                        const labels = chart.data.labels || [],
                            vals = chart.data.datasets[0]?.data || [];
                        let csv = 'label,value\r\n';
                        for (let i = 0; i < labels.length; i++) csv += `"${labels[i]}",${vals[i] ?? 0}\r\n`;
                        const blob = new Blob([csv], {
                            type: 'text/csv;charset=utf-8;'
                        });
                        const url = URL.createObjectURL(blob);
                        const aEl = document.createElement('a');
                        aEl.href = url;
                        aEl.download = `sellers-${activeTab}-${Date.now()}.csv`;
                        document.body.appendChild(aEl);
                        aEl.click();
                        aEl.remove();
                        URL.revokeObjectURL(url);
                    } else if (action === 'png') {
                        const url = chart.toBase64Image();
                        const aEl = document.createElement('a');
                        aEl.href = url;
                        aEl.download = `sellers-${activeTab}.png`;
                        document.body.appendChild(aEl);
                        aEl.click();
                        aEl.remove();
                    } else if (action === 'print') {
                        const url = chart.toBase64Image();
                        const w = window.open('', '_blank');
                        w.document.write(`<img src="${url}" style="max-width:100%;">`);
                        w.document.close();
                        w.focus();
                        w.print();
                    }
                });

                // initial
                (function init() {
                    setActiveFilterUI('lifetime');
                    fetchSellerData('lifetime', null, null, Number(topNSelect.value) || 10);
                })();
            });
        </script>
    @endpush

@endsection
