@extends('admin.layouts.admin')

@section('title', 'Revenue Report')
@section('content')
    <div class="container-fluid py-0 settings-wrapper">

        <div class="settings-right">
            <div class="settings-right-inner">

                {{-- Header (title only) --}}
                <div class="settings-section card mb-4">
                    <div class="card-body">
                        <div class="settings-section-header">
                            <div>
                                <h3 class="settings-section-title">Revenue Report</h3>
                                <div class="settings-section-subtitle">Complete financial overview — gross revenue, refunds,
                                    net revenue and platform profit. Use timeframe filters and export tools as needed.</div>
                            </div>
                        </div>

                        <div class="view-grid">
                            <div class="view-row">
                                <div>
                                    <span class="label">Total Revenue</span>
                                    <div class="value" id="totalRevenue">₹0</div>
                                    <small class="text-muted">Gross revenue</small>
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
                                    <span class="label">Net Revenue</span>
                                    <div class="value" id="netRevenue">₹0</div>
                                    <small class="text-muted">Gross − Refunds</small>
                                </div>
                            </div>

                            <div class="view-row">
                                <div>
                                    <span class="label">Platform Profit</span>
                                    <div class="value" id="platformProfit">₹0</div>
                                    <small class="text-muted">Commission earned</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart Card: controls & export (top-right) --}}
                <div class="settings-section card mb-4 position-relative">
                    <div class="card-body chart-card" style="min-height:660px; position:relative;">

                        <div class="settings-section-header">
                            <div>
                                <h4 class="settings-section-title">Revenue Trend</h4>
                                <div class="settings-section-subtitle">Gross revenue over time — hover to inspect values.
                                    Use quick filters or custom range to change scope.</div>
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

                            {{-- EXPORT DROPDOWN --}}
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

                        {{-- Chart canvas --}}
                        <div id="chartWrapper" class="chart-wrap" style="height:400px;">
                            <canvas id="revenueChart" aria-label="Revenue chart" role="img"></canvas>
                        </div>

                        {{-- loader / no-results --}}
                        <div class="settings-loading" id="chartLoader" aria-hidden="true">
                            <div class="spinner"></div>
                        </div>

                        <div class="no-results" id="chartNoResults" style="display:none;">
                            <div class="no-results-title">No revenue data</div>
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
                                        <div class="settings-section-subtitle">Top 10 products by revenue</div>
                                    </div>
                                </div>

                                <div class="settings-section-divider"></div>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="topProductsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
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
            // Revenue page init
            const revenueWidget = initReportWidget({
                containerSelector: '.settings-right-inner',
                dataRoute: "{{ route('admin.reports.revenue.data') }}",
                canvasSelector: '#revenueChart',
                datasetLabel: 'Revenue',
                kpiMap: {
                    total: 'totalRevenue',
                    refunds: 'refundsTotal',
                    net: 'netRevenue',
                    profit: 'platformProfit'
                },
                csvPrefix: 'revenue'
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
                const totalRevenueEl = $('totalRevenue'),
                    refundsEl = $('refundsTotal'),
                    netRevenueEl = $('netRevenue'),
                    platformProfitEl = $('platformProfit');
                const statusListEl = $('statusList'),
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
                const revenueCanvas = $('revenueChart');

                // state
                let revenueChartInstance = null;
                let activePeriod = 'lifetime';
                let controller = null;

                // helpers
                const fmtCurrency = v => '₹' + (Number(v) || 0).toLocaleString('en-IN', {
                    maximumFractionDigits: 2
                });
                const fmtNumber = v => (Number(v) || 0).toLocaleString('en-IN');
                const escapeHtml = s => String(s || '').replace(/[&<>"']/g, m => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                })[m]);

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
                async function fetchRevenueData(period, from = null, to = null) {
                    cancelOngoing();
                    controller = new AbortController();
                    const signal = controller.signal;

                    activePeriod = period;
                    setActiveFilterUI(period);

                    // build params
                    const params = new URLSearchParams({
                        period
                    });
                    if (period === 'custom') {
                        params.set('from', from);
                        params.set('to', to);
                    }

                    const url = "{{ route('admin.reports.revenue.data') }}?" + params.toString();

                    showLoader(true);
                    noResults.style.display = 'none';

                    try {
                        const res = await fetch(url, {
                            signal
                        });
                        if (!res.ok) throw new Error('Network error ' + res.status);
                        const data = await res.json();

                        if (!Array.isArray(data.labels) || !Array.isArray(data.data)) throw new Error(
                            'Invalid data payload');

                        // KPIs
                        totalRevenueEl.textContent = fmtCurrency(data.totalRevenue);
                        refundsEl.textContent = fmtCurrency(data.refunds ?? 0);
                        netRevenueEl.textContent = fmtCurrency(data.netRevenue ?? 0);
                        platformProfitEl.textContent = fmtCurrency(data.platformProfit ?? 0);

                        // status & products
                        renderStatusList(data.orderStatus || {});
                        renderTopProducts(data.topProducts || []);

                        // chart logic
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
                            showToast('Failed to load revenue data', 'error');
                        }
                    } finally {
                        showLoader(false);
                    }
                }

                // chart lifecycle
                function destroyChart() {
                    if (revenueChartInstance) {
                        try {
                            revenueChartInstance.destroy();
                        } catch (e) {}
                        revenueChartInstance = null;
                    }
                }

                function updateOrCreateChart(labels, values) {
                    if (!revenueChartInstance) {
                        const ctx = revenueCanvas.getContext('2d');
                        revenueChartInstance = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels,
                                datasets: [{
                                    label: 'Revenue',
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
                                                return 'Revenue: ' + fmtCurrency(v);
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
                        revenueChartInstance.data.labels = labels;
                        revenueChartInstance.data.datasets[0].data = values;
                        revenueChartInstance.update({
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
                        div.innerHTML = `<div>
                            <span class="label">${escapeHtml(String(status).replace('_',' ').toUpperCase())}</span>
                            <div class="value">${fmtNumber(count)}</div>
                            <small class="text-muted">${ total ? Math.round(Number(count)/total*100) + '%' : '0%' }</small>
                        </div>`;
                        statusListEl.appendChild(div);
                    });
                }

                function renderTopProducts(list) {
                    topProductsTbody.innerHTML = '';
                    if (!Array.isArray(list) || list.length === 0) {
                        topProductsTbody.innerHTML =
                            '<tr><td colspan="3" class="text-center text-muted">No products</td></tr>';
                        return;
                    }
                    list.forEach((p, i) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML =
                            `<td>${i+1}</td><td>${escapeHtml(p.name)}</td><td>${fmtCurrency(p.revenue)}</td>`;
                        topProductsTbody.appendChild(tr);
                    });
                }

                // UI: active filter visuals
                function setActiveFilterUI(period) {
                    activePeriod = period;
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
                    fetchRevenueData(period);
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
                    fetchRevenueData('custom', from, to);
                });

                // no-results chips
                qa('.no-results-chip').forEach(chip => chip.addEventListener('click', () => fetchRevenueData(chip
                    .dataset.period)));

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
                    if (!revenueChartInstance) {
                        showToast('No chart data to export', 'error');
                        return;
                    }
                    const labels = revenueChartInstance.data.labels || [],
                        vals = revenueChartInstance.data.datasets[0]?.data || [];
                    let csv = 'label,value\r\n';
                    for (let i = 0; i < labels.length; i++) csv += `"${labels[i]}",${vals[i] ?? 0}\r\n`;
                    const blob = new Blob([csv], {
                        type: 'text/csv;charset=utf-8;'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `revenue-${activePeriod}-${Date.now()}.csv`;
                    a.click();
                    URL.revokeObjectURL(url);
                }

                function exportPNG() {
                    if (!revenueChartInstance) {
                        showToast('No chart to export', 'error');
                        return;
                    }
                    const url = revenueChartInstance.toBase64Image();
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `revenue-${activePeriod}.png`;
                    a.click();
                }

                function printChart() {
                    if (!revenueChartInstance) {
                        window.print();
                        return;
                    }
                    const url = revenueChartInstance.toBase64Image();
                    const w = window.open('', '_blank');
                    w.document.write(`<img src="${url}" style="max-width:100%;">`);
                    w.document.close();
                    w.focus();
                    w.print();
                }

                // initial load
                fetchRevenueData('lifetime');

            });
        </script>
    @endpush --}}
@endsection
