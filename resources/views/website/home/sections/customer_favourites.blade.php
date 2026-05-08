<div class="hidden sm:block relative wrapper px-5">
    <div class="container relative z-10 max-w-container mx-auto">
        {{-- Section Title --}}
        <div class="title flex-box mt-[50px] md:mt-lg mb-3.5 md:mb-sm lg:mb-[200px]">
            <div>
                <img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon" class="max-w-6">
            </div>
            <span class="label text-black">Shop by customer favourites</span>
        </div>

        {{-- Favourite Price Buttons --}}
        <div class="relative">
            <div class="flex flex-row flex-wrap sm:flex-col justify-center">

                {{-- Top Button --}}
                @if (isset($data[0]))
                    <div class="w-full flex justify-center items-end -mb-9 sm:-mb-[74px] md:-mb-[132px]">
                        <a href="{{ $data[0]['url'] }}"
                            class="sm:max-w-44 md:max-w-[250px] max-[460px]:z-10 relative inline-block sm:w-sm h-auto scale sm:rotate-354">
                            <img src="{{ asset($data[0]['image']) }}" alt="{{ $data[0]['title'] }}" class="max-h-48 sm:max-h-none w-auto">
                            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex flex-col items-center md:min-w-[150px]">
                                <span class="font-sans text-base md:text-lg font-semibold leading-tight tracking-1">under</span>
                                <span class="font-sans text-xl md:text-3xl font-bold leading-tight tracking-1">₹{{ $data[0]['price'] }}</span>
                                <span class="font-sans text-xs font-normal leading-tight tracking-1 text-center">
                                    {{ $data[0]['title'] }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endif

                {{-- Middle Buttons --}}
                <div class="w-full flex flex-wrap gap-0 md:gap-11">
                    @if (isset($data[1]))
                        <div class="flex-1 flex justify-end">
                            <a href="{{ $data[1]['url'] }}"
                                class="sm:max-w-[170px] md:max-w-72 relative inline-block sm:w-sm h-auto scale">
                                <img src="{{ asset($data[1]['image']) }}" alt="{{ $data[1]['title'] }}" class="object-contain max-h-48 sm:max-h-none w-auto">
                                <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex flex-col items-center">
                                    <span class="font-sans text-base md:text-lg font-semibold leading-tight tracking-1 text-white">under</span>
                                    <span class="font-sans text-xl md:text-3xl lg:text-5xl font-bold leading-tight tracking-1 text-white">₹{{ $data[1]['price'] }}</span>
                                    <span class="font-sans text-xs font-normal leading-tight tracking-1 text-white text-center">
                                        {{ $data[1]['title'] }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if (isset($data[2]))
                        <div class="flex-1 flex justify-start">
                            <a href="{{ $data[2]['url'] }}"
                                class="sm:max-w-46 md:max-w-84 relative inline-block sm:w-sm h-auto scale">
                                <img src="{{ asset($data[2]['image']) }}" alt="{{ $data[2]['title'] }}" class="max-h-48 sm:max-h-none w-auto">
                                <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex flex-col items-center">
                                    <span class="font-sans text-base md:text-lg lg:text-(length:--font-para) font-semibold leading-tight tracking-1">under</span>
                                    <span class="font-sans text-xl md:text-3xl lg:text-6xl font-bold leading-tight tracking-1">₹{{ $data[2]['price'] }}</span>
                                    <span class="font-sans text-xs md:text-base lg:text-base font-normal leading-tight tracking-1 text-center">
                                        {{ $data[2]['title'] }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Bottom Button (reuse first if exists) --}}
                @if (isset($data[3]))
                    <div class="w-full flex justify-center items-start -mt-12 sm:-mt-[104px] md:-mt-[162px]">
                        <a href="{{ $data[0]['url'] }}"
                            class="sm:max-w-44 md:max-w-[250px] col-span-2 relative inline-block sm:w-sm h-auto scale sm:-rotate-349">
                            <img src="{{ asset($data[3]['image']) }}" alt="{{ $data[3]['title'] }}" class="max-h-48 sm:max-h-none w-auto">
                            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex flex-col items-center">
                                <span class="font-sans text-base md:text-lg font-semibold leading-tight tracking-1">under</span>
                                <span class="font-sans text-xl md:text-3xl font-bold leading-tight tracking-1">₹{{ $data[3]['price'] }}</span>
                                <span class="font-sans text-xs font-normal leading-tight tracking-1 text-center md:min-w-[150px]">
                                    {{ $data[3]['title'] }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endif

            </div>
        </div>

        {{-- Decorative Images --}}
        <div class="hidden lg:block absolute top-0 right-0">
            <img src="{{ asset('storage/WebsiteImages/home/customerfav-icon2.png') }}"
                class="max-w-(--max-w-favouriteicon)" alt="">
                <div class="absolute -bottom-[125px] left-1/2 translate-x-1/2 rotate-314">
                    <img src="{{ asset('storage/WebsiteImages/home/star.png') }}" alt="star image" class="max-w-(--max-w-star)">
                </div>
        </div>

        <div class="hidden lg:block absolute bottom-0 left-0">
            <img src="{{ asset('storage/WebsiteImages/home/customerfav-icon1.png') }}"
                class="max-w-(--max-w-favouriteicon)" alt="">
                <div class="absolute -top-24 left-[13px] rotate-314">
                    <img src="{{ asset('storage/WebsiteImages/home/star.png') }}" alt="star image" class="max-w-(--max-w-star)">
                </div>
        </div>
    </div>

    {{-- Background Pattern --}}
    <div class="hidden lg:block absolute inset-x-0 top-[72%] -translate-y-1/2">
        <img src="{{ asset('storage/WebsiteImages/home/pattern2.png') }}" alt="">
    </div>
</div>
