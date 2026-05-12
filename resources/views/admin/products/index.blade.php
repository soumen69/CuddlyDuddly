@extends('admin.layouts.admin')
@section('title', 'All Products')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">

        <style>
            /* Global tighten */
            .products-page .settings-section.card {
                margin-bottom: .45rem !important;
                border-radius: .65rem;
            }

            .products-page .settings-section.card .card-body {
                padding: .45rem .7rem !important;
            }

            /* Header compact */
            .products-page .settings-section-header {
                margin-bottom: .25rem !important;
            }

            .products-page .settings-section-title {
                font-size: .95rem !important;
                font-weight: 700;
            }

            .products-page .settings-section-subtitle {
                font-size: .7rem !important;
            }

            /* Input + select compact */
            .products-page input.form-control-sm,
            .products-page select.form-select-sm {
                padding: .28rem .45rem !important;
                height: 30px !important;
                font-size: .78rem !important;
                border-radius: .4rem !important;
            }

            /* Filters compact layout */
            .products-page form.row.g-2 {
                row-gap: .35rem !important;
            }

            .products-page .form-label.small {
                font-size: .68rem !important;
                margin-bottom: .15rem !important;
            }

            /* Apply button */
            .products-page button.btn.btn-dark.btn-sm {
                padding: .28rem .55rem !important;
                font-size: .78rem !important;
            }

            /* Bulk buttons — super compact floating bar */
            .products-page .bulk-bar {
                padding: .35rem .6rem !important;
                display: flex;
                gap: .35rem;
                background: #fff;
                border: 1px solid #e4e7ee;
                border-radius: .6rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .products-page .bulk-bar .btn {
                padding: .22rem .45rem !important;
                font-size: .75rem !important;
                border-radius: .4rem !important;
                min-width: 32px;
                height: 28px;
            }

            /* Table compact */
            .products-page table.table th,
            .products-page table.table td {
                padding: .42rem .55rem !important;
                font-size: .78rem !important;
            }

            .products-page table.table thead th {
                font-size: .8rem !important;
                font-weight: 700 !important;
            }

            /* Badge compact */
            .products-page .badge {
                padding: .22rem .4rem !important;
                font-size: .68rem !important;
                border-radius: .35rem !important;
            }

            /* Dropdown compact */
            .products-page .dropdown .btn {
                padding: .22rem .45rem !important;
                border-radius: .45rem !important;
            }

            /* Pagination footer */
            .products-page .card-footer {
                padding: .4rem .75rem !important;
            }

            .small,
            small {
                font-size: .999em;
            }

            .variant-row td {
                background: #fafcff;
            }

            .product-card-intel .pc-main-image-wrapper {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 10px;
                text-align: center;
            }

            .pc-thumb {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 6px;
                cursor: pointer;
                border: 2px solid transparent;
            }

            .pc-thumb:hover {
                border-color: #0d6efd;
            }

            .pc-stat-box {
                background: #f8f9fa;
                padding: 8px;
                border-radius: 6px;
            }

            .pc-variant-box {
                background: #f8f9fa;
                padding: 8px;
                border-radius: 6px;
            }

            .pc-variant-table-wrapper {
                max-height: 200px;
                overflow: auto;
            }

            .pc-open-full {
                font-size: 14px;
                color: #6c757d;
                position: absolute;
                margin-top: 3px;
                text-decoration: none;
                transition: 0.15s ease;
            }

            .pc-open-full:hover {
                color: #0d6efd;
                transform: translate(1px, -1px);
            }
        </style>
    @endpush
    <div class="container-fluid py-0 settings-wrapper products-page">
        <div class="settings-right">
            <div class="settings-right-inner">
                {{-- Header compact --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                            <h3 class="settings-section-title mb-0">
                                <i class="bi bi-shop me-2"></i>

                                All Products

                                <div class="settings-section-subtitle">
                                    Manage products — search, filter, bulk actions and quick view.
                                </div>
                            </h3>

                            <div class="d-flex align-items-center gap-2 flex-wrap">

                                {{-- TEMPLATE WIZARD --}}
                                <button id="openBulkWizard" class="btn btn-primary btn-sm shadow-sm">
                                    <i class="bi bi-file-earmark-spreadsheet me-1"></i>
                                    Generate Template
                                </button>

                                {{-- BULK EXCEL UPLOAD --}}
                                <a href="{{ route('admin.bulk.upload.index') }}" class="btn btn-dark btn-sm shadow-sm">
                                    <i class="bi bi-cloud-arrow-up me-1"></i>
                                    Upload Excel
                                </a>

                                {{-- BATCH HISTORY --}}
                                <a href="{{ route('admin.bulk.batches.index') }}"
                                    class="btn btn-outline-secondary btn-sm shadow-sm">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Bulk History
                                </a>

                                {{-- SINGLE PRODUCT --}}
                                @canAccess('admin.products.create')
                                <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm shadow-sm">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    New Product
                                </a>
                                @endcanAccess

                            </div>
                        </div>
                    </div>
                </div>

                <div class="settings-section card mb-2">
                    <div class="card-body py-2">
                        <form method="GET" action="{{ route('admin.products.index') }}"
                            class="row g-2 align-items-center">

                            <!-- Wide Search Bar -->
                            <div class="col-lg-4 col-md-5 col-12">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm" placeholder="Search...">
                            </div>

                            <!-- Compact dropdowns -->
                            <div class="col-lg-1 col-md-2 col-6">
                                <select name="approval_status" class="form-select form-select-sm">
                                    <option value="">Approval</option>
                                    <option value="approved"
                                        {{ request('approval_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                </select>
                            </div>

                            <div class="col-lg-1 col-md-2 col-6">
                                <select name="featured" class="form-select form-select-sm">
                                    <option value="">Featured</option>
                                    <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-6">
                                <select name="seller_id" class="form-select form-select-sm">
                                    <option value="">Seller</option>
                                    @foreach ($sellers as $seller)
                                        <option value="{{ $seller->id }}"
                                            {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                            {{ $seller->name ?? 'Seller #' . $seller->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-6">
                                <select name="sort" class="form-select form-select-sm">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest
                                    </option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest
                                    </option>
                                    <option value="price_low_high"
                                        {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price ↑</option>
                                    <option value="price_high_low"
                                        {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price ↓</option>
                                    <option value="stock_low_high"
                                        {{ request('sort') == 'stock_low_high' ? 'selected' : '' }}>Stock ↑</option>
                                    <option value="stock_high_low"
                                        {{ request('sort') == 'stock_high_low' ? 'selected' : '' }}>Stock ↓</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>A–Z</option>
                                </select>
                            </div>

                            <!-- Buttons stay in same row -->
                            <div class="col-lg-2 col-md-3 col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-primary shadow-sm rounded-pill px-3 me-1">
                                    <i class="bi bi-funnel me-1"></i> Filter
                                </button>
                                <a href="{{ route('admin.products.index') }}"
                                    class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                {{-- Bulk buttons compact --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2 d-flex gap-2 flex-wrap">

                        @canAccess('admin.products.bulk_delete')
                        <button class="btn btn-outline-danger btn-sm" id="deleteSelected">
                            <i class="bi bi-trash"></i>
                        </button>
                        @endcanAccess

                        @canAccess('admin.products.bulk_feature')
                        <button class="btn btn-outline-warning btn-sm" id="featureSelected">
                            <i class="bi bi-star"></i>
                        </button>
                        @endcanAccess

                        @canAccess('admin.products.bulk_approve')
                        <button class="btn btn-outline-success btn-sm" id="approveSelected">
                            <i class="bi bi-check2-circle"></i>
                        </button>
                        @endcanAccess

                    </div>
                </div>

                {{-- Table card (keeps original UX selectors & IDs intact) --}}
                <div class="settings-section card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle products-table">
                                <thead>
                                    <tr>
                                        <th style="width:36px;"><input type="checkbox" id="selectAll"></th>
                                        <th style="width:60px;">#</th>
                                        <th style="min-width:280px;">Product</th>
                                        <th style="width:140px;">Seller</th>
                                        <th style="width:110px;">Variants</th>
                                        <th style="width:120px;">Price</th>
                                        <th style="width:90px;">Stock</th>
                                        <th style="width:90px;">Featured</th>
                                        <th style="width:100px;">Approval</th>
                                        <th class="text-end" style="width:90px;">Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($products && $products->count() > 0)
                                        @foreach ($products as $product)
                                            <tr class="{{ $product->active_variants_count > 0 ? 'variant-row' : '' }}">
                                                <td>
                                                    <input type="checkbox" class="product-checkbox"
                                                        value="{{ $product->id }}">
                                                </td>
                                                <td class="text-muted small">{{ $products->firstItem() + $loop->index }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @php
                                                            if ($product->has_visual_variants) {
                                                                $imgPath = optional($product->primaryVariantImage)
                                                                    ->image_path;
                                                            } else {
                                                                $imgPath = optional($product->primaryImage)->image_path;
                                                            }

                                                            $img = $imgPath
                                                                ? Storage::url($imgPath)
                                                                : asset('images/no-image.png');
                                                        @endphp

                                                        <img src="{{ $img }}"
                                                            style="width:44px;height:44px;object-fit:cover;border-radius:8px">
                                                        <div class="d-flex flex-column">
                                                            <strong class="small">
                                                                {{ $product->name }}
                                                            </strong>
                                                            <div class="d-flex gap-1 mt-1">
                                                                @if ($product->active_variants_count > 0)
                                                                    <span class="badge bg-primary">VAR</span>
                                                                @endif
                                                                @if ($product->has_visual_variants)
                                                                    <span class="badge bg-dark">VIS</span>
                                                                @endif
                                                                @if ($product->featured)
                                                                    <span class="badge bg-warning text-dark">FEAT</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="small">{{ $product->seller->name ?? '—' }}</td>
                                                <td class="small text-center">
                                                    @if ($product->active_variants_count > 0)
                                                        <span class="badge bg-info">
                                                            {{ $product->active_variants_count }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td class="small fw-semibold">
                                                    @if ($product->active_variants_count > 0)
                                                        ₹{{ number_format($product->min_variant_price, 2) }}
                                                        @if ($product->min_variant_price != $product->max_variant_price)
                                                            <span class="text-muted">→</span>
                                                            ₹{{ number_format($product->max_variant_price, 2) }}
                                                        @endif
                                                    @else
                                                        ₹{{ number_format($product->price, 2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $stock =
                                                            $product->active_variants_count > 0
                                                                ? $product->total_variant_stock ?? 0
                                                                : $product->stock;
                                                    @endphp

                                                    <span
                                                        class="badge {{ $stock > 10 ? 'bg-success' : ($stock > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                        {{ $stock }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($product->featured)
                                                        <span class="badge bg-warning text-dark small">Yes</span>
                                                    @else
                                                        <span class="badge bg-secondary small">No</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($product->is_approved)
                                                        <span class="badge bg-success small">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger small">Pending</span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-gear"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @canAccess('admin.products.view')
                                                            <li>
                                                                {{-- KEEP original view button (UX unchanged) --}}
                                                                <button class="dropdown-item btn-view-product"
                                                                    data-id="{{ $product->id }}">
                                                                    <i class="bi bi-eye me-1"></i> View
                                                                </button>
                                                            </li>
                                                            @endcanAccess
                                                            @canAccess('admin.products.edit')
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.products.edit', $product->id) }}">
                                                                    <i class="bi bi-pencil me-1"></i> Edit
                                                                </a>
                                                            </li>
                                                            @endcanAccess
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center text-muted py-4">
                                                <i class="bi bi-box-seam fs-4 d-block mb-1"></i>
                                                No products found
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($products && $products->hasPages())
                        <div class="card-footer py-2">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>

                {{-- keep the original toast container (UX unchanged) --}}
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;"></div>

            </div>
        </div>
    </div>
    @include('admin.partials.bulk-upload-wizard')

    @push('scripts')
        {{-- KEEP original scripts only — no inline behavior injected here --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            window.storageBase = "{{ url('/storage/') }}/";
        </script>
        <script src="{{ asset('js/products-index.js') }}"></script>
        <script>
            $(function() {

                const modalEl = document.getElementById('bulkUploadWizard');

                let bulkModal = null;

                if (modalEl) {

                    bulkModal = new bootstrap.Modal(modalEl);

                    $('#openBulkWizard').on('click', function() {
                        bulkModal.show();
                    });
                }

                /* =========================================================
                   STATE
                ========================================================= */

                let state = {
                    categories: [],
                    subcategories: [],
                    brandMode: null,
                    brandId: null,
                    volume: null
                };

                /* =========================================================
                   HELPERS
                ========================================================= */

                function resetAfterCategoryChange() {

                    state.subcategories = [];
                    state.brandMode = null;
                    state.brandId = null;
                    state.volume = null;

                    $('#subcategoryGrid').empty();

                    $('#subcategorySection').addClass('d-none');

                    $('#finalConfig').addClass('d-none');

                    $('#brandWrap').addClass('d-none');

                    $('#brandMode').val('');

                    $('#brandSelect').val('');

                    $('#uploadVolume').val('');

                    $('#generateTemplate').addClass('d-none');
                }

                function toggleGenerateButton() {

                    const isReady =
                        state.categories.length > 0 &&
                        state.subcategories.length > 0 &&
                        state.brandMode &&
                        state.volume;

                    $('#generateTemplate')
                        .toggleClass('d-none', !isReady);
                }

                /* =========================================================
                   CATEGORY CHANGE
                ========================================================= */

                $('#categoryGrid input').on('change', function() {

                    state.categories = $('#categoryGrid input:checked')
                        .map((i, e) => Number(e.value))
                        .get();

                    resetAfterCategoryChange();

                    if (!state.categories.length) {
                        return;
                    }

                    $.ajax({
                        url: '/admin/bulk/subcategories',
                        method: 'POST',

                        data: {
                            categories: state.categories,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function(response) {

                            let html = '';

                            response.forEach(item => {

                                html += `
                            <label class="compact-check">
                                <input type="checkbox" value="${item.id}">
                                <span>${item.name}</span>
                            </label>
                        `;
                            });

                            $('#subcategoryGrid').html(html);

                            $('#subcategorySection')
                                .removeClass('d-none');
                        },

                        error: function(xhr) {

                            console.error(
                                'Failed to load product types',
                                xhr.responseText
                            );
                        }
                    });
                });

                /* =========================================================
                   SUBCATEGORY CHANGE
                ========================================================= */

                $(document).on('change', '#subcategoryGrid input', function() {

                    state.subcategories = $('#subcategoryGrid input:checked')
                        .map((i, e) => Number(e.value))
                        .get();

                    if (!state.subcategories.length) {

                        $('#finalConfig')
                            .addClass('d-none');

                        toggleGenerateButton();

                        return;
                    }

                    $('#finalConfig')
                        .removeClass('d-none');

                    toggleGenerateButton();
                });

                /* =========================================================
                   BRAND MODE
                ========================================================= */

                $('#brandMode').on('change', function() {

                    state.brandMode = this.value;

                    if (state.brandMode === 'single') {

                        $('#brandWrap')
                            .removeClass('d-none');

                    } else {

                        $('#brandWrap')
                            .addClass('d-none');

                        state.brandId = null;

                        $('#brandSelect').val('');
                    }

                    toggleGenerateButton();
                });

                /* =========================================================
                   BRAND SELECT
                ========================================================= */

                $('#brandSelect').on('change', function() {

                    state.brandId = this.value ?
                        Number(this.value) :
                        null;
                });

                /* =========================================================
                   VOLUME
                ========================================================= */

                $('#uploadVolume').on('change', function() {

                    state.volume = Number(this.value);

                    toggleGenerateButton();
                });

                /* =========================================================
                   GENERATE TEMPLATE
                ========================================================= */

                $('#generateTemplate').on('click', function() {

                    const payload = {
                        categories: state.categories,
                        subcategories: state.subcategories,
                        brand_mode: state.brandMode,
                        brand_id: state.brandMode === 'single' ?
                            state.brandId : null,
                        volume: state.volume
                    };

                    console.log('BULK TEMPLATE PAYLOAD', payload);

                    const form = $('<form>', {
                        method: 'POST',
                        action: "{{ route('admin.generate.template') }}"
                    });

                    form.append(
                        $('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: $('meta[name="csrf-token"]').attr('content')
                        })
                    );

                    Object.entries(payload).forEach(([key, value]) => {

                        if (Array.isArray(value)) {

                            value.forEach(item => {

                                form.append(
                                    $('<input>', {
                                        type: 'hidden',
                                        name: `${key}[]`,
                                        value: item
                                    })
                                );
                            });

                            return;
                        }

                        form.append(
                            $('<input>', {
                                type: 'hidden',
                                name: key,
                                value: value ?? ''
                            })
                        );
                    });

                    $('body').append(form);

                    form.trigger('submit');
                });

            });
        </script>
    @endpush

    {{-- Confirm Delete Modal (unchanged behavior) --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to permanently delete the selected products?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Quick View Modal (unchanged behavior) --}}
    <div class="modal fade" id="productViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Product Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="productViewContent">
                    <div class="text-center text-muted py-4">
                        <div class="spinner-border text-primary"></div>
                        <p class="mt-2 mb-0 small">Loading product details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
