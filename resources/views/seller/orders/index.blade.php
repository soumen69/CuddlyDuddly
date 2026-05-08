@extends('seller.layouts.seller')

@section('title', 'My Orders')

@section('content')

    <div class="flex-[unset] sm:flex-1 w-full">
        @include('seller.layouts.header')

        <div class="w-full px-6 md:pl-14 md:pr-9 mt-8 pb-[200px]">
            <div class="container w-full max-w-full">
                <div class="dashboard-card w-full bg-white p-0">

                    <form action="{{ request()->url() }}" method="GET" id="searchFilterForm">
                        <input type="hidden" name="active_tab" id="active_tab"
                            value="{{ request('active_tab', 'orders') }}">

                        <div class="p-5 pb-0 border-b border-black/20">
                            <div class="flex flex-wrap md:justify-end gap-4 w-full md:w-auto">
                                <div
                                    class="flex items-center gap-3 flex-grow-1 md:flex-grow-0 md:w-52 xl:w-72 h-11 border rounded-[5px] border-black/20 px-4">
                                    <img src="{{ asset('storage/images/dahboard-search.png') }}" class="w-4 h-4">
                                    <input type="text" name="search"
                                        placeholder="Search by order id, product, category" id="search"
                                        value="{{ request('search') }}"
                                        class="w-full bg-transparent outline-none font-sans text-sm placeholder:text-black/50">
                                </div>

                                <div class="relative inline-block flex-none" id="filterProductDropdown">
                                    <button type="button" id="filterProductBtn"
                                        class="flex justify-center items-center gap-4 border h-[46px] border-black/20 rounded-[5px] px-2.5 py-2 cursor-pointer">
                                        <img src="{{ asset('storage/images/dashboard-filter.png') }}" class="w-5 h-5">
                                        <span>Filter</span>
                                    </button>

                                    <div id="dropdownProductMenu"
                                        class="absolute right-0 top-full mt-2 w-[180px] hidden z-50">
                                        <div class="absolute w-full h-[4px]">
                                            <div
                                                class="absolute -top-[6px] right-[40px] w-3 h-3 bg-white rotate-45 border-l border-t border-gray-300 z-51">
                                            </div>
                                        </div>
                                        <div
                                            class="bg-white border border-black/20 rounded-md shadow-lg p-4 flex flex-col gap-4">
                                            <label class="inline-flex gap-2.5"><input type="checkbox" name="payment_status"
                                                    class="status-checkbox" value="paid" {{ request('payment_status') == 'paid' ? 'checked' : '' }}> Paid</label>
                                            <label class="inline-flex gap-2.5"><input type="checkbox" name="payment_status"
                                                    class="status-checkbox" value="failed" {{ request('payment_status') == 'failed' ? 'checked' : '' }}> Failed</label>
                                            <label class="inline-flex gap-2.5"><input type="checkbox" name="payment_status"
                                                    class="status-checkbox" value="pending" {{ request('payment_status') == 'pending' ? 'checked' : '' }}>
                                                Pending</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-4 max-w-full overflow-x-auto mt-5 md:mt-0">
                                <button type="button"
                                    class="tab-btn listblock-title  mb-0 flex-none py-1.5 px-2.5 border border-b-0 border-black/20 rounded-t-sm {{ request('active_tab', 'orders') == 'orders' ? 'bg-black text-white' : 'bg-transparent text-black' }} cursor-pointer"
                                    data-tab="orders">My
                                    Orders</button>
                                <button type="button"
                                    class="tab-btn listblock-title  mb-0 flex-none py-1.5 px-2.5 border border-b-0 border-black/20 rounded-t-sm {{ request('active_tab') == 'return' ? 'bg-black text-white' : 'bg-transparent text-black' }} cursor-pointer"
                                    data-tab="return">Return</button>
                                <button type="button"
                                    class="tab-btn listblock-title  mb-0 flex-none py-1.5 px-2.5 border border-b-0 border-black/20 rounded-t-sm {{ request('active_tab') == 'cancellation' ? 'bg-black text-white' : 'bg-transparent text-black' }} cursor-pointer"
                                    data-tab="cancellation">Cancellation</button>
                            </div>
                        </div>
                    </form>

                    <div id="tabs-container">
                        @include('seller.orders.partials.tabs', [
                            'activeTab' => request('active_tab', 'orders'),
                            'seller' => $seller,
                        ])
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const tabs = document.querySelectorAll(".tab-btn");
            const activeTabInput = document.getElementById("active_tab");
            const form = document.getElementById("searchFilterForm");
            const tabsContainer = document.getElementById("tabs-container");
            let activeTab = activeTabInput ? activeTabInput.value : "orders";

            function updateActiveTabUI() {
                tabs.forEach(tab => {
                    const isActive = tab.dataset.tab === activeTab;
                    tab.classList.toggle("bg-black", isActive);
                    tab.classList.toggle("text-white", isActive);
                    tab.classList.toggle("bg-transparent", !isActive);
                    tab.classList.toggle("text-black", !isActive);
                });

                if (activeTabInput) {
                    activeTabInput.value = activeTab;
                }
            }

            // Function to fetch and update tabs via AJAX
            function updateTabs() {
                const formData = new FormData(form);
                const queryString = new URLSearchParams(formData).toString();

                // Update URL without refreshing the page
                const newUrl = window.location.pathname + '?' + queryString;
                window.history.pushState({ path: newUrl }, '', newUrl);

                fetch(newUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (tabsContainer) {
                            tabsContainer.innerHTML = data.html;
                        }
                        bindPagination();
                    })
                    .catch(error => console.error('Error updating tabs:', error));
            }

            function bindPagination() {
                const links = document.querySelectorAll('#pagination-links a');
                links.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const url = new URL(link.href);
                        const page = url.searchParams.get('page');

                        const currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('page', page);

                        fetch(currentUrl.toString(), {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (tabsContainer) {
                                    tabsContainer.innerHTML = data.html;
                                }
                                bindPagination();
                                window.history.pushState({ path: currentUrl.toString() }, '', currentUrl.toString());
                            });
                    });
                });
            }

            tabs.forEach(tab => {
                tab.addEventListener("click", () => {
                    activeTab = tab.dataset.tab;
                    updateActiveTabUI();

                    // Trigger AJAX update for the new tab
                    updateTabs();
                });
            });

            updateActiveTabUI();

            // Auto-submit form on search/filter changes (AJAX)
            let debounceTimer;
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        updateTabs();
                    }, 500);
                });
            }

            const statusCheckboxes = document.querySelectorAll('.status-checkbox');
            statusCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    statusCheckboxes.forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                    updateTabs();
                });
            });

            bindPagination();
        });
    </script>

    <script src="{{ asset('js/seller-orders.js') }}"></script>
@endpush
