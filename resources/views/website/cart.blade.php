@extends('website.layouts.website')

@section('title', 'Cart | CuddlyDuddly')

<link rel="stylesheet" href="{{ asset('css/product-details.css') }}">
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
<link rel="stylesheet" href="{{ asset('css/seller-registration.css') }}">

@section('content')

    <div class="checkout-header">
        <div class="container max-w-container mx-auto px-5">
            <div class="flex items-center justify-between py-5">
                <span class="text-xl font-bold text-gray-900 hidden sm:block">Checkout</span>
                <!-- Step Bar -->
                <div class="checkout-step-bar" id="stepBar">
                    <!-- Step 1 -->
                    <div class="checkout-step-item">
                        <div class="checkout-step-circle active" id="circle1">1</div>
                        <span class="checkout-step-label active" id="label1">Cart</span>
                    </div>
                    <!-- Step 2 -->
                    <div class="checkout-step-item">
                        <div class="checkout-step-circle inactive" id="circle2">2</div>
                        <span class="checkout-step-label inactive" id="label2">Address</span>
                    </div>
                    <!-- Step 3 -->
                    <div class="checkout-step-item">
                        <div class="checkout-step-circle inactive" id="circle3">3</div>
                        <span class="checkout-step-label inactive" id="label3">Payment</span>
                    </div>
                    <!-- Step 4 -->
                    <div class="checkout-step-item">
                        <div class="checkout-step-circle inactive" id="circle4">4</div>
                        <span class="checkout-step-label inactive" id="label4">Summary</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container max-w-container mx-auto px-5">
        <div class="pt-8">

            <!-- ==================== STEP 1: CART ==================== -->
            <div class="step-panel active-panel" id="step1">
                @if (count($cartItems) > 0)
                    <!-- Shopping Cart -->
                    <div class="shopping-cart-section mb-6">
                        <h2 class="cart-header-label">Shopping Cart</h2>
                        <p class="text-sm md:text-base text-black mb-8">
                            {{ count($cartItems) }} items in your cart
                        </p>
                        @foreach ($cartItems as $item)
                            <div class="cart-product-card" id="cartItem_{{ $item->id }}">
                                <a href="#!" class="cart-product-img">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="product" />
                                </a>

                                <div class="cart-product-info">
                                    <div class="cart-product-info-box">

                                        <!-- PRODUCT NAME -->
                                        <div class="cart-header-label">
                                            {{ $item->name }}
                                        </div>

                                        <!-- SHORT DESCRIPTION -->
                                        @if ($item->description)
                                            <div class="cart-product-desc">
                                                {{ Str::limit($item->description, 80) }}
                                            </div>
                                        @endif

                                        <!-- VARIANT ATTRIBUTES -->
                                        @if (!empty($item->attributes))
                                            <div class="cart-product-meta">
                                                @foreach ($item->attributes as $attr)
                                                    <span class="block">
                                                        {{ $attr['name'] }}: {{ $attr['value'] }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- QUANTITY -->
                                        <div class="cart-product-meta">
                                            <span class="inline-flex items-center gap-1 whitespace-nowrap">
                                                Qty: <span id="qtyLabel_{{ $item->id }}">{{ $item->qty }}</span>
                                            </span>
                                        </div>

                                        <!-- PRICE -->
                                        {{-- <div class="cart-header-label mb-0 mt-1.5">
                                            ₹{{ number_format($item->price, 2) }}
                                        </div> --}}
                                        <div class="cart-header-label mb-0 mt-1.5" id="price_{{ $item->id }}">
                                            ₹{{ number_format($item->price * $item->qty, 2) }}
                                        </div>

                                    </div>
                                </div>
                                <div class="cart-qty-control-action">
                                    <div class="cart-qty-control">
                                        <div class="mcp-qty-row">
                                            <button type="button" class="mcp-qty-btn"
                                                onclick="updateQty({{ $item->id }}, -1)">−</button>
                                            <span id="qty_{{ $item->id }}"
                                                class="mcp-qty-val">{{ $item->qty }}</span>
                                            <button type="button" class="mcp-qty-btn"
                                                onclick="updateQty({{ $item->id }}, 1)">+</button>
                                        </div>
                                    </div>
                                    <button type="button" class="cart-delete-btn"
                                        onclick="removeCartItem({{ $item->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="36" height="36" viewBox="0 0 36 36" fill="none">
                                            <rect width="35.6126" height="35.6128" fill="url(#pattern0_2217_714)" />
                                            <defs>
                                                <pattern id="pattern0_2217_714" patternContentUnits="objectBoundingBox"
                                                    width="1" height="1">
                                                    <use xlink:href="#image0_2217_714" transform="scale(0.00781255)" />
                                                </pattern>
                                                <image id="image0_2217_714" width="128" height="128"
                                                    preserveAspectRatio="none"
                                                    xlink:href="data:image/png;base64,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" />
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Order Summary -->
                    <div class="cart-section-card">
                        <h3 class="text-base text-black mb-3">Order Summary</h3>
                        @php
                            $shipping = 0;
                            $tax = 0;
                            $grandTotal = $total + $shipping + $tax;
                        @endphp

                        <div class="order-summary-row">
                            <span>Subtotal</span>
                            <span id="cartSubtotal">₹{{ number_format($total, 2) }}</span>
                        </div>

                        <div class="order-summary-row">
                            <span>Shipping</span>
                            <span>₹{{ $shipping }}</span>
                        </div>

                        <div class="order-summary-row">
                            <span>Tax</span>
                            <span>₹{{ $tax }}</span>
                        </div>

                        <div class="order-summary-row order-summary-total">
                            <span>Total</span>
                            <span id="cartTotal">₹{{ number_format($grandTotal, 2) }}</span>
                        </div>

                        <!-- Promo Code -->
                        <div class="promo-input-wrap mt-5">
                            <input type="text" class="promo-input" placeholder="Enter promo code" />
                            <button type="button" class="mcp-btn promo-apply-btn">Apply Code</button>
                        </div>

                        <!-- Continue Button -->
                        <button type="button" class="mcp-btn w-full" onclick="goToStep(2)">Continue</button>
                    </div>
                @else
                    <!-- ================= EMPTY CART UI ================= -->
                    <div class="flex flex-col items-center justify-center text-center py-20">
                        <!-- SVG Illustration -->
                        <div class="mb-6">
                            <img src="{{ asset('storage/WebsiteImages/empty-cart.webp') }}" class=""
                                alt="Empty Cart">
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            Your cart is empty
                        </h2>




                        <p class="text-gray-500 mb-6">
                            Looks like you haven’t added anything yet.
                        </p>
                        <a href="{{ route('home') }}" class="mcp-btn px-6">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>
            <!-- ==================== STEP 2: ADDRESS ==================== -->
            <div class="step-panel" id="step2">

                <!-- Saved Addresses -->
                <div class="shopping-cart-section">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                        <div>
                            <h2 class="cart-header-label">Shipping &amp; Billing Address</h2>
                            <p class="text-sm md:text-base text-black mb-8">Please provide your delivery and billing
                                information
                            </p>
                        </div>
                        <button type="button" class="mcp-btn mcp-btn-outline"
                            onclick="event.stopPropagation(); toggleAddressForm()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add new address
                        </button>
                    </div>

                    <!-- Addresses Grid -->
                    <div id="savedAddressesGrid" class="grid sm:grid-cols-2 gap-3 mb-4">
                        @foreach ($addresses as $address)
                            <div class="cart-address-card {{ $address->is_default ? 'selected' : '' }}"
                                onclick="selectAddress(this)" data-id="{{ $address->id }}"
                                data-default="{{ $address->is_default ? 1 : 0 }}">

                                <div class="flex gap-2 w-[calc(100%-36px)]">

                                    <div class="cart-address-card-radio {{ $address->is_default ? 'selected' : '' }}">
                                        <div class="cart-address-card-radio-dot"
                                            style="{{ $address->is_default ? 'display:block' : 'display:none' }}"></div>
                                    </div>

                                    <div class="flex-grow">
                                        <!-- NAME -->
                                        <p class="cart-header-label">
                                            <span>{{ $address->shipping_name }}</span>

                                            @if ($address->is_default)
                                                <span class="ml-2 text-xs text-green-600 font-semibold">(Default)</span>
                                            @endif
                                        </p>
                                        <div class="cart-address-card-line">
                                            <!-- FULL ADDRESS -->
                                            <p>
                                                <span>{{ $address->address_line1 }}</span>

                                                @if ($address->address_line2)
                                                    <span>, {{ $address->address_line2 }}</span>
                                                @endif
                                            </p>
                                            <p>
                                                <span>{{ $address->city }}</span>,
                                                <span>{{ $address->state }}</span> -
                                                <span>{{ $address->postal_code }}</span>
                                            </p>

                                            @if ($address->landmark)
                                                <p>
                                                    <span class="font-semibold">Landmark:</span>
                                                    <span>{{ $address->landmark }}</span>
                                                </p>
                                            @endif
                                        </div>
                                        <!-- CONTACT -->
                                        <p class="cart-address-card-line">
                                            <span>📞 {{ $address->shipping_phone }}</span>
                                        </p>
                                        @if ($address->shipping_email)
                                            <p class="cart-address-card-line">
                                                <span>✉️ {{ $address->shipping_email }}</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <button type="button" class="mcp-btn w-full"
                                    onclick="event.stopPropagation(); setAddress({{ $address->id }})">
                                    Deliver to this Address
                                </button>

                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Add New Address Form -->
                <form id="add_address_form" class="add-address-form mt-12 hidden" onsubmit="saveAddress(event)">

                    <div class="grid sm:grid-cols-2 gap-x-3">
                        <div class="cd-field-group">
                            <label class="cd-field-label">Recipient Name</label>
                            <input type="text" name="shipping_name" class="cd-input" required />
                        </div>

                        <div class="cd-field-group">
                            <label class="cd-field-label">Email Address</label>
                            <input type="email" name="shipping_email" class="cd-input" />
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-x-3">
                        <div class="cd-field-group">
                            <label class="cd-field-label">Phone Number</label>
                            <input type="tel" name="shipping_phone" class="cd-input" required />
                        </div>

                        <div class="cd-field-group">
                            <label class="cd-field-label">Postal Code (PIN)</label>
                            <input type="text" name="postal_code" id="postal_code" class="cd-input" required
                                onblur="fetchPincodeData()" />
                        </div>
                    </div>

                    <div class="cd-field-group">
                        <label class="cd-field-label">Address Line 1</label>
                        <input type="text" name="address_line1" class="cd-input" required />
                    </div>

                    <div class="cd-field-group">
                        <label class="cd-field-label">Address Line 2</label>
                        <input type="text" name="address_line2" class="cd-input" />
                    </div>

                    <div class="cd-field-group">
                        <label class="cd-field-label">Landmark</label>
                        <input type="text" name="landmark" class="cd-input" />
                    </div>

                    <div class="grid sm:grid-cols-2 gap-x-3">
                        <div class="cd-field-group">
                            <label class="cd-field-label">City</label>
                            <input type="text" name="city" id="city" class="cd-input" readonly />
                        </div>

                        <div class="cd-field-group">
                            <label class="cd-field-label">State</label>
                            <input type="text" name="state" id="state" class="cd-input" readonly />
                        </div>
                    </div>

                    <div class="cd-field-group">
                        <label class="cd-field-label">Country</label>
                        <input type="text" name="country" class="cd-input" value="India" readonly />
                    </div>

                    <button type="submit" class="mcp-btn w-full">
                        Save Address and Continue
                    </button>

                </form>

                <!-- Back button -->
                <button type="button" onclick="goToStep(1)"
                    class="cursor-pointer flex items-center gap-0.5 text-base font-normal text-black hover:text-[var(--color-pink-transparent)] mt-4 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Cart
                </button>
            </div>

            <!-- ==================== STEP 3: PAYMENT ==================== -->
            <div class="step-panel" id="step3">
                <h2 class="cart-header-label mb-6">Select Payment Method</h2>

                <!-- Left: Payment Methods -->
                <div class="pay-methods-section">
                    <!-- Cash on Delivery -->
                    <div class="pay-method-card-wrapper" id="payCard_cod" onclick="selectPayment('cod')">
                        <div class="pay-method-card">
                            <div class="pay-method-icon">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="pay-method-title">Cash on Delivery</p>
                                <p class="pay-method-subtitle">Pay at the time of delivery</p>
                            </div>
                            <div class="pay-method-price">₹12,620</div>
                            <div class="pay-method-card-radio" id="payRadio_cod">
                                <div class="pay-method-card-radio-dot" style="display:none" id="payDot_cod"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Pay Online (default selected) -->
                    @php
                        $originalTotal = 0;
                        $finalTotal = 0;

                        foreach ($cartItems as $item) {
                            $original = $item->variant?->compare_price ?? $item->product->price;
                            $final = $item->price;

                            $originalTotal += $original * $item->qty;
                            $finalTotal += $final * $item->qty;
                        }

                        $discount = $originalTotal - $finalTotal;
                    @endphp

                    <div class="pay-method-card-wrapper selected" id="payCard_online" onclick="selectPayment('online')">
                        <div class="pay-method-card">

                            <div class="pay-method-icon">
                                <i class="fa-solid fa-bolt-lightning"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="pay-method-title">
                                    Pay Online
                                    <span class="pay-recommended-badge">RECOMMENDED</span>
                                </p>

                                <p class="pay-method-subtitle flex flex-wrap items-center gap-1 mt-0.5">

                                    @if ($discount > 0)
                                        <del class="pay-original-price">₹{{ number_format($originalTotal, 2) }}</del>
                                    @endif

                                    <span class="pay-offer-price">₹{{ number_format($finalTotal, 2) }}</span>

                                    @if ($discount > 0)
                                        <span class="pay-save-badge">
                                            Save ₹{{ number_format($discount, 2) }}
                                        </span>
                                    @endif

                                </p>
                            </div>

                            <div class="pay-method-price">
                                ₹{{ number_format($finalTotal, 2) }}
                            </div>

                            <div class="pay-method-card-radio selected" id="payRadio_online">
                                <div class="pay-method-card-radio-dot" id="payDot_online"></div>
                            </div>

                        </div>

                        <div class="pay-discount-row">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Extra discount with bank offers & digital wallets
                        </div>
                    </div>
                </div>

                @php
                    $itemCount = count($cartItems);

                    $subtotal = 0;
                    $discount = 0;

                    foreach ($cartItems as $item) {
                        $original = $item->variant?->compare_price ?? $item->product->price;
                        $final = $item->price;

                        $subtotal += $final * $item->qty;

                        if ($original > $final) {
                            $discount += ($original - $final) * $item->qty;
                        }
                    }

                    $shipping = 0; // free for now
                    $total = $subtotal - $discount + $shipping;
                @endphp

                <div class="cart-section-card">
                    <h3 class="text-base text-black mb-3">
                        Price Details <span>({{ $itemCount }} Items)</span>
                    </h3>

                    <div class="order-summary-row">
                        <span>Product Price</span>
                        <span>₹{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="order-summary-row">
                        <span>Shipping Fee</span>
                        <span class="text-xs text-[#1D6E25] font-semibold uppercase">Free</span>
                    </div>

                    <div class="order-summary-row">
                        <span>Total Discounts</span>
                        <span>-₹{{ number_format($discount, 2) }}</span>
                    </div>

                    <div class="order-summary-row order-summary-total">
                        <span>Order Total</span>
                        <span>₹{{ number_format($total, 2) }}</span>
                    </div>

                    @if ($discount > 0)
                        <div class="pay-savings-banner">
                            🎉 YAY! YOUR TOTAL DISCOUNT IS ₹{{ number_format($discount, 2) }}
                        </div>
                    @endif

                    <button id="placeOrderBtn" type="button" class="pay-place-order-btn mcp-btn w-full"
                        onclick="placeOrder()">
                        <span id="btnText">Place Order</span>

                        <span id="btnLoader" style="display:none; margin-left:8px;">
                            <svg width="18" height="18" viewBox="0 0 50 50">
                                <circle cx="25" cy="25" r="20" fill="none" stroke="white"
                                    stroke-width="4" stroke-linecap="round" stroke-dasharray="31.4 31.4">
                                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite"
                                        dur="0.8s" values="0 25 25;360 25 25" />
                                </circle>
                            </svg>
                        </span>
                    </button>

                    <div class="pay-secure-text">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        100% Secure Payments
                    </div>
                </div>

                <div class="pay-card-icons">
                    <div class="pay-card-icon">
                        <svg viewBox="0 0 38 24" width="36" height="22">
                            <rect width="38" height="24" rx="4" fill="#1A1F71" /><text x="5" y="16"
                                fill="white" font-size="9" font-weight="bold" font-family="Arial">VISA</text>
                        </svg>
                    </div>
                    <div class="pay-card-icon">
                        <svg viewBox="0 0 38 24" width="36" height="22">
                            <rect width="38" height="24" rx="4" fill="#fff" />
                            <circle cx="15" cy="12" r="7" fill="#EB001B" />
                            <circle cx="23" cy="12" r="7" fill="#F79E1B" />
                            <path d="M19 6.8a7 7 0 010 10.4A7 7 0 0119 6.8z" fill="#FF5F00" />
                        </svg>
                    </div>
                    <div class="pay-card-icon">
                        <svg viewBox="0 0 38 24" width="36" height="22">
                            <rect width="38" height="24" rx="4" fill="#006FCF" /><text x="4" y="16"
                                fill="white" font-size="7" font-weight="bold" font-family="Arial">AMEX</text>
                        </svg>
                    </div>
                </div>

                <button type="button" onclick="goToStep(2)"
                    class="cursor-pointer flex items-center gap-0.5 text-base font-normal text-black hover:text-[var(--color-pink-transparent)] mt-2 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Address
                </button>
            </div>

            <!-- ==================== STEP 4: ORDER SUMMARY ==================== -->
            <div class="step-panel" id="step4">
                <div class="flex flex-col md:flex-row gap-4 md:items-start">
                    <!-- Left: Order Details + Items -->
                    <div class="grow">
                        <!-- Order Details -->
                        <div class="order-detail-card">
                            <h2 class="cart-header-label flex items-center gap-2">
                                <img src="{{ asset('storage/WebsiteImages/category/order.png') }}" alt="order icon"
                                    class="max-w-5">
                                Order Details
                            </h2>
                            <div class="order-detail-grid">
                                <div>
                                    <div class="order-detail-label">Order ID</div>
                                    <div class="order-detail-value" id="orderId"></div>
                                </div>
                                <div>
                                    <div class="order-detail-label">Order Date</div>
                                    <div class="order-detail-value" id="orderDate"></div>
                                </div>
                                <div>
                                    <div class="order-detail-label">Payment Method</div>
                                    <div class="order-detail-value" id="orderPayment"></div>
                                </div>
                                <div>
                                    <div class="order-detail-label">Delivery Address</div>
                                    <div class="order-detail-value text-sm" id="orderAddress"></div>
                                </div>
                            </div>
                        </div>

                        <div class="order-items-card" id="orderItemsContainer">
                            <h2 class="cart-header-label">Items Purchased</h2>
                        </div>

                        <!-- Action Buttons -->
                        <div class="order-action-btns">
                            <a href="{{ route('home') }}" class="mcp-btn">Continue Shopping</a>
                            <a href="{{ route('order-history') }}" class="mcp-btn mcp-btn-outline">
                                View Order History
                            </a>
                        </div>
                    </div>

                    <!-- Right: Price Summary -->
                    <div class="md:w-[32%] shrink-0">
                        <div class="order-price-summary">
                            <h3 class="cart-header-label">Price Summary</h3>

                            <div class="order-price-summary-row">
                                <span>Subtotal</span>
                                <span id="summarySubtotal">₹0</span>
                            </div>

                            <div class="order-price-summary-row free">
                                <span>Shipping Fee</span>
                                <span>Free</span>
                            </div>

                            <div class="order-price-summary-row discount">
                                <span>Discount</span>
                                <span id="summaryDiscount">₹0</span>
                            </div>

                            <div class="order-price-summary-row total">
                                <span>Total Amount <strong id="summaryTotal">₹0</strong></span>
                                <small class="pay-save-badge">PAID</small>
                            </div>
                        </div>

                        <!-- Estimated Delivery -->
                        <div class="estimate-delivery-box">
                            <div class="order-delivery-box">
                                <div class="estimate-delivery-icon">
                                    <img src="{{ asset('storage/WebsiteImages/category/shipping.webp') }}"
                                        alt="delivery icon" class="max-h-3.5 w-auto">
                                </div>
                                <div>
                                    <p class="text-xs text-[var(--color-silver)] mb-1">Estimated Delivery</p>
                                    <p class="text-base text-black mb-0">{{ now()->addDays(5)->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <!-- Track Order -->
                            <a href="#!" class="mcp-btn w-full">
                                <img src="{{ asset('storage/WebsiteImages/category/track.webp') }}" alt="Track Order"
                                    class="max-w-2.5 w-auto">
                                Track Orders
                            </a>
                        </div>

                        <!-- Need Help -->
                        <div class="order-help-box">
                            <p class="font-semibold text-xs text-[#614112] mb-1">Need Help?</p>
                            <p class="text-xs text-[rgba(97,65,18,0.8)] mb-0">If you have any questions about your order,
                                please contact our support team 24/7.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (() => {

            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            let selectedAddressId = null;
            let currentStep = 1;

            document.addEventListener('DOMContentLoaded', () => {
                const defaultCard = document.querySelector('.cart-address-card[data-default="1"]');
                if (defaultCard) selectAddress(defaultCard);
            });

            // ================= COMMON FETCH =================
            const postJSON = async (url, data = {}) => {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify(data)
                });
                return res.json();
            };

            // ================= STEP NAVIGATION =================
            window.goToStep = (step) => {

                if (step === 3 && !selectedAddressId) {
                    showToast({
                        title: "Oops!",
                        message: "Please select address first",
                        type: "warning"
                    });
                    return;
                }

                document.getElementById('step' + currentStep).classList.remove('active-panel');

                for (let i = 1; i <= 4; i++) {
                    const circle = document.getElementById('circle' + i);
                    const label = document.getElementById('label' + i);

                    circle.className = 'checkout-step-circle';
                    label.className = 'checkout-step-label';

                    if (i < step) {
                        circle.classList.add('done');
                        circle.innerHTML = '✔';
                        label.classList.add('active');
                    } else if (i === step) {
                        circle.classList.add('active');
                        circle.innerHTML = i;
                        label.classList.add('active');
                    } else {
                        circle.classList.add('inactive');
                        circle.innerHTML = i;
                        label.classList.add('inactive');
                    }
                }

                if (step === 2) {
                    document.getElementById('savedAddressesGrid').style.display = '';
                    document.getElementById('add_address_form').style.display = 'none';
                }

                currentStep = step;
                document.getElementById('step' + step).classList.add('active-panel');

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };

            window.updateQty = async (cartId, delta) => {
                const btns = document.querySelectorAll(`#cartItem_${cartId} .mcp-qty-btn`);
                btns.forEach(b => b.disabled = true);
                try {
                    const res = await postJSON('/cart/update', {
                        cart_id: cartId,
                        delta
                    });

                    if (!res.success) {
                        showToast({
                            title: "Oops!",
                            message: res.message || "Something went wrong",
                            type: "warning"
                        });
                        return;
                    }

                    const item = res.item;
                    // ✅ Update qty
                    const qtyEl = document.getElementById(`qty_${item.id}`);
                    if (qtyEl) qtyEl.innerText = item.qty;
                    // ✅ Update "Qty:" label also
                    const qtyLabel = document.getElementById(`qtyLabel_${item.id}`);
                    if (qtyLabel) qtyLabel.innerText = item.qty;
                    // ✅ Update item total
                    document.getElementById(`price_${item.id}`).innerText =
                        `₹${item.total.toFixed(2)}`;
                    // ✅ Update summary
                    document.getElementById('cartSubtotal').innerText =
                        `₹${res.cart.subtotal.toFixed(2)}`;
                    document.getElementById('cartTotal').innerText =
                        `₹${res.cart.grand_total.toFixed(2)}`;
                    // ✅ Optional subtle feedback
                    showToast({
                        title: "Updated",
                        message: "Cart updated successfully",
                        type: "success",
                        duration: 1200
                    });
                    // ✅ Update navbar badge
                    if (typeof updateCartBadge === "function") {
                        updateCartBadge(res.cart.count);
                    }

                } catch (e) {
                    showToast({
                        title: "Error",
                        message: "Network issue. Please try again.",
                        type: "error"
                    });
                } finally {
                    btns.forEach(b => b.disabled = false);
                }
            };

            window.removeCartItem = async (cartId) => {
                const el = document.getElementById(`cartItem_${cartId}`);
                try {
                    const res = await postJSON('/cart/remove', {
                        cart_id: cartId
                    });
                    if (!res.success) {
                        showToast({
                            title: "Error",
                            message: "Failed to remove item",
                            type: "error"
                        });
                        return;
                    }
                    if (el) {
                        el.style.transition = "opacity 0.3s ease";
                        el.style.opacity = 0;
                        setTimeout(() => el.remove(), 300);
                    }
                    document.getElementById('cartSubtotal').innerText =
                        `₹${res.cart.subtotal.toFixed(2)}`;
                    document.getElementById('cartTotal').innerText =
                        `₹${res.cart.grand_total.toFixed(2)}`;
                    // ✅ Empty cart UI
                    if (res.cart.count === 0) {
                        document.getElementById('step1').innerHTML = `
                            <div class="flex flex-col items-center justify-center text-center py-20">
                                <h2 class="text-xl font-semibold mb-2">Your cart is empty 🛒</h2>
                                <p class="text-gray-500 mb-6">Looks like you haven’t added anything yet.</p>
                                <a href="/" class="mcp-btn">Start Shopping</a>
                            </div>`;
                    }
                    showToast({
                        title: "Removed",
                        message: "Item removed from cart",
                        type: "success"
                    });
                    if (typeof updateCartBadge === "function") {
                        updateCartBadge(res.cart.count);
                    }
                } catch (e) {
                    showToast({
                        title: "Error",
                        message: "Network issue. Try again.",
                        type: "error"
                    });
                }
            };

            // ================= ADDRESS =================
            window.selectAddress = (card) => {

                document.querySelectorAll('.cart-address-card').forEach(c => {
                    c.classList.remove('selected');
                    c.querySelector('.cart-address-card-radio').classList.remove('selected');
                    c.querySelector('.cart-address-card-radio-dot').style.display = 'none';
                });

                card.classList.add('selected');
                card.querySelector('.cart-address-card-radio').classList.add('selected');
                card.querySelector('.cart-address-card-radio-dot').style.display = 'block';

                selectedAddressId = card.dataset.id;
            };

            window.setAddress = (id) => {
                selectedAddressId = id;
                goToStep(3);
            };

            window.toggleAddressForm = () => {
                const grid = document.getElementById('savedAddressesGrid');
                const form = document.getElementById('add_address_form');

                const showForm = form.style.display !== 'block';

                grid.style.display = showForm ? 'none' : '';
                form.style.display = showForm ? 'block' : 'none';
            };

            window.fetchPincodeData = async () => {
                const pincode = document.getElementById('postal_code').value;

                if (pincode.length !== 6) return;

                try {
                    const res = await fetch(`https://api.postalpincode.in/pincode/${pincode}`);
                    const data = await res.json();

                    if (data[0].Status !== "Success") {
                        showToast({
                            title: "Invalid PIN",
                            message: "Please enter a valid PIN code",
                            type: "warning"
                        });
                        return;
                    }

                    const postOffice = data[0].PostOffice[0];

                    document.getElementById('city').value = postOffice.District;
                    document.getElementById('state').value = postOffice.State;

                } catch {
                    showToast({
                        title: "Error",
                        message: "Failed to fetch location",
                        type: "error"
                    });
                }
            };

            window.saveAddress = async (e) => {
                e.preventDefault();

                const form = document.getElementById('add_address_form');

                const data = Object.fromEntries(new FormData(form));

                if (!data.city || !data.state) {
                    showToast({
                        title: "Invalid PIN",
                        message: "Please enter a valid PIN code",
                        type: "warning"
                    });
                }

                const res = await postJSON('/checkout/save-address', data);

                if (!res.success) return alert(res.message || 'Error');

                selectedAddressId = res.id;
                goToStep(3);
            };

            // ================= PAYMENT =================
            window.selectPayment = (method) => {
                ['cod', 'online'].forEach(m => {
                    document.getElementById('payCard_' + m).classList.remove('selected');
                    document.getElementById('payRadio_' + m).classList.remove('selected');
                    document.getElementById('payDot_' + m).style.display = 'none';
                });

                document.getElementById('payCard_' + method).classList.add('selected');
                document.getElementById('payRadio_' + method).classList.add('selected');
                document.getElementById('payDot_' + method).style.display = 'block';
            };

            // ================= RAZORPAY =================
            const loadRazorpayScript = () => new Promise(resolve => {
                if (window.Razorpay) return resolve(true);

                const script = document.createElement('script');
                script.src = "https://checkout.razorpay.com/v1/checkout.js";

                script.onload = () => resolve(true);
                script.onerror = () => resolve(false);

                document.body.appendChild(script);
            });


            let isPlacingOrder = false;

            window.placeOrder = async () => {

                if (isPlacingOrder) return; // 🔥 HARD BLOCK multi-click

                const btn = document.getElementById('placeOrderBtn');
                const btnText = document.getElementById('btnText');
                const btnLoader = document.getElementById('btnLoader');

                if (!selectedAddressId) {
                    showToast({
                        title: "Oops!",
                        message: "Please select address",
                        type: "warning"
                    });
                    return;
                }

                try {
                    isPlacingOrder = true;

                    // UI state
                    btn.disabled = true;
                    btnText.innerText = "Placing Order...";
                    btnLoader.style.display = "inline-flex";

                    const data = await postJSON('/checkout/initiate', {
                        address_id: selectedAddressId
                    });

                    if (!data.success) throw new Error(data.message);

                    // ================= MOCK =================
                    if (data.mode === 'mock') {
                        const res = await postJSON('/checkout/success');

                        if (!res.success) throw new Error('Order failed');

                        handleOrderSuccess(res.order);
                        return;
                    }

                    // ================= RAZORPAY =================
                    const loaded = await loadRazorpayScript();
                    if (!loaded) throw new Error('Payment failed to load');

                    const rzp = new Razorpay({
                        key: data.key,
                        amount: data.amount,
                        order_id: data.order_id,

                        handler: async function(response) {
                            const res = await postJSON('/checkout/success', response);

                            if (res.success) {
                                handleOrderSuccess(res.order);
                            } else {
                                throw new Error("Payment verification failed");
                            }
                        },

                        modal: {
                            ondismiss: () => resetPlaceOrderBtn()
                        }
                    });

                    rzp.open();

                } catch (err) {

                    showToast({
                        title: "Error",
                        message: err.message || "Something went wrong",
                        type: "error"
                    });

                    resetPlaceOrderBtn();
                }
            };

            function handleOrderSuccess(order) {

                showToast({
                    title: "Order Placed 🎉",
                    message: "Your order has been placed successfully!",
                    type: "success",
                    duration: 2000
                });

                renderOrderSummary(order);

                setTimeout(() => {
                    goToStep(4);
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 800);

                window.dispatchEvent(new CustomEvent("cart:updated", {
                    detail: {
                        cart: {
                            count: 0
                        }
                    }
                }));

                resetPlaceOrderBtn();
            }

            function resetPlaceOrderBtn() {
                const btn = document.getElementById('placeOrderBtn');
                const btnText = document.getElementById('btnText');
                const btnLoader = document.getElementById('btnLoader');

                isPlacingOrder = false;
                btn.disabled = false;
                btnText.innerText = "Place Order";
                btnLoader.style.display = "none";
            }

            function renderOrderSummary(order) {

                // ===== BASIC DETAILS =====
                document.getElementById('orderId').innerText = order.id;
                document.getElementById('orderDate').innerText = order.date;
                document.getElementById('orderPayment').innerText = order.payment_method;
                document.getElementById('orderAddress').innerText = order.address;

                // ===== ITEMS =====
                const container = document.getElementById('orderItemsContainer');
                container.innerHTML = `<h2 class="cart-header-label">Items Purchased</h2>`;

                let subtotal = 0;
                let discount = 0;

                order.items.forEach(item => {

                    subtotal += item.price * item.qty;

                    container.innerHTML += `
                        <div class="flex justify-between border-b py-3">
                            <div>
                                <p class="font-medium">${item.name}</p>
                                <p class="text-sm text-gray-500">Qty: ${item.qty}</p>
                            </div>
                            <div class="text-right">
                                ₹${(item.price * item.qty).toFixed(2)}
                            </div>
                        </div>
                    `;
                });

                // ===== SUMMARY =====
                document.getElementById('summarySubtotal').innerText = `₹${subtotal.toFixed(2)}`;
                document.getElementById('summaryDiscount').innerText = `₹${discount.toFixed(2)}`;
                document.getElementById('summaryTotal').innerText = `₹${subtotal.toFixed(2)}`;
            }


            // window.placeOrder = async () => {

            //     const btn = document.getElementById('placeOrderBtn');
            //     const loader = document.getElementById('orderLoader');

            //     btn.disabled = true;
            //     loader.style.display = 'flex';

            //     if (!selectedAddressId) {
            //         return showToast({
            //             title: "Oops!",
            //             message: "Please select address",
            //             type: "warning"
            //         });
            //     }

            //     const data = await postJSON('/checkout/initiate', {
            //         address_id: selectedAddressId
            //     });

            //     if (!data.success) return alert(data.message);

            //     if (data.mode === 'mock') {
            //         const res = await postJSON('/checkout/success');

            //         if (!res.success) return alert('Order failed');

            //         showToast({
            //             title: "Order Placed 🎉",
            //             message: "Your order has been placed successfully!",
            //             type: "success",
            //             duration: 2000
            //         });

            //         renderOrderSummary(res.order);

            //         setTimeout(() => {
            //             goToStep(4);
            //             window.scrollTo({
            //                 top: 0,
            //                 behavior: 'smooth'
            //             });
            //         }, 1200);

            //         window.dispatchEvent(new CustomEvent("cart:updated", {
            //             detail: {
            //                 cart: {
            //                     count: 0
            //                 }
            //             }
            //         }));

            //         return; // 🔥🔥🔥 THIS WAS MISSING (CRITICAL FIX)
            //     }

            //     const loaded = await loadRazorpayScript();
            //     if (!loaded) return alert('Payment failed to load');

            //     const rzp = new Razorpay({
            //         key: data.key,
            //         amount: data.amount,
            //         order_id: data.order_id,

            //         handler: async function(response) {

            //             const res = await postJSON('/checkout/success', response);

            //             if (res.success) {
            //                 showToast({
            //                     title: "Order Placed 🎉",
            //                     message: "Your order has been placed successfully!",
            //                     type: "success",
            //                     duration: 2000
            //                 });

            //                 renderOrderSummary(res.order);

            //                 setTimeout(() => {
            //                     goToStep(4);
            //                     window.scrollTo({
            //                         top: 0,
            //                         behavior: 'smooth'
            //                     });
            //                 }, 1200);
            //                 window.dispatchEvent(new CustomEvent("cart:updated", {
            //                     detail: {
            //                         cart: {
            //                             count: 0
            //                         }
            //                     }
            //                 }));
            //             }
            //         }
            //     });

            //     rzp.open();
            // };

        })();
    </script>

@endsection
