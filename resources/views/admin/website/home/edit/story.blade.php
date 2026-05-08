@extends('admin.layouts.admin')

@section('title', 'Edit Our Story')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="cms-edit-header">
            <div>
                <h1>Our Story</h1>
                <p>Edit the brand story section shown on the home page.</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">Cancel</a>
                <button form="storyForm" class="btn-save">Save Changes</button>
            </div>
        </div>

        {{-- FORM --}}
        <form id="storyForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- IMAGE COLUMN --}}
                <div class="col-lg-6">
                    <div class="cms-box">

                        {{-- PRESERVE OLD IMAGE --}}
                        @if (!empty($data['image']))
                            <input type="hidden" name="data[image]" value="{{ $data['image'] }}">
                        @endif

                        {{-- PREVIEW --}}
                        <label>Current Image</label>
                        <div class="text-center mb-3">
                            @if (!empty($data['image']))
                                <img src="{{ asset($data['image']) }}" class="preview-image">
                            @else
                                <p class="text-muted small">No image uploaded yet</p>
                            @endif
                        </div>

                        {{-- NEW IMAGE --}}
                        <input type="file" name="image" class="form-control mb-3">
                        <p class="hint">Leave empty to keep existing image.</p>

                    </div>
                </div>

                {{-- TEXT COLUMN --}}
                <div class="col-lg-6">
                    <div class="cms-box">
                        <label>Story Text</label>
                        <textarea name="data[text]" rows="10" class="form-control" required>{{ $data['text'] ?? '' }}</textarea>
                    </div>
                </div>

            </div>

        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cms-editor.css') }}">
@endpush
