@extends('website.layouts.website')

@section('title', 'Product Details | CuddlyDuddly')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/categories.css') }}">
<link rel="stylesheet" href="{{ asset('css/product-details.css') }}">

@section('content')
    <div class="mcp-page container max-w-container px-5 mx-auto">
        <div class="grid lg:grid-cols-2 gap-5 lg:gap-10 mt-0 lg:mt-8">
            <div class="mcp-product-display">
                <h1 class="mcp-product-title block lg:hidden">
                    {{ $product->name }}
                </h1>
                <div class="mcp-gallery">
                    @php
                        $images = $initialImages;
                    @endphp
                    <div class="mcp-img-stage" id="mcpZoomWrapper">
                        {{-- Zoom lens --}}
                        <div id="mcpZoomLens" class="mcp-zoom-lens hidden"></div>

                        <img id="mcpMainImg" class="mcp-img-main"
                            src="{{ asset('storage/' . ($images[0]->image_path ?? 'fallback.png')) }}"
                            alt="{{ $product->name }}" onerror="this.src='{{ asset('storage/fallback.png') }}'">
                        <div id="mcpZoomResult" class="mcp-zoom-result hidden">
                            <div class="mcp-zoom-panel">
                                <img id="mcpZoomImg"
                                    src="{{ asset('storage/' . ($images[0]->image_path ?? 'fallback.png')) }}"
                                    alt="zoom preview">
                            </div>
                        </div>

                        <!-- Wishlist & Share Buttons -->
                        <div class="flex gap-2 absolute right-5 top-5 product-wishlist-share">
                            <button type="button" id="share_product" class="product-wishlist-btn cursor-pointer">
                                <img src="{{ asset('storage/WebsiteImages/category/share.png') }}" alt="share icon">
                            </button>
                            <button type="button" id="add_to_wishlist" class="product-wishlist-btn cursor-pointer"
                                data-wishlisted="false"
                                onclick="
                                    const btn = this;
                                    const wishlisted = btn.dataset.wishlisted === 'true';
                                    btn.dataset.wishlisted = !wishlisted;
                                    btn.querySelector('.heart-outline').classList.toggle('hidden', !wishlisted === false ? false : true);
                                    btn.querySelector('.heart-filled').classList.toggle('hidden', !wishlisted === false ? true : false);">
                                {{-- Outline icon (default) --}}
                                <svg class="heart-outline block" xmlns="http://www.w3.org/2000/svg" width="15"
                                    height="15" viewBox="0 0 15 15" fill="none">
                                    <g clip-path="url(#clip0_1863_399)">
                                        <path
                                            d="M7.43603 13.5356C7.23593 13.5361 7.03771 13.4969 6.85283 13.4204C6.66795 13.3438 6.50008
                                                                                                 13.2314 6.35891 13.0896L1.43155 8.16205C0.69994 7.43044 0.296875 6.45773 0.296875 5.42285V5.36231C0.296875
                                                                                                  4.32743 0.69994 3.35458 1.43155 2.62311C2.16317 1.89164 3.13618 1.48828 4.17061 1.48828H4.23159C5.26602 1.48828
                                                                                                   6.23903 1.89135 6.97065 2.62296L7.43603 3.08834L7.90141 2.62296C8.63303 1.89135 9.60603 1.48828 10.6405
                                                                                                    1.48828H10.7014C11.7359 1.48828 12.7089 1.89135 13.4405 2.62296C14.1721 3.35458 14.5752 4.32729 14.5752
                                                                                                     5.36217V5.4227C14.5752 6.45758 14.1721 7.43044 13.4405 8.1619L8.51315 13.0894C8.37201 13.2313 8.20414
                                                                                                      13.3438 8.01926 13.4203C7.83438 13.4969 7.63615 13.5361 7.43603 13.5356ZM6.98983 12.4585C7.22899 12.6972
                                                                                                       7.64351 12.6966 7.88223 12.4583L12.8096 7.53128C13.0873 7.25499 13.3074 6.92639 13.4573 6.56449C13.6072
                                                                                                        6.20258 13.6838 5.81456 13.6828 5.42285V5.36231C13.6828 4.56585 13.3725 3.81713 12.8096 3.25403C12.2466
                                                                                                         2.69093 11.4976 2.38068 10.7014 2.38068H10.6405C10.2488 2.37957 9.86078 2.45618 9.49892 2.60607C9.13705
                                                                                                          2.75596 8.80852 2.97615 8.53234 3.25388L7.75149 4.03473C7.71008 4.07618 7.6609 4.10907 7.60677 4.13151C7.55264
                                                                                                           4.15394 7.49462 4.16549 7.43603 4.16549C7.37743 4.16549 7.31941 4.15394 7.26528 4.13151C7.21116 4.10907 7.16198
                                                                                                            4.07618 7.12057 4.03473L6.33972 3.25388C6.06354 2.97615 5.73501 2.75596 5.37314 2.60607C5.01127 2.45618
                                                                                                             4.62327 2.37957 4.23159 2.38068H4.17061C3.37445 2.38068 2.62543 2.69063 2.06248 3.25388C1.49953 3.81713
                                                                                                              1.18927 4.5657 1.18927 5.36217V5.4227C1.18822 5.81439 1.26486 6.2024 1.41474 6.56429C1.56463 6.92617
                                                                                                               1.78478 7.25474 2.06248 7.53098L6.98983 12.4585Z"
                                            fill="black" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1863_399">
                                            <rect width="14.8732" height="14.8732" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>

                                {{-- Filled icon (wishlisted state) --}}
                                <svg class="heart-filled hidden" xmlns="http://www.w3.org/2000/svg" width="15"
                                    height="15" viewBox="0 0 15 15" fill="none">
                                    <path
                                        d="M13.4405 2.62296C12.7089 1.89135 11.7359 1.48828 10.7014 1.48828H10.6405C9.60603 1.48828
                                                                                     8.63303 1.89135 7.90141 2.62296L7.43603 3.08834L6.97065 2.62296C6.23903 1.89135 5.26602
                                                                                      1.48828 4.23159 1.48828H4.17061C3.13618 1.48828 2.16317 1.89164 1.43155 2.62311C0.69994
                                                                                       3.35458 0.296875 4.32743 0.296875 5.36231V5.42285C0.296875 6.45773 0.69994 7.43044 1.43155
                                                                                        8.16205L6.35891 13.0896C6.50008 13.2314 6.66795 13.3438 6.85283 13.4204C7.03771 13.4969
                                                                                         7.23593 13.5361 7.43603 13.5356C7.63615 13.5361 7.83438 13.4969 8.01926 13.4203C8.20414
                                                                                          13.3438 8.37201 13.2313 8.51315 13.0894L13.4405 8.1619C14.1721 7.43044 14.5752 6.45758
                                                                                           14.5752 5.4227V5.36217C14.5752 4.32729 14.1721 3.35458 13.4405 2.62296Z"
                                        fill="#000" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    {{-- Thumb column wrapper (shown only on lg+) --}}
                    <div class="mcp-thumbs-wrapper hidden lg:flex" id="pdpThumbWrapper">
                        {{-- Scroll Up arrow --}}
                        <button class="mcp-thumb-arrow mcp-thumb-arrow--up pdp-arrow-hidden" id="pdpThumbArrowUp"
                            aria-label="Scroll previous">
                            {{-- Left chevron: mobile --}}
                            <svg class="block lg:hidden" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                            {{-- Up chevron: desktop --}}
                            <svg class="hidden lg:block" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                        </button>

                        {{-- Scrollable track --}}
                        <div class="mcp-thumbs" id="pdpThumbContainer">
                            @foreach ($images as $index => $img)
                                <div class="mcp-thumb {{ $index == 0 ? 'mcp-thumb--active' : '' }}"
                                    data-src="{{ asset('storage/' . $img->image_path) }}">
                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                        onerror="this.src='{{ asset('storage/fallback.png') }}'">
                                </div>
                            @endforeach
                        </div>

                        {{-- Scroll Down arrow --}}
                        <button class="mcp-thumb-arrow mcp-thumb-arrow--down pdp-arrow-hidden" id="pdpThumbArrowDown"
                            aria-label="Scroll next">
                            {{-- Right chevron: mobile --}}
                            <svg class="block lg:hidden" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                            {{-- Down chevron: desktop --}}
                            <svg class="hidden lg:block" xmlns="http://www.w3.org/2000/svg" width="14"
                                height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="product-review-zone mt-12 hidden lg:block">
                    {{-- ───────── Ratings Summary ───────── --}}
                    <h2 class="mcp-label">Ratings &amp; Reviews</h2>
                    <div class="mcp-ratings-row">
                        <div class="mcp-rating-score">
                            <span class="mcp-rating-num">{{ $reviewStats['avg'] }}</span>
                            <span class="mcp-rating-single-star">★</span>
                            <div class="mcp-rating-count">{{ $reviewStats['count'] }} Ratings</div>
                        </div>
                        <div class="mcp-rating-bars">
                            @php $total = max($reviewStats['count'], 1); @endphp
                            @foreach ([5, 4, 3, 2, 1] as $star)
                                <div class="mcp-bar-row">
                                    <span class="mcp-bar-label">{{ $star }}</span>
                                    <span class="mcp-bar-star">★</span>
                                    <div class="mcp-bar-track">
                                        <div class="mcp-bar-fill"
                                            style="width: {{ ($reviewStats['distribution'][$star] / $total) * 100 }}%">
                                        </div>
                                    </div>
                                    <span class="mcp-bar-count">
                                        {{ $reviewStats['distribution'][$star] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ───────── Review Form OR User Review ───────── --}}
                    @if (auth('customer')->check())
                        @if (!$currentUserReview)
                            <p class="mcp-label mt-10">Tap on the stars to Rate &amp; Review this product</p>
                            <div class="mcp-tap-rate-stars" id="mcpTapStars">
                                <span class="mcp-tap-star" data-val="1">★</span>
                                <span class="mcp-tap-star" data-val="2">★</span>
                                <span class="mcp-tap-star" data-val="3">★</span>
                                <span class="mcp-tap-star" data-val="4">★</span>
                                <span class="mcp-tap-star" data-val="5">★</span>
                            </div>
                            <p class="mcp-rating-label" id="mcpRatingLabel">&nbsp;</p>
                            <div class="mcp-qa-wrap">
                                <p class="mcp-label">Write Your Review</p>
                                <form method="POST" action="{{ route('review.store') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="rating" id="selectedRating">
                                    <textarea name="comment" class="mcp-qa-textarea" placeholder="Share your experience about this product..." required></textarea>
                                    <button class="mcp-btn">Submit Review</button>
                                </form>
                            </div>
                        @else
                            {{-- USER ALREADY REVIEWED --}}
                            <div class="user-review-box mt-10">
                                <h4 class="mcp-label">Your Review</h4>
                                <div class="mcp-review-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $currentUserReview->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <p class="mcp-review-text">{{ $currentUserReview->comment }}</p>
                            </div>
                        @endif
                    @else
                        {{-- Guest CTA --}}
                        <div class="mt-10">
                            <a href="{{ route('customer.login') }}" class="mcp-btn">
                                Login to write a review
                            </a>
                        </div>
                    @endif


                    {{-- ───────── Latest Reviews ───────── --}}
                    @foreach ($latestReviews as $review)
                        <div class="mcp-review-wrap mt-10">
                            <div class="mcp-review-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <p class="mcp-review-text">
                                {{ $review->comment }}
                            </p>
                            <p class="mcp-review-author">
                                {{ $review->customer->name }}
                            </p>
                            <p class="mcp-review-location">
                                {{ optional($review->customer->defaultShippingAddress)->city }}
                            </p>
                        </div>
                    @endforeach
                    @if ($reviewStats['count'] > 5)
                        <a href="{{ route('product.reviews', $product->slug) }}" class="mcp-btn">
                            View all
                        </a>
                    @endif
                </div>
            </div>

            <div class="mcp-section">
                <!-- ── Brand / Title ── -->
                <h1 class="mcp-product-title hidden lg:block">{{ $product->name }}</h1>
                <!-- ── Price ── -->
                <div class="mcp-price-row">
                    <span class="text-sm sm:text-base text-black">Price:</span>
                    @if ($hasVariants)
                        <strong class="mcp-price-current" id="pdpPrice">
                            ₹{{ $defaultVariant->price }}
                        </strong>

                        @if ($defaultVariant->compare_price)
                            <del class="mcp-price-mrp" id="pdpMrp">
                                ₹{{ $defaultVariant->compare_price }}
                            </del>
                        @endif
                    @else
                        <strong class="mcp-price-current">
                            ₹{{ $product->discount_price ?? $product->price }}
                        </strong>

                        @if ($product->discount_price)
                            <del class="mcp-price-mrp">
                                ₹{{ $product->price }}
                            </del>
                        @endif
                    @endif
                    <div class="cart-rating">
                        <span class="max-w-icon"><img src="{{ asset('storage/WebsiteImages/staricon.png') }}"
                                alt="" class="max-w-3.5 object-contain"></span><span class="cart-span text-white"
                            x-text="product.review">{{ $reviewStats['avg'] ?? 0 }}
                        </span>
                    </div>
                    <div class="mcp-replace-row">
                        <img src="{{ asset('storage/WebsiteImages/category/return-clock.png') }}" alt="Replace Icon"
                            class="mcp-replace-icon">
                        <span class="mcp-replace-text">7 Days Replacement</span>
                    </div>
                </div>
                <p id="pdpStockMsg" class="text-red-600 font-medium mt-2 hidden">
                    Out of Stock
                </p>

                @if ($hasVariants)

                    @foreach ($variantAttributes as $attrId => $attrData)
                        <p class="mcp-label">
                            {{ $attrData['attribute']->name }}
                        </p>

                        {{-- ================= VISUAL ATTRIBUTE ================= --}}
                        @if ($attrData['attribute']->is_visual)
                            <div class="mcp-color-group variant-group" data-attribute="{{ $attrId }}">
                                @foreach ($attrData['values'] as $val)
                                    <div class="mcp-color-swatch variant-option" data-attribute="{{ $attrId }}"
                                        data-value="{{ $val->id }}" style="background: {{ $val->value }}">
                                    </div>
                                @endforeach
                            </div>
                            {{-- ================= NORMAL ATTRIBUTE ================= --}}
                        @else
                            <div class="mcp-size-group variant-group" data-attribute="{{ $attrId }}">
                                @foreach ($attrData['values'] as $val)
                                    <button class="mcp-size-btn variant-option" data-attribute="{{ $attrId }}"
                                        data-value="{{ $val->id }}">
                                        {{ $val->value }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif

                <!-- ── Quantity purchase── -->
                <p class="mcp-label">Quantity</p>
                <div class="mcp-buying-row">
                    <div class="mcp-qty-row">
                        <button class="mcp-qty-btn" onclick="mcpChangeQty(-1)">−</button>
                        <span id="mcpQtyVal" class="mcp-qty-val">1</span>
                        <button class="mcp-qty-btn" onclick="mcpChangeQty(1)">+</button>
                    </div>
                    <div class="mcp-action-row">
                        <button class="mcp-btn" id="buyNowBtn">
                            Buy Now
                        </button>
                        <button class="mcp-btn mcp-btn-outline" id="addToCartBtn">
                            Add to Cart
                        </button>
                    </div>
                </div>

                <!-- ── Delivery ── -->
                <p class="mcp-label">Delivery To</p>
                <div class="mcp-delivery-row">
                    <input type="text" id="pincodeInput" placeholder="Your Pincode" class="mcp-pincode-input" />
                    <button class="mcp-btn" onclick="checkPincode()">Check</button>
                    <p id="pincodeResult" class="mt-2 text-sm"></p>
                </div>

                <!-- ── Bank Offers ── -->
                <div class="mcp-offers-wrap">
                    <div class="mcp-offer-card">
                        <div class="mcp-offer-brief">
                            <img src="{{ asset('storage/WebsiteImages/category/bank.png') }}">
                            <p class="mcp-offer-text">10% Instant Discount* on Purple National Bank Credit Cards</p>
                        </div>
                        <a href="#!" class="mcp-offer-tnc">View T&amp;C</a>
                    </div>
                    <div class="mcp-offer-card">
                        <div class="mcp-offer-brief">
                            <img src="{{ asset('storage/WebsiteImages/category/bank.png') }}">
                            <p class="mcp-offer-text">10% Instant Discount* on Purple National Bank Credit Cards</p>
                        </div>
                        <a href="#!" class="mcp-offer-tnc">View T&amp;C</a>
                    </div>
                </div>

                <!-- ── Accordion: Product Info ── -->
                <div class="mcp-accordion">
                    <div class="mcp-accordion-header" onclick="mcpToggle('mcpAccProductInfo','mcpChevProdInfo')">
                        <div class="mcp-accordion-icon-wrap">
                            <img src="{{ asset('storage/WebsiteImages/category/product-info.png') }}"
                                class="mcp-accordion-svg">
                            <span class="mcp-accordion-title">Product Information</span>
                        </div>
                        <img id="mcpChevProdInfo"
                            src="{{ asset('storage/WebsiteImages/category/arrow-triangle-up.png') }}"
                            class="mcp-accordion-chevron mcp-accordion-chevron--open">
                    </div>
                    <div id="mcpAccProductInfo" class="mcp-accordion-body">
                        <p class="mcp-accordion-title">Specifications:</p>
                        <ul class="mcp-spec-list">
                            {{-- Brand --}}
                            @if ($product->brand)
                                <li>
                                    <strong>Brand</strong> - {{ $product->brand->name }}
                                </li>
                            @endif
                            {{-- Category --}}
                            @if ($product->productCategory)
                                <li>
                                    <strong>Category</strong> - {{ $product->productCategory->name }}
                                </li>
                            @endif
                            {{-- Subcategory --}}
                            @if ($product->subCategory)
                                <li>
                                    <strong>Type</strong> - {{ $product->subCategory->name }}
                                </li>
                            @endif
                            {{-- Dynamic Attributes --}}
                            @foreach ($specifications as $spec)
                                <li>
                                    <strong>
                                        {{ $spec->attributeValue->attribute->name }}
                                    </strong>
                                    -
                                    {{ $spec->attributeValue->value }}
                                </li>
                            @endforeach
                        </ul><br>
                        <p class="mcp-description">{{ $product->description }}</p>
                    </div>
                </div>

                <!-- ── Accordion: Brand Info ── -->
                @if ($product->brand)
                    <div class="mcp-accordion">
                        <div class="mcp-accordion-header" onclick="mcpToggle('mcpAccBrandInfo','mcpChevBrandInfo')">

                            <div class="mcp-accordion-icon-wrap">
                                <img src="{{ asset('storage/WebsiteImages/category/brand-info.png') }}"
                                    class="mcp-accordion-svg">

                                <span class="mcp-accordion-title">
                                    Brand Information
                                </span>
                            </div>

                            <img id="mcpChevBrandInfo"
                                src="{{ asset('storage/WebsiteImages/category/arrow-triangle-up.png') }}"
                                class="mcp-accordion-chevron">
                        </div>

                        <div id="mcpAccBrandInfo" class="mcp-accordion-body mcp-accordion-body--hidden">

                            {{-- Brand Logo --}}
                            @if ($product->brand->logo)
                                <div class="product-brand-dp">
                                    <img src="{{ asset('storage/' . $product->brand->logo) }}"
                                        alt="{{ $product->brand->name }}"
                                        class="max-w-24 max-h-14 w-auto h-auto mx-auto">
                                </div>
                            @endif

                            {{-- Brand Description --}}
                            @if ($product->brand->description)
                                <p class="mcp-accordion-para">
                                    {{ $product->brand->description }}
                                </p>
                            @endif

                        </div>
                    </div>
                @endif

                <!-- ── Accordion: Cancellation ── -->
                <div class="mcp-accordion">
                    <div class="mcp-accordion-header" onclick="mcpToggle('mcpAccCancelPolicy','mcpChevCancelPolicy')">
                        <div class="mcp-accordion-icon-wrap">
                            <img src="{{ asset('storage/WebsiteImages/category/cancellation.png') }}"
                                class="mcp-accordion-svg">
                            <span class="mcp-accordion-title">Cancellation Policy</span>
                        </div>
                        <img id="mcpChevCancelPolicy"
                            src="{{ asset('storage/WebsiteImages/category/arrow-triangle-up.png') }}"
                            class="mcp-accordion-chevron">
                    </div>
                    <div id="mcpAccCancelPolicy" class="mcp-accordion-body mcp-accordion-body--hidden">
                        <p class="mcp-accordion-para">{{ $product->cancellation_policy }}</p>
                    </div>
                </div>
            </div>
            <div class="product-review-zone mt-0 lg:mt-12 block lg:hidden">

                {{-- ───────── Ratings Summary ───────── --}}
                <h2 class="mcp-label">Ratings &amp; Reviews</h2>

                <div class="mcp-ratings-row">
                    <div class="mcp-rating-score">
                        <span class="mcp-rating-num">{{ $reviewStats['avg'] }}</span>
                        <span class="mcp-rating-single-star">★</span>
                        <div class="mcp-rating-count">{{ $reviewStats['count'] }} Ratings</div>
                    </div>

                    <div class="mcp-rating-bars">
                        @php $total = max($reviewStats['count'], 1); @endphp

                        @foreach ([5, 4, 3, 2, 1] as $star)
                            <div class="mcp-bar-row">
                                <span class="mcp-bar-label">{{ $star }}</span>
                                <span class="mcp-bar-star">★</span>

                                <div class="mcp-bar-track">
                                    <div class="mcp-bar-fill"
                                        style="width: {{ ($reviewStats['distribution'][$star] / $total) * 100 }}%">
                                    </div>
                                </div>

                                <span class="mcp-bar-count">
                                    {{ $reviewStats['distribution'][$star] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>


                {{-- ───────── Review Form OR User Review ───────── --}}
                @if (auth('customer')->check())

                    @if (!$currentUserReview)

                        <p class="mcp-label mt-10">Tap on the stars to Rate &amp; Review this product</p>

                        <div class="mcp-tap-rate-stars" id="mcpTapStarsMobile">
                            <span class="mcp-tap-star" data-val="1">★</span>
                            <span class="mcp-tap-star" data-val="2">★</span>
                            <span class="mcp-tap-star" data-val="3">★</span>
                            <span class="mcp-tap-star" data-val="4">★</span>
                            <span class="mcp-tap-star" data-val="5">★</span>
                        </div>

                        <p class="mcp-rating-label" id="mcpRatingLabelMobile">&nbsp;</p>

                        <div class="mcp-qa-wrap">
                            <p class="mcp-label">Write Your Review</p>

                            <form method="POST" action="{{ route('review.store') }}">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="rating" id="selectedRatingMobile">

                                <textarea name="comment" class="mcp-qa-textarea" placeholder="Share your experience about this product..." required></textarea>

                                <button class="mcp-btn">Submit Review</button>
                            </form>
                        </div>
                    @else
                        <div class="user-review-box mt-10">
                            <h4 class="mcp-label">Your Review</h4>

                            <div class="mcp-review-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $currentUserReview->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>

                            <p class="mcp-review-text">{{ $currentUserReview->comment }}</p>
                        </div>

                    @endif
                @else
                    <div class="mt-10">
                        <a href="{{ route('customer.login') }}" class="mcp-btn">
                            Login to write a review
                        </a>
                    </div>

                @endif


                {{-- ───────── Latest Reviews ───────── --}}
                @foreach ($latestReviews as $review)
                    <div class="mcp-review-wrap mt-10">

                        <div class="mcp-review-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                            @endfor
                        </div>

                        <p class="mcp-review-text">
                            {{ $review->comment }}
                        </p>

                        <p class="mcp-review-author">
                            {{ $review->customer->name }}
                        </p>

                        <p class="mcp-review-location">
                            {{ optional($review->customer->defaultShippingAddress)->city }}
                        </p>

                    </div>
                @endforeach

                @if ($reviewStats['count'] > 5)
                    <a href="{{ route('product.reviews', $product->slug) }}" class="mcp-btn">
                        View all
                    </a>
                @endif
            </div>
        </div>
        <!-- ── You May Also Like ── -->

        <div class="mcp-ymal-section">
            <div class="title flex-box mt-5">
                <div>
                    <img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon"
                        class="max-w-6">
                </div>
                <span class="label text-black">You May Also Like</span>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-y-(--margin-sm) gap-3 md:gap-5 addtocart">
                @foreach ($relatedProductsFormatted as $item)
                    @include('website.components.product-card', ['product' => $item])
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const VARIANT_MATRIX = @json($variantMatrix);
        </script>
        <script src="{{ asset('js/cart.js') }}"></script>
        <script>
            let mcpQty = 1;

            function mcpChangeQty(d) {
                mcpQty = Math.max(1, mcpQty + d);
                document.getElementById('mcpQtyVal').textContent = mcpQty;
            }

            const HAS_VARIANTS = @json($hasVariants);
            const PRODUCT_ID = @json($product->id);

            let selectedValues = {};

            document.addEventListener('DOMContentLoaded', function() {

                const defaultVariantId = "{{ $defaultVariant->id ?? '' }}";

                if (defaultVariantId) {
                    document.getElementById('buyNowBtn').dataset.variant = defaultVariantId;
                    document.getElementById('addToCartBtn').dataset.variant = defaultVariantId;
                }

                if (HAS_VARIANTS && {{ $defaultVariant ? 'true' : 'false' }}) {
                    document.getElementById('buyNowBtn').dataset.variant = "{{ $defaultVariant->id }}";
                }

                initThumbSwitch();
                if (HAS_VARIANTS) initVariantEngine();
                if (HAS_VARIANTS) {
                    handleStockState({
                        in_stock: {{ $defaultVariant->stock > 0 ? 'true' : 'false' }}
                    });
                }

                fetch('/cart/count')
                    .then(res => res.json())
                    .then(data => {
                        if (typeof updateCartBadge === "function") {
                            updateCartBadge(data.count);
                        }
                    });
            });

            // ================= IMAGE SWITCH =================

            function initThumbSwitch() {
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.mcp-thumb')) return;

                    let thumb = e.target.closest('.mcp-thumb');
                    let src = thumb.dataset.src;

                    document.querySelectorAll('.mcp-thumb')
                        .forEach(t => t.classList.remove('mcp-thumb--active'));

                    thumb.classList.add('mcp-thumb--active');
                    document.getElementById('mcpMainImg').src = src;
                });
            }

            function initThumbScroll() {
                const track = document.getElementById('pdpThumbContainer');
                const arrowUp = document.getElementById('pdpThumbArrowUp');
                const arrowDown = document.getElementById('pdpThumbArrowDown');

                if (!track || !arrowUp || !arrowDown) return;

                const thumbEls = Array.from(track.querySelectorAll('.mcp-thumb'));

                function isDesktop() {
                    return window.innerWidth >= 1024;
                }

                function getThreshold() {
                    if (window.innerWidth < 640) return 4; // <sm: show 4
                    if (window.innerWidth < 1024) return 5; // sm–md: show 5
                    return 4; // desktop: 4 vertical
                }

                function needsScroll() {
                    return thumbEls.length > getThreshold();
                }

                function showArrows(show) {
                    arrowUp.classList.toggle('pdp-arrow-hidden', !show);
                    arrowDown.classList.toggle('pdp-arrow-hidden', !show);
                }

                function getScrollStep() {
                    const thumb = thumbEls[0];
                    if (!thumb) return 100;
                    const rect = thumb.getBoundingClientRect();
                    const gap = parseFloat(getComputedStyle(track).gap) || 10;
                    return (isDesktop() ? rect.height : rect.width) + gap;
                }

                function syncArrows() {
                    if (!needsScroll()) {
                        showArrows(false);
                        return;
                    }
                    showArrows(true);

                    let atStart, atEnd;
                    if (isDesktop()) {
                        atStart = track.scrollTop <= 2;
                        atEnd = track.scrollTop + track.clientHeight >= track.scrollHeight - 2;
                    } else {
                        atStart = track.scrollLeft <= 2;
                        atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 2;
                    }

                    arrowUp.style.opacity = atStart ? '0.3' : '1';
                    arrowUp.style.pointerEvents = atStart ? 'none' : 'auto';
                    arrowDown.style.opacity = atEnd ? '0.3' : '1';
                    arrowDown.style.pointerEvents = atEnd ? 'none' : 'auto';
                }

                arrowUp.addEventListener('click', () => {
                    const step = getScrollStep();
                    if (isDesktop()) {
                        track.scrollTo({
                            top: track.scrollTop - step,
                            behavior: 'smooth'
                        });
                    } else {
                        track.scrollTo({
                            left: track.scrollLeft - step,
                            behavior: 'smooth'
                        });
                    }
                });

                arrowDown.addEventListener('click', () => {
                    const step = getScrollStep();
                    if (isDesktop()) {
                        track.scrollTo({
                            top: track.scrollTop + step,
                            behavior: 'smooth'
                        });
                    } else {
                        track.scrollTo({
                            left: track.scrollLeft + step,
                            behavior: 'smooth'
                        });
                    }
                });

                track.addEventListener('scroll', syncArrows, {
                    passive: true
                });
                window.addEventListener('resize', () => {
                    syncArrows();
                }, {
                    passive: true
                });

                syncArrows();
            }
            initThumbScroll();

            function initImageZoom() {

                const wrapper = document.getElementById('mcpZoomWrapper');
                const img = document.getElementById('mcpMainImg');
                const lens = document.getElementById('mcpZoomLens');
                const result = document.getElementById('mcpZoomResult');
                const zoomImg = document.getElementById('mcpZoomImg');

                if (!wrapper || !img || !lens || !result || !zoomImg) return;

                const lensSize = 140;
                const zoomLevel = 2.5;

                function isDesktop() {
                    return window.innerWidth >= 1024;
                }

                function activateZoom() {

                    if (!isDesktop()) return;

                    if (window.innerWidth < 1024) return;

                    lens.classList.remove('hidden');
                    result.style.display = 'block';

                    zoomImg.src = img.src;
                }

                function deactivateZoom() {
                    lens.classList.add('hidden');
                    result.style.display = 'none';
                }

                wrapper.addEventListener('mouseenter', activateZoom);

                wrapper.addEventListener('mouseleave', deactivateZoom);

                wrapper.addEventListener('mousemove', function(e) {

                    if (!isDesktop()) return;

                    const rect = img.getBoundingClientRect();

                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    let lensX = x - lensSize / 2;
                    let lensY = y - lensSize / 2;

                    lensX = Math.max(
                        0,
                        Math.min(lensX, rect.width - lensSize)
                    );

                    lensY = Math.max(
                        0,
                        Math.min(lensY, rect.height - lensSize)
                    );

                    lens.style.left = `${lensX}px`;
                    lens.style.top = `${lensY}px`;

                    const zoomedWidth = rect.width * zoomLevel;
                    const zoomedHeight = rect.height * zoomLevel;

                    zoomImg.style.width = `${zoomedWidth}px`;
                    zoomImg.style.height = `${zoomedHeight}px`;

                    const percentX = lensX / (rect.width - lensSize);
                    const percentY = lensY / (rect.height - lensSize);

                    const moveX =
                        (zoomedWidth - result.clientWidth) * percentX;

                    const moveY =
                        (zoomedHeight - result.clientHeight) * percentY;

                    zoomImg.style.left = `-${moveX}px`;
                    zoomImg.style.top = `-${moveY}px`;
                });

                window.addEventListener('resize', () => {
                    if (!isDesktop()) {
                        deactivateZoom();
                    }
                });
            }
            initImageZoom();


            // ================= VARIANT ENGINE =================

            function initVariantEngine() {

                document.querySelectorAll('.variant-option').forEach(el => {

                    el.addEventListener('click', function() {

                        let attr = this.dataset.attribute;
                        let val = this.dataset.value;

                        // mark selected
                        document.querySelectorAll(`[data-attribute="${attr}"]`)
                            .forEach(x => x.classList.remove('mcp-size-btn--active',
                                'mcp-color-swatch--active'));

                        this.classList.add('mcp-size-btn--active', 'mcp-color-swatch--active');

                        selectedValues[attr] = val;

                        updateDisabledStates();
                        resolveVariant();

                    });

                });

            }

            function updateDisabledStates() {

                document.querySelectorAll('.variant-option').forEach(el => {

                    let attr = el.dataset.attribute;
                    let val = el.dataset.value;

                    let tempSelection = {
                        ...selectedValues
                    };
                    tempSelection[attr] = val;

                    let isValid = Object.values(VARIANT_MATRIX).some(variant => {

                        return Object.entries(tempSelection).every(([a, v]) => {
                            return variant[a] == v;
                        });

                    });

                    if (!isValid) {
                        el.classList.add('variant-disabled');
                        el.style.opacity = 0.4;
                        el.style.pointerEvents = 'none';
                    } else {
                        el.classList.remove('variant-disabled');
                        el.style.opacity = '';
                        el.style.pointerEvents = '';
                    }

                });

            }


            function resolveVariant() {
                let values = Object.values(selectedValues);
                if (values.length === 0) return;
                fetch('/api/product/variant/resolve', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            product_id: PRODUCT_ID,
                            attribute_value_ids: values
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (!data.success) return;
                        animateTextChange('pdpPrice', '₹' + data.price);
                        if (data.compare_price) {
                            document.getElementById('pdpMrp').innerText = '₹' + data.compare_price;
                        }
                        updateGallery(data.images);
                        document.getElementById('buyNowBtn').dataset.variant = data.variant_id;
                        document.getElementById('addToCartBtn').dataset.variant = data.variant_id;
                        handleStockState(data);
                    });
            }

            function animateTextChange(id, text) {
                let el = document.getElementById(id);
                el.style.opacity = 0;
                setTimeout(() => {
                    el.innerText = text;
                    el.style.opacity = 1;
                }, 150);
            }

            function updateGallery(images) {
                if (!images || images.length === 0) return;
                const main = document.getElementById('mcpMainImg');
                const container = document.getElementById('pdpThumbContainer');
                main.style.opacity = 0;
                setTimeout(() => {
                    container.innerHTML = '';
                    images.forEach((img, i) => {
                        const url = '/storage/' + img.image_path;
                        const div = document.createElement('div');
                        div.className = 'mcp-thumb ' + (i === 0 ? 'mcp-thumb--active' : '');
                        div.dataset.src = url;
                        div.innerHTML = `<img src="${url}">`;
                        container.appendChild(div);
                    });
                    // main.src = '/storage/' + images[0].image_path;
                    const newSrc = '/storage/' + images[0].image_path;

                    main.src = newSrc;

                    const zoomImg = document.getElementById('mcpZoomImg');
                    if (zoomImg) {
                        zoomImg.src = newSrc;
                    }
                    main.style.opacity = 1;
                }, 120);
            }

            function handleStockState(data) {
                const stockMsg = document.getElementById('pdpStockMsg');
                const buyBtn = document.getElementById('buyNowBtn');
                const cartBtn = document.getElementById('addToCartBtn');
                if (!data.in_stock) {
                    stockMsg.classList.remove('hidden');
                    buyBtn.disabled = true;
                    cartBtn.disabled = true;
                    buyBtn.style.opacity = .5;
                    cartBtn.style.opacity = .5;
                } else {
                    stockMsg.classList.add('hidden');
                    buyBtn.disabled = false;
                    cartBtn.disabled = false;
                    buyBtn.style.opacity = '';
                    cartBtn.style.opacity = '';
                }
            }

            document.addEventListener('DOMContentLoaded', function() {

                const ratingLabels = [
                    '',
                    'Poor',
                    'Fair',
                    'Good',
                    'Very Good',
                    'Excellent'
                ];

                function initRatingWidget(containerId, inputId, labelId) {

                    const container = document.getElementById(containerId);
                    if (!container) return;

                    const stars = container.querySelectorAll('.mcp-tap-star');
                    const input = document.getElementById(inputId);
                    const label = document.getElementById(labelId);

                    let currentRating = 0;

                    function paint(upTo) {
                        stars.forEach(star => {
                            const val = parseInt(star.dataset.val);
                            star.classList.toggle('mcp-tap-star--filled', val <= upTo);
                        });
                    }

                    stars.forEach(star => {

                        const val = parseInt(star.dataset.val);

                        // Desktop hover preview
                        star.addEventListener('mouseenter', () => paint(val));
                        star.addEventListener('mouseleave', () => paint(currentRating));

                        // Mobile touch preview
                        star.addEventListener('touchstart', () => paint(val));

                        // Click / Tap select
                        star.addEventListener('click', () => {

                            currentRating = val;

                            if (input) input.value = currentRating;
                            if (label) label.textContent = ratingLabels[currentRating];

                            paint(currentRating);
                        });

                    });
                }

                // Desktop widget
                initRatingWidget(
                    'mcpTapStars',
                    'selectedRating',
                    'mcpRatingLabel'
                );

                // Mobile widget
                initRatingWidget(
                    'mcpTapStarsMobile',
                    'selectedRatingMobile',
                    'mcpRatingLabelMobile'
                );

                if (HAS_VARIANTS && {{ $defaultVariant ? 'true' : 'false' }}) {

                    const defaultVariantId = "{{ $defaultVariant->id }}";

                    // set dataset
                    document.getElementById('buyNowBtn').dataset.variant = defaultVariantId;

                    // 🔥 OPTIONAL: auto-select UI (first values)
                    document.querySelectorAll('.variant-group').forEach(group => {
                        const first = group.querySelector('.variant-option');
                        if (first) {
                            first.click(); // triggers your engine
                        }
                    });
                }

            });

            function mcpToggle(contentId, chevronId) {
                const body = document.getElementById(contentId);
                const chevron = document.getElementById(chevronId);
                body.classList.toggle('mcp-accordion-body--hidden');
                chevron.classList.toggle('mcp-accordion-chevron--open');
            }

            let isCheckingPincode = false;

            function checkPincode() {

                if (isCheckingPincode) return;

                let pin = document.getElementById('pincodeInput').value;
                let el = document.getElementById('pincodeResult');

                if (!pin || pin.length !== 6) {
                    el.innerText = "Enter valid pincode";
                    el.style.color = "red";
                    return;
                }

                isCheckingPincode = true;

                el.innerText = "Checking delivery...";
                el.style.color = "black";

                fetch('/check-pincode', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            pincode: pin
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network error');
                        return res.json();
                    })
                    .then(data => {

                        if (!data.success) {
                            el.innerText = data.message;
                            el.style.color = "red";
                        } else {
                            el.innerText =
                                data.message + (data.cod ? " • COD Available" : " • Prepaid only");
                            el.style.color = "green";
                        }

                    })
                    .catch(err => {
                        console.error(err);
                        el.innerText = "Something went wrong. Try again.";
                        el.style.color = "red";
                    })
                    .finally(() => {
                        isCheckingPincode = false;
                    });
            }

            const IS_LOGGED_IN = {{ auth('customer')->check() ? 'true' : 'false' }};

            document.getElementById('buyNowBtn').addEventListener('click', function() {
                Cart.add({
                    productId: PRODUCT_ID,
                    variantId: this.dataset.variant || null,
                    qty: mcpQty,
                    buyNow: true,
                    requireVariant: HAS_VARIANTS,
                    selectedCount: Object.keys(selectedValues).length,
                    totalAttributes: document.querySelectorAll('.variant-group').length,
                    isLoggedIn: IS_LOGGED_IN,
                    loginUrl: "{{ route('customer.login') }}",
                    button: this
                });
            });

            document.getElementById('addToCartBtn').addEventListener('click', function() {
                Cart.add({
                    productId: PRODUCT_ID,
                    variantId: this.dataset.variant || null,
                    qty: mcpQty,
                    buyNow: false,
                    requireVariant: HAS_VARIANTS,
                    selectedCount: Object.keys(selectedValues).length,
                    totalAttributes: document.querySelectorAll('.variant-group').length,
                    isLoggedIn: IS_LOGGED_IN,
                    button: this
                });
            });
        </script>
    @endpush
@endsection
