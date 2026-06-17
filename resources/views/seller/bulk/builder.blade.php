@extends('seller.layouts.seller')

@section('content')
    <div x-data="bulkWizard()" class="flex-1 min-w-0 bg-slate-50 min-h-screen">

        @include('seller.layouts.header')

        <div class="px-4 py-5 lg:px-6">
            {{-- TOP HEADER --}}
            <div
                class="rounded-3xl border border-slate-200 bg-gradient-to-r from-indigo-50 via-white to-cyan-50 px-6 py-5 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex gap-5">
                        <a href="{{ route('seller.products.index', ['seller' => $seller->slug]) }}" class="h-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="24"
                                height="24">
                                <path
                                    d="M19,11H9l3.29-3.29a1,1,0,0,0,0-1.42,1,1,0,0,0-1.41,0l-4.29,4.3A2,2,0,0,0,6,12H6a2,2,0,0,0,.59,1.4l4.29,4.3a1,1,0,1,0,1.41-1.42L9,13H19a1,1,0,0,0,0-2Z" />
                            </svg>
                        </a>
                        <div class="min-w-0">
                            <div
                                class="mb-2 inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-white px-3 py-1 text-[11px]
                                        font-bold uppercase tracking-wide text-indigo-700">
                                Enterprise Bulk Ingestion
                            </div>
                            <h1 class="text-2xl font-black tracking-tight text-slate-900 block mt-0">
                                Bulk Product Upload
                            </h1>
                            <p class="mt-1 text-sm text-slate-500">
                                Generate smart catalog templates for bulk product ingestion.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('seller.bulk.dashboard', ['seller' => $seller->slug]) }}"
                        class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm
                                        font-semibold text-slate-700 shadow-sm transition hover:border-indigo-300 hover:text-indigo-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        Bulk Dashboard
                    </a>
                </div>
            </div>

            {{-- MAIN GRID --}}
            <div class="mt-5 grid grid-cols-1 gap-5 xl:grid-cols-12">
                {{-- LEFT --}}
                <div class="space-y-5 xl:col-span-9">
                    {{-- STEP 1 --}}
                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 p-5">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7l9-4 9 4-9 4-9-4zm0 0v10l9 4 9-4V7" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-slate-900">
                                        Select Categories
                                    </div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        Choose the catalog groups you want to upload.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($categories as $category)
                                    <label class="block">
                                        <input type="checkbox" value="{{ $category->id }}" class="peer hidden"
                                            x-model="state.categories" @change="loadSubcategories">
                                        <div
                                            class="group relative cursor-pointer overflow-hidden rounded-lg border-2 border-slate-200
                                                                                bg-white px-3.5 py-2 transition-all duration-200 hover:-translate-y-0.5 hover:border-indigo-300
                                                                                hover:shadow-lg peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white
                                                                                peer-checked:shadow-xl
                                                                            ">
                                            <div
                                                class="absolute right-3 top-3 hidden h-6 w-6 items-center justify-center rounded-full bg-white/20 peer-checked:flex">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <div class="text-sm font-semibold">
                                                {{ $category->name }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- STEP 2 --}}
                    <div x-show="subcategories.length" x-transition.opacity.duration.300ms
                        class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 p-5">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">

                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1"
                                        viewBox="0 0 24 24" width="24" height="24" class="fill-[#bb4d00] max-w-12">
                                        <path class="stroke-[transparent]"
                                            d="M23.621,6.836l-1.352-2.826c-.349-.73-.99-1.296-1.758-1.552L14.214,.359c-1.428-.476-3-.476-4.428,0L3.49,2.458c-.769,.256-1.41,.823-1.759,1.554L.445,6.719c-.477,.792-.567,1.742-.247,2.609,.309,.84,.964,1.49,1.802,1.796l-.005,6.314c-.002,2.158,1.372,4.066,3.418,4.748l4.365,1.455c.714,.238,1.464,.357,2.214,.357s1.5-.119,2.214-.357l4.369-1.457c2.043-.681,3.417-2.585,3.419-4.739l.005-6.32c.846-.297,1.508-.946,1.819-1.79,.317-.858,.228-1.799-.198-2.499ZM10.419,2.257c1.02-.34,2.143-.34,3.162,0l4.248,1.416-5.822,1.95-5.834-1.95,4.246-1.415ZM2.204,7.666l1.327-2.782c.048,.025,7.057,2.373,7.057,2.373l-1.621,3.258c-.239,.398-.735,.582-1.173,.434l-5.081-1.693c-.297-.099-.53-.325-.639-.619-.109-.294-.078-.616,.129-.97Zm3.841,12.623c-1.228-.409-2.052-1.554-2.051-2.848l.005-5.648,3.162,1.054c1.344,.448,2.792-.087,3.559-1.371l.278-.557-.005,10.981c-.197-.04-.391-.091-.581-.155l-4.366-1.455Zm11.897-.001l-4.37,1.457c-.19,.063-.384,.115-.581,.155l.005-10.995,.319,.64c.556,.928,1.532,1.459,2.561,1.459,.319,0,.643-.051,.96-.157l3.161-1.053-.005,5.651c0,1.292-.826,2.435-2.052,2.844Zm4-11.644c-.105,.285-.331,.504-.619,.6l-5.118,1.706c-.438,.147-.934-.035-1.136-.365l-1.655-3.323s7.006-2.351,7.054-2.377l1.393,2.901c.157,.261,.186,.574,.081,.859Z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-slate-900">
                                        Product Types
                                    </div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        Narrow down the exact product classifications.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-wrap gap-2">
                                <template x-for="subcategory in subcategories" :key="subcategory.id">
                                    <label class="block">
                                        <input type="checkbox" :value="subcategory.id" class="peer hidden"
                                            x-model="state.subcategories">
                                        <div
                                            class="
                                                                cursor-pointer
                                                                rounded-lg
                                                                border-2
                                                                border-slate-200
                                                                bg-white
                                                                px-3.5 py-2
                                                                text-sm
                                                                font-semibold
                                                                text-slate-700
                                                                transition-all
                                                                duration-200
                                                                hover:-translate-y-0.5
                                                                hover:border-[#bb4d00]
                                                                hover:shadow-lg
                                                                peer-checked:border-transparent
                                                                peer-checked:bg-[#fef2c5]
                                                                peer-checked:text-black
                                                                peer-checked:shadow-xl
                                                            ">
                                            <div class="flex items-center justify-between">
                                                <span x-text="subcategory.name"></span>
                                                <svg class="hidden h-5 w-5 peer-checked:block" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 3 --}}
                    <div x-show="state.subcategories.length" x-transition.opacity.duration.300ms
                        class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 p-5">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5V4H2v16h5m10 0v-6H7v6m10 0H7" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-slate-900">
                                        Brand Configuration
                                    </div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        Configure whether the upload belongs to one or multiple brands.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-5 p-5">
                            <div class="grid gap-4 md:grid-cols-2">
                                {{-- SINGLE --}}
                                <label class="block">
                                    <input type="radio" value="single" class="peer hidden" x-model="state.brand_mode">
                                    <div
                                        class="
                                                            cursor-pointer
                                                            rounded-xl
                                                            border-2
                                                            border-slate-200
                                                            p-3.5
                                                            transition-all
                                                            duration-200
                                                            hover:border-emerald-300
                                                            hover:shadow-lg
                                                            peer-checked:border-transparent
                                                            peer-checked:bg-[#d1fae5]
                                                        ">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <div class="text-base font-bold">
                                                    Single Brand
                                                </div>
                                                <div class="mt-1 text-sm">
                                                    All products belong to one brand.
                                                </div>
                                            </div>
                                            <svg class="hidden h-5 w-5 peer-checked:block" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </label>

                                {{-- MULTI --}}
                                <label class="block">
                                    <input type="radio" value="multiple" class="peer hidden"
                                        x-model="state.brand_mode">
                                    <div
                                        class="
                                                            cursor-pointer
                                                            rounded-xl
                                                            border-2
                                                            border-slate-200
                                                            p-3.5
                                                            transition-all
                                                            duration-200
                                                            hover:border-emerald-300
                                                            hover:shadow-lg
                                                            peer-checked:border-transparent
                                                            peer-checked:bg-[#d1fae5]
                                                        ">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <div class="text-base font-bold">
                                                    Multiple Brands
                                                </div>
                                                <div class="mt-1 text-sm">
                                                    Products belong to multiple brands.
                                                </div>
                                            </div>
                                            <svg class="hidden h-5 w-5 peer-checked:block" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            {{-- BRAND SELECT --}}
                            <div x-show="state.brand_mode === 'single'" x-transition.opacity.duration.300ms>
                                <select x-model="state.brand_id"
                                    class="
                                                        w-full
                                                        rounded-lg
                                                        border-2
                                                        border-slate-200
                                                        bg-slate-50
                                                        px-4
                                                        py-4
                                                        text-sm
                                                        font-medium
                                                        text-slate-700
                                                        outline-none
                                                        transition
                                                        focus:border-emerald-500
                                                        focus:bg-white
                                                    ">
                                    <option value="">
                                        Select Brand
                                    </option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 4 --}}
                    <div x-show="state.brand_mode" x-transition.opacity.duration.300ms
                        class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 p-5">
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-black/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1"
                                        viewBox="0 0 24 24" width="24" height="24" class="max-w-5">
                                        <path
                                            d="m21,2h-3V0h-2v2h-8V0h-2v2h-3c-1.654,0-3,1.346-3,3v19h24V5c0-1.654-1.346-3-3-3ZM3,4h18c.552,0,1,.449,1,1v3H2v-3c0-.551.448-1,1-1Zm-1,18v-12h20v12H2Zm11.405-9.42l3.094,3.094-1.414,1.414-2.085-2.085v4.997h-2v-5.008l-2.075,2.086-1.414-1.414,3.083-3.083c.775-.775,2.036-.772,2.812,0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-slate-900">
                                        Upload Volume
                                    </div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        Estimate the approximate upload size.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-wrap gap-2">
                                <template x-for="option in volumeOptions" :key="option.value">
                                    <label class="block">
                                        <input type="radio" :value="option.value" class="peer hidden"
                                            x-model="state.volume">
                                        <div
                                            class="
                                                                cursor-pointer
                                                                rounded-lg
                                                                border-2
                                                                border-slate-200
                                                                bg-white
                                                                px-3.5 py-2
                                                                transition-all
                                                                duration-200
                                                                hover:border-black
                                                                hover:shadow-lg
                                                                peer-checked:border-transparent
                                                                peer-checked:bg-black
                                                                peer-checked:text-white
                                                            ">
                                            <div class="flex items-center justify-between">
                                                <div class="font-bold" x-text="option.label"></div>
                                                <svg class="hidden h-5 w-5 peer-checked:block" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDEBAR --}}
                <div class="xl:col-span-3">
                    <div class="sticky top-5 space-y-5">
                        {{-- SUMMARY --}}
                        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                            <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-5 text-white">
                                <div class="text-lg font-bold">
                                    Upload Summary
                                </div>
                                <div class="mt-1 text-sm text-slate-300">
                                    Live ingestion configuration
                                </div>
                            </div>
                            <div class="space-y-5 p-5">
                                {{-- CATEGORY --}}
                                <div>
                                    <div class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400">
                                        Categories
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="category in selectedCategoryNames" :key="category">
                                            <div
                                                class="rounded-xl bg-indigo-100 px-3 py-2 text-xs font-semibold text-indigo-700">
                                                <span x-text="category"></span>
                                            </div>
                                        </template>
                                        <template x-if="!selectedCategoryNames.length">
                                            <div class="text-sm text-slate-400">
                                                Not selected
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                {{-- SUBCATEGORIES --}}
                                <div>

                                    <div class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400">

                                        Product Types

                                    </div>

                                    <div class="flex flex-wrap gap-2">

                                        <template x-for="subcategory in selectedSubcategoryNames" :key="subcategory">

                                            <div
                                                class="rounded-xl bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700">

                                                <span x-text="subcategory"></span>

                                            </div>

                                        </template>

                                        <template x-if="!selectedSubcategoryNames.length">

                                            <div class="text-sm text-slate-400">
                                                Not selected
                                            </div>

                                        </template>

                                    </div>

                                </div>

                                {{-- BRAND --}}
                                <div>

                                    <div class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400">

                                        Brand Mode

                                    </div>

                                    <div
                                        class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">

                                        <template x-if="state.brand_mode">
                                            <span
                                                x-text="state.brand_mode === 'single'
                                                                    ? 'Single Brand'
                                                                    : 'Multiple Brands'"></span>
                                        </template>

                                        <template x-if="!state.brand_mode">
                                            <span>
                                                Not configured
                                            </span>
                                        </template>

                                    </div>

                                </div>

                                {{-- VOLUME --}}
                                <div>

                                    <div class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400">

                                        Upload Volume

                                    </div>

                                    <div class="rounded-2xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">

                                        <template x-if="state.volume">

                                            <span
                                                x-text="
                                                                    volumeOptions.find(
                                                                        v => v.value == state.volume
                                                                    )?.label
                                                                ">
                                            </span>

                                        </template>

                                        <template x-if="!state.volume">
                                            <span>
                                                Not selected
                                            </span>
                                        </template>

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- CTA --}}
                        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="space-y-4">
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">

                                    <div class="flex items-center justify-between text-sm">

                                        <span class="font-semibold text-slate-600">
                                            Completion
                                        </span>
                                        <span class="font-black text-slate-900" x-text="progress + '%'"></span>

                                    </div>

                                    <div class="mt-3 h-3 overflow-hidden rounded-full bg-slate-200">

                                        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-emerald-500 transition-all duration-300"
                                            :style="'width:' + progress + '%'">
                                        </div>

                                    </div>
                                    <template
                                        x-if="
                        state.categories.length &&
                        !isReady
                    ">

                                        <div
                                            class="
                            mt-3
                            rounded-2xl
                            border
                            border-amber-200
                            bg-amber-50
                            px-4
                            py-3
                            text-sm
                            font-medium
                            text-amber-700
                        ">

                                            <div class="flex items-start gap-2">

                                                <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0
                                                                                2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46
                                                                                0L3.34 16c-.77 1.33.19 3 1.73 3z" />

                                                </svg>

                                                <div>

                                                    Some selected categories still need
                                                    at least one product type.

                                                </div>

                                            </div>

                                        </div>

                                    </template>

                                </div>

                                <button type="button" @click="generateTemplate" :disabled="!isReady || isGenerating"
                                    class="
                                                        inline-flex
                                                        w-full
                                                        items-center
                                                        justify-center
                                                        gap-2
                                                        rounded-2xl
                                                        bg-gradient-to-r
                                                        from-indigo-600
                                                        to-indigo-700
                                                        px-6
                                                        py-4
                                                        text-sm
                                                        font-bold
                                                        text-white
                                                        shadow-lg
                                                        transition-all
                                                        duration-200
                                                        hover:-translate-y-0.5
                                                        hover:shadow-xl
                                                        disabled:cursor-not-allowed
                                                        disabled:from-slate-300
                                                        disabled:to-slate-300
                                                        disabled:text-slate-500
                                                        cursor-pointer
                                                    ">

                                    <template x-if="!isGenerating">

                                        <div class="flex items-center gap-2">

                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />

                                            </svg>

                                            <template x-if="isReady">

                                                <span>
                                                    Generate Excel Template
                                                </span>

                                            </template>

                                            <template x-if="!isReady">

                                                <span>
                                                    Complete Required Steps
                                                </span>

                                            </template>

                                        </div>

                                    </template>

                                    <template x-if="isGenerating">

                                        <div class="flex items-center gap-3">

                                            <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4">
                                                </circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z">
                                                </path>
                                            </svg>
                                            <span>
                                                Generating Template...
                                            </span>
                                        </div>
                                    </template>
                                </button>
                            </div>
                            {{--
                            </form> --}}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        function bulkWizard() {

            return {

                subcategories: [],

                get selectedCategoryNames() {

                    return this.categoriesData
                        .filter(category =>
                            this.state.categories.includes(
                                String(category.id)
                            ) || this.state.categories.includes(category.id)
                        )
                        .map(category => category.name);
                },

                volumeOptions: [{
                        value: '100',
                        label: 'Under 100 Products'
                    },
                    {
                        value: '500',
                        label: '100 - 500 Products'
                    },
                    {
                        value: '2000',
                        label: '500 - 2000 Products'
                    },
                    {
                        value: '5000',
                        label: '2000+ Products'
                    }
                ],

                isGenerating: false,

                async generateTemplate() {

                    if (!this.isReady || this.isGenerating) {

                        return;
                    }

                    this.isGenerating = true;

                    try {

                        const response = await fetch(
                            '{{ route('seller.bulk.template.generate', ['seller' => $seller->slug]) }}', {

                                method: 'POST',

                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },

                                body: JSON.stringify({

                                    categories: this.state.categories,

                                    subcategories: this.state.subcategories,

                                    brand_mode: this.state.brand_mode,

                                    brand_id: this.state.brand_id,

                                    volume: this.state.volume,
                                })
                            }
                        );

                        if (!response.ok) {
                            let errorMessage = 'Failed to generate template.';
                            try {
                                const error = await response.json();
                                errorMessage = error.message || errorMessage;
                            } catch (e) {}
                            alert(errorMessage);
                            return;
                        }

                        const blob = await response.blob();
                        const url = window.URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'bulk_catalog_template.xlsx';
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                        window.URL.revokeObjectURL(url);
                    } catch (error) {
                        console.error(error);
                        alert('Something went wrong.');
                    } finally {
                        this.isGenerating = false;
                    }
                },

                state: {
                    categories: [],
                    subcategories: [],
                    brand_mode: '',
                    brand_id: '',
                    volume: '',
                },

                async loadSubcategories() {
                    if (!this.state.categories.length) {
                        this.subcategories = [];
                        this.state.subcategories = [];
                        this.state.brand_mode = '';
                        this.state.brand_id = '';
                        this.state.volume = '';
                        return;
                    }

                    const response = await fetch(
                        '{{ route('seller.bulk.subcategories', ['seller' => $seller->slug]) }}', {

                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },

                            body: JSON.stringify({
                                categories: this.state.categories
                            })
                        }
                    );
                    const incoming = await response.json();
                    this.subcategories = incoming;
                    const validIds = incoming.map(sub =>
                        String(sub.id)
                    );

                    this.state.subcategories = this.state.subcategories.filter(id =>
                        validIds.includes(String(id))
                    );

                    if (!this.state.subcategories.length) {
                        this.state.brand_mode = '';
                        this.state.brand_id = '';
                        this.state.volume = '';
                    }
                },

                hasSelectedSubcategory(categoryId) {
                    return this.subcategories.some(sub => {
                        return (
                            Number(sub.product_categories_id) === Number(categoryId) &&
                            this.state.subcategories.some(
                                id => Number(id) === Number(sub.id)
                            )
                        );
                    });
                },

                get isReady() {
                    if (
                        !this.state.categories.length ||
                        !this.state.subcategories.length ||
                        !this.state.brand_mode ||
                        !this.state.volume
                    ) {
                        return false;
                    }

                    return this.state.categories.every(categoryId => {

                        return this.hasSelectedSubcategory(categoryId);

                    });
                },

                get progress() {
                    let total = 4;
                    let completed = 0;
                    if (this.state.categories.length) {
                        completed++;
                    }
                    const hasValidSubs = this.state.categories.length &&
                        this.state.categories.every(categoryId => {
                            return this.hasSelectedSubcategory(categoryId);
                        });
                    if (hasValidSubs) {
                        completed++;
                    }
                    if (this.state.brand_mode) {
                        completed++;
                    }
                    if (this.state.volume) {
                        completed++;
                    }
                    return Math.round((completed / total) * 100);
                },

                categoriesData: @json(
                    $categories->map(fn($c) => [
                            'id' => $c->id,
                            'name' => $c->name,
                        ])),

                get selectedSubcategoryNames() {

                    return this.subcategories
                        .filter(sub =>
                            this.state.subcategories.includes(
                                String(sub.id)
                            ) || this.state.subcategories.includes(sub.id)
                        )
                        .map(sub => sub.name);
                }
            }
        }
    </script>
@endsection
