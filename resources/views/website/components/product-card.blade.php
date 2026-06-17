<div class="flex flex-col product-card">
    <a href="{{ $product['url'] ?? '#' }}"
        class="product-image cart border border-black/30 rounded-[18px] md:rounded-block overflow-hidden">
        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="max-w-full w-auto h-full object-contain">
    </a>

    <p class="cart-text">{{ $product['name'] }}</p>

    @if (!empty($product['subtitle']))
    <span class="cart-span">{{ $product['subtitle'] }}</span>
    @endif

    <div class="cart-rating">
        <span class="max-w-icon">
            <img src="{{ asset('storage/WebsiteImages/home/staricon.png') }}" class="max-w-(--max-w-xl) object-contain">
        </span>
        <span class="cart-span text-white">{{ $product['rating'] ?? '4.5' }}</span>
    </div>

    <div class="flex-box justify-start items-end gap-3">
        @if (!empty($product['mrp']))
        <span class="cart-price line-through decoration-1">
            ₹{{ number_format($product['mrp']) }}
        </span>
        @endif
        <span class="cart-discount">
            ₹{{ number_format($product['price']) }}
        </span>
    </div>

    <!-- <button class="mcp-btn mcp-btn-outline mt-5"> -->
    <a href="{{ $product['url'] }}" class="mcp-btn mcp-btn-outline mt-5 text-center">
        View Product
    </a>
    <span class="">Add to cart</span>
    <!-- </button> -->
</div>