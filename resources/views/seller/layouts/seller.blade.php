<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Seller Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sellerportal.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            transition: all 0.3s;
        }

        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar .active {
            background: #0d6efd;
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            height: 100vh;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
            }
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            height: 42px !important;
            padding: 6px 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px !important;
            color: #000 !important;
            padding-left: 0 !important;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
</head>

<body>

    <div class="w-full">
        <div class="flex min-h-screen w-full">
            @include('seller.layouts.sidebar')


            @yield('content')
        </div>

    </div>

    <!-- @include('seller.layouts.footer') -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector('#sidebarToggle')?.addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('styles')
    @stack('scripts')

</body>

</html>
