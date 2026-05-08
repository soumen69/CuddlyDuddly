@extends('seller.layouts.seller')

@section('title', 'Product Details')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Product Details</h4>
            <a href="{{ route('seller.products.index', $seller->slug) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-4">
                    <!-- Product Images -->
                    <div class="col-md-5 text-center">
                        @if ($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                class="img-fluid rounded shadow-sm mb-2" alt="{{ $product->name }}">
                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                @foreach ($product->images as $img)
                                    <img src="{{ asset('storage/' . $img->image_path) }}" class="img-thumbnail rounded"
                                        style="width: 60px; height: 60px; object-fit: cover;" alt="">
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small">No images uploaded for this product.</p>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-7">
                        <h5 class="fw-bold mb-2">{{ $product->name }}</h5>
                        <p class="text-muted small mb-3">{{ $product->description ?: 'No description available.' }}</p>

                        <p><strong>Price:</strong> ₹{{ number_format($product->price, 2) }}</p>
                        <p><strong>Stock:</strong> {{ $product->stock }}</p>
                        <p><strong>Category Chain:</strong><br>
                            @forelse ($product->categorySections as $sec)
                                <small class="text-muted d-block">
                                    {{ $sec->masterCategory->name ?? '' }} →
                                    {{ $sec->sectionType->name ?? '' }} →
                                    {{ $sec->category->name ?? '' }}
                                </small>
                            @empty
                                <small class="text-muted">No categories assigned.</small>
                            @endforelse
                        </p>

                        <p>
                            <strong>Status:</strong>
                            @if ($product->is_approved)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending Approval</span>
                            @endif
                        </p>

                        <!-- Action Buttons -->
                        <div class="mt-3 d-flex gap-2">
                            @if (!$product->is_approved)
                                <a href="{{ route('seller.products.edit', [$seller->slug, $product->id]) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            @endif
                            <form action="{{ route('seller.products.destroy', [$seller->slug, $product->id]) }}"
                                method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Meta Info -->
                <div class="row text-muted small">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Created At:</strong> {{ $product->created_at->format('d M Y, h:i A') }}
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Last Updated:</strong> {{ $product->updated_at->format('d M Y, h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection