@extends('admin.layouts.admin')

@section('title', 'Reviews')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">
    <style>
        /* Same image styling as products table */
        .review-img,
        .customer-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
        }

        .table tbody tr:hover {
            background: #f5f7fb;
        }

        .rating-badge {
            font-weight: 600;
            border-radius: 6px;
        }

        /* ---------- Modal Header Styling ---------- */
        .modal-header {
            background: linear-gradient(90deg, #0d6efd, #6610f2);
            color: #fff;
        }

        /* ---------- Review Card Modal Container ---------- */
        .review-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* ---------- Product Section (Top of Modal) ---------- */
        .review-card .product-section {
            background: linear-gradient(135deg, #f3f7ff, #ffffff);
            border-bottom: 1px solid #e9ecef;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Product Image in Modal */
        .review-card .product-img {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }

        /* Modal Stars */
        .star {
            color: #ffc107;
            font-size: 1rem;
        }

        /* ---------- Customer Section (Middle) ---------- */
        .review-card .customer-section {
            padding: 1.2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        /* Customer Avatar */
        .customer-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dee2e6;
        }

        /* Review Text */
        .review-text {
            margin-top: .8rem;
            font-size: .95rem;
            line-height: 1.5;
        }

        /* ---------- Review Meta (Bottom Bar) ---------- */
        .review-meta {
            padding: .8rem 1.2rem;
            background: #f1f3f5;
            border-top: 1px solid #e9ecef;
            font-size: .85rem;
            color: #6c757d;
            display: flex;
            justify-content: space-between;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-0 settings-wrapper products-page">
        <div class="settings-right">
            <div class="settings-right-inner">
                {{-- Header (same UI as products) --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="settings-section-title mb-0">
                                <i class="bi bi-star text-warning me-2"></i>Customer Reviews
                                <div class="settings-section-subtitle">
                                    Manage reviews — search, filter, bulk delete & quick view.
                                </div>
                            </h3>

                            @canAccess('admin.reviews.create')
                            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary btn-sm shadow-sm">
                                <i class="bi bi-plus-circle me-1"></i> New Review
                            </a>
                            @endcanAccess
                        </div>
                    </div>
                </div>

                {{-- Filters (same UI as products) --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2">

                        <form method="GET" action="{{ route('admin.reviews.index') }}" class="row g-2 align-items-center">

                            {{-- Wide search --}}
                            <div class="col-lg-8 col-md-5 col-12">
                                <input type="text" name="product" value="{{ request('product') }}"
                                    class="form-control form-control-sm" placeholder="Search product name...">
                            </div>

                            {{-- Rating --}}
                            <div class="col-lg-2 col-md-3 col-6">
                                <select name="rating" class="form-select form-select-sm">
                                    <option value="">All Ratings</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                            {{ $i }} Stars
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Filter + Reset --}}
                            <div class="col-lg-2 col-md-3 col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-primary shadow-sm rounded-pill px-3 me-1">
                                    <i class="bi bi-funnel me-1"></i> Filter
                                </button>

                                <a href="{{ route('admin.reviews.index') }}"
                                    class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                </a>
                            </div>
                        </form>

                    </div>
                </div>

                {{-- Bulk actions (same UI as products) --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2 d-flex gap-2 flex-wrap">

                        @canAccess('admin.reviews.deleteselected')
                        <button class="btn btn-outline-danger btn-sm" id="deleteSelectedBtn" disabled>
                            <i class="bi bi-trash"></i>
                        </button>
                        @endcanAccess

                        <span class="ms-auto text-muted small">
                            Showing {{ $reviews->firstItem() }}–{{ $reviews->lastItem() }} of {{ $reviews->total() }}
                            reviews
                        </span>
                    </div>
                </div>

                {{-- Table (same UI wrapper as products) --}}
                <div class="settings-section card">
                    <div class="card-body p-0">

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:36px"><input type="checkbox" id="selectAll"></th>
                                        <th style="width:54px">#</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Product</th>
                                        <th style="width:70px;">Image</th>
                                        <th style="width:90px;">Rating</th>
                                        <th>Comment</th>
                                        <th style="width:130px;">Date</th>
                                        <th class="text-end" style="width:90px;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($reviews as $review)
                                        <tr data-id="{{ $review->id }}">

                                            <td><input type="checkbox" name="selected[]" value="{{ $review->id }}"></td>

                                            <td class="text-muted small">{{ $loop->iteration }}</td>

                                            <td class="d-flex align-items-center">
                                                <img src="{{ $review->customer->profile_image
                                                    ? asset('storage/' . $review->customer->profile_image)
                                                    : asset('storage/images/default-avatar.png') }}"
                                                    class="customer-img me-2">

                                                <div>
                                                    <strong class="small">
                                                        {{ $review->customer->name }}
                                                    </strong>
                                                    <div class="text-muted small">{{ $review->customer->phone ?? '-' }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="small">{{ $review->customer->email }}</td>
                                            <td class="small">{{ $review->product->name ?? '-' }}</td>

                                            <td>
                                                <img src="{{ $review->product && $review->product->primaryImage
                                                    ? asset('storage/' . $review->product->primaryImage->image_path)
                                                    : asset('images/no-image.png') }}"
                                                    class="review-img">
                                            </td>

                                            <td>
                                                <span class="badge bg-warning text-dark rating-badge">
                                                    {{ $review->rating }} <i class="bi bi-star-fill"></i>
                                                </span>
                                            </td>

                                            <td class="small">{{ Str::limit($review->comment, 40) ?? '-' }}</td>

                                            <td class="small">{{ $review->created_at->format('d M Y') }}</td>

                                            <td class="text-end">
                                                @canAccess('admin.reviews.show')
                                                <button class="btn btn-sm btn-outline-info viewReviewBtn"
                                                    data-review='@json($review)'>
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @endcanAccess
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted py-4">
                                                <i class="bi bi-exclamation-circle fs-4 d-block mb-1"></i>
                                                No reviews found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if ($reviews->hasPages())
                            <div class="card-footer py-2">
                                {{ $reviews->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ---------- Modal: Rich Review Details ---------- -->
    <div class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content review-card">
                <div class="product-section">
                    <img id="modalProductImage" src="/images/no-image.png" class="product-img" alt="Product">
                    <div class="product-info">
                        <h5 id="modalProductName">Product Name</h5>
                        <div id="modalStars" class="mb-1"></div>
                        <p class="text-muted small mb-0" id="modalReviewDate"></p>
                    </div>
                </div>
                <div class="customer-section">
                    <img id="modalCustomerAvatar" src="/storage/images/default-avatar.png" class="customer-avatar"
                        alt="Customer">
                    <div class="customer-info">
                        <h6 id="modalCustomerName"></h6>
                        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                        <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
                        <div class="review-text mt-2" id="modalComment"></div>
                    </div>
                </div>
                <div class="review-meta">
                    <span><i class="bi bi-calendar"></i> <span id="modalCreatedAt"></span></span>
                    <span><i class="bi bi-star-fill text-warning"></i> <span id="modalRatingValue"></span></span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrf = '{{ csrf_token() }}';
            const selectAll = document.querySelector('#selectAll');
            const deleteBtn = document.querySelector('#deleteSelectedBtn');
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');

            const updateButton = () => deleteBtn.disabled = ![...checkboxes].some(cb => cb.checked);
            selectAll?.addEventListener('change', e => {
                checkboxes.forEach(cb => cb.checked = e.target.checked);
                updateButton();
            });
            checkboxes.forEach(cb => cb.addEventListener('change', updateButton));

            deleteBtn?.addEventListener('click', async () => {
                const ids = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
                if (!ids.length || !confirm(`Delete ${ids.length} review(s)?`)) return;
                const res = await fetch("{{ route('admin.reviews.bulkDelete') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        ids
                    })
                });
                const data = await res.json();
                if (data.success) {
                    ids.forEach(id => document.querySelector(`tr[data-id="${id}"]`)?.remove());
                    deleteBtn.disabled = true;
                } else alert(data.message || 'Failed to delete reviews.');
            });

            // View modal with stars
            document.querySelectorAll('.viewReviewBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const r = JSON.parse(btn.dataset.review);
                    const stars = document.getElementById('modalStars');
                    stars.innerHTML = '';
                    for (let i = 1; i <= 5; i++) {
                        stars.innerHTML +=
                            `<i class="bi ${i <= r.rating ? 'bi-star-fill star' : 'bi-star text-muted'}"></i>`;
                    }
                    document.getElementById('modalProductImage').src = r.product?.primary_image
                        ?.image_path ?
                        `/storage/${r.product.primary_image.image_path}` :
                        '/images/no-image.png';
                    document.getElementById('modalProductName').innerText = r.product?.name || '-';
                    document.getElementById('modalReviewDate').innerText = new Date(r.created_at)
                        .toLocaleString();
                    document.getElementById('modalCustomerAvatar').src = r.customer?.profile_image ?
                        `/storage/${r.customer.profile_image}` :
                        '/storage/images/default-avatar.png';
                    document.getElementById('modalCustomerName').innerText =`${r.customer.name}`;
                    document.getElementById('modalEmail').innerText = r.customer.email;
                    document.getElementById('modalPhone').innerText = r.customer.phone || '-';
                    document.getElementById('modalComment').innerText = r.comment || '-';
                    document.getElementById('modalCreatedAt').innerText = new Date(r.created_at)
                        .toLocaleDateString();
                    document.getElementById('modalRatingValue').innerText = `${r.rating}/5`;
                    new bootstrap.Modal(document.getElementById('reviewModal')).show();
                });
            });
        });
    </script>
@endpush
