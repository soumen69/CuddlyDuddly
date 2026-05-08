<div class="product-accordion-item border-b border-black/10 pricing-accordion">
    <button type="button"
        class="product-accordion-header cursor-pointer w-full flex justify-between items-center px-6 py-4 bg-gray-50 hover:bg-gray-100 transition-colors">
        <span class="accordion-title">Variant & Specifications </span>
        <div class="icon pointer-events-none transition-transform duration-300">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </button>

    <div class="product-accordion-content overflow-hidden transition-[max-height] duration-500 ease-in-out p-0">
        <div class="px-6 pt-6 pb-8">
            <div class="grid grid-cols-1 gap-6">
                <div class="simple-block grid md:grid-cols-1 gap-x-5" id="simpleBlock">
                    <div class="card">
                        <!-- <div class="card-header bg-light fw-semibold">
                            <i class="bi bi-layers me-2"></i> Product Variants
                        </div> -->
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

                    <div class="product-specification-attribute">
                        <!-- <label class="form-label">
                            Product Specifications
                        </label> -->
                        <div class="card-body">
                            <div id="attributeContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
