<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/output.css') }}"> --}}
</head>

<body>
    {{-- Header --}}
    @include('website.layouts.header')
    {{-- Main Content --}}
    @include('website.partials.category-menu')

    @yield('content')

    <div id="universalModal"
        style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.45); align-items:center; justify-content:center;">
        <div
            style="background:#fff; border-radius:24px; padding:2.5rem 2rem; max-width:360px; width:90%; text-align:center;">
            <!-- ICON -->
            <div id="toastIconWrap"
                style="width:56px; height:56px; border-radius:50%; background:#dcfce7; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                <svg id="toastIcon" xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;color:#16a34a;"
                    fill="none" viewBox="0 0 24 24" stroke="#16a34a">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <!-- TITLE -->
            <h2 id="toastTitle" style="font-size:1.2rem; font-weight:700; color:#111; margin-bottom:0.4rem;">
                Title
            </h2>
            <!-- MESSAGE -->
            <p id="toastMessage" style="font-size:0.85rem; color:#888;">
                Message
            </p>
        </div>
    </div>

    {{-- Footer --}}
    @include('website.layouts.footer')

    @stack('styles')
    @stack('scripts')
    {{-- <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('js/slick.min.js') }}"></script> --}}
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        function getIcon(type) {

            if (type === 'success') {
                return `
                <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="#16a34a">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>`;
            }

            if (type === 'error') {
                return `
                <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="#dc2626">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>`;
            }

            if (type === 'warning') {
                return `
                <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;" fill="none" viewBox="0 0 24 24" stroke="#d97706">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                </svg>`;
            }
        }

        function showToast({
            title = "Success",
            message = "Done",
            type = "success",
            duration = 2500
        } = {}) {

            const modal = document.getElementById('universalModal');
            const titleEl = document.getElementById('toastTitle');
            const msgEl = document.getElementById('toastMessage');
            const iconWrap = document.getElementById('toastIconWrap');

            // ✅ Set content (FIXED)
            titleEl.textContent = title;
            msgEl.textContent = message;

            // ✅ Icon + background
            if (type === 'success') {
                iconWrap.style.background = '#dcfce7';
            } else if (type === 'error') {
                iconWrap.style.background = '#fee2e2';
            } else if (type === 'warning') {
                iconWrap.style.background = '#fef3c7';
            }

            // ✅ Replace full SVG (FIXED)
            iconWrap.innerHTML = getIcon(type);

            // ✅ Show
            modal.style.display = 'flex';

            // ✅ Hide
            setTimeout(() => {
                modal.style.display = 'none';
            }, duration);
        }

        function updateCartBadge(count) {
            const badge = document.querySelector('#cartBadge');
            if (!badge) return;

            badge.innerText = count;

            if (count > 0) {
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        window.addEventListener("cart:updated", function(e) {
            const cart = e.detail?.cart;
            if (!cart) return;
            if (typeof updateCartBadge === "function") {
                updateCartBadge(cart.count || 0);
            }
        });
    </script>
</body>

</html>
