@extends('seller.layouts.seller')

@section('title', 'My Products')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/seller-products.css') }}">

    <div class="flex-1 min-w-0">
        @include('seller.layouts.header')

        <section class="">
            <div class="w-full flex flex-col sm:flex-row justify-between pt-6 px-6 pb-4 md:pl-14 md:pr-9 sm:pb-10">
                <div class="mb-4 sm:mb-0">
                    <h3 class="font-sans font-normal text-lg md:text-xl lg:text-2xl xl:text-3xl leading-tight tracking-1 text-black">
                        @php $seller = Auth::guard('seller')->user(); @endphp
                        @if ($seller)
                            <span class="me-3">Welcome! {{ $seller->name }}</span>
                        @endif
                    </h3>
                    <p class="font-sans font-normal text-base leading-tight tracking-1 text-black">
                        Let's get your store moving!
                    </p>
                </div>

                @if ($seller)
                    <a href="{{ route('seller.products.create', $seller->slug) }}" class="seller-btn">
                        Add Products
                    </a>
                @endif
            </div>

            <div class="w-full px-6 md:pl-14 md:pr-9">
                <div class="w-full max-w-full">
                    <div class="dashboard-card w-full bg-white p-0">

                        <div class="p-5 pb-0 border-b border-black/20">
                            <div class="flex flex-wrap md:justify-end gap-4 w-full md:w-auto">
                                <div
                                    class="flex items-center gap-3 flex-grow-1 md:flex-grow-0 md:w-52 xl:w-72 h-11 border rounded-[5px] border-black/20 px-4">
                                    <img src="{{ asset('storage/images/dahboard-search.png') }}" class="w-4 h-4">
                                    <input type="text" placeholder="Search by product, category" id="search"
                                        class="w-full bg-transparent outline-none font-sans text-sm placeholder:text-black/50">
                                </div>

                                <div class="relative inline-block flex-none" id="filterDropdown">
                                    <button type="button" id="filterBtn"
                                        class="flex justify-center items-center gap-2 border h-11 border-black/20 rounded-sm px-2.5 py-2 cursor-pointer text-[var(--color-silver)] hover:bg-[#d9dad9] transition-all duration-300"><!-- Updated gap to 2 -->
                                        <img src="{{ asset('storage/images/dashboard-filter.png') }}" class="max-w-[15px] object-contain">
                                        <span>Filter</span>
                                    </button>

                                    <div id="dropdownMenu" class="absolute right-0 top-full mt-2 w-[180px] hidden z-50">
                                        <div
                                            class="bg-white border border-black/20 rounded-md shadow-lg p-4 flex flex-col gap-4">
                                            <label>
                                                <input type="checkbox" class="status-checkbox" value="1">
                                                Approved
                                            </label>
                                            <label>
                                                <input type="checkbox" class="status-checkbox" value="0"> Pending
                                            </label>
                                            <label>
                                                <input type="checkbox" class="status-checkbox" value="2">
                                                Rejected
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-1.5 max-w-full overflow-x-auto mt-5 md:mt-0">
                                <button type="button"
                                    class="tab-btn listblock-title mb-0 flex-none py-1.5 px-2.5 border border-b-0 border-black/20 rounded-t-sm {{ ($activeTab ?? '1') == '1' ? 'bg-black text-white' : 'bg-transparent text-black' }} cursor-pointer"
                                    data-tab="1">My Products</button>
                                <button type="button"
                                    class="tab-btn listblock-title mb-0 flex-none py-1.5 px-2.5 border border-b-0 border-black/20 rounded-t-sm {{ ($activeTab ?? '1') == '0' ? 'bg-black text-white' : 'bg-transparent text-black' }} cursor-pointer"
                                    data-tab="0">Products Draft</button>
                            </div>
                        </div>

                        <div id="product-container">
                            
                            @include('seller.products.partials.table-container')
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection


@push('scripts')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Pass route to JS -->
    <script>
        const searchUrl = "{{ route('seller.products.search', $seller->slug) }}";
    </script>

    <!-- External JS -->
    <script src="{{ asset('js/seller-products.js') }}"></script>

@endpush