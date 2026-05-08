@extends('admin.layouts.admin')

@section('title', 'Inventory Details')

@section('content')
    <div class="container-fluid px-2 px-md-3 py-2">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h5 class="fw-semibold text-primary mb-3">
                    <i class="bi bi-eye me-2"></i> Inventory Details
                </h5>

                <dl class="row mb-0">
                    <dt class="col-sm-3">Product</dt>
                    <dd class="col-sm-9">{{ $inventory->product->name ?? '-' }}</dd>

                    <dt class="col-sm-3">Seller</dt>
                    <dd class="col-sm-9">{{ $inventory->seller->name ?? '-' }}</dd>

                    <dt class="col-sm-3">SKU</dt>
                    <dd class="col-sm-9"><code>{{ $inventory->sku }}</code></dd>

                    <dt class="col-sm-3">Quantity</dt>
                    <dd class="col-sm-9">{{ $inventory->quantity }}</dd>

                    <dt class="col-sm-3">Reserved</dt>
                    <dd class="col-sm-9">{{ $inventory->reserved_quantity }}</dd>

                    <dt class="col-sm-3">Price</dt>
                    <dd class="col-sm-9">₹{{ number_format($inventory->price, 2) }}</dd>

                    <dt class="col-sm-3">Warehouse</dt>
                    <dd class="col-sm-9">{{ $inventory->warehouse_location ?? '-' }}</dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-{{ $inventory->status == 'in_stock' ? 'success' : 'secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $inventory->status)) }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Last Updated</dt>
                    <dd class="col-sm-9">{{ $inventory->updated_at->format('d M, Y') }}</dd>
                </dl>

                <div class="text-end mt-4">
                    <a href="{{ route('admin.inventory.edit', $inventory->id) }}"
                        class="btn btn-outline-primary rounded-pill shadow-sm me-2">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('admin.inventory.index') }}"
                        class="btn btn-outline-secondary rounded-pill shadow-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
