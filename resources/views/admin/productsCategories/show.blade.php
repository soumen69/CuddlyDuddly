@extends('admin.layouts.admin')

@section('title', 'View Product Category')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">
    @endpush

    <div class="settings-right-inner">

        {{-- Header --}}
        <div class="settings-section card mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">

                <div>
                    <h3 class="settings-section-title mb-0">
                        <i class="bi bi-diagram-3 me-2"></i>
                        {{ $category->name }}
                    </h3>

                    <div class="settings-section-subtitle">
                        Category Structure Overview
                    </div>
                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('admin.product-categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    <a href="{{ route('admin.product-categories.index') }}" class="btn btn-sm btn-secondary">
                        Back
                    </a>

                </div>

            </div>
        </div>


        <div class="row g-3">

            {{-- LEFT SIDE --}}
            <div class="col-lg-4">

                {{-- Category Info --}}
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">

                        <h6 class="mb-3">Category Details</h6>

                        <table class="table table-sm mb-0">

                            <tr>
                                <th width="40%">Name</th>
                                <td>{{ $category->name }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($category->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Slug</th>
                                <td class="text-muted">{{ $category->slug }}</td>
                            </tr>

                        </table>

                    </div>
                </div>


                {{-- Sub Categories --}}
                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="mb-3">Sub Categories</h6>

                        @if ($category->subCategories->isEmpty())

                            <p class="text-muted small mb-0">
                                No sub categories added.
                            </p>
                        @else
                            <div class="d-flex flex-wrap gap-2">

                                @foreach ($category->subCategories as $sub)
                                    <span class="badge bg-light border text-dark px-3 py-2">
                                        {{ $sub->name }}
                                    </span>
                                @endforeach

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- RIGHT SIDE --}}
            <div class="col-lg-8">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="mb-3">Attributes</h6>

                        @if ($category->attributes->isEmpty())

                            <p class="text-muted small mb-0">
                                No attributes configured for this category.
                            </p>
                        @else
                            @foreach ($category->attributes as $map)
                                @php $attr = $map->attribute; @endphp

                                <div class="border rounded p-3 mb-2 bg-white">

                                    <div class="d-flex justify-content-between align-items-start">

                                        <div>

                                            <strong>{{ $attr->name }}</strong>

                                            <small class="text-muted ms-2">
                                                ({{ $attr->input_type }})
                                            </small>

                                            @if ($attr->is_filterable)
                                                <span class="badge bg-info ms-2">Filter</span>
                                            @endif

                                            @if ($attr->is_variant)
                                                <span class="badge bg-warning ms-1">Variant</span>
                                            @endif

                                            {{-- Values --}}
                                            <div class="mt-2">

                                                @if ($attr->values->isEmpty())
                                                    <small class="text-muted">
                                                        No predefined values
                                                    </small>
                                                @else
                                                    @foreach ($attr->values as $value)
                                                        <span class="badge bg-light border text-dark me-1">
                                                            {{ $value->value }}
                                                        </span>
                                                    @endforeach
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
