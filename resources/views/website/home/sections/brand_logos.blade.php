<div class="wrapper px-5 mt-11 md:mt-lg">
    <div class="container max-w-container mx-auto">

        {{-- Section title --}}
        <div class="title flex-box mb-sm">
            <div>
                <img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon" class="max-w-6">
            </div>
            <span class="label text-black">
                Shop by customer favourite Brands
            </span>
        </div>

        {{-- Brand grid wrapper --}}
        <div class="w-full block border border-black/20 rounded-brand p-6 md:px-12 md:py-10 mb-0 md:mb-sm">
            <div class="w-full grid grid-cols-2 sm:grid-cols-3 gap-6 m-auto">

                @foreach ($data as $img)
                    <a href="#!" class="inline-block cursor-pointer">
                        <img src="{{ asset($img) }}" alt="Brand logo" class="max-h-10 md:max-h-12 max-w-full xl:max-w-(--max-w-xl) xl:max-h-20 object-contain">
                    </a>
                @endforeach

            </div>
        </div>

    </div>
</div>
