/* report-charts.js
   Generic report widget for Sales / Revenue pages.
   Requires Chart.js v4 loaded on the page (chart.umd.min.js).
   Usage: include this file, then call initReportWidget(config).
*/

(() => {
    // expose to window
    window.initReportWidget = function initReportWidget(cfg = {}) {
        // --- default config ---
        const config = Object.assign({
            containerSelector: 'body',            // root container to query elements from
            dataRoute: '',                        // required: endpoint URL (e.g. route('admin.reports.sales.data'))
            canvasSelector: '#salesChart',        // canvas
            datasetLabel: 'Value',                // chart tooltip/legend label
            kpiMap: {                             // map the server response keys to DOM element ids
                total: 'totalSales',                // sales uses totalSales; revenue uses totalRevenue
                refunds: 'refundsTotal',
                count: 'ordersCount',               // optional, must be present in response (sales uses orderStatus)
                net: 'netRevenue',
                profit: 'platformProfit'
            },
            topProductsTableSelector: '#topProductsTable tbody',
            statusListSelector: '#statusList',
            controls: {                           // selectors inside container (defaults match your blades)
                periodButtons: '#periodButtons',
                customToggle: '#chartCustomToggle',
                customBox: '#customRangeInline',
                from: '#fromDate',
                to: '#toDate',
                applyCustom: '#applyCustomRange',
                cancelCustom: '#cancelCustomRange',
                exportMenu: '#chartExport',
                exportContainer: '.chart-controls'
            },
            toastSelector: '#settingsToast',
            loaderSelector: '#chartLoader',
            noResultsSelector: '#chartNoResults',
            csvPrefix: 'report',
            locale: 'en-IN'
        }, cfg);

        // --- dom roots ---
        const root = document.querySelector(config.containerSelector) || document.body;
        const canvas = root.querySelector(config.canvasSelector);
        const ctx = canvas ? canvas.getContext('2d') : null;

        const el = {
            periodButtons: root.querySelector(config.controls.periodButtons),
            customToggle: root.querySelector(config.controls.customToggle),
            customBox: root.querySelector(config.controls.customBox),
            from: root.querySelector(config.controls.from),
            to: root.querySelector(config.controls.to),
            applyCustom: root.querySelector(config.controls.applyCustom),
            cancelCustom: root.querySelector(config.controls.cancelCustom),
            exportMenu: root.querySelector(config.controls.exportMenu),
            exportContainer: root.querySelector(config.controls.exportContainer),
            loader: root.querySelector(config.loaderSelector),
            noResults: root.querySelector(config.noResultsSelector),
            toast: root.querySelector(config.toastSelector),
            topProductsTbody: root.querySelector(config.topProductsTableSelector),
            statusList: root.querySelector(config.statusListSelector)
        };

        // state
        let chartInstance = null;
        let activePeriod = 'lifetime';
        let controller = null;

        // helpers
        const fmtCurrency = v => '₹' + (Number(v) || 0).toLocaleString(config.locale, { maximumFractionDigits: 2 });
        const fmtNumber = v => (Number(v) || 0).toLocaleString(config.locale);
        const escapeHtml = s => String(s || '').replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m]);

        // show toast
        function showToast(msg, type = 'success') {
            if (!el.toast) return;
            el.toast.textContent = msg;
            el.toast.className = 'settings-toast ' + (type === 'error' ? 'error' : (type === 'success' ? 'success' : ''));
            el.toast.style.display = 'block';
            setTimeout(() => el.toast.style.display = 'none', 2600);
        }

        function showLoader(v) {
            if (!el.loader) return;
            el.loader.classList.toggle('is-visible', !!v);
            el.loader.style.display = v ? 'block' : 'none';
            el.loader.setAttribute('aria-hidden', v ? 'false' : 'true');
        }

        function cancelOngoing() {
            if (controller) {
                try { controller.abort(); } catch (e) { }
                controller = null;
            }
        }

        // update KPIs if elements exist and key exists in response
        function updateKpis(payload) {
            if (!payload) return;
            const map = config.kpiMap;
            if (map.total && document.getElementById(map.total) && payload[map.total]) {
                document.getElementById(map.total).textContent = fmtCurrency(payload[map.total]);
            } else if (map.total && document.getElementById(map.total) && payload.totalSales) {
                document.getElementById(map.total).textContent = fmtCurrency(payload.totalSales);
            } else if (map.total && document.getElementById(map.total) && payload.totalRevenue) {
                document.getElementById(map.total).textContent = fmtCurrency(payload.totalRevenue);
            }

            if (map.refunds && document.getElementById(map.refunds)) {
                document.getElementById(map.refunds).textContent = fmtCurrency(payload[map.refunds] ?? payload.refunds ?? 0);
            }
            if (map.net && document.getElementById(map.net)) {
                document.getElementById(map.net).textContent = fmtCurrency(payload[map.net] ?? payload.netRevenue ?? 0);
            }
            if (map.profit && document.getElementById(map.profit)) {
                document.getElementById(map.profit).textContent = fmtCurrency(payload[map.profit] ?? payload.platformProfit ?? 0);
            }
            if (map.count && document.getElementById(map.count)) {
                // if orderStatus provided, compute sum
                if (payload.orderStatus && typeof payload.orderStatus === 'object') {
                    const total = Object.values(payload.orderStatus).reduce((s, n) => s + Number(n || 0), 0);
                    document.getElementById(map.count).textContent = fmtNumber(total);
                } else {
                    document.getElementById(map.count).textContent = fmtNumber(payload[map.count] ?? payload.orderCount ?? 0);
                }
            }
            // range label if provided (optional)
            if (payload.from && payload.to) {
                const rangeEl = document.getElementById('rangeLabel');
                if (rangeEl) rangeEl.textContent = `${payload.from} → ${payload.to}`;
            }
        }

        // render status list
        function renderStatusList(obj) {
            if (!el.statusList) return;
            el.statusList.innerHTML = '';
            const entries = Object.entries(obj || {});
            if (!entries.length) {
                el.statusList.innerHTML = '<div class="no-results-hint">No orders in this range</div>';
                return;
            }
            const total = entries.reduce((s, [, c]) => s + Number(c || 0), 0);
            entries.forEach(([status, count]) => {
                const div = document.createElement('div');
                div.className = 'view-row';
                div.innerHTML = `<div><span class="label">${escapeHtml(String(status).replace('_', ' ').toUpperCase())}</span><div class="value">${fmtNumber(count)}</div><small class="text-muted">${total ? Math.round(Number(count) / total * 100) + '%' : '0%'}</small></div>`;
                el.statusList.appendChild(div);
            });
        }

        // render top products
        function renderTopProducts(list) {
            if (!el.topProductsTbody) return;
            el.topProductsTbody.innerHTML = '';
            if (!Array.isArray(list) || list.length === 0) {
                el.topProductsTbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No products</td></tr>';
                return;
            }
            list.forEach((p, i) => {
                const tr = document.createElement('tr');
                // support both sales and revenue payload shapes (qty or revenue)
                const thirdCol = (p.qty !== undefined) ? `<td>${fmtNumber(p.qty)}</td><td>${fmtCurrency(p.revenue)}</td>` : `<td>${fmtCurrency(p.revenue)}</td>`;
                tr.innerHTML = `<td>${i + 1}</td><td>${escapeHtml(p.name)}</td>${thirdCol}`;
                el.topProductsTbody.appendChild(tr);
            });
        }

        // destroy chart safely
        function destroyChart() {
            if (chartInstance) {
                try { chartInstance.destroy(); } catch (e) { }
                chartInstance = null;
            }
        }

        // create or update chart
        function updateOrCreateChart(labels, values) {
            if (!ctx) return;
            if (!chartInstance) {
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: config.datasetLabel,
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
                        animation: { duration: 600, easing: 'easeOutQuart' },
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: ctx => {
                                        const v = ctx.raw ?? ctx.parsed?.y;
                                        return `${config.datasetLabel}: ${fmtCurrency(v)}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 12 } },
                            y: { beginAtZero: true, ticks: { callback: v => fmtNumber(v) } }
                        }
                    }
                });
            } else {
                chartInstance.data.labels = labels;
                chartInstance.data.datasets[0].data = values;
                chartInstance.update({ duration: 600, easing: 'easeOutQuart' });
            }
        }

        // Export helpers
        function exportCSV() {
            if (!chartInstance) { showToast('No chart data to export', 'error'); return; }
            const labels = chartInstance.data.labels || [], vals = chartInstance.data.datasets[0]?.data || [];
            let csv = 'label,value\r\n';
            for (let i = 0; i < labels.length; i++) csv += `"${labels[i]}",${vals[i] ?? 0}\r\n`;
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a'); a.href = url;
            a.download = `${config.csvPrefix}-${activePeriod}-${Date.now()}.csv`;
            document.body.appendChild(a); a.click(); a.remove();
            URL.revokeObjectURL(url);
        }

        function exportPNG() {
            if (!chartInstance) { showToast('No chart to export', 'error'); return; }
            const url = chartInstance.toBase64Image();
            const a = document.createElement('a'); a.href = url; a.download = `${config.csvPrefix}-${activePeriod}.png`;
            document.body.appendChild(a); a.click(); a.remove();
        }

        function printChart() {
            if (!chartInstance) { window.print(); return; }
            const url = chartInstance.toBase64Image();
            const w = window.open('', '_blank'); w.document.write(`<img src="${url}" style="max-width:100%;">`); w.document.close(); w.focus(); w.print();
        }

        // Event wiring (delegated)
        function wireEvents() {
            if (el.periodButtons) {
                el.periodButtons.addEventListener('click', e => {
                    const btn = e.target.closest('.filter-btn');
                    if (!btn) return;
                    const period = btn.dataset.period;
                    if (el.customBox) el.customBox.style.display = 'none';
                    load(period);
                });
            }

            // keyboard accessibility
            qaAll('.filter-btn', root).forEach(btn => btn.addEventListener('keydown', ev => {
                if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); btn.click(); }
            }));

            if (el.customToggle && el.customBox) {
                el.customToggle.addEventListener('click', () => {
                    const open = el.customBox.style.display === 'block';
                    el.customBox.style.display = open ? 'none' : 'block';
                    el.customToggle.setAttribute('aria-expanded', (!open).toString());
                });
            }
            if (el.cancelCustom) {
                el.cancelCustom.addEventListener('click', () => {
                    if (el.customBox) el.customBox.style.display = 'none';
                    if (el.customToggle) el.customToggle.setAttribute('aria-expanded', 'false');
                });
            }
            if (el.applyCustom) {
                el.applyCustom.addEventListener('click', () => {
                    const from = el.from?.value, to = el.to?.value;
                    if (!from || !to) { showToast('Please select both from and to dates', 'error'); return; }
                    if (el.customBox) el.customBox.style.display = 'none';
                    load('custom', from, to);
                });
            }

            // no-results chips
            qaAll('.no-results-chip', root).forEach(chip => chip.addEventListener('click', () => load(chip.dataset.period)));

            // export actions
            document.addEventListener('click', e => {
                const a = e.target.closest('[data-action]');
                if (!a) return;
                e.preventDefault();
                const act = a.getAttribute('data-action');
                if (act === 'csv') exportCSV();
                else if (act === 'png') exportPNG();
                else if (act === 'print') printChart();
            });
        }

        // small helper for querySelectorAll scoped to root
        function qaAll(selector, rootEl = root) {
            return Array.from((rootEl || document).querySelectorAll(selector || ''));
        }

        // main loader
        async function load(period = 'lifetime', from = null, to = null) {
            cancelOngoing();
            controller = new AbortController();
            const signal = controller.signal;
            activePeriod = period;
            // set UI active state
            setActiveFilterUI(period);

            const params = new URLSearchParams({ period });
            if (period === 'custom') {
                if (from) params.set('from', from);
                if (to) params.set('to', to);
            }

            const url = config.dataRoute + '?' + params.toString();

            showLoader(true);
            if (el.noResults) el.noResults.style.display = 'none';

            try {
                const res = await fetch(url, { signal });
                if (!res.ok) throw new Error('Network error ' + res.status);
                const data = await res.json();
                if (!Array.isArray(data.labels) || !Array.isArray(data.data)) throw new Error('Invalid payload');

                // KPIs
                updateKpis(data);

                // status & products
                renderStatusList(data.orderStatus || {});
                renderTopProducts(data.topProducts || []);

                // chart
                if (data.labels.length === 0 || data.data.every(v => Number(v) === 0)) {
                    destroyChart();
                    if (el.noResults) el.noResults.style.display = 'flex';
                } else {
                    if (el.noResults) el.noResults.style.display = 'none';
                    updateOrCreateChart(data.labels, data.data);
                }
            } catch (err) {
                if (err.name !== 'AbortError') {
                    console.error(err);
                    showToast('Failed to load data', 'error');
                }
            } finally {
                showLoader(false);
                controller = null;
            }
        }

        // active filter UI visuals
        function setActiveFilterUI(period) {
            activePeriod = period;
            qaAll('.filter-btn', root).forEach(b => {
                const is = b.dataset.period === period;
                b.classList.toggle('btn-primary', is);
                b.classList.toggle('btn-outline-primary', !is);
                b.setAttribute('aria-pressed', is ? 'true' : 'false');
            });
        }

        // init
        wireEvents();
        // initial load
        load('lifetime');

        // public API object (returns so caller can control)
        return {
            load,
            destroy: () => { cancelOngoing(); destroyChart(); },
            exportCSV,
            exportPNG,
            printChart,
            getChartInstance: () => chartInstance
        };
    };
})();
