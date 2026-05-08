@extends('admin.layouts.admin')

@section('title', 'Edit Category Grid')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="cms-edit-header">
            <div>
                <h1>Category Grid</h1>
                <p>Manage categories shown on the home page.</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">Cancel</a>
                <button form="categoryGridForm" class="btn-save">Save Changes</button>
            </div>
        </div>

        {{-- FORM --}}
        <form id="categoryGridForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                @foreach ($data as $i => $item)
                    <div class="col-lg-4">
                        <div class="cms-box h-100">

                            {{-- PRESERVE OLD IMAGE --}}
                            <input type="hidden" name="data[{{ $i }}][image]"
                                value="{{ $item['image'] ?? '' }}">

                            {{-- PREVIEW --}}
                            <img src="{{ asset($item['image']) }}" class="preview-image mb-3">

                            {{-- TITLE --}}
                            <label>Title</label>
                            <input type="text" name="data[{{ $i }}][title]" class="form-control mb-2"
                                value="{{ $item['title'] ?? '' }}">

                            {{-- URL --}}
                            <label>URL</label>
                            <input type="text" name="data[{{ $i }}][url]" class="form-control mb-3"
                                value="{{ $item['url'] ?? '' }}">

                            {{-- OPTIONAL NEW IMAGE --}}
                            <label>Replace Image</label>
                            <input type="file" name="category_image_{{ $i }}" class="form-control">
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
