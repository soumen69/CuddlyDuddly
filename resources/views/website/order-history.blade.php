@extends('website.layouts.website')

@section('title', 'Order history')


<!-- <link rel="stylesheet" href="{{ asset('css/product-details.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

@section('content')

    <div class="orders-page">
        <div class="container max-w-container mx-auto px-5">
            <h1 class="cart-header-label">My Orders History</h1>
            <p class="text-sm text-[var(--color-silver)] mb-8">Manage and track your recent baby essentials and
                gear purchases.</p>

            <div class="orders-toolbar">
                <div class="orders-search-block">
                    <label for="search_input" class="order-filter-label">Find your order</label>
                    <div class="orders-search-wrap">
                        <span class="orders-search-icon">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                                <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.5" />
                                <line x1="10.5" y1="10.5" x2="14" y2="14" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </span>
                        <input class="orders-search-input" type="text" placeholder="Your Order ID" name="search_input"
                            id="search_input" oninput="filterOrders()">
                    </div>
                </div>
                <div class="orders-selects-wrap">
                    <div class="order-select-block">
                        <label for="search_input" class="order-filter-label">Order Status</label>
                        <select class="orders-select" id="statusFilter" onchange="filterOrders()">
                            <option value="">All Status</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Out for delivery">Out for delivery</option>
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
            </div>
            <div>
                <p class="cart-header-label">Order ID</p>
                <p class="text-sm text-[var(--color-silver)] mb-4 lg:mb-6 xl:mb-8">#CD123456</p>
            </div>
            <div class="orders-list" id="ordersList"></div>

            <div class="orders-view-all-wrap">
                <button class="mcp-btn w-full">View All</button>
            </div>
        </div>
    </div>

    <script>
        const orders = [
            {
                id: '#CD123456', name: 'Chuck Taylor All Star Stroller',
                desc: 'Limited edition all-terrain stroller with shock absorption and breathable mesh sliding.',
                date: 'Oct 12, 2023', qty: '1 Unit', status: 'Delivered', price: '₹ 849.00',
                actions: ['Reorder', 'Write Review'],
                imgUrl: 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=180&q=70',
                imgBg: '#dbeafe'
            },
            {
                id: '#CD123456', name: 'Chuck Taylor All Star Stroller',
                desc: 'Limited edition all-terrain stroller with shock absorption and breathable mesh sliding.',
                date: 'Oct 12, 2023', qty: '1 Unit', status: 'Delivered', price: '₹ 849.00',
                actions: ['Reorder', 'Write Review'],
                imgUrl: '/storage/WebsiteImages/category/baby-seater.webp',
                imgBg: '#dbeafe'
            },
            {
                id: '#CD123456', name: 'Chuck Taylor All Star Stroller',
                desc: 'Limited edition all-terrain stroller with shock absorption and breathable mesh sliding.',
                date: 'Oct 12, 2023', qty: '1 Unit', status: 'Delivered', price: '₹ 849.00',
                actions: ['Reorder', 'Write Review'],
                imgUrl: '/storage/WebsiteImages/category/car-seat.webp',
                imgBg: '#dbeafe'
            },
            {
                id: '#CD123456', name: 'Chuck Taylor All Star Stroller',
                desc: 'Limited edition all-terrain stroller with shock absorption and breathable mesh sliding.',
                date: 'Oct 12, 2023', qty: '1 Unit', status: 'Cancelled', price: '₹ 849.00',
                actions: ['Try Purchasing Again', 'Write Review'],
                imgUrl: '/storage/WebsiteImages/category/travel-system1.webp'
            },
            {
                id: '#CD123456', name: 'Chuck Taylor All Star Stroller',
                desc: 'Limited edition all-terrain stroller with shock absorption and breathable mesh sliding.',
                date: 'Oct 12, 2023', qty: '1 Unit', status: 'Out for delivery', price: '₹ 849.00',
                actions: ['Track Order', 'Write Review'],
                imgUrl: null, imgBg: '#dbeafe'
            }
        ];

        function getBadgeClass(status) {
            if (status === 'Delivered') return 'order-status-delivered';
            if (status === 'Cancelled') return 'order-status-cancelled';
            return 'order-status-out';
        }

        function getActionIcon(action) {
            if (action === 'Reorder') return `<img src="/storage/WebsiteImages/category/refresh.png" alt="reorder icon" class="action-icon">`;
            if (action === 'Track Order') return `<img src="/storage/WebsiteImages/category/track-order.png" alt="track order icon" class="action-icon">`;
            if (action === 'Try Purchasing Again') return `<img src="/storage/WebsiteImages/category/refresh.png" alt="reorder icon" class="action-icon">`;
            return `<img src="/storage/WebsiteImages/category/write.png" alt="write icon" class="action-icon">`;
        }

        function getWriteIcon() {
            return `<img src="/storage/WebsiteImages/category/write.png" alt="write icon" class="action-icon">`;
        }

        function renderImg(o) {
            if (o.imgUrl) {
                return `<a href="#!" class="order-product-img"><img src="${o.imgUrl}" alt="${o.name}" onerror="this.parentNode.style.background='${o.imgBg}'"></a>`;
            }
            return `<a href="#!" class="order-product-img" style="background:${o.imgBg}">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.2" stroke-linecap="round">
                      <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                      <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                  </a>`;
        }

        function renderCard(o) {
            return `<div class="order-card" data-status="${o.status}">
                <div class="order-card-top">
                  ${renderImg(o)}
                  <div class="order-card-info">
                    <div class="order-price-row">
                      <p class="order-product-name">${o.name}</p>
                      <strong class="order-product-price">${o.price}</strong>
                    </div>
                    <p class="order-product-desc">${o.desc}</p>
                    <div class="order-meta-grid">
                      <div>
                        <div class="order-meta-label">Order ID</div>
                        <div class="order-meta-value">${o.id}</div>
                      </div>
                      <div>
                        <div class="order-meta-label">Order Date</div>
                        <div class="order-meta-value">${o.date}</div>
                      </div>
                      <div>
                        <div class="order-meta-label">Quantity</div>
                        <div class="order-meta-value">${o.qty}</div>
                      </div>
                      <div>
                        <div class="order-meta-label">Status</div>
                        <div class="order-meta-value">
                          <span class="${getBadgeClass(o.status)}">${o.status}</span>
                        </div>
                      </div>
                    </div>
                    <div class="order-actions">
                      <button type="button" class="mcp-btn">${getActionIcon(o.actions[0])} ${o.actions[0]}</button>
                      <button type="button" class="mcp-btn mcp-btn-outline">${getWriteIcon()} ${o.actions[1]}</button>
                    </div>
                  </div>
                </div>
            </div>`;
        }

        function filterOrders() {
            const search = document.getElementById('search_input').value.toLowerCase();
            const status = document.getElementById('statusFilter').value;

            const filtered = orders.filter(o => {
                const matchSearch = !search || o.id.toLowerCase().includes(search) || o.name.toLowerCase().includes(search);
                const matchStatus = !status || o.status === status;
                return matchSearch && matchStatus;
            });

            // Split into two groups
            const reorderGroup = filtered.filter(o => o.actions[0] === 'Reorder');
            const otherGroup = filtered.filter(o => o.actions[0] !== 'Reorder');

            const list = document.getElementById('ordersList');

            if (filtered.length === 0) {
                list.innerHTML = '<div class="orders-no-results">No orders found matching your filters.</div>';
                return;
            }

            let html = '';

            if (reorderGroup.length > 0) {
                html += `<div class="order-group-recent">${reorderGroup.map(renderCard).join('')}</div>`;
            }

            if (otherGroup.length > 0) {
                html += `<div class="order-group-other">${otherGroup.map(renderCard).join('')}</div>`;
            }

            list.innerHTML = html;
        }

        filterOrders();
    </script>

@endsection