@extends('admin.layouts.admin')

@section('title', 'Edit Promo Section')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="cms-edit-header">
            <div>
                <h1>Promo Banner</h1>
                <p>Edit the promotional banner shown on the home page.</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">Cancel</a>
                <button form="promoForm" class="btn-save">Save Changes</button>
            </div>
        </div>

        {{-- FORM --}}
        <form id="promoForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- IMAGE COLUMN --}}
                <div class="col-lg-6">
                    <div class="cms-box">

                        {{-- PRESERVE OLD IMAGE --}}
                        <input type="hidden" name="data[image]" value="{{ $data['image'] ?? '' }}">

                        <h3>Background Image</h3>

                        {{-- PREVIEW --}}
                        <div class="text-center mb-3">
                            @if (!empty($data['image']))
                                <img src="{{ asset($data['image']) }}" class="preview-image">
                            @else
                                <p class="text-muted small">No image uploaded</p>
                            @endif
                        </div>

                        {{-- OPTIONAL NEW IMAGE --}}
                        <input type="file" name="promo_image" class="form-control">
                        <p class="hint">Leave empty to keep existing image.</p>

                    </div>
                </div>

                {{-- TEXT COLUMN --}}
                <div class="col-lg-6">
                    <div class="cms-box">
                        <h3>Content</h3>

                        <label>Title</label>
                        <input type="text" name="data[title]" class="form-control mb-2"
                            value="{{ $data['title'] ?? '' }}">

                        <label>Subtitle</label>
                        <input type="text" name="data[subtitle]" class="form-control mb-2"
                            value="{{ $data['subtitle'] ?? '' }}">

                        <label>CTA Text</label>
                        <input type="text" name="data[cta_text]" class="form-control mb-2"
                            value="{{ $data['cta_text'] ?? '' }}">

                        <label>CTA URL</label>
                        <input type="text" name="data[cta_url]" class="form-control"
                            value="{{ $data['cta_url'] ?? '' }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cms-editor.css') }}">
@endpush
