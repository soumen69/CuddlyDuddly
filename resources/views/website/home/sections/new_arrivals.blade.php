<div class="wrapper px-5 mt-11 md:mt-lg">
    <div class="container max-w-container mx-auto">

        <div class="flex flex-wrap justify-between items-center mb-sm relative">
            <div class="title flex-box mx-0">
                <div>
                    <img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon" class="max-w-6">
                </div>
                <span class="label text-black">New Arrivals</span>
            </div>

            <a href="{{ $data['view_all_url'] ?? '#!' }}"
                class="group flex-box py-3.5 px-5 rounded-xxl
                      border border-black/20 hover:bg-black">
                <span class="addcart group-hover:text-white hidden md:block">View all</span>
                <span class="max-w-icon">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="max-w-4 
                                max-h-(--max-h-arrow)
                                object-contain group-hover:text-white">
                        <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-(--margin-sm) gap-3 md:gap-5 addtocart">
            @foreach ($data['products'] as $product)
                @include('website.components.product-card', ['product' => $product])
            @endforeach
        </div>

    </div>
</div>
