<div>
    <span class="accordion-title">Product Details</span>

    <div class="product-accordion-content overflow-hidden transition-[max-height] duration-500 ease-in-out p-0">
        <div class="px-6 py-6">
            <div id="visualVariantCard" style="display:none;" class="mb-6">
                <label class="form-label" id="visualVariantTitle">Variant Images</label>
                <div id="visualVariantImageContainer"></div>
                <div id="visualVariantError" class="text-red-500 text-sm font-semibold mt-2 hidden"></div>
            </div>
            <!-- Media Upload -->
            <div class="col-12 mb-6" id="productImagesBlock">
                <label class="form-label">Product Images<span class="text-red-500">*</span></label>


                <div id="dropZone"
                    class="dropzone-area text-center w-full min-h-[200px] border border-black/20 bg-white rounded-sm p-6 flex flex-col items-center justify-center cursor-pointer hover:bg-blue-100 transition-all min-h-[180px]">

                    <div
                        class="dropzone-content flex flex-col items-center justify-center text-center absolute inset-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="24" viewBox="0 0 36 24"
                            fill="none" class="max-w-7 mx-auto mb-4">
                            <path
                                d="M29.025 9.06C28.005 3.885 23.46 0 18 0C13.665 0 9.9 2.46 8.025 6.06C3.51 6.54 0 10.365 0 15C0 19.965 4.035 24 9 24H28.5C32.64 24 36 20.64 36 16.5C36 12.54 32.925 9.33 29.025 9.06ZM28.5 21H9C5.685 21 3 18.315 3 15C3 11.925 5.295 9.36 8.34 9.045L9.945 8.88L10.695 7.455C12.12 4.71 14.91 3 18 3C21.93 3 25.32 5.79 26.085 9.645L26.535 11.895L28.83 12.06C31.17 12.21 33 14.175 33 16.5C33 18.975 30.975 21 28.5 21ZM12 13.5H15.825V18H20.175V13.5H24L18 7.5L12 13.5Z"
                                fill="#EA1849" />
                        </svg>
                        <p class="text-sm mb-2 text-black-500">
                            Drag & Drop Images Here or
                            <span class="text-[#EA1849]">Browse</span>
                        </p>

                        <small class="text-[#6D6D6D] text-sm">
                            Minimum 3 images required.
                        </small>
                    </div>


                    <div id="imagePreviews"
                        class="flex flex-wrap gap-3 mt-4 justify-start {{ isset($product) && $product->images->count() ? '' : 'd-none' }}">

                        @if (isset($product))
                            @foreach ($product->images as $img)
                                <div class="preview-item existing" data-id="{{ $img->id }}">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Existing Image">
                                    <button type="button" class="preview-remove"
                                        data-existing-id="{{ $img->id }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div id="uploadProgress" class="mt-4 w-full hidden" style="display: none;">

                        <div class="progress w-full bg-indigo-100 rounded-full h-2 overflow-hidden">
                            <div class="progress-bar bg-indigo-600 h-2 rounded-full transition-all duration-300 w-[0%]">
                            </div>
                        </div>
                        <small class="text-sm block mt-1">
                            Uploading:
                            <span class="upload-count">0</span> /
                            <span class="total-count">0</span>
                        </small>

                    </div>
                </div>

                <input type="file" id="imageInput" name="images[]" accept="image/*" multiple hidden>

                @error('images')
                    <p><small class="form-error text-red-500 text-sm mt-2">{{ $message }}</small></p>
                @enderror
                @error('images.*')
                    <p><small class="form-error text-red-500 text-sm mt-2">{{ $message }}</small></p>
                @enderror

                <div id="errorMessage" class="d-none text-red-500 text-sm mt-2 font-semibold"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="w-full">
                    {{-- <div class="card border-0 shadow-sm"> --}}

                    <div class="card-header bg-light fw-semibold">
                        <i class="bi bi-diagram-2 me-2"></i> Website Category Placement
                    </div>

                    <div class="card-body">

                        <label class="form-label fw-semibold">Show Product In<span class="text-red-500">*</span></label>
                        @php
                            $selectedCategorySections = old(
                                'master_category_section_id',
                                isset($product)
                                    ? $product->categorySections->pluck('master_category_section_id')->toArray()
                                    : [],
                            );
                        @endphp

                        <select name="master_category_section_id[]" id="categorySelect" multiple required>

                            @foreach ($categoryTree as $item)
                                <option value="{{ $item->id }}"
                                    {{ in_array($item->id, $selectedCategorySections) ? 'selected' : '' }}>

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
                    {{-- </div> --}}
                </div>

                <div class="col-12 mb-6">
                    <label class="form-label">YouTube Product Video (Optional)</label>

                    <input type="url" name="youtube_url" placeholder="https://www.youtube.com/watch?v=xxxx"
                        value="{{ old('youtube_url', $product->youtube_url ?? '') }}" class="seller-info-field">

                    @error('youtube_url')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>
    </div>
</div>
