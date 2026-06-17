@extends('seller.layouts.seller')

@section('content')

    <div class="min-h-screen flex-1 bg-slate-50">
        @include('seller.layouts.header')
        <div class="px-4 py-5 lg:px-6">
            {{-- HEADER --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-5 px-6 py-5 xl:flex-row xl:items-center xl:justify-between">
                    {{-- LEFT --}}
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('seller.products.index', ['seller' => $seller->slug]) }}" class="h-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="24"
                                    height="24">
                                    <path
                                        d="M19,11H9l3.29-3.29a1,1,0,0,0,0-1.42,1,1,0,0,0-1.41,0l-4.29,4.3A2,2,0,0,0,6,12H6a2,2,0,0,0,.59,1.4l4.29,4.3a1,1,0,1,0,1.41-1.42L9,13H19a1,1,0,0,0,0-2Z" />
                                </svg>
                            </a>
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-indigo-700">
                                <span class="h-2 w-2 rounded-full bg-indigo-600"></span>
                                Media Review
                            </div>
                            <div
                                class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-slate-600">
                                Batch #{{ $batchId }}
                            </div>
                        </div>
                        <h1 class="mt-4 text-2xl font-black tracking-tight text-slate-900">
                            Review Product Images
                        </h1>
                        <p class="mt-2 text-sm text-slate-500">
                            Review uploaded images before applying them to the catalog.
                        </p>
                    </div>
                    {{-- RIGHT --}}
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('seller.bulk.images.gateway', ['seller' => $seller->slug, 'batchId' => $batchId]) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Back
                        </a>

                        <form method="POST"
                            action="{{ route('seller.bulk.images.commit', ['seller' => $seller->slug, 'batchId' => $batchId]) }}">
                            @csrf
                            <button
                                onclick="this.disabled=true; this.classList.add('opacity-70','pointer-events-none'); this.form.submit();"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                                Apply Images
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- OVERVIEW --}}
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                {{-- TOTAL --}}
                <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                    <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400">
                        Total Images
                    </div>
                    <div class="mt-2 text-2xl font-black text-slate-900">
                        {{ $stats['total_images'] }}
                    </div>
                </div>
                {{-- COVER --}}
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 shadow-sm">
                    <div class="text-[11px] font-bold uppercase tracking-wide text-emerald-700">
                        Cover Images
                    </div>
                    <div class="mt-2 text-2xl font-black text-emerald-900">
                        {{ $stats['cover_images'] }}
                    </div>
                </div>

                {{-- VARIANT --}}
                <div class="rounded-2xl border border-indigo-200 bg-indigo-50 px-5 py-4 shadow-sm">
                    <div class="text-[11px] font-bold uppercase tracking-wide text-indigo-700">
                        Variant Images
                    </div>
                    <div class="mt-2 text-2xl font-black text-indigo-900">
                        {{ $stats['variant_images'] }}
                    </div>
                </div>
                {{-- PRODUCTS --}}
                <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 shadow-sm">
                    <div class="text-[11px] font-bold uppercase tracking-wide text-amber-700">
                        Products
                    </div>
                    <div class="mt-2 text-2xl font-black text-amber-900">
                        {{ $stats['products'] }}
                    </div>
                </div>
            </div>

            {{-- PRODUCTS --}}
            <div class="mt-6 space-y-4">

                @forelse ($images as $productCode => $product)
                    <div x-data="{ open: false }"
                        class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        {{-- PRODUCT HEADER --}}
                        <div @click="open = !open"
                            class="flex cursor-pointer items-center justify-between gap-4 px-5 py-4 transition hover:bg-slate-50">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="truncate text-base font-black text-slate-900">
                                        {{ $productCode }}
                                    </h3>
                                    <span
                                        class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-600">
                                        {{ $product['groups']->sum(fn($g) => $g['images']->count()) }}
                                        Images
                                    </span>
                                    @if ($product['is_variant_product'])
                                        <span
                                            class="rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-bold text-indigo-700">
                                            {{ $product['variant_count'] }}
                                            Variants
                                        </span>
                                    @endif
                                </div>
                                @php
                                    $previewImages = collect($product['groups'])->pluck('images')->flatten()->take(5);

                                    $totalImages = collect($product['groups'])->sum(
                                        fn($group) => $group['images']->count(),
                                    );
                                @endphp

                                <div class="mt-3 flex items-center -space-x-2">
                                    @foreach ($previewImages as $preview)
                                        <img src="{{ asset('storage/' . $preview->image_path) }}"
                                            class="h-10 w-10 rounded-full border-2 border-white object-cover shadow-sm">
                                    @endforeach

                                    @if ($totalImages > 5)
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-white bg-slate-200 text-[10px] font-bold text-slate-700 shadow-sm">
                                            +{{ $totalImages - 5 }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-700 transition"
                                :class="open ? 'rotate-180' : ''">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <div x-show="open" x-collapse x-cloak class="border-t border-slate-100 bg-slate-50/50 p-4">
                            <div class="space-y-4">
                                @foreach ($product['groups'] as $variantKey => $group)
                                    @php
                                        $variantImages = $group['images'];
                                    @endphp
                                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                                        {{-- VARIANT HEADER --}}
                                        <div
                                            class="flex items-center justify-between border-b border-slate-100 bg-slate-50 px-4 py-3">
                                            <div>
                                                <h4 class="text-sm font-black text-slate-900">
                                                    {{ $group['label'] }}
                                                </h4>
                                                <div class="mt-1 text-xs text-slate-500">
                                                    {{ $variantImages->count() }} Images
                                                </div>
                                            </div>
                                        </div>

                                        {{-- IMAGES --}}
                                        <div class="p-4">
                                            <div
                                                class="grid grid-cols-2 gap-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8">
                                                @foreach ($variantImages as $image)
                                                    <div
                                                        class="group overflow-hidden rounded-lg border border-slate-200 bg-white transition hover:border-slate-300 hover:shadow-sm">
                                                        {{-- IMAGE --}}
                                                        <div class="relative">
                                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                class="aspect-square w-full object-cover">
                                                        </div>

                                                        {{-- FOOTER --}}
                                                        <div class="px-2 py-2">
                                                            <div class="text-center text-[10px] font-black text-slate-600">
                                                                #{{ $loop->iteration }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty

                    {{-- EMPTY --}}
                    <div
                        class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center shadow-sm">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100">
                            <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 16l4-4a2 2 0 012.828 0" />
                            </svg>
                        </div>
                        <h2 class="mt-5 text-xl font-black text-slate-900">
                            No Images Uploaded
                        </h2>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            Upload product images before review.
                        </p>
                        <a href="{{ route('seller.bulk.images.gateway', ['seller' => $seller->slug, 'batchId' => $batchId]) }}"
                            class="mt-5 inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                            Return Back
                        </a>
                    </div>
                @endforelse
            </div>
            @if ($images->hasPages())
                <div class="mt-6">
                    {{ $images->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
