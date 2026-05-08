@extends('admin.layouts.admin')

@section('title', 'Edit Trust Icons')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="cms-edit-header">
            <div>
                <h1>Trust Icons</h1>
                <p>Edit the trust highlights shown on the home page.</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">
                    Cancel
                </a>
                <button form="trustIconsForm" class="btn-save">
                    Save Changes
                </button>
            </div>
        </div>

        {{-- FORM --}}
        <form id="trustIconsForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                @foreach ($data as $i => $item)
                    <div class="col-lg-4">
                        <div class="cms-box">

                            {{-- PRESERVE OLD ICON --}}
                            <input type="hidden" name="data[{{ $i }}][icon]" value="{{ $item['icon'] ?? '' }}">

                            {{-- PREVIEW --}}
                            <div class="text-center mb-3">
                                @if (!empty($item['icon']))
                                    <img src="{{ asset($item['icon']) }}" style="height:48px">
                                @else
                                    <p class="text-muted small">No icon</p>
                                @endif
                            </div>

                            {{-- OPTIONAL NEW ICON --}}
                            <label class="form-label">Change Icon</label>
                            <input type="file" name="icon_{{ $i }}" class="form-control mb-3">
                            <small class="text-muted d-block mb-3">
                                Leave empty to keep existing icon
                            </small>

                            {{-- TEXT --}}
                            <label class="form-label">Text</label>
                            <input type="text" name="data[{{ $i }}][text]" class="form-control"
                                value="{{ $item['text'] ?? '' }}" required>

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
