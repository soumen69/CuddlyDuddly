{{-- EDIT MODE: Lock only published variant products; drafts can still change type --}}
@if(isset($product) && (int) ($product->status ?? 1) === 1 && (int) $product->is_variant === 0)

    <div class="mb-4">
        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
            Variant Product
        </span>

        {{-- Hidden input to preserve value --}}
        <input type="hidden" name="is_variant" value="0">
    </div>

@else

    {{-- CREATE MODE, draft, or editable product type --}}
    <div class="flex flex-col sm:flex-row gap-3.5 sm:gap-6">
        <label>
            <input type="radio" name="is_variant" value="1" {{ old('is_variant', $product->is_variant ?? 1) == 1 ? 'checked' : '' }}>
            Simple Product
        </label>

        <label>
            <input type="radio" name="is_variant" value="0" {{ old('is_variant', $product->is_variant ?? 1) == 0 ? 'checked' : '' }}>
            Product With Variants
        </label>
    </div>

@endif


<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <button class="close-btn" onclick="closeModal()" type="button"><i class="fa-solid fa-xmark"></i>
        </button>
        @if(isset($product) && isset($seller))
            <a href="{{ route('seller.products.variants.create', ['seller' => $seller->slug, 'productId' => $product->id]) }}"
                class="bg-yellow-300 hover:bg-yellow-400 text-sm font-semibold px-6 py-2 rounded-md max-w-[186px] inline-block text-center">
                Generate Variants →
            </a>
        @else
            <div class="bg-yellow-300 hover:bg-yellow-400 text-sm font-semibold px-6 py-2 rounded-md max-w-[186px]">
                Generate Variants →
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg p-6 space-y-6 mt-5">
            <div class="rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-gray-700">
                <p class="font-medium text-gray-900">How to upload variant products</p>
                <p class="mt-1">
                    Save the main product first. Then download the sample file, fill one row per variant with the dynamic attribute columns
                    like Size or Color, and the fixed columns `SKU`, `Price`, `Stock`, and `Status`.
                </p>
                <p class="mt-2 font-medium text-gray-900">
                    After saving the product, add variant rows from the Product Listing action menu.
                </p>
            </div>

            <!-- GENERATE & BULK ACTIONS -->
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div class="flex flex-wrap gap-3 items-center size-btn">
                    <!-- Auto SKU -->
                    <label class="flex items-center gap-2 text-sm font-medium">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div
                            class="w-10 h-5 bg-gray-300 rounded-full peer peer-checked:bg-gray-700 relative after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:h-4 after:w-4 after:rounded-full after:transition-all peer-checked:after:translate-x-5">
                        </div>
                        Auto Generate SKUs
                    </label>
                </div>
            </div>

            <!-- UPLOAD SECTION -->
            <div class="flex justify-between gap-3">

                <!-- UPLOAD FORM -->
                <form action="{{ route('seller.products.import', $seller->id) }}" method="POST"
                    enctype="multipart/form-data" id="uploadForm">

                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
                    <input type="file" name="file" id="fileInput" accept=".xlsx,.xls" class="hidden">

                    <button type="button" id="customUploadBtn" class="px-4 py-2 border rounded-md text-sm font-medium">
                        Upload .xlsx
                    </button>
                </form>

                <!-- DOWNLOAD BUTTON -->
                <a href="{{ route('seller.products.sample', request()->route('seller')) }}"
                    class="flex gap-1.5 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium down-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v8m0 0l-4-4m4 4l4-4" />
                    </svg>
                    <span>Download Sample .xlsx</span>
                </a>

            </div>

        </div>
    </div>
</div>



<script>
    const customUploadBtn = document.getElementById('customUploadBtn');
    const fileInput = document.getElementById('fileInput');
    const uploadForm = document.getElementById('uploadForm');

    // Open file picker when button is clicked
    customUploadBtn.addEventListener('click', () => {
        fileInput.click();
    });

    // Automatically submit the form when a file is selected
    fileInput.addEventListener('change', async () => {
        if (fileInput.files.length > 0) {
            const formData = new FormData(uploadForm);
            try {
                const originalText = customUploadBtn.innerHTML;
                customUploadBtn.innerHTML = '<span>Uploading...</span>';

                const response = await fetch(uploadForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    renderVariantsTable(result.data);
                } else {
                    alert(result.error || 'Failed to upload file. Make sure it contains correct headers.');
                }

                customUploadBtn.innerHTML = originalText;
                fileInput.value = ''; // reset file input
            } catch (error) {
                console.error(error);
                alert('An error occurred during upload.');
                customUploadBtn.innerHTML = `
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12V4m0 0l-4 4m4-4l4 4" />
                    </svg>
                    <span>Upload .csv / .xlsx</span>
                `;
            }
        }
    });

    function renderVariantsTable(variants) {
        const tbody = document.querySelector('.modaltable tbody');
        tbody.innerHTML = ''; // clear existing rows

        variants.forEach((variant) => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50';

            const colorLower = variant.color.toLowerCase();
            let colorClass = 'bg-gray-500';
            if (colorLower.includes('blue')) colorClass = 'bg-blue-500';
            else if (colorLower.includes('red')) colorClass = 'bg-red-500';
            else if (colorLower.includes('green')) colorClass = 'bg-green-500';
            else if (colorLower.includes('yellow')) colorClass = 'bg-yellow-500';
            else if (colorLower.includes('pink')) colorClass = 'bg-pink-400';
            else if (colorLower.includes('black')) colorClass = 'bg-black';
            else if (colorLower.includes('white')) colorClass = 'bg-white border text-black';

            const id = variant.id;

            tr.innerHTML = `
                <td class="px-4 py-3">
                    ${variant.size}
                    <input type="hidden" name="variants[${id}][size]" value="${variant.size}">
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full ${colorClass}"></span>
                        ${variant.color}
                        <input type="hidden" name="variants[${id}][color]" value="${variant.color}">
                    </div>
                </td>
                <td class="px-4 py-3">
                    ${variant.sku}
                    <input type="hidden" name="variants[${id}][sku]" value="${variant.sku}">
                </td>
                <td class="px-4 py-3">
                    ${variant.price}
                    <input type="hidden" name="variants[${id}][price]" value="${variant.price}">
                </td>
                <td class="px-4 py-3">
                    ${variant.stock}
                    <input type="hidden" name="variants[${id}][stock]" value="${variant.stock}">
                </td>
                <td class="px-4 py-3">
                    ${variant.weight}
                    <input type="hidden" name="variants[${id}][weight]" value="${variant.weight}">
                </td>
                <td class="px-4 py-3">
                    ${variant.barcode}
                    <input type="hidden" name="variants[${id}][barcode]" value="${variant.barcode}">
                </td>
                <td class="px-4 py-3 text-center">📷</td>
                <td class="px-4 py-3 text-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="variants[${id}][is_active]" value="1" class="sr-only peer" checked>
                        <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-green-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:h-4 after:w-4 after:rounded-full after:transition-all peer-checked:after:translate-x-5"></div>
                    </label>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }
</script>
