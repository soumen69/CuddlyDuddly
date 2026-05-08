<div class="wrapper px-5 mt-8 md:mt-lg">
    <div class="container max-w-container mx-auto">

        <div class="title flex-box mb-sm">
            <div>
                <img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" class="max-w-6">
            </div>
            <span class="label text-black">{{ $data['title'] }}</span>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-y-(--margin-sm) gap-3 md:gap-5 addtocart">
            @foreach ($data['products'] as $product)
                @include('website.components.product-card', ['product' => $product])
            @endforeach
        </div>

    </div>
</div>
