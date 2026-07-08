@php
    use Illuminate\Support\Facades\Auth;

    $seller = Auth::guard('seller')->user();
    $isSeller = Auth::guard('seller')->check();

    $menuIcons = [
        'dashboard' => <<<'SVG'
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M9 3H4C3.44772 3 3 3.44772 3 4V11C3 11.5523 3.44772 12 4 12H9C9.55228 12 10 11.5523 10 11V4C10 3.44772 9.55228 3 9 3Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M20 3H15C14.4477 3 14 3.44772 14 4V7C14 7.55228 14.4477 8 15 8H20C20.5523 8 21 7.55228 21 7V4C21 3.44772 20.5523 3 20 3Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M20 12H15C14.4477 12 14 12.4477 14 13V20C14 20.5523 14.4477 21 15 21H20C20.5523 21 21 20.5523 21 20V13C21 12.4477 20.5523 12 20 12Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M9 16H4C3.44772 16 3 16.4477 3 17V20C3 20.5523 3.44772 21 4 21H9C9.55228 21 10 20.5523 10 20V17C10 16.4477 9.55228 16 9 16Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        SVG
        ,
        'products' => <<<'SVG'
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 3V9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M16.76 2.99999C17.1327 2.99739 17.4988 3.09901 17.8168 3.29338C18.1349 3.48774 18.3923 3.76712 18.56 4.09999L20.79 8.57899C20.9279 8.85576 20.9998 9.16075 21 9.46999V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V9.47199C3.00002 9.16165 3.07226 8.85558 3.211 8.57799L5.45 4.09999C5.61696 3.76864 5.87281 3.49027 6.18893 3.29601C6.50504 3.10175 6.86897 2.99926 7.24 2.99999H16.76Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M3.054 9.013H20.947" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        SVG
        ,
        'orders' => <<<'SVG'
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M16 10C16 11.0609 15.5786 12.0783 14.8284 12.8284C14.0783 13.5786 13.0609 14 12 14C10.9391 14 9.92172 13.5786 9.17157 12.8284C8.42143 12.0783 8 11.0609 8 10"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M3.103 6.034H20.897" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M3.4 5.467C3.14036 5.81319 3 6.23426 3 6.667V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6.667C21 6.23426 20.8596 5.81319 20.6 5.467L18.6 2.8C18.4137 2.55161 18.1721 2.35 17.8944 2.21115C17.6167 2.07229 17.3105 2 17 2H7C6.68951 2 6.38328 2.07229 6.10557 2.21115C5.82786 2.35 5.58629 2.55161 5.4 2.8L3.4 5.467Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        SVG
        ,
        'payout' => <<<'SVG'
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M11 15H13C13.5304 15 14.0391 14.7893 14.4142 14.4142C14.7893 14.0391 15 13.5304 15 13C15 12.4696 14.7893 11.9609 14.4142 11.5858C14.0391 11.2107 13.5304 11 13 11H10C9.4 11 8.9 11.2 8.6 11.6L3 17"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M7 21L8.6 19.6C8.9 19.2 9.4 19 10 19H14C15.1 19 16.1 18.6 16.8 17.8L21.4 13.4C21.7859 13.0354 22.0111 12.5323 22.0261 12.0016C22.0411 11.4709 21.8447 10.9559 21.48 10.57C21.1153 10.1841 20.6123 9.95892 20.0816 9.94392C19.5508 9.92891 19.0359 10.1254 18.65 10.49L14.45 14.39"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M2 16L8 22" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M16 11.9C17.6016 11.9 18.9 10.6016 18.9 8.99998C18.9 7.39835 17.6016 6.09998 16 6.09998C14.3984 6.09998 13.1 7.39835 13.1 8.99998C13.1 10.6016 14.3984 11.9 16 11.9Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M6 8C7.65685 8 9 6.65685 9 5C9 3.34315 7.65685 2 6 2C4.34315 2 3 3.34315 3 5C3 6.65685 4.34315 8 6 8Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        SVG
        ,
        'support' => <<<'SVG'
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M3 11H6C6.53043 11 7.03914 11.2107 7.41421 11.5858C7.78929 11.9609 8 12.4696 8 13V16C8 16.5304 7.78929 17.0391 7.41421 17.4142C7.03914 17.7893 6.53043 18 6 18H5C4.46957 18 3.96086 17.7893 3.58579 17.4142C3.21071 17.0391 3 16.5304 3 16V11ZM3 11C3 9.8181 3.23279 8.64778 3.68508 7.55585C4.13738 6.46392 4.80031 5.47177 5.63604 4.63604C6.47177 3.80031 7.46392 3.13738 8.55585 2.68508C9.64778 2.23279 10.8181 2 12 2C13.1819 2 14.3522 2.23279 15.4442 2.68508C16.5361 3.13738 17.5282 3.80031 18.364 4.63604C19.1997 5.47177 19.8626 6.46392 20.3149 7.55585C20.7672 8.64778 21 9.8181 21 11M21 11V16C21 16.5304 20.7893 17.0391 20.4142 17.4142C20.0391 17.7893 19.5304 18 19 18H18C17.4696 18 16.9609 17.7893 16.5858 17.4142C16.2107 17.0391 16 16.5304 16 16V13C16 12.4696 16.2107 11.9609 16.5858 11.5858C16.9609 11.2107 17.4696 11 18 11H21Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M21 16V18C21 19.0609 20.5786 20.0783 19.8284 20.8284C19.0783 21.5786 18.0609 22 17 22H12"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        SVG
        ,
        'settings' => <<<'SVG'
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M9.671 4.13603C9.7261 3.55637 9.99533 3.01807 10.4261 2.62631C10.8569 2.23454 11.4182 2.01746 12.0005 2.01746C12.5828 2.01746 13.1441 2.23454 13.5749 2.62631C14.0057 3.01807 14.2749 3.55637 14.33 4.13603C14.3631 4.51048 14.486 4.87145 14.6881 5.18837C14.8903 5.50529 15.1659 5.76884 15.4915 5.95671C15.8171 6.14457 16.1831 6.25123 16.5587 6.26765C16.9343 6.28407 17.3082 6.20977 17.649 6.05103C18.1781 5.81081 18.7777 5.77605 19.331 5.95352C19.8843 6.13098 20.3518 6.50798 20.6425 7.01113C20.9332 7.51429 21.0263 8.1076 20.9036 8.6756C20.781 9.2436 20.4514 9.74565 19.979 10.084C19.6714 10.2999 19.4203 10.5866 19.2469 10.9201C19.0736 11.2535 18.983 11.6237 18.983 11.9995C18.983 12.3753 19.0736 12.7456 19.2469 13.079C19.4203 13.4124 19.6714 13.6992 19.979 13.915C20.4514 14.2534 20.781 14.7555 20.9036 15.3235C21.0263 15.8915 20.9332 16.4848 20.6425 16.9879C20.3518 17.4911 19.8843 17.8681 19.331 18.0455C18.7777 18.223 18.1781 18.1883 17.649 17.948C17.3082 17.7893 16.9343 17.715 16.5587 17.7314C16.1831 17.7478 15.8171 17.8545 15.4915 18.0424C15.1659 18.2302 14.8903 18.4938 14.6881 18.8107C14.486 19.1276 14.3631 19.4886 14.33 19.863C14.2749 20.4427 14.0057 20.981 13.5749 21.3727C13.1441 21.7645 12.5828 21.9816 12.0005 21.9816C11.4182 21.9816 10.8569 21.7645 10.4261 21.3727C9.99533 20.981 9.7261 20.4427 9.671 19.863C9.63794 19.4884 9.5151 19.1273 9.31286 18.8103C9.11063 18.4933 8.83497 18.2296 8.50923 18.0418C8.18349 17.8539 7.81727 17.7472 7.44158 17.7309C7.06589 17.7146 6.6918 17.7891 6.351 17.948C5.82189 18.1883 5.22233 18.223 4.669 18.0455C4.11567 17.8681 3.64817 17.4911 3.35748 16.9879C3.06679 16.4848 2.97371 15.8915 3.09636 15.3235C3.219 14.7555 3.5486 14.2534 4.021 13.915C4.32862 13.6992 4.57973 13.4124 4.75309 13.079C4.92645 12.7456 5.01695 12.3753 5.01695 11.9995C5.01695 11.6237 4.92645 11.2535 4.75309 10.9201C4.57973 10.5866 4.32862 10.2999 4.021 10.084C3.54926 9.74547 3.22025 9.24362 3.0979 8.67601C2.97555 8.1084 3.06861 7.51557 3.35898 7.01274C3.64936 6.50991 4.11631 6.13301 4.66909 5.95527C5.22187 5.77753 5.82098 5.81166 6.35 6.05103C6.69076 6.20977 7.06474 6.28407 7.4403 6.26765C7.81586 6.25123 8.18193 6.14457 8.50754 5.95671C8.83314 5.76884 9.10869 5.50529 9.31086 5.18837C9.51304 4.87145 9.63588 4.51048 9.669 4.13603"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path
            d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        SVG
    ,
    ];

    $menus = [
        [
            'label' => 'Dashboard',
            'icon' => 'dashboard',
            'type' => 'route',
            'route' => 'seller.dashboard',
            'active_routes' => ['seller.dashboard'],
        ],
        [
            'label' => 'My products',
            'icon' => 'products',
            'type' => 'route',
            'route' => 'seller.products.index',
            'active_routes' => [
                'seller.products.index',
                'seller.add.products',
                'seller.products.edit',
                'seller.products.variants.create',
                'seller.products.bulk.create',
                'seller.products.create',
            ],
        ],
        [
            'label' => 'My orders',
            'icon' => 'orders',
            'type' => 'route',
            'route' => 'seller.orders.index',
            'active_routes' => ['seller.orders.index', 'seller.orders.show'],
        ],
        [
            'label' => 'Payout',
            'icon' => 'payout',
            'type' => 'route',
            'route' => 'seller.payouts.index',
            'active_routes' => ['seller.payouts.index'],
        ],
        [
            'label' => 'Support',
            'icon' => 'support',
            'type' => 'route',
            'route' => 'seller.support.index',
            'active_routes' => ['seller.support.index'],
        ],
        [
            'label' => 'Settings',
            'icon' => 'settings',
            'type' => 'route',
            'route' => 'seller.setting',
            'active_routes' => ['seller.setting'],
        ],
    ];
