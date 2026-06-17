@extends('seller.layouts.seller')

@section('title', 'Bulk Product Upload')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/seller-registration.css') }}">
        <style>
            .modal-content {
                border-radius: 24px;
            }
        </style>
    @endpush

    <div class="p-6">
        <div class="flex items-center gap-4 mb-6">
            <button type="button" onclick="window.history.back()"
                class="flex-none w-9 h-9 rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1182_398)">
                        <path d="M11.4647 21.4961L7.16551 17.1969L11.4647 12.8977" stroke="white" stroke-width="2.02667"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M7.16523 17.1969L27.2282 17.1969" stroke="white" stroke-width="2.02667"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_1182_398">
                            <rect width="24.32" height="24.32" fill="white"
                                transform="translate(17.1968 34.3937) rotate(-135)"></rect>
                        </clipPath>
                    </defs>
                </svg>
            </button>
        </div>

        <div class="md:pl-14">
            <h2 class="text-2xl font-semibold mb-4">Bulk Product Upload</h2>

            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <input type="search" name="file" class="border border-black rounded-3xl p-2 w-full"
                        placeholder="Search Category" required>
                </div>
            </form>
        </div>

    @endsection
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showBank = @json((int) request('bank_required', 0) === 1);
                const modalEl = document.getElementById('bankDetailsModal');
                if (showBank && modalEl && window.bootstrap) {
                    new bootstrap.Modal(modalEl).show();
                }
            });
        </script>
    @endpush
