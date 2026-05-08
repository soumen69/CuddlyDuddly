@extends('admin.layouts.admin')

@section('title', 'Edit Brand Logos')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="cms-edit-header">
            <div>
                <h1>Brand Logos</h1>
                <p>Manage brand logos displayed on the homepage.</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">Cancel</a>
                <button form="brandLogosForm" class="btn-save">Save Changes</button>
            </div>
        </div>

        {{-- FORM --}}
        <form id="brandLogosForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="cms-box">
                <h3>Brand Logos</h3>

                <div class="cms-image-grid">
                    @foreach ($data ?? [] as $i => $logo)
                        <div>

                            {{-- PRESERVE OLD --}}
                            <input type="hidden" name="data[{{ $i }}]" value="{{ $logo ?? '' }}">

                            {{-- PREVIEW --}}
                            <img src="{{ asset($logo) }}" class="preview-thumb mb-2">

                            {{-- OPTIONAL REPLACE --}}
                            <input type="file" name="brand_logo_{{ $i }}" class="form-control">
                            <p class="hint">Leave empty to keep existing logo.</p>

                        </div>
                    @endforeach
                </div>
            </div>

        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cms-editor.css') }}">
@endpush
