@extends('admin.layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="container-fluid py-1">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Product
                </h5>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="productForm" action="{{ route('admin.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        {{-- BASIC INFO --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    Basic Information
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Seller</label>
                                        <select name="seller_id" class="form-select" required>
                                            <option value="">Select Seller</option>
                                            @foreach ($sellers as $seller)
                                                <option value="{{ $seller->id }}"
                                                    {{ $product->seller_id == $seller->id ? 'selected' : '' }}>
                                                    {{ $seller->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Product Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $product->name) }}" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Base Price</label>
                                        <input type="number" step="0.01" name="price" class="form-control"
                                            value="{{ old('price', $product->price) }}">
                                    </div>
                                    <div class="col-md-2" id="basicStockField">
                                        <label class="form-label fw-semibold">Stock</label>
                                        <input type="number" name="stock" class="form-control"
                                            value="{{ old('stock', $product->stock) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Description</label>
                                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- CATEGORY --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    Product Type
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Product Category</label>
                                        <select name="product_categories_id" id="productCategory" class="form-select"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach ($productCategories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $product->product_categories_id == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Product Sub Category</label>
                                        <select name="product_sub_categories_id" id="productSubCategory" class="form-select"
                                            required>
                                            <option value="{{ $product->product_sub_categories_id }}">
                                                {{ $product->subCategory->name ?? '' }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{-- VARIANTS --}}

                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    Product Variants
                                </div>
                                <div class="card-body">
                                    <div id="variantContainer">
                                        <div id="variantAttributes"></div>
                                        <div id="variantTable" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="visualVariantCard" style="display:none;">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold" id="visualVariantTitle">
                                    Variant Images
                                </div>
                                <div class="card-body">
                                    <div id="visualVariantImageContainer"></div>
                                    <div id="visualVariantError" class="text-danger small fw-semibold mt-2 d-none"></div>
                                </div>
                            </div>
                        </div>

                        {{-- ATTRIBUTES --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    Product Specifications
                                </div>
                                <div class="card-body">
                                    <div id="attributeContainer"></div>
                                </div>
                            </div>
                        </div>



                        {{-- WEBSITE CATEGORY --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    Website Category Placement
                                </div>
                                <div class="card-body">
                                    <select name="master_category_section_id[]" id="categorySelect" multiple required>
                                        @php
                                            $selectedSections = $product->categorySections
                                                ->pluck('master_category_section_id')
                                                ->toArray();
                                        @endphp
                                        @foreach ($categoryTree as $item)
                                            <option value="{{ $item->id }}"
                                                {{ in_array($item->id, $selectedSections) ? 'selected' : '' }}>
                                                {{ $item->masterCategory->name }}
                                                → {{ $item->sectionType->name }}
                                                → {{ $item->category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Images</label>
                            <div id="dropZone" class="dropzone-area">
                                <div id="dropzoneContent" class="dropzone-content text-center">
                                    <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
                                    <p class="mt-2 mb-1 fw-semibold">Drag & Drop Images Here or Click to Browse</p>
                                    <small class="text-muted">Upload at least 3 images (JPEG, PNG, max 500KB each).</small>
                                </div>

                                <!-- Existing Images -->
                                <div id="imagePreviews" class="preview-container mt-3">
                                    @foreach ($product->images as $img)
                                        <div class="preview-item existing" data-id="{{ $img->id }}">
                                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Existing Image">
                                            <button type="button" class="preview-remove"
                                                data-existing-id="{{ $img->id }}" title="Remove"> <i
                                                    class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Upload progress -->
                                <div id="uploadProgress" class="upload-progress mt-3 d-none">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="upload-status">
                                        Uploading: <span class="upload-count">0</span>/<span class="total-count">0</span>
                                    </small>
                                </div>
                            </div>

                            <input type="file" id="imageInput" name="images[]" accept="image/*" multiple hidden>
                            <input type="hidden" id="removedImages" name="removed_images" value="">
                            @error('images')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                            @error('images.*')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror

                            <div id="errorMessage" class="text-danger mt-2 small fw-semibold d-none"></div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
        <link href="{{ asset('css/product-form.css') }}" rel="stylesheet">
    @endpush


    @push('scripts')
        <script>
            const productCategoryTree = @json($productCategories);
            const existingVariants = @json($product->variants);
            const existingAttributes = @json($product->attributeValues);
            const existingVisualImages = @json($product->visualImages);
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/product-edit.js') }}"></script>
        {{-- <script src="{{ asset('js/product-form-core.js') }}"></script> --}}
    @endpush
@endsection
