@php
    use Illuminate\Support\Facades\Auth;

    $admin = Auth::guard('admin')->user();
    $isAdmin = Auth::guard('admin')->check();

    // Sidebar collapse state tracking
    $openSellers = request()->routeIs('admin.sellers.*') || request()->routeIs('admin.payouts.*');
    $openProducts =
        request()->routeIs('admin.products.*') ||
        request()->routeIs('admin.categories.*') ||
        request()->routeIs('admin.product-categories.*') ||
        request()->routeIs('admin.brands.*') ||
        request()->routeIs('admin.inventory.*');
    $openOrders =
        request()->routeIs('admin.orders.*') ||
        request()->routeIs('admin.returns.*') ||
        request()->routeIs('admin.cancellations.*');
    $openCustomers =
        request()->routeIs('admin.customers.*') ||
        request()->routeIs('admin.reviews.*') ||
        request()->routeIs('admin.wishlists.*');
    $openWebsite = request()->routeIs('admin.website.*');
    $openSupport = request()->routeIs('admin.support.*') || request()->routeIs('admin.tickets.*');
    $openReports = request()->routeIs('admin.reports.*');
    $openPayments = request()->routeIs('admin.payments.*');
    $openShipping = request()->routeIs('admin.shipping.*');
    $openSettings = request()->routeIs('admin.settings.*') || request()->routeIs('admin.roles.*');
    $openTrash = request()->routeIs('admin.trash.*');

@endphp

