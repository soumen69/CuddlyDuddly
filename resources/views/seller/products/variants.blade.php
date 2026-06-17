<div>
    <span class="accordion-title">Variant & Specifications </span>

    <div class="px-6 pt-6 pb-8">
        <div class="grid grid-cols-1 gap-6">
            <div class="simple-block grid md:grid-cols-1 gap-x-5" id="simpleBlock">
                <div class="card">
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
                    <div class="card-body">
                        <div id="attributeContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
