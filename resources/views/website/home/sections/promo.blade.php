<div class="wrapper px-5 mt-4 md:mt-lg">
    <div class="container max-w-container mx-auto">
        <div class="relative w-full block border border-black/30 rounded-block p-5 mb-0 md:mb-sm overflow-hidden">

            <img src="{{ asset('storage/WebsiteImages/home/backgroundpattern3.png') }}"
                class="absolute inset-0 w-full h-full object-cover z-0" alt="">

            <div class="relative z-10 w-full grid grid-cols-1 md:grid-cols-2 gap-6 m-auto">

                <div class="relative hidden sm:block sm:h-48 md:h-auto">
                    <div class="absolute -bottom-[55px] -right-[90px]">
                        <img src="{{ asset('storage/WebsiteImages/home/flower.png') }}" alt="">
                    </div>
                    <img src="{{ asset($data['image']) }}" alt="">
                </div>

                <div class="flex flex-col justify-center items-center">
                    <h3 class="mb-2.5 lg:mb-3.5 font-sans font-semibold text-lg md:text-xl lg:text-2xl xl:text-4xl text-center">
                        {{ $data['title'] }}
                    </h3>
                    <p class="mb-3.5 font-sans text-base md:text-xl text-center">
                        {{ $data['subtitle'] }}
                    </p>
                    <a href="{{ $data['cta_url'] }}" class="btn-primary">
                        {{ $data['cta_text'] }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
