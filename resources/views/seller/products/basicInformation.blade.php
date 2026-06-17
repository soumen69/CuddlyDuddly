<span class="accordion-title">Basic Information</span>
<div class="overflow-hidden transition-[max-height] duration-500 ease-in-out p-0">
    <div class="pb-6">
        <div class="px-6 pt-7 space-y-7">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="form-label">
                        Product Name<span class="text-red-500">*</span>
                    </label>
                    <input type="name" name="name" value="{{ old('name', $product->name ?? '') }}"
                        placeholder="e.g. Organic baby blanket" class="seller-info-field">
                    @error('name')
                        <p class="form-error text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">
                        Category<span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="product_categories_id" id="productCategory" class="seller-info-field" required>
                            <option value="" selected disabled>Select Category</option>
                            @foreach ($productCategories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('product_categories_id', $selectedCategoryId ?? null) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_categories_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div>
                    <label class="form-label">
                        Sub Category<span class="text-red-500">*</span>
                    </label>
                    <select name="product_sub_categories_id" id="productSubCategory" class="seller-info-field" required>
                        <option value="" selected disabled>Select Sub Category</option>
                        @if (isset($product) && $product->subCategory)
                            <option value="{{ $product->subCategory->id }}"
                                {{ old('product_sub_categories_id', $selectedSubCategoryId ?? $product->subCategory->id) == $product->subCategory->id ? 'selected' : '' }}>
                                {{ $product->subCategory->name }}
                            </option>
                        @endif
                    </select>
                    @error('product_sub_categories_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label">
                        Base Price<span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="price"
                        value="{{ old('price', $product->price ?? '') }}" placeholder="0.00" class="seller-info-field">
                    @error('price')
                        <p class="form-error text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="basicStockField">
                    <label class="form-label">
                        Stock<span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="stock"
                        value="{{ old('stock', $product->stock ?? '') }}" placeholder="Quantity"
                        class="seller-info-field">
                    @error('stock')
                        <p class="form-error text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <!-- Short Description -->
            <div>
                <label class="form-label">
                    Product short info<span class="text-red-500">*</span>
                </label>
                <textarea class="seller-info-field" name="short_description" rows="4"
                    placeholder="Brief description shown under product name with in 1000 characters" data-maxlength="1000">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                <p class="text-xs text-black/50 text-right mt-1">0/1000</p>
            </div>
        </div>
    </div>
</div>
