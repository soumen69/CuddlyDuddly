@extends('seller.layouts.seller')

@section('title', 'My Products')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/seller-registration.css') }}">
        <link href="{{ asset('css/product-form.css') }}" rel="stylesheet">

        <style>
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: none;
            }

            input[type="number"] {
                -moz-appearance: textfield;
            }

            input:invalid {
                border-color: red !important;
            }

            input:invalid:focus {
                box-shadow: 0 0 0 1px red;
            }
        </style>
    @endpush

    <div class="flex-[unset] sm:flex-1 min-w-0">
        @include('seller.layouts.header')
        <div class=" flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-[45px]">

            <div class="w-full">
                <div class="flex items-center gap-4 mb-6">
                    <button type="button" onclick="window.history.back()"
                        class="flex-none w-9 h-9 rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1182_398)">
                                <path d="M11.4647 21.4961L7.16551 17.1969L11.4647 12.8977" stroke="white"
                                    stroke-width="2.02667" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.16523 17.1969L27.2282 17.1969" stroke="white" stroke-width="2.02667"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_1182_398">
                                    <rect width="24.32" height="24.32" fill="white"
                                        transform="translate(17.1968 34.3937) rotate(-135)"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <div>
                        <h3
                            class="font-sans font-normal text-lg md:text-xl lg:text-2xl xl:text-3xl leading-tight tracking-1 text-black">
                            {{ isset($product) ? 'Edit product' : 'Add new products' }}
                        </h3>
                        <p class="font-sans font-normal text-base leading-tight tracking-1 text-black">
                            {{ isset($product) ? 'Update the details below to modify your product' : 'Fill in the details below to list your product on Cuddly Duddly' }}
                        </p>
                    </div>
                </div>

                <form id="productForm"
                    action="{{ isset($product) ? route('seller.products.update', [$seller->slug, $product->id]) : route('seller.products.store', $seller->slug) }}"
                    method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif
                    <input type="hidden" name="product_action" id="productAction" value="publish">

                    <div class="bg-white rounded-lg overflow-hidden w-full">

                        <!-- SECTION: Basic Information -->
                        @include('seller.products.basicInformation')

                        <!-- SECTION: Pricing & Inventory -->
                        <div id="variantSection" class="hidden">
                            @include('seller.products.variants')
                        </div>

                        <!-- Product Details (Images & Description) -->
                        @include('seller.products.productDetails')
                    </div>
                    <div class="flex justify-between items-center pt-8 pb-4 px-6 gap-4">
                        <a href="{{ route('seller.products.index', $seller->slug) }}"
                            class="px-3.5 py-2 sm:px-6 sm:py-3 bg-white cursor-pointer border border-gray-300 text-sm sm:text-base text-black font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-sm whitespace-nowrap">
                            Cancel
                        </a>
                        <div class="flex gap-3 sm:gap-4">
                            {{-- <button type="button"
                                onclick="document.getElementById('productAction').value='draft'; document.getElementById('productForm').requestSubmit();"
                                class="px-3.5 py-2 sm:px-8 sm:py-3 cursor-pointer bg-gray-100 text-sm sm:text-base text-black font-medium rounded-lg hover:bg-gray-200 transition-colors whitespace-nowrap">
                                Save Draft
                            </button> --}}

                            <button type="button"
                                onclick="document.getElementById('productAction').value='publish'; document.getElementById('productForm').requestSubmit();"
                                class="px-3.5 py-2 sm:px-12 sm:py-3 cursor-pointer bg-black text-sm sm:text-base text-white font-medium rounded-lg hover:bg-gray-900 transition-all shadow-lg hover:shadow-xl whitespace-nowrap sm:min-w-[140px]">
                                Save
                            </button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        @php
            $sellerExistingProductImages = isset($product)
                ? $product->images
                    ->map(function ($img) {
                        return [
                            'id' => $img->id,
                            'path' => $img->image_path,
                            'is_primary' => $img->is_primary,
                        ];
                    })
                    ->values()
                : [];

            $sellerExistingAttributes = isset($product)
                ? $product->attributeValues
                    ->map(function ($value) {
                        return [
                            'attribute_value_id' => $value->attribute_value_id,
                        ];
                    })
                    ->values()
                : [];

            $sellerExistingVariants = isset($product)
                ? $product->variants
                    ->map(function ($variant) {
                        return [
                            'id' => $variant->id,
                            'sku' => $variant->sku,
                            'price' => $variant->price,
                            'stock' => $variant->stock,
                            'values' => $variant->values
                                ->map(function ($value) {
                                    return [
                                        'id' => $value->id,
                                        'value' => $value->value,
                                    ];
                                })
                                ->values(),
                        ];
                    })
                    ->values()
                : [];

            $sellerExistingVisualImages = isset($product)
                ? $product->visualImages
                    ->map(function ($img) {
                        return [
                            'id' => $img->id,
                            'attribute_value_id' => $img->attribute_value_id,
                            'image_path' => $img->image_path,
                            'is_primary' => $img->is_primary,
                        ];
                    })
                    ->values()
                : [];
        @endphp

        <script>
            window.CKEDITOR_UPLOAD_URL =
                "{{ route('seller.ckeditor-image-upload', ['seller' => $seller->slug, '_token' => csrf_token()], false) }}";
        </script>
        <script>
            window.productCategoryTree = @json($productCategories);
            window.selectedSubCategoryId = @json($selectedSubCategoryId ?? null);
            window.existingProductImages = @json($sellerExistingProductImages);
            window.existingAttributes = @json($sellerExistingAttributes);
            window.existingVariants = @json($sellerExistingVariants);
            window.existingVisualImages = @json($sellerExistingVisualImages);
            window.attributeUrlTemplate = "{{ route('product-categories.attributes', ':id') }}";
        </script>
        <script src="{{ asset('js/product-form.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showBank = @json((int) request('bank_required', 0) === 1);
                const modalEl = document.getElementById('bankDetailsModal');
                if (showBank && modalEl && window.bootstrap) {
                    new bootstrap.Modal(modalEl).show();
                }
            });
        </script>
    @endpush


@endsection
