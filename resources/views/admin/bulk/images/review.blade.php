@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1">
                    Image Review
                </h4>

                <div class="small text-muted">
                    Review staged images before commit.
                </div>
            </div>

            <form method="POST" action="{{ route('admin.bulk.images.commit', $batchId) }}">

                @csrf

                <button class="btn btn-success">

                    Commit Images

                </button>
            </form>
        </div>

        <div class="card border-0 shadow-sm">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>Preview</th>

                            <th>Product</th>

                            <th>Type</th>

                            <th>Primary</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($images as $image)
                            <tr>

                                <td width="100">

                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        class="img-fluid rounded border">

                                </td>

                                <td>

                                    {{ $image->product_code }}

                                </td>

                                <td>

                                    {{ ucfirst($image->image_type) }}

                                </td>

                                <td>

                                    @if ($image->is_primary)
                                        <span class="badge bg-success">

                                            Primary

                                        </span>
                                    @endif

                                </td>

                                <td>

                                    <span class="badge bg-warning text-dark">

                                        {{ ucfirst(str_replace('_', ' ', $image->status)) }}

                                    </span>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>
    </div>
@endsection
