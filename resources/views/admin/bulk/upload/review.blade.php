@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="fw-bold mb-1">
                    Batch Review #{{ $batchId }}
                </h4>

                <div class="small text-muted">
                    Review imported products before commit.
                </div>
            </div>
            @php

                $blockedProducts = $products->whereIn('status', ['pending_review', 'rejected'])->count();

            @endphp
            @if ($summary['product_errors'] + $summary['batch_errors'] === 0 && $blockedProducts === 0)
                <form method="POST" action="{{ route('admin.bulk.batch.commit', $batchId) }}">

                    @csrf

                    <button class="btn btn-success">
                        Queue Commit
                    </button>

                </form>
            @else
                <button class="btn btn-secondary" disabled>

                    Resolve Product Reviews Before Commit
                </button>
            @endif
        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="small text-muted">Products</div>
                        <div class="fs-3 fw-bold">
                            {{ $summary['products'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="small text-muted">Variants</div>
                        <div class="fs-3 fw-bold">
                            {{ $summary['variants'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="small text-muted">Errors</div>
                        <div class="fs-3 fw-bold text-danger">
                            {{ $summary['product_errors'] }} </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="small text-muted">
                            Batch Errors
                        </div>

                        <div class="fs-3 fw-bold text-warning">
                            {{ $summary['batch_errors'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Group</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Errors</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($products as $product)
                            @php
                                $compiled = json_decode($product->compiled_payload, true);
                                $errs = $errors[$product->product_code] ?? collect();
                            @endphp

                            <tr>

                                <td>
                                    {{ $product->product_code }}
                                </td>

                                <td>

                                    @php
                                        $badgeClass = match ($product->status) {
                                            'approved' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'compile_failed', 'validation_failed' => 'bg-danger',
                                            'pending_review' => 'bg-warning text-dark',
                                            default => 'bg-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                                    </span>

                                </td>

                                <td>
                                    {{ $compiled['product']['name'] ?? '-' }}
                                </td>

                                <td>
                                    {{ $product->category_name ?? '-' }}
                                </td>

                                <td>
                                    @if ($errs->count())
                                        <ul class="mb-0 small text-danger">
                                            @foreach ($errs as $e)
                                                <li>{{ $e->message }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-success small">
                                            No errors
                                        </span>
                                    @endif
                                </td>

                                <td>

                                    @if ($product->status === 'approved')
                                        <span class="badge bg-success">
                                            Approved
                                        </span>
                                    @elseif($product->status === 'rejected')
                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>
                                    @elseif($errs->count() || in_array($product->status, ['compile_failed', 'validation_failed']))
                                        <button class="btn btn-sm btn-secondary" disabled>

                                            Resolve Errors First

                                        </button>
                                    @else
                                        <div class="d-flex gap-2">

                                            <form method="POST"
                                                action="{{ route('admin.bulk.batch.approve', $product->id) }}">

                                                @csrf

                                                <button class="btn btn-sm btn-success">
                                                    Approve
                                                </button>

                                            </form>

                                            <button class="btn btn-sm btn-danger rejectBtn" data-id="{{ $product->id }}">

                                                Reject

                                            </button>

                                        </div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form method="POST" id="rejectForm">
                    @csrf

                    <div class="modal-header">
                        <h6 class="modal-title">
                            Reject Product
                        </h6>
                    </div>

                    <div class="modal-body">
                        <textarea name="reason" class="form-control" rows="4" placeholder="Enter rejection reason" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger">
                            Reject Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {

            const modal = new bootstrap.Modal(
                document.getElementById('rejectModal')
            );

            $('.rejectBtn').click(function() {

                let id = $(this).data('id');

                $('#rejectForm').attr(
                    'action',
                    `/admin/bulk/batch/${id}/reject`
                );

                modal.show();
            });
        });
    </script>
@endsection
