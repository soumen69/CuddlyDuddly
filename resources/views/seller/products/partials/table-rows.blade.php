@forelse($products as $product)
    <tr class="border-b border-black/10">
        <td class="pl-5">{{ $loop->iteration }}</td>
        <td class="table-p-name">{{ $product->name }}</td>
        <td>₹{{ number_format($product->price, 2) }}</td>
        <!-- <td>{{ $product->stock }}</td> -->
        <td>
            @if($product->is_approved == 1)
                <span class="deliver-btn">Approved</span>
            @elseif($product->is_approved == 0)
                <span class="refund">Pending</span>
            @elseif($product->is_approved == 2)
                <span class="cancelled">Rejected</span>
            @else
                <span class="text-gray-500">Unknown</span>
            @endif
        </td>
        <td class="actions-cell min-w-20 w-[10%]">
            <button type="button" class="action-btn cursor-pointer">
                <img src="{{ asset('storage/images/table-popup.png') }}" alt="">
            </button>
            <div class="action-dropdown">
                @if((int) ($product->is_variant ?? 1) === 0)
                    <a  href="{{ route('seller.products.variants.create', ['seller' => $seller->slug, 'productId' => $product->id]) }}" class="upload variant p-5 actions-button"
                    style="flex-direction:column; align-items:center;">
                       <i class="fa-solid fa-boxes-stacked"></i>
                    </a>
                @endif

                @if($product-> is_approved == 0)

                <a href="{{ route('seller.products.edit', [$seller->slug, $product->id]) }}" class="edit actions-button">
                   <i class="fa-solid fa-pen"></i>
                </a>
                @endif
                <form action="{{ route('seller.products.destroy', [$seller->slug, $product->id]) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="delete actions-button">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-5">No products found</td>
    </tr>
@endforelse
