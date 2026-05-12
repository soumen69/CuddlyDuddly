{{-- resources/views/admin/bulk/upload/batches.blade.php --}}

@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid py-3">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="fw-bold mb-1">
                    Bulk Upload History
                </h4>

                <div class="small text-muted">
                    Monitor uploaded batches, validation status and commit progress.
                </div>
            </div>

            <a href="{{ route('admin.bulk.upload.index') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-upload me-1"></i>
                Upload New Excel
            </a>
        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body border-bottom py-2">

                <form method="GET">

                    <div class="row g-2">

                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Batch ID / Seller" value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm">

                                <option value="">
                                    All Status
                                </option>

                                <option value="review_required" @selected(request('status') == 'review_required')>
                                    Review Required
                                </option>

                                <option value="ready_for_commit" @selected(request('status') == 'ready_for_commit')>
                                    Ready For Commit
                                </option>

                                <option value="queued" @selected(request('status') == 'queued')>
                                    Queued
                                </option>

                                <option value="partially_committed" @selected(request('status') == 'partially_committed')>
                                    Partially Committed
                                </option>

                                <option value="committed" @selected(request('status') == 'committed')>
                                    Committed
                                </option>

                                <option value="commit_failed" @selected(request('status') == 'commit_failed')>
                                    Commit Failed
                                </option>

                                <option value="image_upload_pending" @selected(request('status') == 'image_upload_pending')>
                                    Image Upload Pending
                                </option>

                                <option value="image_upload_in_progress" @selected(request('status') == 'image_upload_in_progress')>
                                    Image Upload In Progress
                                </option>

                                <option value="image_completed" @selected(request('status') == 'image_completed')>
                                    Image Completed
                                </option>

                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-dark btn-sm w-100">
                                <i class="bi bi-search me-1"></i>
                                Filter
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#Batch</th>
                            <th>Seller</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Approved</th>
                            <th>Failed</th>
                            <th>Errors</th>
                            <th>Created</th>
                            <th width="220">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($batches as $batch)
                            <tr>

                                <td>
                                    <span class="fw-semibold">
                                        #{{ $batch->id }}
                                    </span>
                                </td>

                                <td>

                                    @if ($batch->seller_name)
                                        {{ $batch->seller_name }}
                                    @else
                                        <span class="text-muted">
                                            Unknown Seller
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    @php
                                        $statusClass = match ($batch->status) {
                                            'review_required' => 'warning',
                                            'ready_for_commit' => 'dark',
                                            'queued' => 'primary',
                                            'partially_committed' => 'info',
                                            'committed' => 'success',
                                            'commit_failed' => 'danger',
                                            'image_upload_pending' => 'warning',
                                            'image_upload_in_progress' => 'info',
                                            'image_completed' => 'success',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $batch->status)) }}
                                    </span>

                                </td>

                                <td>
                                    {{ $batch->total_products }}
                                </td>

                                <td>
                                    <span class="text-success fw-semibold">
                                        {{ $batch->approved_products }}
                                    </span>
                                </td>

                                <td>
                                    <span class="text-danger fw-semibold">
                                        {{ $batch->failed_products }}
                                    </span>
                                </td>

                                <td>

                                    @if ($batch->total_errors > 0)
                                        <span class="text-danger fw-semibold">
                                            {{ $batch->total_errors }}
                                        </span>
                                    @else
                                        <span class="text-success">
                                            0
                                        </span>
                                    @endif

                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($batch->created_at)->format('d M Y h:i A') }} </td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        {{-- REVIEW --}}
                                        <a href="{{ route('admin.bulk.batch.review', $batch->id) }}"
                                            class="btn btn-sm btn-dark">
                                            <i class="bi bi-eye me-1"></i>
                                            Review
                                        </a>
                                        {{-- IMAGE FLOW --}}
                                        @if (in_array($batch->status, ['image_upload_pending', 'image_upload_in_progress']))
                                            <a href="{{ route('admin.bulk.images.gateway', $batch->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-images me-1"></i>
                                                {{ $batch->status === 'image_upload_pending' ? 'Upload Images' : 'Resume Images' }}
                                            </a>
                                        @endif
                                        {{-- COMPLETED --}}
                                        @if ($batch->status === 'image_completed')
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Completed
                                            </span>
                                        @endif
                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9">

                                    <div class="text-center py-5">

                                        <div class="mb-2">
                                            <i class="bi bi-inbox fs-1 text-muted"></i>
                                        </div>

                                        <div class="fw-semibold">
                                            No Bulk Upload Batches Found
                                        </div>

                                        <div class="small text-muted">
                                            Upload your first Excel catalog to begin ingestion.
                                        </div>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            @if (method_exists($batches, 'links'))
                <div class="card-footer bg-white">

                    {{ $batches->links() }}

                </div>
            @endif

        </div>

    </div>
@endsection
