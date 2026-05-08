@extends('admin.layouts.admin')

@section('content')
    @push('styles')
        {{-- shared admin design tokens/styles (keeps UI consistent) --}}
        <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">

        {{-- page-specific compact styling (only visual) --}}
        <style>
            /* Scope to this blade */
            #category-tree-panel {
                background: #fbfdff;
                border-right: 1px solid #e6eefc;
                padding: .9rem;
            }

            /* Use admin card look for left panel (keep ID for JS) */
            #category-tree-panel.settings-section.card {
                border-radius: .75rem;
                border: 1px solid #e3e6ee;
                padding: 0;
                background: var(--card-bg, #fff);
            }

            #category-tree-panel .card-body {
                padding: .9rem;
            }

            /* Tree button style (kept from your original, tuned to admin UI) */
            .tree-btn {
                width: 100%;
                text-align: left;
                border-radius: 8px;
                padding: .42rem .6rem;
                transition: background .12s ease, transform .12s ease;
                background: transparent;
                border: 0;
                color: var(--text-primary, #202633);
            }

            .tree-btn:hover {
                background: #f1f3f7;
                transform: translateX(2px);
            }

            /* badge look consistent with admin */
            #category-tree-panel .badge {
                background: #eef3fb;
                color: #0d47a1;
                font-weight: 700;
                border-radius: 6px;
                padding: .18rem .45rem;
            }

            /* Skeleton & shimmer */
            .skeleton {
                background: linear-gradient(90deg, #e9edf6 25%, #f6f8fb 50%, #e9edf6 75%);
                background-size: 200% 100%;
                animation: shimmer 1.2s infinite;
                border-radius: 8px;
            }

            @keyframes shimmer {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }

            .skeleton-card {
                height: 76px;
                margin-bottom: 10px;
            }

            /* Product panel styling using admin card look */
            #product-panel.settings-section.card {
                border-radius: .75rem;
                border: 1px solid #e3e6ee;
                padding: 0;
                background: var(--card-bg, #fff);
            }

            #product-panel .card-body {
                padding: .9rem;
            }

            /* Compact controls row */
            #product-panel .d-flex.mb-2 {
                gap: .5rem;
                align-items: center;
            }

            #product-search {
                min-width: 0;
                flex: 1 1 auto;
                max-width: 640px;
            }

            #per-page {
                width: 92px;
            }

            #clear-filter {
                white-space: nowrap;
            }

            /* Product cards tuned to admin look */
            #product-list .card {
                border-radius: .6rem;
                border: 1px solid #eef3fb;
                background: #fbfdff;
            }

            #product-list .card .card-body {
                padding: .6rem;
            }

            /* Pagination area small */
            #product-pagination {
                display: flex;
                gap: .5rem;
                align-items: center;
                flex-wrap: wrap;
            }

            /* Make left panel scroll nicely and fit layout */
            #category-tree-panel .card-body {
                height: calc(100vh - 160px);
                overflow: auto;
                padding-right: .6rem;
            }

            /* Tighten typography */
            #category-tree-panel h5,
            #product-panel h5 {
                font-size: .95rem;
                margin-bottom: .6rem;
            }

            #product-list .small {
                font-size: .82rem;
            }

            /* Responsive tweaks */
            @media (max-width: 992px) {
                #category-tree-panel .card-body {
                    height: auto;
                }

                #product-panel .card-body {
                    padding: .7rem;
                }

                #product-search {
                    max-width: 100%;
                }

                .tree-btn {
                    padding: .35rem .5rem;
                }
            }

            .bg-secondary {
                background-color: rgb(193 204 214) !important;
            }

            .tree-loading {
                font-size: 13px;
                color: #777;
                padding: 6px 0;
            }

            .tree-btn.loading {
                opacity: .6;
                pointer-events: none;
            }
        </style>
    @endpush

    <div class="container-fluid py-0 settings-wrapper">
        <div class="settings-right">
            <div class="settings-right-inner">

                <div class="row g-3">

                    <!-- LEFT CATEGORY TREE -->
                    <div class="col-md-3">
                        {{-- Keep same ID and inner structure so JS selectors remain valid --}}
                        <div id="category-tree-panel" class="settings-section card">
                            <div class="card-body">
                                <h5 class="fw-bold">Category Explorer</h5>

                                <ul id="master-list-root" class="list-unstyled mb-0">
                                    @foreach ($masters as $m)
                                        <li class="mb-2">
                                            <button class="btn tree-btn expand-mc-root" data-mc="{{ $m->id }}">
                                                <strong>{{ $m->name }}</strong>
                                                <span class="badge ms-2">{{ $m->product_count }}</span>
                                            </button>
                                            <ul class="st-list list-unstyled ps-3 mt-1" data-loaded="false"></ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>


                    <!-- PRODUCT PANEL -->
                    <div class="col-md-9">
                        <div id="product-panel" class="settings-section card">
                            <div class="card-body">

                                <div class="d-flex mb-2">
                                    {{-- keep original IDs so JS works the same --}}
                                    <input id="product-search" class="form-control me-2" placeholder="Search products...">
                                    <select id="per-page" class="form-select w-auto me-2">
                                        <option value="10">10</option>
                                        <option value="20" selected>20</option>
                                        <option value="50">50</option>
                                    </select>
                                    <button id="clear-filter" class="btn btn-outline-secondary">Clear</button>
                                </div>

                                <div id="product-list">
                                    <div class="alert alert-info mb-0">Select a category to view products.</div>
                                </div>

                                <nav id="product-pagination" class="mt-3"></nav>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const treeCache = {
            sectionTypes: {},
            categories: {}
        };

        const fetchJson = url =>
            fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(r => r.json());

        const showSkeleton = () => {
            const list = document.getElementById('product-list');
            list.innerHTML = `
        <div class="skeleton skeleton-card"></div>
        <div class="skeleton skeleton-card"></div>
        <div class="skeleton skeleton-card"></div>
        <div class="skeleton skeleton-card"></div>`;
        };

        /* ============================================================
           Render Product Cards
        ============================================================ */
        function renderProducts(json) {
            const list = document.getElementById('product-list');

            if (!json.data || json.data.length === 0) {
                list.innerHTML = `<div class="alert alert-info">No products found.</div>`;
                document.getElementById('product-pagination').innerHTML = "";
                return;
            }

            list.innerHTML = json.data.map(p => {
                const img = p.images?.[0] ?
                    `/storage/${p.images[0].image_path}` :
                    `/images/placeholder.png`;

                return `
        <div class="card mb-2 shadow-sm border-0">
            <div class="card-body d-flex">
                <img src="${img}" style="width:72px;height:72px;object-fit:cover;margin-right:12px;border-radius:8px;">
                <div>
                    <strong>${p.name}</strong><br>
                    <small class="text-muted">${p.seller ? p.seller.name : ''}</small><br>
                    <small class="fw-bold">₹${Number(p.price).toFixed(2)}</small>
                </div>
            </div>
        </div>`;
            }).join('');

            renderPagination(json);
        }

        /* ============================================================
           Pagination
        ============================================================ */
        function renderPagination(json) {
            const pg = document.getElementById('product-pagination');
            let html = "";

            if (json.prev_page_url)
                html +=
                `<button class="btn btn-sm btn-outline-primary me-2" data-url="${json.prev_page_url}">Prev</button>`;

            html += `<span class="fw-bold">Page ${json.current_page} / ${json.last_page}</span>`;

            if (json.next_page_url)
                html +=
                `<button class="btn btn-sm btn-outline-primary ms-2" data-url="${json.next_page_url}">Next</button>`;

            pg.innerHTML = html;
        }

        /* ============================================================
           Load Products
        ============================================================ */
        let lastParams = {};
        let hasActiveCategory = false;

        async function loadProducts(params = {}) {

            const searchValue = document.getElementById('product-search').value.trim();
            if (searchValue !== "") {
                delete lastParams.chain_type;
                delete lastParams.mcs_id;
            }
            lastParams = {
                ...lastParams,
                ...params
            };
            lastParams.per_page = document.getElementById('per-page').value;
            lastParams.search = searchValue;

            // If no category and no search → show default message
            if (!hasActiveCategory && searchValue === "") {
                document.getElementById("product-list").innerHTML =
                    `<div class='alert alert-info'>Select a category to view products.</div>`;
                document.getElementById("product-pagination").innerHTML = "";
                return;
            }

            showSkeleton();

            const qs = new URLSearchParams(lastParams).toString();
            const json = await fetchJson(`{{ route('admin.category-explorer.products') }}?${qs}`);

            renderProducts(json);
        }

        /* ============================================================
           Category Tree Clicks
        ============================================================ */
        document.addEventListener('DOMContentLoaded', () => {

            document.getElementById("category-tree-panel").addEventListener("click", async (e) => {
                const t = e.target.closest('button');
                if (!t) return;

                /* ===== MASTER CATEGORY ===== */
                if (t.classList.contains("expand-mc-root")) {
                    const mcList = t.parentElement.querySelector(".st-list");

                    if (mcList.dataset.loaded === "true") {
                        mcList.classList.toggle("d-none");
                        return;
                    }

                    const mc = t.dataset.mc;
                    mcList.innerHTML = `<li class="tree-loading">Loading...</li>`;
                    t.classList.add('loading');

                    let rows = treeCache.sectionTypes[mc];
                    if (!rows) {
                        rows = await fetchJson(
                            "{{ route('admin.category-explorer.children', 'section_type') }}/" + mc
                        );
                        treeCache.sectionTypes[mc] = rows;
                    }

                    mcList.innerHTML = rows.map(r => `
            <li>
                <button class="btn tree-btn expand-st" data-st="${r.id}" data-mc="${mc}">
                    ${r.name}
                    <span class="badge bg-secondary ms-1">${r.product_count}</span>
                </button>
                <ul class="cat-list list-unstyled ps-3" data-loaded="false"></ul>
            </li>`).join("");

                    mcList.dataset.loaded = "true";
                    t.classList.remove('loading');
                }

                /* ===== SECTION TYPE ===== */
                if (t.classList.contains("expand-st")) {
                    const catList = t.parentElement.querySelector(".cat-list");

                    if (catList.dataset.loaded === "true") {
                        catList.classList.toggle("d-none");
                        return;
                    }

                    const st = t.dataset.st;
                    const mc = t.dataset.mc;
                    const key = mc + '_' + st;

                    catList.innerHTML = `<li class="tree-loading">Loading...</li>`;
                    t.classList.add('loading');

                    let rows = treeCache.categories[key];
                    if (!rows) {
                        rows = await fetchJson(
                            "{{ route('admin.category-explorer.children', 'category') }}/" + st +
                            "?mc=" + mc
                        );
                        treeCache.categories[key] = rows;
                    }

                    catList.innerHTML = rows.map(r => `
            <li>
                <button class="btn tree-btn select-mcs" data-mcs="${r.id}">
                    ${r.name}
                    <span class="badge bg-secondary ms-1">${r.product_count}</span>
                </button>
            </li>`).join("");

                    catList.dataset.loaded = "true";
                    t.classList.remove('loading');
                }

                /* ===== FINAL CATEGORY ===== */
                if (t.classList.contains("select-mcs")) {
                    hasActiveCategory = true;
                    loadProducts({
                        chain_type: "category",
                        mcs_id: t.dataset.mcs
                    });
                }
            });

            /* ============================================================
               Search / Filters
            ============================================================ */
            let debounce;

            document.getElementById("product-search").addEventListener("input", () => {
                clearTimeout(debounce);
                debounce = setTimeout(() => loadProducts(), 300); // ALWAYS call
            });

            document.getElementById("per-page").addEventListener("change", () => loadProducts());

            document.getElementById("clear-filter").addEventListener("click", () => {
                lastParams = {};
                hasActiveCategory = false;
                document.getElementById("product-search").value = "";
                document.getElementById("product-list").innerHTML =
                    `<div class='alert alert-info'>Select a category to view products.</div>`;
                document.getElementById("product-pagination").innerHTML = "";
            });

            /* ============================================================
               Pagination Click
            ============================================================ */
            document.getElementById("product-pagination").addEventListener("click", (e) => {
                const btn = e.target.closest("button[data-url]");
                if (!btn) return;

                const url = new URL(btn.dataset.url);
                const q = Object.fromEntries(url.searchParams.entries());
                loadProducts(q);
            });

        });
    </script>
@endpush
