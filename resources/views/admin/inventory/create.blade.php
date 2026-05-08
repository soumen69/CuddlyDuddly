@extends('admin.layouts.admin')

@section('title', 'Add Inventory')

@section('content')
    <div class="container-fluid px-2 px-md-3 py-2">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h5 class="fw-semibold text-primary mb-3">
                    <i class="bi bi-plus-circle me-2"></i> Add Inventory
                </h5>
                <form action="{{ route('admin.inventory.store') }}" method="POST">
                    @csrf
                    @include('admin.inventory._form')
                </form>
            </div>
        </div>
    </div>
@endsection
