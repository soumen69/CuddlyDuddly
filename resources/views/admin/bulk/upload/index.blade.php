@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    Bulk Catalog Upload
                </h5>
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('admin.bulk.upload.process') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Upload Excel File
                        </label>

                        <input type="file" name="excel" class="form-control" accept=".xlsx,.xls" required>
                    </div>

                    {{--
                    IMPORTANT:
                    config[] should later come from
                    actual wizard payload persistence.
                --}}

                    <input type="hidden" name="config[categories][]" value="1">
                    <input type="hidden" name="config[brand_mode]" value="multiple">
                    <input type="hidden" name="config[volume]" value="100">

                    <button class="btn btn-primary">
                        Process Upload
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
