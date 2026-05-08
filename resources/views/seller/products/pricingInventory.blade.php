<div class="product-accordion-item border-b border-black/10 pricing-accordion">
    <button type="button"
        class="product-accordion-header cursor-pointer w-full flex justify-between items-center px-6 py-4 bg-gray-50 hover:bg-gray-100 transition-colors">
        <span class="accordion-title">Pricing & Inventory</span>
        <div class="icon pointer-events-none transition-transform duration-300">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </button>

    <div
        class="product-accordion-content overflow-hidden transition-[max-height] duration-500 ease-in-out p-0">
        <div class="px-6 pt-6 pb-8">
            <div class="grid grid-cols-1 gap-6">
                @include('seller.products.partials.variant-row')
                <div class="simple-block grid md:grid-cols-2 gap-x-5 gap-y-6" id="simpleBlock">
                    <div>
                        <label class="form-label" id="priceLabel">
                            Main Product Price<span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="price"
                            value="{{ old('price', $product->price ?? '') }}" placeholder="0.0"
                            min="100"
                            class="seller-info-field">
                        @error('price')
                            <p class="form-error text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label" id="stockLabel">
                            Total Stock Quantity<span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock"
                            value="{{ old('stock', $product->stock ?? '') }}"
                            placeholder="Enter available units" min="10"
                            class="seller-info-field">
                        @error('stock')
                            <p class="form-error text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div id="skuBlock">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-medium text-black">
                                SKU/Product ID<span class="text-red-500">*</span>
                                <span class="text-gray-400 font-normal ml-2 text-sm">Auto-generated on save</span>
                            </label>
                        </div>

                        <input type="text" name="sku" id="skuInput"
                            value="{{ old('sku', $product->sku ?? '') }}"
                            placeholder="Will be generated automatically"
                            readonly
                            class="seller-info-field">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
