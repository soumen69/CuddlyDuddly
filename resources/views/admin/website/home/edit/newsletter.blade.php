@extends('admin.layouts.admin')

@section('title', 'Edit Newsletter')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="cms-edit-header">
            <div>
                <h1>Newsletter Section</h1>
                <p>Email capture banner shown near footer.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">Cancel</a>
                <button form="newsletterForm" class="btn-save">Save Changes</button>
            </div>
        </div>

        {{-- FORM --}}
        <form id="newsletterForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">

                {{-- TEXT COLUMN --}}
                <div class="col-lg-6">
                    <div class="cms-box">

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

                {{-- IMAGE COLUMN --}}
                <div class="col-lg-6">
                    <div class="cms-box">

                        {{-- PRESERVE OLD BACKGROUND --}}
                        @if (!empty($data['background']))
                            <input type="hidden" name="data[background]" value="{{ $data['background'] }}">
                        @endif

                        <label>Background Image</label>

                        {{-- PREVIEW --}}
                        <div class="text-center mb-2">
                            @if (!empty($data['background']))
                                <img src="{{ asset($data['background']) }}" class="preview-image">
                            @else
                                <p class="text-muted small">No background uploaded</p>
                            @endif
                        </div>

                        {{-- OPTIONAL NEW IMAGE --}}
                        <input type="file" name="newsletter_background" class="form-control">
                        <p class="hint">Leave empty to keep existing image.</p>

                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cms-editor.css') }}">
@endpush
