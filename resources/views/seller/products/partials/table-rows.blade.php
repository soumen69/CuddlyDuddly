<tbody>
    @forelse($products as $product)

        {{-- MY PRODUCTS --}}
        @if ($activeTab == '1' && $product->variants->count())
            @foreach ($product->variants as $variant)
                <tr class="border-b border-black/10">
                    <td class="pl-5">{{ $loop->iteration }}</td>

                    {{-- Image --}}
                    <td>
                        @php
                            $variantImage = $product->visualImages
                                ->where('attribute_value_id', optional($variant->values->first())->id)
                                ->first();
                            $fallbackProductImage = $product->primaryImage
                                ?? $product->primaryVariantImage
                                ?? $product->images->first();
                        @endphp

                        @if ($variantImage || $fallbackProductImage)
                            <img src="{{ asset('storage/' . ($variantImage->image_path ?? $fallbackProductImage->image_path)) }}"
                                class="w-10 h-14 object-cover rounded-md border">
                        @else
                            <span>No image</span>
                        @endif
                    </td>

                    {{-- Product --}}
                    <td class="table-p-name">
                        {{ $product->name }}
                        <br>
                        <small class="text-gray-500">
                            {{ $variant->values->pluck('value')->implode(' / ') }}
                        </small>
                    </td>

                    {{-- Price --}}
                    <td>
                        <div class="editable-price flex items-center gap-2">

                            <span class="price-text">
                                ₹{{ number_format($variant->price, 2) }}
                            </span>

                            <input type="number" step="0.01" value="{{ $variant->price }}"
                                data-product-id="{{ $variant->id }}" data-mode="variant"
                                data-update-url="{{ route('seller.products.update-price', [$seller->slug, $variant->id]) }}"
                                class="price-input border rounded px-2 py-1 w-24 hidden">

                            <button type="button" class="change-price-btn edit-price-btn">
                                {{-- <i class="fa-solid fa-pen-to-square"></i> --}}
                                Change
                            </button>

                        </div>
                    </td>

                    {{-- Stock --}}
                    <td>
                        <div class="editable-stock flex items-center gap-2">

                            <span class="stock-text">
                                {{ $variant->stock }}
                            </span>

                            <input type="number" value="{{ $variant->stock }}" data-product-id="{{ $variant->id }}"
                                data-mode="variant"
                                data-update-url="{{ route('seller.products.update-stock', [$seller->slug, $variant->id]) }}"
                                class="stock-input border rounded px-2 py-1 w-20 hidden">

                            <button type="button" class="change-price-btn edit-stock-btn">
                                Change
                            </button>

                        </div>
                    </td>

                    {{-- Featured Toggle --}}
                    <td class="actions-cell">

                        <div class="flex justify-center">

                            <label class="switch">

                                @if ($product->variants->count())
                                    {{-- Variant Product --}}
                                    <input type="checkbox" class="feature-toggle" data-id="{{ $variant->id }}"
                                        data-feature-url="{{ route('seller.products.toggle-featured', ['seller' => $seller->slug, 'id' => $variant->id]) }}"
                                        data-feature-type="variant"
                                        {{ $variant->is_featured == 1 ? 'checked' : '' }}>
                                @else
                                    {{-- Simple Product --}}
                                    <input type="checkbox" class="feature-toggle" data-id="{{ $product->id }}"
                                        data-feature-url="{{ route('seller.products.toggle-featured', ['seller' => $seller->slug, 'id' => $product->id]) }}"
                                        data-feature-type="product"
                                        {{ $product->featured == 1 ? 'checked' : '' }}>
                                @endif
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </td>
                </tr>
            @endforeach
        @elseif ($activeTab == '1' && (int) $product->is_approved === 1)
            <tr class="border-b border-black/10">
                <td class="pl-5">{{ $loop->iteration }}</td>

                <td>
                    @php
                        $simpleProductImage = $product->primaryImage
                            ?? $product->primaryVariantImage
                            ?? $product->images->first();
                    @endphp

                    @if ($simpleProductImage)
                        <img src="{{ asset('storage/' . $simpleProductImage->image_path) }}"
                            class="w-10 h-14 object-cover rounded-md border">
                    @else
                        <span>No image</span>
                    @endif
                </td>

                <td class="table-p-name">{{ $product->name }}</td>

                <td>
                    <div class="editable-price flex items-center gap-2">
                        <span class="price-text">₹{{ number_format($product->price, 2) }}</span>

                        <input type="number" step="0.01" value="{{ $product->price }}"
                            data-product-id="{{ $product->id }}" data-mode="product"
                            data-update-url="{{ route('seller.products.update-price', [$seller->slug, $product->id]) }}"
                            class="price-input border rounded px-2 py-1 w-24 hidden">

                        <button type="button" class="edit-price-btn text-gray-600 hover:text-black">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                </td>

                <td>
                    <div class="editable-stock flex items-center gap-2">
                        <span class="stock-text">{{ $product->stock }}</span>

                        <input type="number" value="{{ $product->stock }}" data-product-id="{{ $product->id }}"
                            data-mode="product"
                            data-update-url="{{ route('seller.products.update-stock', [$seller->slug, $product->id]) }}"
                            class="stock-input border rounded px-2 py-1 w-20 hidden">

                        <button type="button" class="edit-stock-btn text-gray-600 hover:text-black">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                </td>

                <td class="actions-cell">
                    <div class="flex justify-center">
                        <label class="switch">
                            <input type="checkbox" class="feature-toggle" data-id="{{ $product->id }}"
                                data-feature-url="{{ route('seller.products.toggle-featured', ['seller' => $seller->slug, 'id' => $product->id]) }}"
                                data-feature-type="product" {{ $product->featured == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </td>
            </tr>
        @else
            {{-- Pending / Rejected --}}
            <tr class="border-b border-black/10">
                <td class="pl-5">{{ $loop->iteration }}</td>

                <td>
                    @php
                        $simpleProductImage = $product->primaryImage
                            ?? $product->primaryVariantImage
                            ?? $product->images->first();
                    @endphp

                    @if ($simpleProductImage)
                        <img src="{{ asset('storage/' . $simpleProductImage->image_path) }}"
                            class="w-10 h-14 object-cover rounded-md border">
                    @else
                        <span>No image</span>
                    @endif
                </td>

                <td class="table-p-name">{{ $product->name }}</td>

                <td>₹{{ number_format($product->price, 2) }}</td>

                <td>
                    @if ($product->is_approved == 0)
                        <span class="refund">Pending</span>
                    @elseif($product->is_approved == 2)
                        <span class="cancelled">Rejected</span>
                    @endif
                </td>

                <td class="actions-cell">
                    <button type="button"
                        onclick="window.location.href='{{ route('seller.products.edit', [$seller->slug, $product->id]) }}'"
                        class="bg-black text-white px-4 py-2 rounded-md text-sm">
                        Edit Product
                    </button>
                </td>
            </tr>
        @endif

    @empty
        <tr>
            <td colspan="6" class="text-center py-5">No products found</td>
        </tr>
    @endforelse
</tbody>


<style>
    .feature-toggle:checked+.toggle-bg {
        background: black;
    }

    .feature-toggle:checked+.toggle-bg+.dot {
        transform: translateX(20px);
    }
</style>
