@extends('admin.layouts.admin')

@section('title', 'Edit Inventory')

@section('content')
    <div class="container-fluid px-2 px-md-3 py-2">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h5 class="fw-semibold text-primary mb-3">
                    <i class="bi bi-pencil-square me-2"></i> Edit Inventory
                </h5>
                <form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.inventory._form')
                </form>
            </div>
        </div>
    </div>
@endsection
