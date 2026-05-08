@extends('admin.layouts.admin')
@section('title', 'Review Details')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <h5 class="mb-0"><i class="bi bi-chat-quote me-2"></i> Review Details</h5>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <img src="{{ $review->product && $review->product->primaryImage
                            ? asset('storage/' . $review->product->primaryImage->image_path)
                            : asset('images/no-image.png') }}"
                            class="img-fluid rounded border mb-3" alt="Product">
                        <h5>{{ $review->product->name }}</h5>
                        <p class="text-muted small">{{ $review->product->slug }}</p>
                    </div>

                    <div class="col-md-8">
                        <h5>Customer Info</h5>
                        <p><strong>Name:</strong> {{ $review->customer->name }}</p>
                        <p><strong>Email:</strong> {{ $review->customer->email }}</p>
                        <p><strong>Phone:</strong> {{ $review->customer->phone ?? '-' }}</p>

                        <h5 class="mt-4">Review</h5>
                        <p><strong>Rating:</strong> <span class="badge bg-warning text-dark">{{ $review->rating }}/5</span>
                        </p>
                        <p>{{ $review->comment }}</p>
                        <p class="text-muted small"><i class="bi bi-clock"></i>
                            {{ $review->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
