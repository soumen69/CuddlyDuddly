@extends('admin.layouts.admin')

@section('title', 'Manage Inventory')

@section('content')
    <div class="container-fluid px-2 px-md-3 py-2">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-semibold text-primary">
                <i class="bi bi-box-seam me-2"></i> Inventory
            </h4>
            <a href="{{ route('admin.inventory.create') }}" class="btn btn-gradient-primary btn-sm shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Add Inventory
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body bg-light rounded-4">
                <form method="GET" class="row gy-2 gx-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted small">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm shadow-sm" placeholder="Search by Product / SKU">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-muted small">Seller</label>
                        <select name="seller_id" class="form-select form-select-sm shadow-sm">
                            <option value="">All Sellers</option>
                            @foreach ($sellers as $seller)
                                <option value="{{ $seller->id }}"
                                    {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                    {{ $seller->name ?? $seller->contact_person }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-muted small">Status</label>
                        <select name="status" class="form-select form-select-sm shadow-sm">
                            <option value="">All</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 text-end">
                        <button class="btn btn-sm btn-primary shadow-sm rounded-pill px-3">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.inventory.index') }}"
                            class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="card border-0 shadow-lg rounded-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Seller</th>
                            <th>Quantity</th>
                            <th>Reserved</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Updated</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventories as $inventory)
                            <tr class="border-bottom">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($inventory->product && $inventory->product->primaryImage)
                                            <img src="{{ asset('storage/' . $inventory->product->primaryImage->image_path) }}"
                                                alt="Product" class="rounded me-2"
                                                style="width:45px;height:45px;object-fit:cover;">
                                        @else
                                            <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center me-2"
                                                style="width:45px;height:45px;">
                                                <i class="bi bi-box"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $inventory->product->name ?? '—' }}</div>
                                            <small
                                                class="text-muted">{{ $inventory->product->category->name ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><code>{{ $inventory->sku }}</code></td>
                                <td>{{ $inventory->seller->name ?? ($inventory->seller->contact_person ?? '—') }}</td>
                                <td>
                                    <span
                                        class="fw-semibold {{ $inventory->quantity <= $inventory->min_stock ? 'text-danger' : 'text-success' }}">
                                        {{ $inventory->quantity }}
                                    </span>
                                </td>
                                <td>{{ $inventory->reserved_quantity }}</td>
                                <td>₹{{ number_format($inventory->price, 2) }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill bg-{{ $inventory->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($inventory->status) }}
                                    </span>
                                </td>
                                <td>{{ $inventory->updated_at->format('d M, Y') }}</td>

                                <!-- Actions -->
                                <td class="text-end">
                                    <a href="{{ route('admin.inventory.show', $inventory->id) }}"
                                        class="btn btn-outline-info btn-sm rounded-pill shadow-sm me-1"
                                        title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.inventory.edit', $inventory->id) }}"
                                        class="btn btn-outline-primary btn-sm rounded-pill shadow-sm me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button"
                                        class="btn btn-outline-warning btn-sm rounded-pill shadow-sm me-1 adjust-stock-btn"
                                        data-id="{{ $inventory->id }}" title="Adjust Stock">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>

                                    <form action="{{ route('admin.inventory.destroy', $inventory->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm rounded-pill shadow-sm delete-btn"
                                            type="submit" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">No inventory records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($inventories && $inventories->hasPages())
                <div class="card-footer">
                    {{ $inventories->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Adjust Stock Modal -->
    <div class="modal fade" id="adjustStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="adjustStockForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adjust Inventory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="inventory_id">

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label small">Current Qty</label>
                                <input type="number" id="current_quantity" class="form-control form-control-sm" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label small">Reserved Qty</label>
                                <input type="number" id="current_reserved" class="form-control form-control-sm"
                                    readonly>
                            </div>
                        </div>

                        <!-- Action & Quantity Row -->
                        <div class="row g-2 mb-2 align-items-end">
                            <div class="col-6">
                                <label class="form-label small">Action</label>
                                <select id="adjust_action" class="form-select form-select-sm" required>
                                    <option value="added">Add Stock</option>
                                    <option value="removed">Remove Stock</option>
                                    <option value="reserve">Reserve Stock</option>
                                    <option value="release">Release Reserved</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small">Quantity</label>
                                <input type="number" id="adjust_quantity" name="quantity"
                                    class="form-control form-control-sm" min="1" required>
                            </div>
                        </div>

                        <!-- Remarks Row -->
                        <div class="mb-2">
                            <label class="form-label small">Remarks</label>
                            <textarea id="adjust_remarks" name="remarks" class="form-control form-control-sm" rows="3"
                                placeholder="Optional remarks"></textarea>
                        </div>

                        <div id="adjust_error" class="text-danger small mt-1"></div>
                    </div>

                    <div class="modal-footer py-2">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .btn-gradient-primary {
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: #fff;
            border: none;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #0284c7);
            color: #fff;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/inventory-index.js') }}"></script>
@endpush