<div class="sidebar overflow-auto" style="max-height: 100vh;">
    {{-- Sidebar Header --}}
    <div class="sidebar-header d-flex align-items-center p-3 border-bottom">
        <img src="{{ asset('logo/cuddlyduddly_logo.png') }}" alt="CuddlyDuddly Logo" style="height: 32px;" class="me-2">
        <h4 class="m-0">Admin Panel</h4>
    </div>

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    {{-- ============ SELLERS ============ --}}
    @if (
        $isAdmin &&
            $admin->hasAnyPermission([
                'admin.sellers.index',
                'admin.sellers.create',
                'admin.sellers.compliance',
                'admin.payouts.index',
            ]))
        <a class="dropdown-toggle {{ $openSellers ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#menuSellers"
            aria-expanded="{{ $openSellers }}" aria-controls="menuSellers">
            <i class="bi bi-shop"></i> Sellers
        </a>
        <div class="collapse ps-3 {{ $openSellers ? 'show' : '' }}" id="menuSellers" data-bs-parent=".sidebar">
            @if ($admin->hasPermission('admin.sellers.index'))
                <a href="{{ route('admin.sellers.index') }}"
                    class="{{ request()->routeIs('admin.sellers.index') ? 'active' : '' }}">All Sellers</a>
            @endif
            {{-- @if ($admin->hasPermission('admin.sellers.create'))
                <a href="{{ route('admin.sellers.create') }}"
                    class="{{ request()->routeIs('admin.sellers.create') ? 'active' : '' }}">Applications</a>
            @endif --}}
            {{-- @if ($admin->hasPermission('admin.sellers.compliance'))
                <a href="{{ route('admin.sellers.compliance') }}"
                    class="{{ request()->routeIs('admin.sellers.compliance') ? 'active' : '' }}">KYC / Compliance</a>
            @endif --}}
            @if ($admin->hasPermission('admin.payouts.index'))
                <a href="{{ route('admin.payouts.index') }}"
                    class="{{ request()->routeIs('admin.payouts.*') ? 'active' : '' }}">Payouts</a>
            @endif
        </div>
    @endif

    {{-- ============ PRODUCTS ============ --}}
    @if (
        $isAdmin &&
            $admin->hasAnyPermission([
                'admin.products.index',
                'admin.categories.index',
                'admin.brands.index',
                'admin.inventory.index',
                'admin.product-categories.index',
            ]))
        <a class="dropdown-toggle {{ $openProducts ? '' : 'collapsed' }}" data-bs-toggle="collapse"
            href="#menuProducts" aria-expanded="{{ $openProducts }}" aria-controls="menuProducts">
            <i class="bi bi-box-seam"></i> Products
        </a>
        <div class="collapse ps-3 {{ $openProducts ? 'show' : '' }}" id="menuProducts" data-bs-parent=".sidebar">
            @if ($admin->hasPermission('admin.products.index'))
                <a href="{{ route('admin.products.index') }}"
                    class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">All Products</a>
            @endif
            @if ($admin->hasPermission('admin.categories.index'))
                <a href="{{ route('admin.categories.index') }}"
                    class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Website Categories</a>
            @endif
            @if ($admin->hasPermission('admin.product-categories.index'))
                <a href="{{ route('admin.product-categories.index') }}"
                    class="{{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">
                    Product Categories
                </a>
            @endif
            @if ($admin->hasPermission('admin.brands.index'))
                <a href="{{ route('admin.brands.index') }}"
                    class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">Brands</a>
            @endif
            @if ($admin->hasPermission('admin.inventory.index'))
                <a href="{{ route('admin.inventory.index') }}"
                    class="{{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">Inventory</a>
            @endif
        </div>
    @endif

    {{-- ============ ORDERS ============ --}}
    @if ($isAdmin && $admin->hasAnyPermission(['admin.orders.index', 'admin.returns.index', 'admin.cancellations.index']))
        <a class="dropdown-toggle {{ $openOrders ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#menuOrders"
            aria-expanded="{{ $openOrders }}" aria-controls="menuOrders">
            <i class="bi bi-cart-check"></i> Orders
        </a>
        <div class="collapse ps-3 {{ $openOrders ? 'show' : '' }}" id="menuOrders" data-bs-parent=".sidebar">
            @if ($admin->hasPermission('admin.orders.index'))
                <a href="{{ route('admin.orders.index') }}"
                    class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">All Orders</a>
            @endif
            @if ($admin->hasPermission('admin.returns.index'))
                <a href="{{ route('admin.returns.index') }}"
                    class="{{ request()->routeIs('admin.returns.*') ? 'active' : '' }}">Returns</a>
            @endif
            @if ($admin->hasPermission('admin.cancellations.index'))
                <a href="{{ route('admin.cancellations.index') }}"
                    class="{{ request()->routeIs('admin.cancellations.*') ? 'active' : '' }}">Cancellations</a>
            @endif
        </div>
    @endif

    {{-- ============ CUSTOMERS ============ --}}
    @if ($isAdmin && $admin->hasAnyPermission(['admin.customers.index', 'admin.reviews.index', 'admin.wishlists.index']))
        <a class="dropdown-toggle {{ $openCustomers ? '' : 'collapsed' }}" data-bs-toggle="collapse"
            href="#menuCustomers" aria-expanded="{{ $openCustomers }}" aria-controls="menuCustomers">
            <i class="bi bi-people"></i> Customers
        </a>
        <div class="collapse ps-3 {{ $openCustomers ? 'show' : '' }}" id="menuCustomers" data-bs-parent=".sidebar">
            @if ($admin->hasPermission('admin.customers.index'))
                <a href="{{ route('admin.customers.index') }}"
                    class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">All Customers</a>
            @endif
            @if ($admin->hasPermission('admin.reviews.index'))
                <a href="{{ route('admin.reviews.index') }}"
                    class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">Reviews</a>
            @endif
            @if ($admin->hasPermission('admin.wishlists.index'))
                <a href="{{ route('admin.wishlists.index') }}"
                    class="{{ request()->routeIs('admin.wishlists.*') ? 'active' : '' }}">Wishlists</a>
            @endif
        </div>
    @endif

    {{-- ============ WEBSITE CONTENT ============ --}}
    @if (
        $isAdmin &&
            $admin->hasAnyPermission([
                'admin.website.blogs.index',
                'admin.website.banners',
                'admin.website.pages',
                'admin.website.seo',
            ]))
        <a class="dropdown-toggle {{ $openWebsite ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#menuWebsite"
            aria-expanded="{{ $openWebsite }}" aria-controls="menuWebsite">
            <i class="bi bi-globe"></i> Website Content
        </a>
        <div class="collapse ps-3 {{ $openWebsite ? 'show' : '' }}" id="menuWebsite" data-bs-parent=".sidebar">
            @if ($admin->hasPermission('admin.website.home'))
                <a href="{{ route('admin.website.home') }}"
                    class="{{ request()->routeIs('admin.website.home*') ? 'active' : '' }}">
                    Home Page
                </a>
            @endif
            @if ($admin->hasPermission('admin.website.banners'))
                <a href="{{ route('admin.website.banners') }}"
                    class="{{ request()->routeIs('admin.website.banners') ? 'active' : '' }}">Banners</a>
            @endif
            @if ($admin->hasPermission('admin.website.pages'))
                <a href="{{ route('admin.website.pages') }}"
                    class="{{ request()->routeIs('admin.website.pages') ? 'active' : '' }}">Pages</a>
            @endif
            @if ($admin->hasPermission('admin.website.blogs.index'))
                <a href="{{ route('admin.website.blogs.index') }}"
                    class="{{ request()->routeIs('admin.website.blogs.*') ? 'active' : '' }}">Blogs</a>
            @endif
            @if ($admin->hasPermission('admin.website.seo'))
                <a href="{{ route('admin.website.seo') }}"
                    class="{{ request()->routeIs('admin.website.seo') ? 'active' : '' }}">SEO Settings</a>
            @endif
        </div>
    @endif

    {{-- ============ SUPPORT ============ --}}
    @if (
        $isAdmin &&
            $admin->hasAnyPermission(['admin.support.seller', 'admin.support.customer', 'admin.support.tickets.index']))
        <a class="dropdown-toggle {{ $openSupport ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#menuSupport"
            aria-expanded="{{ $openSupport }}" aria-controls="menuSupport">
            <i class="bi bi-headset"></i> Support
        </a>
        <div class="collapse ps-3 {{ $openSupport ? 'show' : '' }}" id="menuSupport" data-bs-parent=".sidebar">
            @if ($admin->hasPermission('admin.support.seller'))
                <a href="{{ route('admin.support.seller') }}"
                    class="{{ request()->routeIs('admin.support.seller') ? 'active' : '' }}">Seller Support</a>
            @endif
            @if ($admin->hasPermission('admin.support.customer'))
                <a href="{{ route('admin.support.customer') }}"
                    class="{{ request()->routeIs('admin.support.customer') ? 'active' : '' }}">Customer Support</a>
            @endif
            <a href="{{ route('admin.support.tickets.index') }}"
                class="{{ request()->routeIs('admin.support.tickets.*') ? 'active' : '' }}">All Tickets</a>
        </div>
    @endif


    {{-- ============ PAYMENTS ============ --}}
    @if ($isAdmin && $admin->hasAnyPermission(['admin.payments.settlements', 'admin.payments.logs']))
        <a class="dropdown-toggle {{ request()->routeIs('admin.payments.*') ? '' : 'collapsed' }}"
            data-bs-toggle="collapse" href="#menuPayments"
            aria-expanded="{{ request()->routeIs('admin.payments.*') }}" aria-controls="menuPayments">
            <i class="bi bi-currency-rupee"></i> Payments
        </a>

        <div class="collapse ps-3 {{ request()->routeIs('admin.payments.*') ? 'show' : '' }}" id="menuPayments"
            data-bs-parent=".sidebar">

            @if ($admin->hasPermission('admin.payments.settlements'))
                <a href="{{ route('admin.payments.settlements') }}"
                    class="{{ request()->routeIs('admin.payments.settlements') ? 'active' : '' }}">
                    Settlement Logs
                </a>
            @endif

            @if ($admin->hasPermission('admin.payments.logs'))
                <a href="{{ route('admin.payments.logs') }}"
                    class="{{ request()->routeIs('admin.payments.logs') ? 'active' : '' }}">
                    Payment Webhook Logs
                </a>
            @endif
        </div>
    @endif

    {{-- ============ SHIPPING ============ --}}
    @if ($isAdmin && $admin->hasAnyPermission(['admin.shipping.logs']))
        <a class="dropdown-toggle {{ request()->routeIs('admin.shipping.*') ? '' : 'collapsed' }}"
            data-bs-toggle="collapse" href="#menuShipping"
            aria-expanded="{{ request()->routeIs('admin.shipping.*') }}" aria-controls="menuShipping">
            <i class="bi bi-truck"></i> Shipping Logs
        </a>

        <div class="collapse ps-3 {{ request()->routeIs('admin.shipping.*') ? 'show' : '' }}" id="menuShipping"
            data-bs-parent=".sidebar">

            @if ($admin->hasPermission('admin.shipping.logs'))
                <a href="{{ route('admin.shipping.logs') }}"
                    class="{{ request()->routeIs('admin.shipping.logs') ? 'active' : '' }}">
                    Shipment Events
                </a>
            @endif
        </div>
    @endif


    {{-- ============ REPORTS ============ --}}


    @if (
        $isAdmin &&
            $admin->hasAnyPermission([
                'admin.reports.sales',
                'admin.reports.revenue',
                'admin.reports.seller-performance',
                'admin.reports.customer-insights',
            ]))
        <a class="dropdown-toggle {{ $openReports ? '' : 'collapsed' }}" data-bs-toggle="collapse"
            href="#menuReports" aria-expanded="{{ $openReports }}" aria-controls="menuReports">
            <i class="bi bi-bar-chart"></i> Reports
        </a>
        <div class="collapse ps-3 {{ $openReports ? 'show' : '' }}" id="menuReports" data-bs-parent=".sidebar">
            @if ($admin->hasPermission('admin.reports.sales'))
                <a href="{{ route('admin.reports.sales') }}"
                    class="{{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">Sales</a>
            @endif
            @if ($admin->hasPermission('admin.reports.revenue'))
                <a href="{{ route('admin.reports.revenue') }}"
                    class="{{ request()->routeIs('admin.reports.revenue') ? 'active' : '' }}">Revenue</a>
            @endif
            @if ($admin->hasPermission('admin.reports.seller-performance'))
                <a href="{{ route('admin.reports.seller-performance') }}"
                    class="{{ request()->routeIs('admin.reports.seller-performance') ? 'active' : '' }}">Seller
                    Performance</a>
            @endif
            @if ($admin->hasPermission('admin.reports.customer-insights'))
                <a href="{{ route('admin.reports.customer-insights') }}"
                    class="{{ request()->routeIs('admin.reports.customer-insights') ? 'active' : '' }}">Customer
                    Insights</a>
            @endif
        </div>
    @endif

    {{-- ============ SETTINGS ============ --}}
    @if (
        $isAdmin &&
            $admin->hasAnyPermission([
                'admin.settings.general',
                'admin.settings.payments',
                'admin.settings.shipping',
                'admin.roles.index',
            ]))
        <a class="dropdown-toggle {{ $openSettings ? '' : 'collapsed' }}" data-bs-toggle="collapse"
            href="#menuSettings" aria-expanded="{{ $openSettings }}" aria-controls="menuSettings">
            <i class="bi bi-gear"></i> Settings
        </a>
        <div class="collapse ps-3 {{ $openSettings ? 'show' : '' }}" id="menuSettings" data-bs-parent=".sidebar">
            @if ($admin->hasPermission('admin.settings.general'))
                <a href="{{ route('admin.settings.general') }}"
                    class="{{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">General</a>
            @endif
            @if ($admin->hasPermission('admin.settings.payments'))
                <a href="{{ route('admin.settings.payments') }}"
                    class="{{ request()->routeIs('admin.settings.payments') ? 'active' : '' }}">Payment</a>
            @endif
            {{-- @if ($admin->hasPermission('admin.settings.shipping'))
                <a href="{{ route('admin.settings.shipping') }}"
                    class="{{ request()->routeIs('admin.settings.shipping') ? 'active' : '' }}">Shipping</a>
            @endif --}}
            @if ($admin->hasPermission('admin.roles.index'))
                <a href="{{ route('admin.roles.index') }}"
                    class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Roles & Permissions</a>
            @endif


            @if ($admin->hasPermission('admin.trash.index'))
                <a href="{{ route('admin.trash.index') }}"
                    class="{{ request()->routeIs('admin.trash.*') ? 'active' : '' }}">Trash</a>
            @endif
        </div>
    @endif
</div>
