@extends('admin.layouts.admin')

@section('title', 'Sales Report')

@section('content')
    <div class="container-fluid py-0 settings-wrapper">

        <div class="settings-right">
            <div class="settings-right-inner">

                {{-- Header (title only) --}}
                <div class="settings-section card mb-4">
                    <div class="card-body">
                        <div class="settings-section-header">
                            <div>
                                <h3 class="settings-section-title">Sales Report</h3>
                                <div class="settings-section-subtitle">Overview of sales, trends and top products — use the
                                    chart controls to adjust range and exports.</div>
                            </div>
                        </div>

                        <div class="view-grid">
                            <div class="view-row">
                                <div>
                                    <span class="label">Total Sales</span>
                                    <div class="value" id="totalSales">₹0</div>
                                    <small class="text-muted">Amount</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <span class="label">Refunds</span>
                                    <div class="value" id="refundsTotal">₹0</div>
                                    <small class="text-muted">Refunded amount</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <span class="label">Orders</span>
                                    <div class="value" id="ordersCount">0</div>
                                    <small class="text-muted">Total orders</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <span class="label">Range</span>
                                    <div class="value" id="rangeLabel">—</div>
                                    <small class="text-muted">From → To</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart Card: controls & export are inside chart-controls (top-right) --}}
                <div class="settings-section card mb-4 position-relative">
                    <div class="card-body chart-card" style="min-height:660px; position:relative;">

                        <div class="settings-section-header">
                            <div>
                                <h4 class="settings-section-title">Sales Trend</h4>
                                <div class="settings-section-subtitle">Interactive sales trend — hover to see precise
                                    values.</div>
                            </div>
                            <div class="section-actions"></div>
                        </div>

                        <div class="settings-section-divider"></div>

                        {{-- Chart controls (compact, top-right) --}}
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

                            {{-- EXPORT DROPDOWN (only export + nothing else) --}}
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

                        {{-- Inline custom date picker (appears near controls) --}}
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

                        {{-- Chart canvas (increased height) --}}
                        <div id="chartWrapper" class="chart-wrap" style="height:400px;">
                            <canvas id="salesChart" aria-label="Sales chart" role="img"></canvas>
                        </div>

                        {{-- loader / no-results --}}
                        <div class="settings-loading" id="chartLoader" aria-hidden="true">
                            <div class="spinner"></div>
                        </div>

                        <div class="no-results" id="chartNoResults" style="display:none;">
                            <div class="no-results-title">No sales data</div>
                            <div class="no-results-hint">No transactions found for the selected period.</div>
                            <div class="no-results-suggestions">
                                <div class="no-results-chip" data-period="24hr">Last 24 Hrs</div>
                                <div class="no-results-chip" data-period="week">Last Week</div>
                                <div class="no-results-chip" data-period="month">Last Month</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order status + Top products --}}
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="settings-section card">
                            <div class="card-body">
                                <div class="settings-section-header">
                                    <div>
                                        <h5 class="settings-section-title">Order Status</h5>
                                        <div class="settings-section-subtitle">Counts by status</div>
                                    </div>
                                </div>

                                <div class="settings-section-divider"></div>

                                <div id="statusList" class="view-grid"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="settings-section card">
                            <div class="card-body">
                                <div class="settings-section-header">
                                    <div>
                                        <h5 class="settings-section-title">Top Products</h5>
                                        <div class="settings-section-subtitle">Top 10 products by quantity</div>
                                    </div>
                                </div>

                                <div class="settings-section-divider"></div>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="topProductsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                            </div>
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
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
        <script src="{{ asset('js/report-charts.js') }}"></script>

        <script>
            // Sales page init
            const salesWidget = initReportWidget({
                containerSelector: '.settings-right-inner', // root scope (optional)
                dataRoute: "{{ route('admin.reports.sales.data') }}",
                canvasSelector: '#salesChart',
                datasetLabel: 'Sales',
                kpiMap: {
                    total: 'totalSales',
                    refunds: 'refundsTotal',
                    count: 'ordersCount'
                },
                csvPrefix: 'sales'
            });
        </script>
    @endpush

    {{-- @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // DOM helpers
                const $ = id => document.getElementById(id);
                const qa = sel => Array.from(document.querySelectorAll(sel));

                // elements
                const totalSalesEl = $('totalSales'),
                    refundsEl = $('refundsTotal'),
                    ordersCountEl = $('ordersCount');
                const rangeLabelEl = $('rangeLabel'),
                    statusListEl = $('statusList'),
                    topProductsTbody = document.querySelector('#topProductsTable tbody');
                const loader = $('chartLoader'),
                    noResults = $('chartNoResults'),
                    toastEl = $('settingsToast');
                const periodButtonsContainer = $('periodButtons');
                const chartCustomToggle = $('chartCustomToggle'),
                    customRangeInline = $('customRangeInline');
                const fromDateEl = $('fromDate'),
                    toDateEl = $('toDate'),
                    applyCustomRangeBtn = $('applyCustomRange'),
                    cancelCustomRangeBtn = $('cancelCustomRange');
                const salesCanvas = $('salesChart');

                // state
                let salesChartInstance = null;
                let activePeriod = 'lifetime';
                let controller = null;

                // helpers
                const fmtCurrency = v => '₹' + (Number(v) || 0).toLocaleString('en-IN', {
                    maximumFractionDigits: 2
                });
                const fmtNumber = v => (Number(v) || 0).toLocaleString('en-IN');
                const cap = s => s ? s.charAt(0).toUpperCase() + s.slice(1) : s;
                const escapeHtml = s => String(s || '').replace(/[&<>"']/g, m => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                } [m]));

                const showToast = (msg, type = 'success') => {
                    toastEl.textContent = msg;
                    toastEl.className = 'settings-toast ' + (type === 'error' ? 'error' : (type === 'success' ?
                        'success' : ''));
                    toastEl.style.display = 'block';
                    setTimeout(() => toastEl.style.display = 'none', 2600);
                };

                const showLoader = v => {
                    loader.classList.toggle('is-visible', !!v);
                    loader.style.display = v ? 'block' : 'none';
                    loader.setAttribute('aria-hidden', v ? 'false' : 'true');
                };

                const cancelOngoing = () => {
                    if (controller) {
                        try {
                            controller.abort();
                        } catch (e) {}
                        controller = null;
                    }
                };

                // fetch data
                async function fetchSalesData(period, from = null, to = null) {
                    cancelOngoing();
                    controller = new AbortController();
                    const signal = controller.signal;

                    activePeriod = period;
                    setActiveFilterUI(period);
                    if (period === 'custom' && from && to) rangeLabelEl.textContent = `${from} → ${to}`;

                    // build URL (only period/from/to)
                    const params = new URLSearchParams({
                        period
                    });
                    if (period === 'custom') {
                        params.set('from', from);
                        params.set('to', to);
                    }
                    const url = "{{ route('admin.reports.sales.data') }}?" + params.toString();

                    showLoader(true);
                    noResults.style.display = 'none';

                    try {
                        const res = await fetch(url, {
                            signal
                        });
                        if (!res.ok) throw new Error('Network error ' + res.status);
                        const data = await res.json();

                        if (!Array.isArray(data.labels) || !Array.isArray(data.data)) throw new Error(
                            'Invalid data');

                        // KPIs
                        totalSalesEl.textContent = fmtCurrency(data.totalSales);
                        refundsEl.textContent = fmtCurrency(data.refunds ?? 0);
                        const orderStatusCounts = data.orderStatus || {};
                        const ordersSum = Object.values(orderStatusCounts).reduce((s, n) => s + Number(n || 0), 0);
                        ordersCountEl.textContent = fmtNumber(ordersSum);
                        rangeLabelEl.textContent = (data.from && data.to) ? `${data.from} → ${data.to}` :
                            rangeLabelEl.textContent;

                        // lists
                        renderStatusList(orderStatusCounts);
                        renderTopProducts(data.topProducts || []);

                        // chart (animated update)
                        if (data.labels.length === 0 || data.data.every(v => Number(v) === 0)) {
                            destroyChart();
                            noResults.style.display = 'flex';
                        } else {
                            noResults.style.display = 'none';
                            updateOrCreateChart(data.labels, data.data);
                        }
                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            console.error(err);
                            showToast('Failed to load sales data', 'error');
                        }
                    } finally {
                        showLoader(false);
                        controller = null;
                    }
                }

                // chart lifecycle
                function destroyChart() {
                    if (salesChartInstance) {
                        try {
                            salesChartInstance.destroy();
                        } catch (e) {}
                        salesChartInstance = null;
                    }
                }

                function updateOrCreateChart(labels, values) {
                    if (!salesChartInstance) {
                        const ctx = salesCanvas.getContext('2d');
                        salesChartInstance = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels,
                                datasets: [{
                                    label: 'Sales',
                                    data: values,
                                    borderWidth: 2,
                                    borderColor: 'rgba(13,110,253,1)',
                                    backgroundColor: ctx => {
                                        const c = ctx.chart.ctx;
                                        const g = c.createLinearGradient(0, 0, 0, ctx.chart.height);
                                        g.addColorStop(0, 'rgba(13,110,253,0.18)');
                                        g.addColorStop(1, 'rgba(13,110,253,0.02)');
                                        return g;
                                    },
                                    pointRadius: 3,
                                    pointHoverRadius: 6,
                                    tension: 0.28,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                animation: {
                                    duration: 600,
                                    easing: 'easeOutQuart'
                                },
                                interaction: {
                                    mode: 'index',
                                    intersect: false
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: ctx => {
                                                const v = ctx.raw ?? ctx.parsed?.y;
                                                return 'Sales: ' + fmtCurrency(v);
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            maxRotation: 0,
                                            autoSkip: true,
                                            maxTicksLimit: 12
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: v => fmtNumber(v)
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        salesChartInstance.data.labels = labels;
                        salesChartInstance.data.datasets[0].data = values;
                        salesChartInstance.update({
                            duration: 600,
                            easing: 'easeOutQuart'
                        });
                    }
                }

                // render helpers
                function renderStatusList(obj) {
                    statusListEl.innerHTML = '';
                    const entries = Object.entries(obj || {});
                    if (!entries.length) {
                        statusListEl.innerHTML = '<div class="no-results-hint">No orders in this range</div>';
                        return;
                    }
                    const total = entries.reduce((s, [, c]) => s + Number(c || 0), 0);
                    entries.forEach(([status, count]) => {
                        const div = document.createElement('div');
                        div.className = 'view-row';
                        div.innerHTML =
                            `<div><span class="label">${escapeHtml(String(status).replace('_',' ').toUpperCase())}</span><div class="value">${fmtNumber(count)}</div><small class="text-muted">${ total ? Math.round(Number(count)/total*100) + '%' : '0%' }</small></div>`;
                        statusListEl.appendChild(div);
                    });
                }

                function renderTopProducts(list) {
                    topProductsTbody.innerHTML = '';
                    if (!Array.isArray(list) || list.length === 0) {
                        topProductsTbody.innerHTML =
                            '<tr><td colspan="4" class="text-center text-muted">No products</td></tr>';
                        return;
                    }
                    list.forEach((p, i) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML =
                            `<td>${i+1}</td><td>${escapeHtml(p.name)}</td><td>${fmtNumber(p.qty)}</td><td>${fmtCurrency(p.revenue)}</td>`;
                        topProductsTbody.appendChild(tr);
                    });
                }

                // UI: active filter visuals
                function setActiveFilterUI(period) {
                    qa('.filter-btn').forEach(b => {
                        const is = b.dataset.period === period;
                        b.classList.toggle('btn-primary', is);
                        b.classList.toggle('btn-outline-primary', !is);
                        b.setAttribute('aria-pressed', is ? 'true' : 'false');
                    });
                }

                // EVENTS
                periodButtonsContainer.addEventListener('click', e => {
                    const btn = e.target.closest('.filter-btn');
                    if (!btn) return;
                    const period = btn.dataset.period;
                    customRangeInline.style.display = 'none';
                    fetchSalesData(period);
                });

                qa('.filter-btn').forEach(btn => btn.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        btn.click();
                    }
                }));

                // custom toggle
                chartCustomToggle.addEventListener('click', () => {
                    const open = customRangeInline.style.display === 'block';
                    customRangeInline.style.display = open ? 'none' : 'block';
                    chartCustomToggle.setAttribute('aria-expanded', (!open).toString());
                });
                cancelCustomRangeBtn.addEventListener('click', () => {
                    customRangeInline.style.display = 'none';
                    chartCustomToggle.setAttribute('aria-expanded', 'false');
                });

                applyCustomRangeBtn.addEventListener('click', () => {
                    const from = fromDateEl.value,
                        to = toDateEl.value;
                    if (!from || !to) {
                        showToast('Please select both from and to dates', 'error');
                        return;
                    }
                    customRangeInline.style.display = 'none';
                    fetchSalesData('custom', from, to);
                });

                // no-results chips
                qa('.no-results-chip').forEach(chip => chip.addEventListener('click', () => fetchSalesData(chip.dataset
                    .period)));

                // export actions delegated
                document.addEventListener('click', e => {
                    const a = e.target.closest('[data-action]');
                    if (!a) return;
                    e.preventDefault();
                    const act = a.getAttribute('data-action');
                    if (act === 'csv') exportCSV();
                    else if (act === 'png') exportPNG();
                    else if (act === 'print') printChart();
                });

                // exports
                function exportCSV() {
                    if (!salesChartInstance) {
                        showToast('No chart data to export', 'error');
                        return;
                    }
                    const labels = salesChartInstance.data.labels || [],
                        vals = salesChartInstance.data.datasets[0]?.data || [];
                    let csv = 'label,value\r\n';
                    for (let i = 0; i < labels.length; i++) csv += `"${labels[i]}",${vals[i] ?? 0}\r\n`;
                    const blob = new Blob([csv], {
                        type: 'text/csv;charset=utf-8;'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `sales-${activePeriod}-${Date.now()}.csv`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    URL.revokeObjectURL(url);
                }

                function exportPNG() {
                    if (!salesChartInstance) {
                        showToast('No chart to export', 'error');
                        return;
                    }
                    const url = salesChartInstance.toBase64Image();
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `sales-${activePeriod}.png`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                }

                function printChart() {
                    if (!salesChartInstance) {
                        window.print();
                        return;
                    }
                    const url = salesChartInstance.toBase64Image();
                    const w = window.open('', '_blank');
                    w.document.write(`<img src="${url}" style="max-width:100%;">`);
                    w.document.close();
                    w.focus();
                    w.print();
                }

                // initial load
                fetchSalesData('lifetime');

            });
        </script>
    @endpush --}}
@endsection
