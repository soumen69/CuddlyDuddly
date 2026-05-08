<div class="product-accordion-item border-b border-black/10">
    <button type="button"
        class="product-accordion-header cursor-pointer w-full flex justify-between items-center px-6 py-4 bg-gray-50 hover:bg-gray-100 transition-colors">
        <span class="accordion-title">Cancellation Policy</span>
        <div class="icon pointer-events-none transition-transform duration-300">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </button>
    <div class="product-accordion-content overflow-hidden transition-[max-height] duration-500 ease-in-out p-0">
        <div class="px-6 py-6">
            <div>
                <textarea name="cancellation_policy" id="cancellation_policy" rows="6"
                    placeholder="Mention shipping information with in 500 characters" data-maxlength="500"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-black focus:ring-1 focus:ring-black transition-all resize-none">{{ old('cancellation_policy', $product->cancellation_policy ?? '') }}</textarea>
                <p class="text-xs text-black/50 text-right mt-1">0/500</p>
            </div>
        </div>
    </div>
</div>