@extends('seller.layouts.seller')

@section('title', 'Notification Details')

@section('content')
    <div class="seller-profile flex-1 min-w-0">
        @include('seller.layouts.header')
        <div class=" flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-[45px]">
            <div class="w-full">
                <div class="flex items-center gap-4 mb-6">
                    <button type="button" onclick="window.history.back()"
                        class="flex-none w-9 h-9 rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1182_398)">
                                <path d="M11.4647 21.4961L7.16551 17.1969L11.4647 12.8977" stroke="white"
                                    stroke-width="2.02667" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.16523 17.1969L27.2282 17.1969" stroke="white" stroke-width="2.02667"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_1182_398">
                                    <rect width="24.32" height="24.32" fill="white"
                                        transform="translate(17.1968 34.3937) rotate(-135)"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <div>
                        <h3
                            class="font-sans font-normal text-lg md:text-xl lg:text-2xl xl:text-3xl leading-tight tracking-1 text-black">
                            Notifications
                        </h3>
                        <p class="font-sans font-normal text-base leading-tight tracking-1 text-black">
                            Stay updated with product approvals, order alerts, return requests, and seller activities.
                        </p>
                    </div>
                </div>

                <!--notofication details-->
                @php
                    $productImage = null;

                    if ($product && $product->primaryImage && $product->primaryImage->image_path) {
                        $productImage = asset('storage/' . ltrim($product->primaryImage->image_path, '/'));
                    } elseif ($product && $product->images->first() && $product->images->first()->image_path) {
                        $productImage = asset('storage/' . ltrim($product->images->first()->image_path, '/'));
                    }

                    $productUrl = $product
                        ? route('seller.products.edit', [auth('seller')->user()->slug, $product->id])
                        : null;
                @endphp
                <div class="nd-wrap">

                    <!-- Left: notification image with status badge -->
                    <div class="nd-img-wrap">
                        <img src="{{ $productImage ?: asset('images/no-image.png') }}" alt="{{ $notification->title }}"
                            onerror="this.parentNode.style.background='#f0f0f0'">
                        <span class="nd-status-badge">
                            {{ ucfirst($notification->type ?? 'Notification') }}
                        </span>
                    </div>

                    <!-- Right: notification content -->
                    <div class="nd-content">

                        <!-- Meta: tag + date -->
                        <div class="nd-meta-row">
                            <span class="nd-tag">
                                {{ ucfirst($notification->type ?? 'Notification') }}
                            </span>

                            <span class="nd-date">
                                • {{ $notification->created_at?->format('M d, Y \a\t h:i A') }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h1 class="nd-title">
                            {{ $notification->title }}
                        </h1>

                        <!-- Description -->
                        <p class="nd-desc">
                            {{ $notification->details ?: $notification->message }}
                        </p>

                        <!-- Message card -->
                        <div class="nd-message-card">
                            <div class="nd-message-label">Message</div>
                            <p class="nd-message-text">
                                {{ $notification->message }}
                            </p>
                        </div>

                        <!-- Product info card -->
                        <div class="nd-product-card">
                            <div class="flex gap-4 items-center">
                                <div class="nd-product-img">
                                    <img src="{{ $productImage ?: asset('images/no-image.png') }}"
                                        alt="{{ $product?->name }}" onerror="this.parentNode.style.background='#f0f0f0'">
                                </div>
                                <div class="nd-product-info">
                                    <div class="nd-product-name">
                                        {{ $product?->name ?? 'No Product Linked' }}
                                    </div>
                                    <div class="nd-product-meta">ID: #PRD-90122 • SKU: EC-SLP-SM</div>
                                </div>
                            </div>
                            {{-- <button type="button" class="nd-mcp-btn">View Product</button> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
