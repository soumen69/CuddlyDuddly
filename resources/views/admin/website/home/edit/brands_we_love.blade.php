@extends('admin.layouts.admin')

@section('title', 'Edit Brands We Love')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="cms-edit-header">
            <div>
                <h1>Brands We Love</h1>
                <p>Manage featured brand banners.</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">Cancel</a>
                <button form="brandsLoveForm" class="btn-save">Save Changes</button>
            </div>
        </div>

        {{-- FORM --}}
        <form id="brandsLoveForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                @foreach ($data ?? [] as $i => $brand)
                    <div class="col-lg-4">
                        <div class="cms-box h-100">

                            {{-- PRESERVE OLD IMAGE --}}
                            <input type="hidden" name="data[{{ $i }}][image]"
                                value="{{ $brand['image'] ?? '' }}">

                            {{-- PREVIEW --}}
                            <img src="{{ asset($brand['image']) }}" class="preview-image mb-3">

                            {{-- URL --}}
                            <label>Redirect URL</label>
                            <input type="text" name="data[{{ $i }}][url]" class="form-control mb-3"
                                value="{{ $brand['url'] ?? '' }}">

                            {{-- OPTIONAL NEW IMAGE --}}
                            <label>Replace Image</label>
                            <input type="file" name="brand_image_{{ $i }}" class="form-control">
                            <p class="hint">Leave empty to keep existing image.</p>

                        </div>
                    </div>
                @endforeach
            </div>

        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cms-editor.css') }}">
@endpush
