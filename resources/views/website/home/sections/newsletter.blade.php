<div class="wrapper px-5 mt-4 md:mt-lg">
    <div class="container max-w-container mx-auto">
        <div class="relative h-52 sm:h-60 md:h-72 lg:h-96 xl:h-[472px] border border-black/30 rounded-block overflow-hidden p-3.5 sm:p-4 md:p-5 lg:p-6 bg-cover bg-no-repeat"
            style="background-image: url('{{ asset($data['background']) }}')">

            <div
                class="relative z-10 max-w-(--max-w-block) mx-auto w-full h-full
                       flex flex-col justify-center items-center
                       rounded-block overflow-hidden backdrop-blur-lg">

                <h3
                    class="relative z-10 max-w-(--max-w-label) md:max-w-[unset]
                           mb-2.5 lg:mb-3.5 font-sans font-semibold text-lg md:text-xl lg:text-2xl xl:text-4xl
                           text-center leading-tight tracking-1 text-black">
                    {{ $data['title'] }}
                </h3>

                <p
                    class="relative z-10 mb-3 lg:mb-3.5 font-sans font-normal
                           text-base md:text-xl lg:text-(length:--font-para)
                           text-center leading-tight tracking-1 text-black">
                    {{ $data['subtitle'] }}
                </p>

                {{-- CLICKABLE BUTTON --}}
                <a href="{{ $data['cta_url'] }}" class="relative z-20 btn-primary">
                    {{ $data['cta_text'] }}
                </a>

                {{-- GLASS OVERLAY (NON-CLICKABLE) --}}
                <div class="absolute inset-0 rounded-[15px] bg-white/53 pointer-events-none">
                    <img src="{{ asset('storage/WebsiteImages/home/border.png') }}" alt="border"
                        class="w-full h-full object-fill">
                </div>

            </div>
        </div>
    </div>
</div>
