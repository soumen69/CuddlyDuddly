@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid py-4">

        <div class="mb-4">

            <h4 class="fw-bold mb-1">
                Manual Product Image Upload
            </h4>

            <div class="small text-muted">
                Upload product and visual variant images.
            </div>
        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <form method="POST" action="{{ route('admin.bulk.images.manual.upload', $batchId) }}"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Select Product
                        </label>

                        <select name="product_id" class="form-select" required>

                            <option value="">
                                Select Product
                            </option>

                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">

                                    {{ $product->product_code }}
                                    -
                                    {{ $product->name }}

                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Upload Images
                        </label>

                        <input type="file" name="images[]" class="form-control" multiple required>

                        <div class="small text-muted mt-1">
                            Minimum 4 images required.
                        </div>
                    </div>

                    <button class="btn btn-dark">
                        Upload Images
                    </button>

                </form>

            </div>
        </div>
    </div>
@endsection
