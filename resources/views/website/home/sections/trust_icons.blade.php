<div class="hidden sm:block relative px-5">
<div class="container max-w-container mx-auto">
    <div class="w-full grid gap-x-1 lg:gap-x-4 gap-y-4 sm:grid-cols-3">

        @foreach ($data as $item)
            <div class="flex-box bg-pink-transparent/13 py-5 md:py-8 px-2 lg:p-9 xl:p-12 rounded-card">
                <img src="{{ asset($item['icon']) }}" class="max-w-icon object-contain" alt="">
                <span class="font-sans text-sm md:text-base font-normal not-italic leading-tight tracking-1 text-black">{{ $item['text'] }}</span>
            </div>
        @endforeach

    </div>
</div>
</div>