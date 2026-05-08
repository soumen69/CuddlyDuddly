 <div class="product-accordion-item border-b border-black/10">
     <button type="button"
         class="product-accordion-header cursor-pointer w-full flex justify-between items-center px-6 py-4 bg-gray-50 hover:bg-gray-100 transition-colors">
         <span class="accordion-title">Brand Information</span>
         <div class="icon pointer-events-none transition-transform duration-300">
             <i class="fa-solid fa-chevron-down"></i>
         </div>
     </button>
     <div
         class="product-accordion-content overflow-x-hidden overflow-y-auto transition-[max-height] duration-500 ease-in-out p-0">
         <div class="px-6 py-6">
             <!-- Placeholder for Safety Content -->
             <div>
                 <label class="form-label">Brand Information<span class="text-red-500">*</span></label>
                 <textarea name="brand_info" id="brand_info" rows="6" placeholder="Mention Brand Information with logo"
                     class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-black focus:ring-1 focus:ring-black transition-all resize-none">
                    {{ old('brand_info', $product->brand_info ?? '') }}
                </textarea>
             </div>
         </div>
     </div>
 </div>
