<div class="row g-3">
    {{-- Product --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Product</label>
        <select name="product_id" class="form-select shadow-sm @error('product_id') is-invalid @enderror"
            @isset($inventory) disabled @endisset required>
            <option value="" disabled>Select Product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}"
                    {{ old('product_id', $inventory->product_id ?? '') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        {{-- Hidden field to preserve product_id when disabled --}}
        @isset($inventory)
            <input type="hidden" name="product_id" value="{{ $inventory->product_id }}">
        @endisset
        @error('product_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Seller --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Seller</label>
        <select name="seller_id" class="form-select shadow-sm @error('seller_id') is-invalid @enderror"
            @isset($inventory) disabled @endisset required>
            <option value="" disabled>Select Seller</option>
            @foreach ($sellers as $seller)
                <option value="{{ $seller->id }}"
                    {{ old('seller_id', $inventory->seller_id ?? '') == $seller->id ? 'selected' : '' }}>
                    {{ $seller->name }}
                </option>
            @endforeach
        </select>
        {{-- Hidden field to preserve seller_id when disabled --}}
        @isset($inventory)
            <input type="hidden" name="seller_id" value="{{ $inventory->seller_id }}">
        @endisset
        @error('seller_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- SKU --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold">SKU
            <small class="text-muted">(auto-generated)</small>
        </label>
        <input type="text" name="sku" class="form-control shadow-sm @error('sku') is-invalid @enderror"
            value="{{ old('sku', $inventory->sku ?? '') }}" readonly>
        @error('sku')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Quantity --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold">Quantity</label>
        <input type="number" name="quantity" class="form-control shadow-sm @error('quantity') is-invalid @enderror"
            value="{{ old('quantity', $inventory->quantity ?? 0) }}" required>
        @error('quantity')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Reserved Quantity --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold">Reserved Quantity</label>
        <input type="number" name="reserved_quantity"
            class="form-control shadow-sm @error('reserved_quantity') is-invalid @enderror"
            value="{{ old('reserved_quantity', $inventory->reserved_quantity ?? 0) }}">
        @error('reserved_quantity')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Price --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold">Selling Price (₹)</label>
        <input type="number" step="0.01" name="price"
            class="form-control shadow-sm @error('price') is-invalid @enderror"
            value="{{ old('price', $inventory->price ?? '') }}">
        @error('price')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Cost Price --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold">Cost Price (₹)</label>
        <input type="number" step="0.01" name="cost_price"
            class="form-control shadow-sm @error('cost_price') is-invalid @enderror"
            value="{{ old('cost_price', $inventory->cost_price ?? '') }}">
        @error('cost_price')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Min Stock --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold">Min Stock</label>
        <input type="number" name="min_stock" class="form-control shadow-sm @error('min_stock') is-invalid @enderror"
            value="{{ old('min_stock', $inventory->min_stock ?? 0) }}">
        @error('min_stock')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Warehouse --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Warehouse Location</label>
        <input type="text" name="warehouse_location"
            class="form-control shadow-sm @error('warehouse_location') is-invalid @enderror"
            value="{{ old('warehouse_location', $inventory->warehouse_location ?? '') }}">
        @error('warehouse_location')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Status --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Status</label>
        <select name="status" class="form-select shadow-sm @error('status') is-invalid @enderror">
            <option value="in_stock" {{ old('status', $inventory->status ?? '') == 'in_stock' ? 'selected' : '' }}>
                In Stock
            </option>
            <option value="out_of_stock"
                {{ old('status', $inventory->status ?? '') == 'out_of_stock' ? 'selected' : '' }}>
                Out of Stock
            </option>
        </select>
        @error('status')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

{{-- Actions --}}
<div class="text-end mt-4">
    <button type="submit" class="btn btn-gradient-primary rounded-pill px-4 py-2 fw-semibold shadow-sm submit-btn"
        data-action="{{ isset($inventory) ? 'Updating...' : 'Saving...' }}">
        <i class="bi {{ isset($inventory) ? 'bi-pencil-square' : 'bi-save' }} me-1"></i>
        {{ isset($inventory) ? 'Update' : 'Save' }}
    </button>
    <a href="{{ route('admin.inventory.index') }}"
        class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold shadow-sm">
        Cancel
    </a>
</div>

@push('styles')
    <style>
        .btn-gradient-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            color: #fff;
            transition: all 0.25s ease-in-out;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-gradient-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.querySelector('select[name="product_id"]');
            const sellerSelect = document.querySelector('select[name="seller_id"]');
            const skuInput = document.querySelector('input[name="sku"]');
            const forms = document.querySelectorAll('form');

            function randomChar() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                return chars.charAt(Math.floor(Math.random() * chars.length));
            }

            function generateMixedDatePart() {
                const now = new Date();
                const day = now.getDate().toString().padStart(2, '0');
                const month = (now.getMonth() + 1).toString().padStart(2, '0');
                const year = now.getFullYear().toString().slice(-2);
                return `${randomChar()}${day}${randomChar()}${month}${randomChar()}${year}${randomChar()}`;
            }

            function generateSKU() {
                const isEditMode = skuInput.dataset.hasValue === "true";
                if (isEditMode) return;

                const productName = productSelect.selectedOptions[0]?.text || '';
                const sellerName = sellerSelect.selectedOptions[0]?.text || '';

                // Only generate if both are selected
                if (!productName || !sellerName) {
                    skuInput.value = '';
                    return;
                }

                // Clean + shorten (remove spaces and special chars)
                const cleanProduct = productName.replace(/[^a-zA-Z0-9]/g, '').substring(0, 6).toUpperCase();
                const cleanSeller = sellerName.replace(/[^a-zA-Z0-9]/g, '').substring(0, 4).toUpperCase();
                const mixedDate = generateMixedDatePart();

                skuInput.value = `${cleanProduct}-${cleanSeller}-${mixedDate}`;
            }

            // Mark if editing (existing SKU)
            skuInput.dataset.hasValue = skuInput.value ? "true" : "false";

            // Only attach change listeners if we’re in create mode
            if (!skuInput.value) {
                productSelect.addEventListener('change', generateSKU);
                sellerSelect.addEventListener('change', generateSKU);
            }

            // Prevent multiple submissions
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('.submit-btn');
                    if (!submitBtn || submitBtn.disabled) return;

                    submitBtn.disabled = true;
                    const actionText = submitBtn.dataset.action || 'Saving...';
                    submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                ${actionText}
            `;
                });
            });
        });
    </script>
@endpush
