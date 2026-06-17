@extends('seller.layouts.seller')

@section('title', 'My Orders')

@section('content')

    <div class="flex-[unset] sm:flex-1">
        @include('seller.layouts.header')

        <div class="w-full px-6 md:pl-14 md:pr-9 mt-8 pb-[200px]">
            <div class="container w-full max-w-full">
                <div class="dashboard-card w-full bg-white p-0">

                    <form action="{{ request()->url() }}" method="GET" id="searchFilterForm">
                        <input type="hidden" name="active_tab" id="active_tab"
                            value="{{ request('active_tab', 'orders') }}">

                        <div
                            class="flex flex-col md:flex-row gap-5 md:gap-2.5 p-3 justify-between items-center border-b border-black/20">
                            <div class="flex w-100 gap-[30px]">
                                <button type="button"
                                    class="tab-btn listblock-title border-b-2 {{ request('active_tab', 'orders') == 'orders' ? 'border-black' : 'border-transparent' }} cursor-pointer"
                                    data-tab="orders">My
                                    Orders</button>
                                <button type="button"
                                    class="tab-btn listblock-title border-b-2 {{ request('active_tab') == 'return' ? 'border-black' : 'border-transparent' }} cursor-pointer"
                                    data-tab="return">Return</button>
                                <button type="button"
                                    class="tab-btn listblock-title border-b-2 {{ request('active_tab') == 'cancellation' ? 'border-black' : 'border-transparent' }} cursor-pointer"
                                    data-tab="cancellation">Cancellation</button>
                            </div>

                            <div class="flex flex-wrap gap-4">
                                <div
                                    class="flex items-center gap-3 lg:w-[376px] h-[46px] border rounded-[5px] border-black/20 px-4">
                                    <img src="{{ asset('storage/images/dahboard-search.png') }}" class="w-5 h-5">
                                    <input type="text" name="search" placeholder="Search by order id, product, category, price"
                                        id="search" value="{{ request('search') }}"
                                        class="w-full bg-transparent outline-none font-sans text-sm placeholder:text-black/60">
                                </div>

                                <div class="relative inline-block" id="filterProductDropdown">
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
                        </div>
                    </form>

                    <div id="tabs-container">
                        @include('seller.orders.partials.tabs', ['activeTab' => request('active_tab', 'orders')])
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
                    const target = tab.dataset.tab;

                    tabs.forEach(t => {
                        t.classList.remove("border-black", "text-black");
                        t.classList.add("border-transparent", "text-gray-500");
                    });

                    tab.classList.add("border-black", "text-black");
                    tab.classList.remove("border-transparent", "text-gray-500");

                    activeTabInput.value = target;
                    
                    const panels = document.querySelectorAll(".tab-panel");
                    panels.forEach(panel => panel.classList.add("hidden"));
                    const targetPanel = document.querySelector(`.tab-panel[data-tab="${target}"]`);
                    if (targetPanel) targetPanel.classList.remove("hidden");
                });
            });

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
                checkbox.addEventListener('change', function() {
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
