@extends('admin.layouts.admin')
@section('title', 'Add New Product')
@section('content')
    <div class="container-fluid py-1">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box2-heart me-2"></i> Add New Product</h5>
            </div>

            <div class="card-body">
                <form id="productForm" action="{{ route('admin.products.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="bi bi-info-circle me-2"></i> Basic Information
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Seller</label>
                                        <select name="seller_id" class="form-select" required>
                                            <option value="">Select Seller</option>
                                            @foreach ($sellers as $seller)
                                                <option value="{{ $seller->id }}"
                                                    {{ old('seller_id') == $seller->id ? 'selected' : '' }}>
                                                    {{ $seller->name ?? $seller->shop_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('seller_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Product Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name') }}" placeholder="Example: Boys Cotton T-Shirt" required>
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Base Price</label>
                                        <input type="number" step="0.01" name="price" class="form-control"
                                            value="{{ old('price') }}" placeholder="0.00">
                                        @error('price')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2" id="basicStockField">
                                        <label class="form-label fw-semibold">Stock</label>
                                        <input type="number" name="stock" class="form-control"
                                            value="{{ old('stock') }}" placeholder="Quantity">
                                        @error('stock')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Description</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Short product description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="bi bi-diagram-3 me-2"></i> Product Type
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Product Category</label>
                                        <select name="product_categories_id" id="productCategory" class="form-select"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach ($productCategories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ old('product_categories_id') == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_categories_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Product Sub Category</label>
                                        <select name="product_sub_categories_id" id="productSubCategory" class="form-select"
                                            required>
                                            <option value="">Select Sub Category</option>
                                        </select>
                                        @error('product_sub_categories_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="bi bi-layers me-2"></i> Product Variants
                                </div>
                                <div class="card-body">
                                    <div id="variantContainer">
                                        <div id="variantAttributes"></div>
                                        <div id="variantTable" class="mt-3"></div>
                                        @error('variants')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="visualVariantCard" style="display:none;">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="bi bi-palette me-2"></i>
                                    <span id="visualVariantTitle">Variant Images</span>
                                </div>
                                <div class="card-body">
                                    <div id="visualVariantImageContainer"></div>
                                    <div id="visualVariantError" class="text-danger small fw-semibold mt-2 d-none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="bi bi-sliders me-2"></i> Product Specifications
                                </div>
                                <div class="card-body">
                                    <div id="attributeContainer"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="bi bi-diagram-2 me-2"></i> Website Category Placement
                                </div>
                                <div class="card-body">
                                    <label class="form-label fw-semibold">Show Product In</label>
                                    <select name="master_category_section_id[]" id="categorySelect" multiple required>
                                        @foreach ($categoryTree as $item)
                                            <option value="{{ $item->id }}"
                                                {{ collect(old('master_category_section_id'))->contains($item->id) ? 'selected' : '' }}>
                                                {{ $item->masterCategory->name }}
                                                → {{ $item->sectionType->name }}
                                                → {{ $item->category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('master_category_section_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="bi bi-images me-2"></i> Product Images
                                </div>
                                <div class="card-body">
                                    <div id="dropZone" class="dropzone-area text-center">
                                        <div class="dropzone-content">
                                            <i class="bi bi-cloud-arrow-up fs-2 text-primary"></i>
                                            <p class="mt-2 mb-1 fw-semibold">
                                                Drag & Drop Images Here
                                            </p>
                                            <small class="text-muted">
                                                Minimum 4 images required (only if product has no visual variants).
                                            </small>
                                        </div>
                                        <div id="imagePreviews" class="preview-container mt-3 d-none"></div>
                                        <div id="uploadProgress" class="upload-progress mt-3 d-none">
                                            <div class="progress">
                                                <div class="progress-bar"></div>
                                            </div>
                                            <small>
                                                Uploading:
                                                <span class="upload-count">0</span> /
                                                <span class="total-count">0</span>
                                            </small>
                                        </div>
                                    </div>
                                    <input type="file" id="imageInput" name="images[]" accept="image/*" multiple
                                        hidden>
                                    <div id="errorMessage" class="text-danger mt-2 small fw-semibold d-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🎯 Submit -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Add Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <link href="{{ asset('css/product-form.css') }}" rel="stylesheet">
    @endpush
    @push('scripts')
        <script>
            const productCategoryTree = @json($productCategories);
            window.attributeUrlTemplate = "{{ route('product-categories.attributes', ':id') }}";
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/product-form.js') }}"></script>
    @endpush
@endsection
