@extends('seller.layouts.seller')

@section('title', 'Notification Details')

@section('content')
    <div class="flex-[unset] sm:flex-1">
        @include('seller.layouts.header')

        <div class="px-6 md:pl-14 md:pr-9 py-8">
            <div class="mb-6">
                <a href="{{ route('seller.dashboard', ['seller' => auth('seller')->user()->slug]) }}"
                    class="text-sm text-gray-600 hover:text-black">Back to dashboard</a>
                <h1 class="text-2xl font-semibold mt-2">Notification Details</h1>
                <p class="text-sm text-gray-500 mt-1">View the full message for this notification.</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden max-w-4xl">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-64 shrink-0">
                            @php
                                $productImage = null;
                                if ($product && $product->primaryImage && $product->primaryImage->image_path) {
                                    $productImage = asset('storage/' . ltrim($product->primaryImage->image_path, '/'));
                                } elseif ($product && $product->images->first() && $product->images->first()->image_path) {
                                    $productImage = asset('storage/' . ltrim($product->images->first()->image_path, '/'));
                                }
                                $productUrl = ($product && $product->id)
                                    ? route('seller.products.edit', [auth('seller')->user()->slug, $product->id])
                                    : null;
                            @endphp

                            @if ($productImage)
                                <img src="{{ $productImage }}" alt="Notification image"
                                    class="w-full h-56 object-cover rounded-xl border border-gray-200">
                            @else
                                <div
                                    class="w-full h-56 rounded-xl border border-dashed border-gray-300 bg-gray-50 flex items-center justify-center text-gray-400">
                                    No image available
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    {{ ucfirst($notification->type ?? 'update') }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ optional($notification->created_at)->format('M d, Y h:i A') }}
                                </span>
                            </div>

                            <h2 class="text-xl font-semibold text-gray-900 mb-3">
                                {{ $notification->title }}
                            </h2>

                            <p class="text-gray-700 leading-7 mb-6">
                                {{ $notification->details ?: $notification->message }}
                            </p>

                            <div class="rounded-xl bg-gray-50 border border-gray-200 p-4">
                                <div class="text-sm text-gray-500 mb-1">Message</div>
                                <div class="text-gray-800">{{ $notification->message }}</div>
                            </div>

                            @if ($product)
                                <div class="mt-5 rounded-xl border border-gray-200 p-4">
                                    <div class="text-sm text-gray-500 mb-1">Linked product</div>
                                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-600 mt-1">Product ID: {{ optional($product)->id }}</div>
                                    @if ($productUrl)
                                        <a href="{{ $productUrl }}"
                                            class="inline-flex items-center mt-4 px-4 py-2 rounded-lg bg-black text-white text-sm font-medium hover:bg-gray-800">
                                            View product
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
