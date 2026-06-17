<div class="h-[34vh] overflow-x-auto md:overflow-x-visible">
    <table class="table-auto w-full seller-table">
        <thead>
            <tr class="border-b border-black/20">
                <th class="pl-5">Serial No</th>
                <th>Product Image</th>
                <th class="table-p-name">Product</th>
                @if ($activeTab == '1')
                    <th>Price</th>
                    <th>Stock</th>
                @else
                    <th>Price</th>
                    <th>Status</th>
                @endif
                <th class="min-w-20 w-[10%]">Actions</th>
            </tr>
        </thead>
        <tbody id="productTable">
            @include('seller.products.partials.table-rows', ['products' => $products, 'seller' => $seller])
        </tbody>
    </table>
</div>

<div class="mt-6 px-5 flex items-center justify-between flex-wrap gap-4" id="paginationLinks">
    <div class="text-sm text-gray-500 font-sans">
        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
        results
    </div>
    <div class="custom-pagination">
        {{ $products->links('pagination::simple-tailwind') }}
    </div>
</div>
