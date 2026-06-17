@extends('website.layouts.website')

@section('title', 'Product Categories | CuddlyDuddly')
@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@endpush
@section('content')
    <div class="wrapper px-5 pt-0 md:pt-7">
        <div class="container max-w-container mx-auto">
            <div class="flex flex-col lg:flex-row gap-10">
                <div class="flex flex-col category__sidebar">
                    <p class="text-block text-start">
                        {{ $master->name }}
                        <span id="result-range">1-{{ $currentTabCount }}</span>
                        of {{ number_format($totalProductsCount) }} Results
                    </p>
                    <h4
                        class="font-sans text-3xl font-semibold leading-tight tracking-[var(--tracking-1)] text-black mt-7 pb-[50px] lg:pb-[40px] text-center md:text-left">
                        {{ $master->name }}
                    </h4>
                    <div class="popup-content" id="filterpopup" style="{{ empty($filters) ? 'display:none;' : '' }}">
                        <span class="block md:hidden close"><i class="fa fa-close"></i></span>
                        <div class="px-[20px] pt-4 pb-4 rounded-block border border-black/30 bg-white h-full">
                            <div class="w-full">
                                <div class="w-full flex flex-col gap-4" id="filters-container" bis_skin_checked="1">
                                    @include('website.partials.category-filters', [
                                        'filters' => $filters,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 pt-7">
                    <div x-data="tabsComponent()" x-init="loadTabs()" class="w-full  bg-white">
                        <div class="flex flex-auto overflow-x-scroll md:overflow-x-hidden md:flex-wrap gap-4 mb-9">
                            <template x-for="tab in tabs" :key="tab.name">
                                <button
                                    class="flex justify-center items-center gap-4 py-[15px] px-[20px] text-sm font-medium rounded-tab border border-black/20 cursor-pointer"
                                    :class="activeTab === tab.name ? 'border-2 border-pink-transparent bg-[#ea184914]' : ''"
                                    @click="loadProducts(tab)">
                                    <span x-text="tab.name"
                                        class="whitespace-nowrap font-sans font-normal text-[15px] leading-tight tracking-[var(--tracking-1)] text-black"></span>
                                </button>
                            </template>
                        </div>

                        <template x-for="tab in tabs" :key="tab.name">
                            <div x-show="activeTab === tab.name" x-cloak x-transition>
                                <div x-show="loading" x-cloak>
                                    @include('website.components.plp-skeleton')
                                </div>

                                <div x-show="!loading" x-cloak
                                    class="grid grid-cols-2 lg:grid-cols-3 gap-y-(--margin-sm) gap-3 md:gap-5 addtocart">
                                    <template x-for="product in tab.products" :key="product.id">
                                        <div class="flex flex-col product-card">

                                            <a :href="`/product/${product.slug}`" target="_blank"
                                                class="product-image cart border border-black/30 rounded-[18px] md:rounded-block overflow-hidden block">
                                                <img :src="product.image" :alt="product.name"
                                                    class="max-w-full w-auto h-full object-contain">
                                            </a>

                                            <a :href="`/product/${product.slug}`" target="_blank" class="cart-text"
                                                x-text="product.name">
                                            </a> <span class="cart-span" x-text="product.info"></span>
                                            <div class="flex gap-4 justify-between items-center">
                                                <div class="flex-box justify-start items-end gap-3 mt-2"><span
                                                        class="cart-discount" x-text="product.discounted"></span><span
                                                        class="cart-price line-through decoration-1"
                                                        x-text="product.price"></span>
                                                </div>
                                                <div class="cart-rating"><span class="max-w-icon"><img
                                                            src="{{ asset('storage/WebsiteImages/staricon.png') }}"
                                                            alt=""
                                                            class="max-w-(--max-w-xl) object-contain"></span><span
                                                        class="cart-span text-white" x-text="product.review"></span></div>
                                            </div>
                                            <div class="flex flex-wrap gap-2 mt-2" x-show="product.variants_grouped.visual">
                                                <template x-for="(values, attr) in product.variants_grouped.visual"
                                                    :key="attr">
                                                    <div class="flex flex-wrap gap-1">
                                                        <template x-for="(variant, index) in values" :key="variant.value">
                                                            <div class="w-3.5 h-3.5 rounded-full border flex-shrink-0"
                                                                :style="`background:${variant.value}`">
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="flex flex-wrap gap-2 mt-2" x-show="product.variants_grouped.text">
                                                <template x-for="(values, attr) in product.variants_grouped.text"
                                                    :key="attr">
                                                    <div class="flex flex-wrap gap-1">
                                                        <template x-for="(variant, index) in values"
                                                            :key="variant.value">
                                                            <div class="px-2 h-5 leading-5 border border-black/20 text-xs rounded-full flex-shrink-0"
                                                                x-text="variant.value">
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                            <button class="mcp-btn mcp-btn-outline mt-5 addToCartBtn"
                                                :data-product="product.id" :data-has-variants="product.has_variants"
                                                :data-slug="product.slug">
                                                <svg width="23" height="23" viewBox="0 0 29 29" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="group-hover:text-white w-auto max-[480px]:w-3.5">
                                                    <path
                                                        d="M9.66634 26.5832C10.3337 26.5832 10.8747 26.0422 10.8747 25.3748C10.8747 24.7075 10.3337 24.1665 9.66634 24.1665C8.999 24.1665 8.45801 24.7075 8.45801 25.3748C8.45801 26.0422 8.999 26.5832 9.66634 26.5832Z"
                                                        stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M22.9583 26.5834C23.6257 26.5834 24.1667 26.0424 24.1667 25.3751C24.1667 24.7077 23.6257 24.1667 22.9583 24.1667C22.291 24.1667 21.75 24.7077 21.75 25.3751C21.75 26.0424 22.291 26.5834 22.9583 26.5834Z"
                                                        stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M2.47656 2.47705H4.89323L8.1074 17.4846C8.2253 18.0342 8.53112 18.5255 8.97221 18.874C9.4133 19.2224 9.96207 19.4062 10.5241 19.3937H22.3416C22.8916 19.3928 23.4248 19.2044 23.8532 18.8594C24.2816 18.5145 24.5796 18.0338 24.6978 17.4966L26.6916 8.51872H6.18615"
                                                        stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span class="">Add to
                                                    cart</span>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script src="{{ asset('js/cart.js') }}"></script>
        <script>
            window.plpRequestId = 0;
            window.tabsData = @json($tabs);
            window.masterSlug = "{{ $master->slug }}";
            window.totalProductsCount = {{ $totalProductsCount }};

            function tabsComponent() {
                return {
                    tabs: window.tabsData || [],
                    activeTab: '',
                    loading: false,
                    requestId: 0,
                    updateCounter(count) {
                        const el = document.getElementById('result-range');
                        if (el) {
                            el.textContent = count > 0 ? `1-${count}` : '0';
                        }
                    },

                    loadTabs() {
                        if (!this.tabs.length) return;
                        this.activeTab = this.tabs[0].name;
                        if (this.tabs[0].products.length) {
                            this.updateCounter(this.tabs[0].products.length);
                        }
                        // openInitialDropdowns();
                    },

                    async loadProducts(tab) {

                        const currentRequest = ++this.requestId;

                        this.activeTab = tab.name;
                        this.loading = true;

                        try {

                            const url =
                                `/category/${window.masterSlug}/${tab.sectionSlug}/${tab.slug}/products`;

                            const response = await fetch(url);

                            if (!response.ok) {
                                throw new Error('Network error');
                            }

                            const data = await response.json();

                            if (currentRequest !== this.requestId) {
                                return;
                            }

                            tab.products = data.products || [];

                            this.updateCounter(tab.products.length);

                            const container =
                                document.getElementById('filters-container');

                            const popup =
                                document.getElementById('filterpopup');
                            if (container && popup) {
                                container.innerHTML =
                                    data.filtersHtml || '';
                                const hasProducts =
                                    tab.products.length > 0;
                                const hasFilters =
                                    data.filtersHtml &&
                                    data.filtersHtml.trim() !== '';
                                if (hasProducts && hasFilters) {
                                    popup.style.display = 'block';
                                    openInitialDropdowns();
                                } else {
                                    popup.style.display = 'none';
                                }
                            }
                        } catch (err) {
                            console.error(err);
                        } finally {
                            if (currentRequest === this.requestId) {
                                this.loading = false;
                            }
                        }
                    }
                }
            }


            document.addEventListener('click', function(e) {

                const container = document.getElementById('filters-container');
                if (!container) return;

                const header = e.target.closest('.megalink');

                // 👉 Toggle dropdown
                if (header && container.contains(header)) {
                    e.preventDefault();

                    const item = header.closest('.megadown-items');

                    // 🔥 SIMPLE TOGGLE (no force open/close others)
                    item.classList.toggle('active');

                    return;
                }

            });

            function openInitialDropdowns() {
                const container = document.getElementById('filters-container');
                if (!container) return;
                container.querySelectorAll('.megadown-items')
                    .forEach(el => el.classList.add('active'));
            }

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.addToCartBtn');
                if (!btn) return;
                const hasVariants = btn.dataset.hasVariants === "true";
                // 🔥 Variant product → go PDP
                if (hasVariants) {
                    window.location.href = `/product/${btn.dataset.slug}`;
                    return;
                }
                // ✅ Simple product → add directly
                Cart.add({
                    productId: btn.dataset.product,
                    variantId: null,
                    qty: 1,
                    button: btn
                });
            });
            document.addEventListener('change', async function(e) {

                if (!e.target.classList.contains('ajax-filter')) {
                    return;
                }

                const tabComponent = Alpine.closestDataStack(
                    document.querySelector('[x-data="tabsComponent()"]')
                )[0];

                const tab = tabComponent.tabs.find(
                    t => t.name === tabComponent.activeTab
                );

                if (!tab) return;

                const currentRequest = ++window.plpRequestId;

                tabComponent.loading = true;

                try {

                    const filters = {};

                    document
                        .querySelectorAll('.ajax-filter:checked')
                        .forEach(input => {

                            const attribute =
                                input.dataset.attribute;

                            if (!filters[attribute]) {
                                filters[attribute] = [];
                            }

                            filters[attribute].push(input.value);
                        });

                    const params = new URLSearchParams();

                    Object.entries(filters).forEach(
                        ([attribute, values]) => {

                            values.forEach(value => {

                                params.append(
                                    `filters[${attribute}][]`,
                                    value
                                );

                            });

                        }
                    );

                    const url =
                        `/category/${window.masterSlug}/${tab.sectionSlug}/${tab.slug}/products?` +
                        params.toString();

                    const response = await fetch(url);

                    const data = await response.json();

                    if (currentRequest !== window.plpRequestId) {
                        return;
                    }

                    tab.products =
                        data.products || [];

                    tabComponent.updateCounter(
                        tab.products.length
                    );

                    const container =
                        document.getElementById('filters-container');

                    if (container) {

                        container.innerHTML =
                            data.filtersHtml || '';

                        openInitialDropdowns();
                    }

                } catch (err) {

                    console.error(err);

                } finally {

                    if (
                        currentRequest === window.plpRequestId
                    ) {
                        tabComponent.loading = false;
                    }
                }
            });
            // document.addEventListener('change', async function(e) {

            //     if (!e.target.classList.contains('ajax-filter')) {
            //         return;
            //     }

            //     const activeTab = Alpine.evaluate(
            //         document.querySelector('[x-data="tabsComponent()"]'),
            //         'activeTab'
            //     );

            //     const tabComponent = Alpine.closestDataStack(
            //         document.querySelector('[x-data="tabsComponent()"]')
            //     )[0];

            //     const tab = tabComponent.tabs.find(
            //         t => t.name === tabComponent.activeTab
            //     );

            //     if (!tab) return;

            //     const filters = {};

            //     document.querySelectorAll('.ajax-filter:checked')
            //         .forEach(input => {

            //             const attribute = input.dataset.attribute;

            //             if (!filters[attribute]) {
            //                 filters[attribute] = [];
            //             }

            //             filters[attribute].push(input.value);
            //         });

            //     const params = new URLSearchParams();

            //     Object.entries(filters).forEach(([attribute, values]) => {
            //         values.forEach(value => {
            //             params.append(`filters[${attribute}][]`, value);
            //         });
            //     });

            //     const url =
            //         `/category/${window.masterSlug}/${tab.sectionSlug}/${tab.slug}/products?` +
            //         params.toString();

            //     const response = await fetch(url);

            //     const data = await response.json();

            //     tab.products = data.products || [];

            //     const container = document.getElementById('filters-container');

            //     if (container) {
            //         container.innerHTML = data.filtersHtml || '';
            //         openInitialDropdowns();
            //     }

            //     tabComponent.updateCounter(tab.products.length);
            // });
        </script>
    @endpush
@endsection
