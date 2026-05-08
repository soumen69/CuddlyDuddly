@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid py-4">

        <div class="mb-4">

            <h3 class="fw-bold mb-1">
                Product Image Upload
            </h3>

            <div class="text-muted small">
                Batch #{{ $batch->id }} committed successfully.
            </div>
        </div>

        <div class="row g-4">

            {{-- ZIP FLOW --}}
            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body d-flex flex-column">

                        <div class="mb-3">
                            <i class="bi bi-file-earmark-zip fs-1"></i>
                        </div>

                        <h5 class="fw-bold">
                            Upload Via ZIP
                        </h5>

                        <p class="text-muted small flex-grow-1">

                            Download structured image folders,
                            place images inside folders,
                            zip again and upload.

                        </p>

                        <a href="{{ route('admin.bulk.images.zip.template', $batch->id) }}" class="btn btn-dark mb-2">
                            Download ZIP Template
                        </a>

                        <form method="POST" action="{{ route('admin.bulk.images.zip.upload', $batch->id) }}"
                            enctype="multipart/form-data">

                            @csrf

                            <input type="file" name="zip" class="form-control mb-2" accept=".zip" required>

                            <button class="btn btn-primary w-100">
                                Upload ZIP
                            </button>

                        </form>

                    </div>
                </div>
            </div>

            {{-- MANUAL FLOW --}}
            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body d-flex flex-column">

                        <div class="mb-3">
                            <i class="bi bi-images fs-1"></i>
                        </div>

                        <h5 class="fw-bold">
                            Manual Upload
                        </h5>

                        <p class="text-muted small flex-grow-1">

                            Upload product and visual variant
                            images individually using drag/drop.

                        </p>

                        <a href="{{ route('admin.bulk.images.manual', $batch->id) }}" class="btn btn-success">
                            Start Manual Upload
                        </a>

                    </div>
                </div>
            </div>

            {{-- SKIP --}}
            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body d-flex flex-column">

                        <div class="mb-3">
                            <i class="bi bi-clock-history fs-1"></i>
                        </div>

                        <h5 class="fw-bold">
                            Skip For Now
                        </h5>

                        <p class="text-muted small flex-grow-1">

                            You can upload images later.
                            Products remain pending image completion.

                        </p>

                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            Continue Later
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
