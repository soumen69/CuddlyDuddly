@extends('admin.layouts.admin')

@section('title', 'Edit Product List')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="cms-edit-header">
            <div>
                <h1>Product List</h1>
                <p>Featured products section.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.website.home') }}" class="btn-cancel">Cancel</a>
                <button form="productListForm" class="btn-save">Save Changes</button>
            </div>
        </div>

        {{-- FORM --}}
        <form id="productListForm" method="POST" action="{{ route('admin.website.home.update', $section) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- SECTION TITLE --}}
            <div class="cms-box">
                <label>Section Title</label>
                <input type="text" name="data[title]" class="form-control" value="{{ $data['title'] ?? '' }}">
            </div>

            <div class="row g-4">
                @foreach ($data['products'] ?? [] as $i => $product)
                    <div class="col-lg-4">
                        <div class="cms-box h-100">

                            {{-- PRESERVE OLD IMAGE --}}
                            <input type="hidden" name="data[products][{{ $i }}][image]"
                                value="{{ $product['image'] ?? '' }}">

                            {{-- PREVIEW --}}
                            <img src="{{ asset($product['image']) }}" class="preview-image mb-3">

                            {{-- NAME --}}
                            <label>Name</label>
                            <input type="text" name="data[products][{{ $i }}][name]" class="form-control mb-2"
                                value="{{ $product['name'] ?? '' }}">

                            {{-- SUBTITLE --}}
                            <label>Subtitle</label>
                            <input type="text" name="data[products][{{ $i }}][subtitle]"
                                class="form-control mb-2" value="{{ $product['subtitle'] ?? '' }}">

                            {{-- PRICE --}}
                            <label>Price</label>
                            <input type="number" name="data[products][{{ $i }}][price]"
                                class="form-control mb-2" value="{{ $product['price'] ?? '' }}">

                            {{-- URL --}}
                            <label>URL</label>
                            <input type="text" name="data[products][{{ $i }}][url]" class="form-control mb-3"
                                value="{{ $product['url'] ?? '' }}">

                            {{-- OPTIONAL NEW IMAGE --}}
                            <label>Replace Image</label>
                            <input type="file" name="product_image_{{ $i }}" class="form-control">
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
