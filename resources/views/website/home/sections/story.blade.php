<div class="hidden sm:block relative w-full px-5 overflow-hidden bg-white">
    <div class="container max-w-container mx-auto">

        <div class="relative w-full mb-10 rounded-block overflow-hidden">

            <div
                class="absolute left-6 top-5 min-w-(--min-w-4xs)
                       p-2.5 md:px-2.5 md:py-4 flex-box rounded-label
                       bg-pink-transparent/30 border-t-[0.5px]
                       border-b-[0.5px] border-[#ffc0cb3b]">
                <div>
                    <img src="{{ asset('storage/WebsiteImages/home/labelicon.png') }}" class="max-w-6" alt="">
                </div>
                <span class="label">Our story</span>
            </div>

            <div class="invisible sm:visible absolute -top-14 -right-[88px] max-w-48 lg:max-w-md overflow-hidden z-10">
                <img src="{{ asset('storage/WebsiteImages/home/flower-pattern.png') }}" alt="">
            </div>

            <img src="{{ asset($data['image']) }}" class="md:min-h-auto max-h-52 md:max-h-[300px] lg:max-h-(--max-h-story)"
                alt="Our Story">

            <p class="absolute z-10 inset-x-6 bottom-6 max-w-(--max-w-text) text-info">
                {!! $data['text'] !!}
            </p>

            <div class="absolute w-full h-full inset-0 bg-linear-to-b from-transparent to-black/70"></div>
        </div>

    </div>
</div>
