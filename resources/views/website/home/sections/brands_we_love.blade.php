<div class="wrapper px-5">
    <div class="container max-w-container mx-auto">

        <div class="title flex-box mb-sm">
            <div>
                <img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon" class="max-w-6">
            </div>
            <span class="label text-black">Brands we love</span>
        </div>

        <div class="w-full grid grid-cols-2 gap-3 md:gap-5 m-auto">

            @foreach ($data as $brand)
                <a href="{{ $brand['url'] ?? '#!' }}"
                    class="inline-block border border-black/30 rounded-brandsm
                          overflow-hidden sm:max-h-60 md:max-h-72 lg:max-h-96 xl:max-h-[470px]">
                    <img src="{{ asset($brand['image']) }}" alt=""
                        class="transform transition-transform duration-300
                                hover:scale-110 cursor-pointer object-bottom">
                </a>
            @endforeach

        </div>

    </div>
</div>
