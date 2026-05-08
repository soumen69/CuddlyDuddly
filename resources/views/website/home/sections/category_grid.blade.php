<div class="wrapper px-5 -mt-5 sm:mt-0 overflow-x-hidden relative z-2">
    <div class="container max-w-container mx-auto">

        {{-- Section title --}}
        <div class="title flex-box mt-0 sm:mt-14 md:mt-lg mb-sm hidden sm:flex">
            <div>
                <img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon" class="max-w-6">
            </div>
            <span class="label text-black">Shop by category</span>
        </div>

        <div class="relative grid gap-4">

            {{-- Decorative flower --}}
            <div class="hidden lg:block absolute -top-[130px] -right-[179px]">
                <img src="{{ asset('storage/WebsiteImages/home/flowerpatter.png') }}" alt="flower design" class="max-w-80">
            </div>

            {{-- First two large categories --}}
            <div class="grid grid-cols-2 gap-4">
                @foreach ($data as $index => $category)
                    @if ($index < 2)
                        <div class="relative rounded-block overflow-hidden">

                            <img src="{{ asset($category['image']) }}" alt="{{ $category['title'] }}"
                                class="h-38 md:h-40 lg:h-72 xl:h-80 transform transition-transform duration-300 hover:scale-110 cursor-pointer">

                            <div class="absolute top-3.5 md:top-6 left-2 right-2 md:left-3.5 label-wrapper">
                                <span class="label text-black">
                                    {{ $category['title'] }}
                                </span>
                            </div>

                            <div
                                class="absolute left-0 right-0 bottom-0 z-0 h-2/5
                                       flex justify-end items-end blur-div">
                            </div>

                            <a href="{{ $category['url'] }}" class="group collection-btn flex-box gap-0 lg:pl-6">
                                <span class="label leading-none text-black font-medium group-hover:text-white">
                                    View collection
                                </span>
                                <span>
                                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="max-w-4 md:max-w-5 xl:max-w-6 max-h-4 md:max-h-5 xl:max-h-(--max-h-arrow)
                                                object-contain group-hover:text-white">
                                        <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Remaining four categories --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($data as $index => $category)
                    @if ($index >= 2)
                        <div class="relative h-38 md:h-40 lg:h-56 xl:h-70 rounded-block overflow-hidden">

                            <img src="{{ asset($category['image']) }}" alt="{{ $category['title'] }}"
                                class="transform transition-transform duration-300 hover:scale-110 cursor-pointer">

                            <div class="absolute top-3 md:top-6 left-2 md:left-3.5 right-2 label-wrapper">
                                <span class="label text-black">
                                    {{ $category['title'] }}
                                </span>
                            </div>

                            <div
                                class="absolute left-0 right-0 bottom-0 z-0 h-2/5
                                       flex justify-end items-end blur-div">
                            </div>

                            <a href="{{ $category['url'] }}"
                                class="group w-10 h-10 md:w-[50px] md:h-[50px]
                                      xl:w-[70px] xl:h-[70px]
                                      absolute right-3.5 bottom-3.5 z-10
                                      flex-box inline-flex p-6
                                      bg-white/32 border border-black/22
                                      rounded-full backdrop-blur hover:bg-black">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="flex-shrink-0 max-w-5 xl:max-w-[unset]
                                            max-h-(--max-h-arrow)
                                            object-contain group-hover:text-white">
                                    <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
