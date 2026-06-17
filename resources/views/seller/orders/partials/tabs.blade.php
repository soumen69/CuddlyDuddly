<div class="tab-panels">

    {{-- ================= ORDERS TAB ================= --}}
    <div class="tab-panel {{ $activeTab == 'orders' ? '' : 'hidden' }}" data-tab="orders">
        <div class="overflow-x-auto w-full p-0">
            <table class="table-auto w-full sm:w-full seller-table">
                <thead>
                    <tr class="border-b border-black/20">
                        <th>Serial No</th>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b">
                            <td class="pl-5">{{ $loop->iteration }}</td>
                            <td>{{ $order->order_number ?? 'N/A' }}</td>

                            <td>
                                @foreach ($order->items as $item)
                                    @if ($item->product?->seller_id == $seller->id)
                                        <div>
                                            {{ $item->product->name }} (x{{ $item->quantity }})
                                        </div>
                                    @endif
                                @endforeach
                            </td>

                            <td>
                                ₹{{ number_format($order->items->where('product.seller_id', $seller->id)->sum('subtotal'), 2) }}
                            </td>
                            @php
                                $paymentStatus = $order->payment_status ?? 'pending';
                                if ($paymentStatus == 'paid') {
                                    $statusText = 'Paid';
                                    $statusClass = 'deliver-btn';
                                } elseif ($paymentStatus == 'failed') {
                                    $statusText = 'Failed';
                                    $statusClass = 'failed-btn';
                                } else {
                                    $statusText = 'Pending';
                                    $statusClass = 'pending-btn';
                                }
                            @endphp

                            <td><span class="{{ $statusClass }}">{{ $statusText }}</span></td>

                            <td>
                                <a href="{{ route('seller.orders.show', [$seller->slug, $order->id]) }}"
                                    class="popup cursor-pointer">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">No orders found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if (method_exists($orders, 'hasPages') && $orders->hasPages())
                <div class="mt-4 px-4" id="pagination-links">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ================= RETURN TAB ================= --}}
    <div class="tab-panel {{ $activeTab == 'return' ? '' : 'hidden' }}" data-tab="return">
        <div class="overflow-x-auto w-full p-0">
            <table class="table-auto w-full sm:w-full seller-table">
                <thead>
                    <tr class="border-b border-black/20">
                        <th>Return No</th>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $return)
                        <tr class="border-b">
                            <td class="pl-5">{{ $return->return_number }}</td>
                            <td>{{ $return->order->order_number ?? 'N/A' }}</td>
                            <td>{{ $return->orderItem?->product?->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($return->refund_amount, 2) }}</td>
                            <td>
                                <span class="refund">{{ ucfirst($return->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('seller.orders.show', [$seller->slug, $return->order_id]) }}"
                                    class="popup cursor-pointer">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">No return requests found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if (method_exists($returns, 'hasPages') && $returns->hasPages())
                <div class="mt-4 px-4" id="pagination-links">
                    {{ $returns->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ================= CANCELLATION TAB ================= --}}
    <div class="tab-panel {{ $activeTab == 'cancellation' ? '' : 'hidden' }}" data-tab="cancellation">
        <div class="overflow-x-auto w-full p-0">
            <table class="table-auto w-full sm:w-full seller-table">
                <thead>
                    <tr class="border-b border-black/20">
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cancellation as $order)
                        <tr class="border-b">
                            <td class="pl-5">{{ $order->order_number ?? 'N/A' }}</td>

                            <td>
                                @foreach ($order->items as $item)
                                    @if ($item->product?->seller_id == $seller->id)
                                        <div>
                                            {{ $item->product->name }} (x{{ $item->quantity }})
                                        </div>
                                    @endif
                                @endforeach
                            </td>

                            <td>
                                ₹{{ number_format($order->items->where('product.seller_id', $seller->id)->sum('subtotal'), 2) }}
                            </td>
                            <td>{{ ucfirst($order->payment_status ?? 'N/A') }}</td>
                            <td><span class="cancelled">Cancelled</span></td>
                            <td>
                                <a href="{{ route('seller.orders.show', [$seller->slug, $order->id]) }}"
                                    class="popup cursor-pointer">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">No cancelled orders found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if (method_exists($cancellation, 'hasPages') && $cancellation->hasPages())
                <div class="mt-4 px-4" id="pagination-links">
                    {{ $cancellation->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
