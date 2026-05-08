@extends('admin.layouts.admin')

@section('title', 'Edit Hero Section')

@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="cms-edit-header">
            <div>
                <h1>Hero Section</h1>
                <p>Edit the main banner content shown at the top of the home page.</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">Cancel</a>
                <button form="heroForm" class="btn-save">Save Changes</button>
            </div>
        </div>

        <form id="heroForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- LEFT: TEXT --}}
                <div class="col-lg-6">

                    {{-- Heading --}}
                    <div class="cms-box">
                        <h3>Hero Heading</h3>
                        <p class="hint">Split headline parts for styled rendering.</p>

                        <div class="cms-grid">
                            <div>
                                <label>Icon One</label>
                                <input type="text" name="data[heading][iconone]" class="form-control"
                                    value="{{ $data['heading']['iconone'] ?? '' }}">
                            </div>

                            <div>
                                <label>Icon Two</label>
                                <input type="text" name="data[heading][icontwo]" class="form-control"
                                    value="{{ $data['heading']['icontwo'] ?? '' }}">
                            </div>
                        </div>

                        <div class="mt-2">
                            <label>Remaining Text</label>
                            <input type="text" name="data[heading][rest]" class="form-control"
                                value="{{ $data['heading']['rest'] ?? '' }}">
                        </div>
                    </div>

                    {{-- Subheading --}}
                    <div class="cms-box">
                        <h3>Subheading</h3>
                        <textarea rows="3" name="data[subheading]" class="form-control">{{ $data['subheading'] ?? '' }}</textarea>
                    </div>

                    {{-- CTA --}}
                    <div class="cms-box">
                        <h3>Call To Action</h3>

                        <div class="cms-grid">
                            <div>
                                <label>CTA Text</label>
                                <input type="text" name="data[cta_text]" class="form-control"
                                    value="{{ $data['cta_text'] ?? '' }}">
                            </div>

                            <div>
                                <label>CTA URL</label>
                                <input type="text" name="data[cta_url]" class="form-control"
                                    value="{{ $data['cta_url'] ?? '' }}">
                            </div>
                        </div>
                    </div>

                    {{-- Avatars --}}
                    <div class="cms-box">
                        <h3>Customer Avatars</h3>
                        <p class="hint">Small review/customer icons shown near CTA.</p>

                        <div class="cms-image-grid">
                            @foreach ($data['avatars'] ?? [] as $avatar)
                                <img src="{{ asset($avatar) }}" class="preview-thumb">
                                <input type="hidden" name="data[avatars][]" value="{{ $avatar }}">
                            @endforeach
                        </div>

                        <input type="file" name="new_avatars[]" class="form-control mt-2" multiple>
                    </div>


                </div>

                {{-- RIGHT: IMAGES --}}
                <div class="col-lg-6">
                    <div class="cms-box">
                        <h3>Main Hero Image</h3>

                        @if (!empty($data['hero_image']))
                            <img src="{{ asset($data['hero_image']) }}" class="preview-image">
                            <input type="hidden" name="data[hero_image]" value="{{ $data['hero_image'] }}">
                        @endif

                        <input type="file" name="new_hero_image" class="form-control">
                    </div>

                    <div class="cms-box">
                        <h3>Decorative Throne Image</h3>

                        @if (!empty($data['throne_image']))
                            <img src="{{ asset($data['throne_image']) }}" class="preview-image">
                            <input type="hidden" name="data[throne_image]" value="{{ $data['throne_image'] }}">
                        @endif

                        <input type="file" name="new_throne_image" class="form-control">
                    </div>

                    <div class="cms-box">
                        <h3>Background Pattern</h3>

                        @if (!empty($data['pattern_image']))
                            <img src="{{ asset($data['pattern_image']) }}" class="preview-image">
                            <input type="hidden" name="data[pattern_image]" value="{{ $data['pattern_image'] }}">
                        @endif

                        <input type="file" name="new_pattern_image" class="form-control">
                    </div>


                </div>

            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cms-editor.css') }}">
@endpush
