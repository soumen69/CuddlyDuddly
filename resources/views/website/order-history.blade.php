@extends('website.layouts.website')

@section('title', 'Order History')

<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

@section('content')

    <div class="orders-page">
        <div class="container max-w-container mx-auto px-5">

            <h1 class="cart-header-label">
                My Orders
            </h1>

            <p class="text-sm text-[var(--color-silver)] mb-8">
                Manage and track all your purchases.
            </p>

            {{-- Toolbar --}}
            <div class="orders-toolbar">

                <form method="GET" class="contents">

                    <div class="orders-search-block">
                        <label class="order-filter-label">
                            Find your order
                        </label>

                        <div class="orders-search-wrap">

                            <span class="orders-search-icon">
                                <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                                    <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.5" />
                                    <line x1="10.5" y1="10.5" x2="14" y2="14" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </span>

                            <input type="text" class="orders-search-input" placeholder="Order ID" name="search"
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="orders-selects-wrap">

                        <div class="order-select-block">
                            <label class="order-filter-label">
                                Order Status
                            </label>

                            <select name="status" class="orders-select" onchange="this.form.submit()">

                                <option value="">All</option>

                                @foreach (['pending', 'confirmed', 'processing', 'shipped', 'out_for_delivery', 'delivered', 'cancelled'] as $status)
                                    <option value="{{ $status }}" @selected(request('status') == $status)>
                                        {{ ucwords(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="order-select-block">
                            <label for="periodFilter" class="order-filter-label">Time Period</label>
                            <select class="orders-select" id="periodFilter">
                                <option>Last 30 days</option>
                                <option>Last 60 days</option>
                                <option>Last 90 days</option>
                            </select>
                        </div>
                        <div class="order-select-block">
                            <label for="sortFilter" class="order-filter-label">Sort By</label>
                            <select class="orders-select" id="sortFilter" onchange="filterOrders()">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                            </select>
                        </div>

                    </div>

                </form>

            </div>


            @forelse($orders as $order)

                <div class="mb-10">

                    <div class="mb-5">

                        <p class="cart-header-label">
                            Order ID
                        </p>

                        <p class="text-sm text-[var(--color-silver)]">
                            #{{ $order->order_number }}
                        </p>

                    </div>


                    @foreach ($order->items as $item)
                        @php

                            $product = $item->product;

                            $image =
                                $item->variant?->image_url ??
                                ($product->primaryImage
                                    ? asset('storage/' . $product->primaryImage->image_path)
                                    : asset('images/product-placeholder.png'));

                            $status = $order->order_status;

                            switch ($status) {
                                case 'delivered':
                                    $badge = 'order-status-delivered';
                                    break;

                                case 'cancelled':
                                    $badge = 'order-status-cancelled';
                                    break;

                                default:
                                    $badge = 'order-status-out';
                            }
                        @endphp

                        <div class="order-card">

                            <div class="order-card-top">

                                <a href="{{ route('product.details', $product->slug) }}" class="order-product-img">

                                    <img src="{{ $image }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover"> </a>

                                <div class="order-card-info">

                                    <div class="order-price-row">

                                        <p class="order-product-name">
                                            {{ $product->name }} </p>

                                        <strong class="order-product-price">
                                            ₹{{ number_format($item->subtotal, 2) }}
                                        </strong>

                                    </div>

                                    <p class="order-product-desc">

                                        {{ \Illuminate\Support\Str::limit(strip_tags($product->short_description), 120) }}

                                    </p>

                                    <div class="order-meta-grid">

                                        <div>

                                            <div class="order-meta-label">
                                                Order Date
                                            </div>

                                            <div class="order-meta-value">
                                                {{ $order->created_at->format('d M Y') }}
                                            </div>

                                        </div>

                                        <div>

                                            <div class="order-meta-label">
                                                Quantity
                                            </div>

                                            <div class="order-meta-value">
                                                {{ $item->quantity }}
                                            </div>

                                        </div>

                                        <div>

                                            <div class="order-meta-label">
                                                Payment
                                            </div>

                                            <div class="order-meta-value">
                                                {{ ucfirst($order->payment_status) }}
                                            </div>

                                        </div>

                                        <div>

                                            <div class="order-meta-label">
                                                Status
                                            </div>

                                            <div class="order-meta-value">

                                                <span class="{{ $badge }}">
                                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                                </span>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="order-actions">

                                        @if ($status == 'delivered')
                                            <a href="{{ route('cart.reorder', $order->id) }}" class="mcp-btn">

                                                <img src="/storage/WebsiteImages/category/refresh.png" class="action-icon">

                                                Reorder

                                            </a>

                                            <a href="{{ route('review.create', $product->id) }}"
                                                class="mcp-btn mcp-btn-outline">

                                                <img src="/storage/WebsiteImages/category/write.png" class="action-icon">

                                                Write Review

                                            </a>
                                        @elseif(in_array($status, ['processing', 'shipped', 'out_for_delivery']))
                                            <a href="{{ route('orders.track', $order->id) }}" class="mcp-btn">

                                                <img src="/storage/WebsiteImages/category/track-order.png"
                                                    class="action-icon">

                                                Track Order

                                            </a>
                                        @elseif($status == 'cancelled')
                                            <a href="{{ route('cart.reorder', $order->id) }}" class="mcp-btn">

                                                <img src="/storage/WebsiteImages/category/refresh.png" class="action-icon">

                                                Buy Again

                                            </a>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            @empty

                <div class="text-center py-20">

                    <img src="{{ asset('storage/WebsiteImages/empty-cart.webp') }}" class="mx-auto w-20 h-auto mb-5">

                    <h3 class="text-xl font-semibold">
                        No Orders Yet
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Looks like you haven't placed any orders.
                    </p>

                    <a href="{{ route('home') }}" class="mcp-btn mt-6">

                        Place Order

                    </a>

                </div>
            @endforelse


            <div class="mt-8">
                {{ $orders->withQueryString()->links() }}
            </div>

        </div>
    </div>

@endsection
