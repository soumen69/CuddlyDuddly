@extends('seller.layouts.seller')

@section('title', 'Product Variants')

@section('content')

    <div class="flex-[unset] sm:flex-1 min-w-0">
        @include('seller.layouts.header')
        <div class=" flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-[45px]">
            <div class="w-full">
                <div class="flex items-center gap-4 mb-6">
                    <button type="button" onclick="window.history.back()"
                        class="w-[60px] h-[60px] rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <h3 class="font-sans font-normal text-3xl sm:text-[40px] leading-tight tracking-1 text-black">
                            Add Product Variants
                        </h3>
                        <p class="font-sans font-normal text-lg leading-tight tracking-1 text-black">
                            Create or upload variations for your product
                        </p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-lg border border-black/10 overflow-hidden w-full p-6">
                    <div class="variant-attributes mb-6" id="variantBlock">
                        <label class="form-label font-medium mb-2 block">Attribute Name</label>
                        <select
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none focus:border-black focus:ring-1 focus:ring-black transition-all mb-4">
                            <option>Size</option>
                            <option>Color</option>
                        </select>

                        <div class="size-buttons flex gap-2">
                            <button type="button" class="px-4 py-2 border rounded hover:bg-gray-50">0-3M</button>
                            <button type="button" class="px-4 py-2 border rounded hover:bg-gray-50">3-6M</button>
                            <button type="button" class="px-4 py-2 border rounded hover:bg-gray-50">6-12M</button>
                        </div>
                    </div>

                    <div
                        class="bg-yellow-300 hover:bg-yellow-400 text-sm font-semibold px-6 py-2 rounded-md max-w-[186px] mb-5 text-center transition-colors">
                        Generate Variants →
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6 space-y-6">
                        <div class="flex justify-between items-center">
                            <!-- LEFT SIDE : Upload Form -->
                            <form action="{{ route('seller.products.import', request()->route('seller')) }}" method="POST"
                                enctype="multipart/form-data" class="flex gap-2 items-center" id="uploadForm"
                                data-variants-url="{{ route('seller.products.variants.data', request()->route('seller')) }}"
                                data-products-index-url="{{ route('seller.products.index', request()->route('seller')) }}"
                                data-variant-status-url-template="{{ route('seller.products.variants.status', ['seller' => request()->route('seller'), 'variant' => '__VARIANT_ID__']) }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ request()->query('productId') }}">
                                <input type="file" name="file" id="fileInput" accept=".xlsx,.xls" class="hidden" required>
                                <input type="file" name="images[]" id="imageInput" accept="image/*" multiple class="hidden">
                                <button type="button"
                                    class="flex gap-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50 cursor-pointer"
                                    id="customImageBtn">
                                    Upload Images
                                </button>
                                <button type="button"
                                    class="flex gap-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50"
                                    id="customUploadBtn">
                                    Upload .xlsx
                                </button>
                            </form>
                            <!-- RIGHT SIDE : Download Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('seller.products.sample', request()->route('seller')) }}"
                                    id="sampleDownloadBtn"
                                    class="flex gap-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                        class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v8m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    <span>Download Sample .xlsx</span>
                                </a>
                                @if ($hasUploadedExcel)
                                    <a href="{{ route('seller.products.uploads.excel', ['seller' => request()->route('seller'), 'product_id' => request()->query('productId')]) }}"
                                        class="flex gap-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                            class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v8m0 0l-4-4m4 4l4-4" />
                                        </svg>
                                        <span>Download Uploaded Excel</span>
                                    </a>
                                @endif

                                @if ($hasUploadedImages)
                                    <a href="{{ route('seller.products.uploads.images', ['seller' => request()->route('seller'), 'product_id' => request()->query('productId')]) }}"
                                        class="flex gap-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                            class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v8m0 0l-4-4m4 4l4-4" />
                                        </svg>
                                        <span>Download Uploaded Images (.zip)</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="rounded-md border border-gray-200 bg-gray-50 p-4">
                            <!-- <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                                    <li>If product has Color upload images using SKU naming first: <span
                                            class="font-medium">SKU-front, SKU-back, SKU-top, SKU-side</span>.</li>
                                    <li>Example: <span class="font-medium">BLACK-XL-front.png, BLACK-XL-back.png,
                                            BLACK-XL-top.png, BLACK-XL-side.png</span>.</li>
                                    <li>If product has no color variant, keep SKU simple (example: <span
                                            class="font-medium">6-12M</span>) and enter price as per your product.</li>
                                </ul> -->

                            <p class="text-sm font-semibold text-gray-800 mb-2">Upload Images Instructions</p>
                            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                                <li>If the product has <span class="font-medium">Color variants</span>, upload images using
                                    SKU naming format:
                                    <span class="font-medium">SKU-front, SKU-back, SKU-top, SKU-side</span>.
                                </li>
                                <li>Note:
                                    <span class="font-medium">
                                        SKU-(SIZE)-front whould be the primary Image.
                                    </span>
                                </li>

                                <li>Example:
                                    <span class="font-medium">
                                        1. BLACK-XL-front.png, BLACK-XL-back.png, BLACK-XL-top.png, BLACK-XL-side.png
                                        2. If the product Have no image mention only SKU on excel sheet 6-12M, 12-18M, 18-24M
                                    </span>
                                </li>

                                <li>Image file names must <span class="font-medium">exactly match the SKU</span> mentioned
                                    in the Excel file.</li>

                                <li>Do not use <span class="font-medium">spaces</span> in file names. Use <span
                                        class="font-medium">hyphen (-)</span> only.</li>

                                <li>Supported image formats:
                                    <span class="font-medium">.png, .jpg, .jpeg, .webp</span>.
                                </li>

                                <li>If the product has <span class="font-medium">no color variant</span>, keep the SKU
                                    simple (example:
                                    <span class="font-medium">6-12M</span>) and upload images like:
                                    <span class="font-medium">6-12M-front.png</span>.
                                </li>

                                <li>You can upload multiple images for the same SKU using different views like
                                    <span class="font-medium">front, back, top, side</span>.
                                </li>

                                <li>⚠️ If the image file name does not match the SKU correctly, the image will not be
                                    attached to the variant.</li>
                            </ul>

                            <button type="button" id="openImageInstructionModal"
                                class="mt-3 text-sm font-medium underline text-black hover:text-gray-700 cursor-pointer">
                                Check the not allowed Image's
                            </button>
                        </div>
                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="w-full text-sm modaltable">
                                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Size</th>
                                        <th class="px-4 py-3 text-left">Color</th>
                                        <th class="px-4 py-3 text-left">SKU*</th>
                                        <th class="px-4 py-3 text-left">MRP*</th>
                                        <th class="px-4 py-3 text-left">Stock*</th>
                                        <th class="px-4 py-3 text-left">Weight</th>
                                        <!-- <th class="px-4 py-3 text-center">Image</th> -->
                                        <th class="px-4 py-3 text-center">Status</th>
                                        <th class="px-4 py-3 text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 bg-white">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <label class="flex items-center gap-2 mr-auto text-sm font-medium cursor-pointer">
                            <input type="checkbox" id="declarationCheckbox" class="cursor-pointer">
                            I confirm these variant details are correct.
                        </label>

                        <button type="button" id="cancelVariantsBtn"
                            class="px-6 py-2 border rounded-lg hover:bg-gray-50 font-medium cursor-pointer">Cancel
                        </button>

                        <button type="button" id="saveVariantsBtn"
                            class="px-8 py-2 bg-black text-white rounded-lg hover:bg-gray-900 font-medium shadow cursor-pointer">Save
                            Variants
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="imageInstructionModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <div class="flex items-center justify-between border-b px-5 py-4">
                <h4 class="text-lg font-semibold">Image Upload Instructions</h4>
                <button type="button" id="closeImageInstructionModal"
                    class="text-gray-500 hover:text-black text-xl leading-none">&times;</button>
            </div>
            <div class="px-5 py-4 text-sm text-gray-700 space-y-3">
                <p class="font-medium">1. Product with color:</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Use SKU with view name in filename.</li>
                    <li>Format: <span class="font-medium">BLACK-(SIZE)-front, BLACK-(SIZE)-back, BLACK-(SIZE)-top,
                            BLACK-(SIZE)-side</span>.</li>
                    <li>Example: <span class="font-medium">BLACK-XL-front.png</span>.</li>
                    <li>If your product setup supports extra view, optional filename can be <span
                            class="font-medium">BLACK-(SIZE)-other</span>.</li>
                </ul>
                <p class="font-medium">2. Product without color:</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>You can keep SKU as size only. Example: <span class="font-medium">6-12M, 12-24M, 2-3Y</span>.</li>
                    <li>Enter product price according to your product details.</li>
                </ul>
            </div>
            <div class="border-t px-5 py-3 text-right">
                <button type="button" id="closeImageInstructionModalFooter"
                    class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium hover:bg-gray-50">Close</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/variant.js') }}"></script>
    @endpush

@endsection
