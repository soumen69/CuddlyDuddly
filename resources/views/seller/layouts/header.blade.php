{{-- <header>
    <button class="btn btn-outline-dark d-md-none" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <h5 class="m-0">Seller Dashboard</h5>

    <div>
        @php $seller = Auth::guard('seller')->user(); @endphp
        @if ($seller)
        <span class="me-3">Hello👋, {{ $seller->name }}</span>
        @endif

        <form method="POST" action="{{ route('seller.logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</header> --}}
<div
    class="w-full flex flex-wrap-reverse lg:flex-nowrap justify-center py-6 px-6 md:pl-14 md:pr-9 border-b border-black/20 gap-5">

    <div class="flex gap-4 justify-end absolute top-6 right-6 z-50">
        <style>
            .alert {
                transition: all 0.4s ease;
            }
        </style>


        {{-- RIGHT SIDE ALERTS --}}
        <div class="w-full flex justify-end items-start">

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-dismissible fade show 
                                        flex items-center gap-3 
                                        bg-gradient-to-r from-green-50 to-green-200 
                                        !text-green-900 border !border-green-300 
                                        shadow-md rounded-xl px-5 py-3">

                    <i class="fa-solid fa-circle-check text-green-700 text-xl"></i>

                    <span class="font-medium">{{ session('success') }}</span>

                    <button type="button" class="btn-close !ml-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ERROR --}}
            @if (session('error'))
                <div class="alert alert-dismissible fade show 
                                        flex items-center gap-3 
                                        bg-gradient-to-r from-red-50 to-red-200 
                                        text-red-900 border border-red-300
                                        shadow-md rounded-xl px-5 py-3">

                    <i class="fa-solid fa-triangle-exclamation text-red-700 text-xl"></i>

                    <span class="font-medium">{{ session('error') }}</span>

                    <button type="button" class="btn-close !ml-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

        </div>


    </div>

    <div class="w-full flex flex-wrap gap-4">
        <div
            class="flex-1 flex-box w-full max-w-full order-2 lg:order-[unset] max-w-auto justify-start rounded-[64.18px] border border-black/20 pl-4 pr-2.5 py-3">
            <span><img src={{ asset('storage/images/dahboard-search.png') }} alt=""
                    class="max-w-4 object-contain"></span><input type="text"
                class="w-full h-full placeholder:font-sans placeholder:text-base placeholder:text-black placeholder:font-normal placeholder:tracking-1 placeholder:leading-tight"
                placeholder="Search">
        </div>
        <div class="w-full lg:w-auto flex items-center gap-5">
            <button id="dashboardhamburger" type="button" class="text-[28px] block lg:hidden ml-0 lg:m-auto">
                <i class="fa-solid fa-bars"></i>
            </button>


            <button
                class="cursor-pointer w-9 h-9 md:w-12 md:h-12 ml-auto inline-block lg:mr-0 my-0 lg:m-auto group rounded-full border border-black/20 hover:bg-black transition-all duration-300">
                <svg
                    width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-full max-h-4 md:max-h-6 group-hover:text-white">
                    <path
                        d="M14.0681 28.7721C14.3086 29.1886 14.6545 29.5345 15.0711 29.775C15.4876 30.0154 15.9601 30.142 16.4411 30.142C16.9221 30.142 17.3946 30.0154 17.8112 29.775C18.2277 29.5345 18.5736 29.1886 18.8141 28.7721"
                        stroke="currentColor" stroke-width="2.7402" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                    <path
                        d="M4.46917 20.9981C4.29019 21.1943 4.17207 21.4383 4.12919 21.7003C4.08631 21.9624 4.12051 22.2313 4.22763 22.4743C4.33476 22.7173 4.51018 22.9239 4.73258 23.069C4.95497 23.2141 5.21475 23.2915 5.4803 23.2917H27.4019C27.6674 23.2918 27.9272 23.2147 28.1498 23.0699C28.3723 22.925 28.5479 22.7186 28.6554 22.4758C28.7628 22.233 28.7973 21.9642 28.7548 21.7021C28.7122 21.44 28.5944 21.1959 28.4157 20.9995C26.5935 19.1211 24.6617 17.1249 24.6617 10.9608C24.6617 8.78056 23.7956 6.68962 22.2539 5.14796C20.7123 3.6063 18.6213 2.7402 16.4411 2.7402C14.2609 2.7402 12.1699 3.6063 10.6283 5.14796C9.08659 6.68962 8.2205 8.78056 8.2205 10.9608C8.2205 17.1249 6.28729 19.1211 4.46917 20.9981Z"
                        stroke="currentColor" stroke-width="2.7402" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </button>
            <div class="w-9 h-9 md:w-12 md:h-12 rounded-full border border-black/20 overflow-hidden">
                <img src="{{asset('storage/images/profileimg.png')}}" alt="" class="scale-150">
            </div>
            <span class="">
                <form id="logoutForm" method="POST" action="{{ route('seller.logout') }}"
                    class="">
                    @csrf
                    <button type="button" id="logoutBtn"
                        class="cursor-pointer w-9 h-9 md:w-12 md:h-12 ml-auto mr-0 my-0 md:m-auto group rounded-full border-[1.5px] 
                        border-[var(--color-pink-transparent)] bg-white text-[var(--color-pink-transparent)] hover:border-black 
                        focus:border-black hover:text-black focus:text-black flex items-center justify-center transition-all 
                        duration-300">
                        <!-- <i class="fa-solid fa-arrow-right-from-bracket"></i> -->
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </span>


        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000);
        });
    });

    // Logout 
    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to logout from your account.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, logout",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>