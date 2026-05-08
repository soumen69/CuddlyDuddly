@extends('admin.layouts.admin')
@section('title', 'Add Review')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h5 class="mb-0"><i class="bi bi-star me-2"></i> Add New Review</h5>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <form action="{{ route('admin.reviews.store') }}" method="POST" class="p-4">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Customer</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Product</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-select" required>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Comment</label>
                        <textarea name="comment" rows="3" class="form-control" placeholder="Write review..."></textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-lg me-1"></i> Save Review
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
