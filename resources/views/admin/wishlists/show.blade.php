@extends('admin.layouts.admin')
@section('title', 'Customer Wishlist')

@push('styles')
    <style>
        .wishlist-table th {
            background: #f8f9fa;
            text-transform: uppercase;
            font-size: .8rem;
        }

        .wishlist-table td {
            vertical-align: middle;
        }

        .product-thumb {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

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
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="bi bi-person-heart me-2"></i> {{ $user->name }}’s Wishlist</h2>
                <p class="text-muted mb-0">{{ $user->email }}</p>
            </div>
            <a href="{{ route('admin.wishlists.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                @if ($wishlists->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-heartbreak me-2"></i> No wishlist items found for this customer.
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span><strong>{{ $total }}</strong> item{{ $total > 1 ? 's' : '' }} in wishlist</span>
                        <button class="btn btn-outline-danger btn-sm" id="deleteAllUserWishlist"
                            data-user="{{ $user->id }}">
                            <i class="bi bi-trash"></i> Delete All
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table wishlist-table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Added On</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wishlists as $wishlist)
                                    <tr data-id="{{ $wishlist->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $wishlist->product && $wishlist->product->primaryImage
                                                    ? asset('storage/' . $wishlist->product->primaryImage->image_path)
                                                    : asset('images/no-image.png') }}"
                                                    class="product-thumb" alt="Product">
                                                <div>
                                                    <strong>{{ $wishlist->product->name ?? 'Unknown Product' }}</strong><br>
                                                    <small
                                                        class="text-muted">#{{ $wishlist->product->id ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>₹{{ number_format($wishlist->product->price ?? 0, 2) }}</td>
                                        <td>
                                            <span
                                                class="stock-badge {{ ($wishlist->product->stock ?? 0) > 0 ? 'stock-in' : 'stock-out' }}">
                                                {{ ($wishlist->product->stock ?? 0) > 0 ? 'In Stock' : 'Out of Stock' }}
                                            </span>
                                        </td>
                                        <td>{{ $wishlist->created_at->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-outline-danger btn-sm deleteSingleWishlist"
                                                data-id="{{ $wishlist->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrf = '{{ csrf_token() }}';

            // Delete single wishlist
            document.querySelectorAll('.deleteSingleWishlist').forEach(btn => {
                btn.addEventListener('click', async () => {
                    if (!confirm('Remove this product from wishlist?')) return;
                    const id = btn.dataset.id;
                    const row = btn.closest('tr');
                    const res = await fetch(`/admin/wishlists/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        }
                    });
                    const data = await res.json();
                    if (data.success) row.remove();
                });
            });

            // Delete all wishlist items for user
            document.getElementById('deleteAllUserWishlist')?.addEventListener('click', async (e) => {
                if (!confirm('Delete all wishlist items for this user?')) return;
                const userId = e.target.dataset.user;
                const ids = [...document.querySelectorAll('.deleteSingleWishlist')].map(b => b.dataset
                    .id);
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
                if (data.success) location.reload();
            });
        });
    </script>
@endpush