@endphp

<aside id="dashboardnav-wrapper"
    class="
      fixed lg:static flex flex-col items-center pt-12 gap-[110px]
      top-0 left-0 bottom-0
      w-49 xl:w-[280px] xl:min-w-[280px]
      h-screen lg:h-auto
      bg-white
      border-r border-black/20
      z-50
      transform
     -translate-x-full
      lg:translate-x-0
      transition-transform duration-300 ease-in-out
    ">
    <div class="mx-auto">
        <a href="{{ route('seller.dashboard', $seller->slug) }}">
            <img src={{ asset('storage/images/logo.webp') }} alt="company logo"
                class="max-w-40 xl:max-w-(--max-w-lg) object-contain">
        </a>
    </div>
    <nav class="dashboardnav">
        <ul class="flex flex-col gap-5">
            @foreach ($menus as $menu)
                <li
                    class="dashboard-list {{ !empty($menu['active_routes']) && request()->routeIs(...$menu['active_routes']) ? 'active' : '' }}">
                    <a href="{{ $menu['type'] === 'route' ? route($menu['route'], $seller->slug) : $menu['url'] }}">
                        <span>{!! $menuIcons[$menu['icon']] !!}</span>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

<script>
    $('#dashboardhamburger').on('click', function() {
        $('#dashboardnav-wrapper').toggleClass('-translate-x-full');
        $('#sidebar-overlay').toggleClass('hidden');
    });

    $('#sidebar-overlay').on('click', function() {
        $('#dashboardnav-wrapper').addClass('-translate-x-full');
        $('#sidebar-overlay').addClass('hidden');
    });
</script>
