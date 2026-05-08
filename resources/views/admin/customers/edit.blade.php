@extends('admin.layouts.admin')

@section('title', 'Edit Customer')

@section('content')
    <div class="container">
        <h2><i class="bi bi-pencil-square"></i> Edit Customer</h2>

        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input name="name" class="form-control" value="{{ old('name', $customer->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control"
                                    value="{{ old('email', $customer->email) }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select id="gender" name="gender" required class="form-select">
                                    <option value="">-- Select Gender --</option>
                                    <option value="male"
                                        {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female"
                                        {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other"
                                        {{ old('gender', $customer->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- DOB -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date Of Birth</label>
                                <input id="dob" type="date" name="dob"
                                    value="{{ old('dob', optional($customer->dob)->format('Y-m-d')) }}"
                                    class="form-control" required>
                                @error('dob')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 text-end">
                        <button class="btn btn-success">
                            <i class="bi bi-check-lg"></i> Update
                        </button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
