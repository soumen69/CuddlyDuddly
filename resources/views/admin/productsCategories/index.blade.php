@extends('admin.layouts.admin')

@section('title', 'Product Categories')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">

    <div class="settings-right-inner">

        {{-- Header Section --}}
        <div class="settings-section card mb-2">
            <div class="card-body py-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="settings-section-title mb-0">
                        <i class="bi bi-diagram-3 me-2"></i> Product Categories
                        <div class="settings-section-subtitle">
                            Define product types and manage their attribute structure.
                        </div>
                    </h3>

                    <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary btn-sm shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> New Category
                    </a>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">

                <div class="p-3 d-flex justify-content-between align-items-center">
                    <div></div>
                    <div class="text-muted small">
                        Showing {{ $categories->firstItem() ?? 0 }}
                        to {{ $categories->lastItem() ?? 0 }}
                        of {{ $categories->total() }} categories
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">#</th>
                                <th><i class="bi bi-tag me-1"></i> Category</th>
                                <th><i class="bi bi-list-check me-1"></i> Attributes</th>
                                <th><i class="bi bi-check-circle me-1"></i> Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $category->name }}
                                        </div>
                                        <small class="text-muted">
                                            Slug: {{ $category->slug }}
                                        </small>
                                    </td>

                                    <td>
                                        @php
                                            $count = $category->attributes->count();
                                        @endphp

                                        @if ($count > 0)
                                            <span class="badge bg-info text-dark">
                                                {{ $count }} Attributes
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                No Attributes
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($category->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        {{-- <div class="d-inline-flex align-items-center">
                                            <a href="{{ route('admin.product-categories.edit', $category) }}"
                                                class="btn btn-sm btn-outline-warning me-1">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('admin.product-categories.destroy', $category) }}"
                                                method="POST" onsubmit="return confirm('Delete this category?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div> --}}
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.product-categories.show', $category) }}">
                                                        <i class="bi bi-eye me-1"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.product-categories.edit', $category) }}">
                                                        <i class="bi bi-pencil me-1"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.product-categories.destroy', $category) }}"
                                                        method="POST" onsubmit="return confirm('Delete this category?')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-exclamation-circle me-2"></i>
                                        No product categories found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-2">
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>

@endsection
