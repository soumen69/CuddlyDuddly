@extends('admin.layouts.admin')
@section('title', 'Wishlists')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">
    <style>
        /* ----------------------------------
                   KEEP: Avatar Images
                ---------------------------------- */
        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* ----------------------------------
                   KEEP: Wishlist Thumbnails
                ---------------------------------- */
        .thumb {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            transition: transform .2s ease;
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #f1f1f1;
        }

        .thumb:hover {
            transform: scale(1.05);
        }

        .thumb .remove {
            position: absolute;
            inset: 0;
            background: rgba(220, 53, 69, 0.75);
            color: #fff;
            border: none;
            opacity: 0;
            transition: opacity .2s;
            border-radius: 50%;
            font-size: .7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumb:hover .remove {
            opacity: 1;
            cursor: pointer;
        }

        /* ----------------------------------
                   KEEP: Stock Badges
                ---------------------------------- */
        .stock-badge {
            border-radius: 30px;
            padding: 2px 8px;
            font-size: .7rem;
            font-weight: 500;
        }

        .stock-in {
            background: #d1e7dd;
            color: #0f5132;
        }

        .stock-out {
            background: #f8d7da;
            color: #842029;
        }

        /* ----------------------------------
                   KEEP: Modal Product Thumb
                ---------------------------------- */
        .product-thumb {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* ----------------------------------
                   APPLY: Reviews Modal UI
                ---------------------------------- */
        .modal-header {
            background: linear-gradient(90deg, #0d6efd, #6610f2);
            color: #fff;
        }

        .modal-content {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
        }

        .btn-close-white {
            filter: brightness(0) invert(1);
        }
    </style>
@endpush


@section('content')
    <div class="container-fluid py-0 settings-wrapper products-page">

        <div class="settings-right">
            <div class="settings-right-inner">

                {{-- Header --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="settings-section-title mb-0">
                                <i class="bi bi-heart-fill text-danger me-2"></i> Wishlists
                                <div class="settings-section-subtitle">
                                    Manage wishlist items — search, view & delete.
                                </div>
                            </h3>

                            <span class="text-muted small">
                                Total Wishlist Items: <strong>{{ $total }}</strong>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Filters (Matches Products UI) --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2">
                        <form method="GET" action="{{ route('admin.wishlists.index') }}"
                            class="row g-2 align-items-center">

                            <div class="col-lg-10 col-md-5 col-12">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm" placeholder="Search customer or product...">
                            </div>

                            <div class="col-lg-2 col-md-3 col-12 text-end">
                                <button class="btn btn-sm btn-primary shadow-sm rounded-pill px-3 me-1">
                                    <i class="bi bi-search me-1"></i> Search
                                </button>

                                <a href="{{ route('admin.wishlists.index') }}"
                                    class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Bulk actions --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2 d-flex gap-2 flex-wrap">
                        {{-- We may add bulk delete in future --}}
                    </div>
                </div>

                {{-- Table --}}
                <div class="settings-section card">
                    <div class="card-body p-0">

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:54px;">#</th>
                                        <th>Customer</th>
                                        <th class="text-center">Wishlist Products</th>
                                        <th style="width:100px;" class="text-center">Count</th>
                                        <th class="text-end" style="width:90px;">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($wishlists as $userId => $items)
                                        @php $user = $items->first()->user; @endphp

                                        <tr data-user="{{ $userId }}">

                                            <td class="text-muted small">{{ $loop->iteration }}</td>

                                            {{-- Customer --}}
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('storage/images/default-avatar.png') }}"
                                                        class="avatar">

                                                    <div>
                                                        <strong class="small">{{ $user->name }}</strong>
                                                        <div class="text-muted small">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Wishlist Thumbnails --}}
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                                    @foreach ($items as $wishlist)
                                                        <div class="thumb"
                                                            data-name="{{ $wishlist->product->name ?? '' }}">
                                                            <button class="remove" data-id="{{ $wishlist->id }}">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                            <img
                                                                src="{{ $wishlist->product && $wishlist->product->primaryImage
                                                                    ? asset('storage/' . $wishlist->product->primaryImage->image_path)
                                                                    : asset('images/no-image.png') }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>

                                            {{-- Count --}}
                                            <td class="text-center">
                                                <span class="badge bg-primary rounded-pill px-2 py-1">
                                                    {{ $items->count() }}
                                                </span>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-end">

                                                @canAccess('admin.wishlists.show')
                                                <button class="btn btn-outline-primary btn-sm viewDetails"
                                                    data-user="{{ $userId }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @endcanAccess

                                                @canAccess('admin.wishlists.delete')
                                                <button class="btn btn-outline-danger btn-sm deleteAll"
                                                    data-user="{{ $userId }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                @endcanAccess

                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-heartbreak fs-4 d-block"></i>
                                                No wishlist data found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                {{-- Modal --}}
                <div class="modal fade" id="wishlistModal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="bi bi-person-heart me-2"></i> Customer Wishlist
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div id="wishlistDetails" class="table-responsive">
                                    <div class="text-center py-4 text-muted">Loading wishlist...</div>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <a id="fullPageLink" href="#" target="_blank" class="btn btn-outline-secondary">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Open full page
                                </a>

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
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
        document.addEventListener('DOMContentLoaded', () => {
            const csrf = '{{ csrf_token() }}';
            const modal = new bootstrap.Modal(document.getElementById('wishlistModal'));
            const detailsContainer = document.getElementById('wishlistDetails');
            const fullPageLink = document.getElementById('fullPageLink');

            /* ---------------------------------
               Remove single wishlist product
            --------------------------------- */
            document.querySelectorAll('.remove').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    const card = btn.closest('.thumb');
                    if (!confirm('Remove this product from wishlist?')) return;

                    const res = await fetch(`/admin/wishlists/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        }
                    });
                    const data = await res.json();
                    if (data.success) card.remove();
                });
            });

            /* ---------------------------------
               Delete ALL items for a user
            --------------------------------- */
            document.querySelectorAll('.deleteAll').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const row = btn.closest('tr');
                    const userId = btn.dataset.user;

                    if (!confirm('Delete all wishlist items for this user?')) return;

                    const ids = [...row.querySelectorAll('.remove')].map(b => b.dataset.id);

                    const res = await fetch("{{ route('admin.wishlists.bulkDelete') }}", {
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
                    if (data.success) row.remove();
                });
            });

            /* ---------------------------------
               View wishlist in modal
            --------------------------------- */
            document.querySelectorAll('.viewDetails').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const userId = btn.dataset.user;

                    detailsContainer.innerHTML =
                        `<div class="text-center py-4 text-muted">Loading wishlist...</div>`;

                    fullPageLink.href = `/admin/wishlists/${userId}`;

                    modal.show();

                    const res = await fetch(`/admin/wishlists/${userId}`, {
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await res.json();

                    if (!data.success || !data.wishlist.length) {
                        detailsContainer.innerHTML =
                            `<div class="text-center py-4 text-muted"><i class="bi bi-heartbreak me-2"></i>No wishlist items found.</div>`;
                        return;
                    }

                    let html = `
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Date Added</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>`;

                    data.wishlist.forEach((item, i) => {
                        html += `
                    <tr>
                        <td>${i + 1}</td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="${item.image}" class="product-thumb">
                                <span>${item.name}</span>
                            </div>
                        </td>

                        <td>₹${item.price}</td>

                        <td>
                            <span class="stock-badge ${item.in_stock ? 'stock-in' : 'stock-out'}">
                                ${item.in_stock ? 'In Stock' : 'Out of Stock'}
                            </span>
                        </td>

                        <td>${item.date}</td>

                        <td class="text-end">
                            <button class="btn btn-outline-danger btn-sm removeWishlist" data-id="${item.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    });

                    html += `</tbody></table>`;

                    detailsContainer.innerHTML = html;
                });
            });
        });
    </script>
@endpush
