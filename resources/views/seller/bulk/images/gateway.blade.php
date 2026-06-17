@extends('seller.layouts.seller')

@section('content')
    @push('styles')
        <style>
            @keyframes tooltipFlash {

                0%,
                100% {
                    opacity: 0;
                    transform: translateY(4px);
                }

                15%,
                85% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .auto-tooltip {
                animation: tooltipFlash 4s ease-in-out 1;
            }
        </style>
    @endpush


    <div class="min-h-screen flex-1 bg-slate-50" x-data="{
        zipGuide: false,
        manualGuide: false,
    
        zipUploading: false,
        skipSubmitting: false,
    
        showZipHint: false,
        showManualHint: false,
        init() {
            setTimeout(() => {
                this.showZipHint = true;
            }, 1200);
    
            setTimeout(() => {
                this.showManualHint = true;
            }, 1800);
    
            setTimeout(() => {
                this.showZipHint = false;
                this.showManualHint = false;
            }, 5200);
        }
    }">

        @include('seller.layouts.header')

        <div class="px-4 py-4 lg:px-6">
            {{-- HEADER --}}
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-r from-indigo-50 via-white to-cyan-50 shadow-sm">
                <div class="flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
                    {{-- LEFT --}}
                    <div class="max-w-3xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('seller.bulk.batches.index', ['seller' => $seller->slug]) }}" class="h-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="24"
                                    height="24">
                                    <path
                                        d="M19,11H9l3.29-3.29a1,1,0,0,0,0-1.42,1,1,0,0,0-1.41,0l-4.29,4.3A2,2,0,0,0,6,12H6a2,2,0,0,0,.59,1.4l4.29,4.3a1,1,0,1,0,1.41-1.42L9,13H19a1,1,0,0,0,0-2Z" />
                                </svg>
                            </a>
                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-indigo-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span>
                                Product Media Upload
                            </div>
                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-600">
                                Batch #{{ $batch->id }}
                            </div>
                        </div>
                        <h1 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                            Upload Product Images
                        </h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                            Upload product and variant images using ZIP workflow or manual assignment.
                        </p>
                    </div>
                    {{-- STATUS --}}
                    <div class="flex flex-wrap gap-3">
                        <div class="rounded-xl border border-emerald-200 bg-white px-3 py-2 shadow-sm">
                            <div class="text-[10px] font-bold uppercase tracking-wide text-emerald-700">
                                Products
                            </div>
                            <div class="mt-1 text-sm font-black text-slate-900">
                                Committed
                            </div>
                        </div>
                        <div class="rounded-xl border border-indigo-200 bg-white px-3 py-2 shadow-sm">
                            <div class="text-[10px] font-bold uppercase tracking-wide text-indigo-700">
                                Current Stage
                            </div>
                            <div class="mt-1 text-sm font-black text-slate-900">
                                Image Upload
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white px-3 py-2 shadow-sm">
                            <div class="text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                Batch Status
                            </div>
                            <div class="mt-1 text-sm font-black text-slate-900">
                                {{ ucfirst(str_replace('_', ' ', $batch->status)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- CARDS --}}
            {{-- WORKFLOW SELECTION --}}
            <div class="mt-5 grid gap-4 lg:grid-cols-3">

                {{-- ZIP WORKFLOW --}}
                <div
                    class="group flex h-full flex-col rounded-3xl border border-indigo-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                    <div class="flex items-start justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M8 12l4 4m0 0l4-4m-4 4V4" />
                            </svg>
                        </div>

                        <div class="relative">
                            <button @click="zipGuide = true" :disabled="zipGuide"
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 disabled:pointer-events-none disabled:opacity-60">
                                i
                            </button>

                            <div x-show="showZipHint" x-transition
                                class="auto-tooltip pointer-events-none absolute top-14 right-0 z-20" style="display:none;">
                                <div class="relative">
                                    <div
                                        class="absolute -top-1 right-4 h-3 w-3 rotate-45 border-l border-t border-slate-800 bg-slate-900">
                                    </div>
                                    <div
                                        class="rounded-xl border border-slate-800 bg-slate-900 px-3 py-2 text-[11px] font-semibold text-white shadow-2xl whitespace-nowrap">
                                        Read ZIP Guide First
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div
                            class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-indigo-700">
                            Recommended
                        </div>

                        <h2 class="mt-3 text-xl font-black text-slate-900">
                            ZIP Upload Workflow
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Best for large catalog uploads with product variants and organized folders.
                        </p>
                    </div>

                    <div class="mt-auto pt-6">
                        <a href="{{ route('seller.bulk.images.zip.template', ['seller' => $seller->slug, 'batchId' => $batch->id]) }}"
                            onclick="this.classList.add('pointer-events-none','opacity-70')"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-indigo-700">
                            Download ZIP Template
                        </a>
                    </div>
                </div>

                {{-- MANUAL --}}
                <div
                    class="group flex h-full flex-col rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                    <div class="flex items-start justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>

                        <div class="relative">
                            <button @click="manualGuide = true" :disabled="manualGuide"
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 disabled:pointer-events-none disabled:opacity-60">
                                i
                            </button>
                            <div x-show="showManualHint" x-transition
                                class="auto-tooltip pointer-events-none absolute top-14 right-0 z-20" style="display:none;">
                                <div class="relative">
                                    <div
                                        class="absolute -top-1 right-4 h-3 w-3 rotate-45 border-l border-t border-slate-800 bg-slate-900">
                                    </div>
                                    <div
                                        class="rounded-xl border border-slate-800 bg-slate-900 px-3 py-2 text-[11px] font-semibold text-white shadow-2xl whitespace-nowrap">
                                        View Manual Upload Guide
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div
                            class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-blue-700">
                            Manual Workflow
                        </div>

                        <h2 class="mt-3 text-xl font-black text-slate-900">
                            Upload Manually
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Recommended for smaller uploads, quick changes and individual product updates.
                        </p>
                    </div>

                    <div class="mt-auto pt-6">
                        <a href="{{ route('seller.bulk.images.manual', ['seller' => $seller->slug, 'batchId' => $batch->id]) }}"
                            onclick="this.classList.add('pointer-events-none','opacity-70')"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                            Open Manual Upload
                        </a>
                    </div>
                </div>

                {{-- SKIP --}}
                <div
                    class="group flex h-full flex-col rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3" />
                        </svg>
                    </div>

                    <div class="mt-5">
                        <div
                            class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-700">
                            Continue Later
                        </div>

                        <h2 class="mt-3 text-xl font-black text-slate-900">
                            Skip For Now
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            You can resume image uploads anytime later from batch history.
                        </p>
                    </div>

                    <div class="mt-auto pt-6">
                        <form method="POST"
                            action="{{ route('seller.bulk.images.skip', ['seller' => $seller->slug, 'batchId' => $batch->id]) }}"
                            @submit="skipSubmitting = true">
                            @csrf

                            <button type="submit" :disabled="skipSubmitting"
                                :class="skipSubmitting ? 'opacity-70 cursor-not-allowed' : ''"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-amber-300 bg-white px-4 py-3 text-sm font-bold text-amber-700 transition hover:bg-amber-50">

                                <span x-show="!skipSubmitting">
                                    Continue Later
                                </span>

                                <span x-show="skipSubmitting">
                                    Redirecting...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ZIP UPLOAD SECTION --}}
            <div class="mt-5 overflow-hidden rounded-3xl border border-indigo-200 bg-white shadow-sm">

                {{-- HEADER --}}
                <div
                    class="flex flex-col gap-4 border-b border-indigo-100 bg-gradient-to-r from-indigo-50 to-white px-5 py-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <div
                            class="inline-flex items-center rounded-full bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-indigo-700 shadow-sm">
                            ZIP Processing
                        </div>

                        <h2 class="mt-2 text-xl font-black text-slate-900">
                            Upload Prepared ZIP
                        </h2>

                        <p class="mt-1 text-sm text-slate-600">
                            Upload final compressed product image ZIP.
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-indigo-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 shadow-sm">
                        Supported Format:
                        <span class="font-black text-slate-900">
                            .zip
                        </span>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="p-5">
                    <form method="POST"
                        action="{{ route('seller.bulk.images.zip.upload', ['seller' => $seller->slug, 'batchId' => $batch->id]) }}"
                        enctype="multipart/form-data" @submit="if(zipUploading) return false; zipUploading = true">

                        @csrf

                        <div
                            class="flex flex-col gap-3 rounded-2xl border border-dashed border-indigo-300 bg-indigo-50 p-4 lg:flex-row lg:items-center lg:justify-between">

                            {{-- LEFT --}}
                            <div class="flex items-center gap-4">

                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-indigo-700 shadow-sm">

                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <!-- File Outline with Zip Detail -->
                                        <path
                                            d="M14 2H6C4.89 2 4 2.89 4 4V20C4 21.11 4.89 22 6 22H18C19.11 22 20 21.11 20 20V8L14 2Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M14 2V8H20" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <!-- Zipper/Zip Text Representation -->
                                        <path d="M12 12V15" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                        <path d="M10 13H14" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                        <!-- Upload Arrow -->
                                        <path d="M12 18V21M12 18L10 20M12 18L14 20" stroke="red" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                </div>

                                <div>
                                    <div class="text-sm font-black text-slate-900">
                                        Select ZIP File
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        Single compressed ZIP only
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT --}}
                            <div x-data="{
                                selectedZip: null,
                                zipName: '',
                                zipSize: ''
                            }" class="flex flex-col gap-3 lg:items-end">

                                {{-- FILE PREVIEW --}}
                                <div x-show="selectedZip" x-transition
                                    class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3">

                                    {{-- ICON --}}
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm">

                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h10M7 12h10M7 17h6" />
                                        </svg>
                                    </div>

                                    {{-- META --}}
                                    <div>

                                        <div class="max-w-[220px] truncate text-sm font-black text-slate-900"
                                            x-text="zipName">
                                        </div>

                                        <div class="mt-1 text-xs font-medium text-emerald-700" x-text="zipSize">
                                        </div>
                                    </div>

                                    {{-- REMOVE --}}
                                    <button type="button"
                                        @click="
                selectedZip = null;
                zipName = '';
                zipSize = '';
                $refs.zipInput.value = null;
            "
                                        class="ml-2 flex h-7 w-7 items-center justify-center rounded-full bg-white text-xs font-black text-slate-700 shadow-sm transition hover:bg-rose-100">

                                        ✕
                                    </button>
                                </div>

                                {{-- ACTIONS --}}
                                <div class="flex flex-col gap-3 sm:flex-row">

                                    {{-- BROWSE --}}
                                    <label
                                        class="inline-flex cursor-pointer items-center justify-center rounded-2xl border border-indigo-300 bg-white px-5 py-3 text-sm font-bold text-indigo-700 transition hover:bg-indigo-50">

                                        <input x-ref="zipInput" type="file" name="zip" accept=".zip"
                                            class="hidden" required
                                            @change="
                    if($event.target.files.length){

                        selectedZip = $event.target.files[0];

                        zipName = selectedZip.name;

                        zipSize = (
                            selectedZip.size / 1024 / 1024
                        ).toFixed(2) + ' MB';
                    }
                ">

                                        Select ZIP
                                    </label>

                                    {{-- SUBMIT --}}
                                    <button type="submit" :disabled="zipUploading || !selectedZip"
                                        :class="zipUploading ?
                                            'opacity-70 cursor-not-allowed pointer-events-none' :
                                            ''"
                                        class="inline-flex min-w-[170px] items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white transition hover:bg-indigo-700 disabled:bg-indigo-300">
                                        <span x-show="!zipUploading" class="inline-flex items-center gap-2">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v14m7-7H5" />
                                            </svg>
                                            Process ZIP
                                        </span>
                                        <span x-show="zipUploading" class="inline-flex items-center gap-2">
                                            <span
                                                class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent">
                                            </span>
                                            Processing...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ZIP GUIDE MODAL --}}
        <div x-show="zipGuide" x-transition.opacity
            class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-950/60 p-4" style="display:none;">
            <div class="w-full max-w-4xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl">
                {{-- HEADER --}}
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <div class="text-[11px] font-bold uppercase tracking-wide text-indigo-700">
                            ZIP Upload Guide
                        </div>
                        <h2 class="mt-1 text-xl font-black text-slate-900">
                            How ZIP Image Upload Works
                        </h2>
                    </div>

                    <button @click="zipGuide = false"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50">
                        ✕
                    </button>
                </div>

                <div class="grid gap-4 p-5 xl:grid-cols-2">
                    {{-- LEFT --}}
                    <div>
                        <div class="space-y-3">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="text-sm font-black text-slate-900">
                                    1. Download ZIP Template
                                </div>
                                <div class="mt-1 text-xs leading-6 text-slate-500">
                                    Download prepared product folders and unzip them.
                                </div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="text-sm font-black text-slate-900">
                                    2. Add Product Images
                                </div>
                                <div class="mt-1 text-xs leading-6 text-slate-500">
                                    Place images inside folders using product or color folders.
                                </div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="text-sm font-black text-slate-900">
                                    3. Compress & Upload
                                </div>
                                <div class="mt-1 text-xs leading-6 text-slate-500">
                                    ZIP the folders again and upload the final ZIP file.
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4">
                            <div class="text-sm font-black text-amber-900">
                                Main Product Image
                            </div>
                            <div class="mt-1 text-xs leading-6 text-amber-700">
                                Rename one image as
                                <span class="font-black">1.webp</span>,
                                <span class="font-black">1.jpg</span>
                                or
                                <span class="font-black">1.png</span>.
                                This image becomes the main product thumbnail and banner image.
                            </div>
                        </div>
                    </div>
                    {{-- RIGHT --}}
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div
                                class="inline-flex items-center rounded-full bg-white px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-700">
                                Simple Product
                            </div>
                            <div class="mt-3 overflow-hidden rounded-xl bg-slate-950 p-3 text-xs text-slate-200">
                                <pre class="leading-6">
                                AAA2/
                                ├── 1.webp
                                ├── 2.webp
                                └── 3.webp
                                </pre>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-4">
                            <div
                                class="inline-flex items-center rounded-full bg-white px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-indigo-700">
                                Variant Product
                            </div>
                            <div class="mt-3 overflow-hidden rounded-xl bg-slate-950 p-3 text-xs text-slate-200">
                                <pre class="leading-6">
                                    AAA1/
                                    ├── RED/
                                    ├── BLUE/
                                    └── WHITE/
                                    </pre>
                            </div>
                            <div class="mt-3 text-xs leading-6 text-slate-500">
                                Variant folders automatically map images to colors.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MANUAL GUIDE MODAL --}}
        <div x-show="manualGuide" x-transition.opacity
            class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-950/60 p-4" style="display:none;">
            <div class="w-full max-w-2xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl">
                {{-- HEADER --}}
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <div class="text-[11px] font-bold uppercase tracking-wide text-blue-700">
                            Manual Upload Guide
                        </div>
                        <h2 class="mt-1 text-xl font-black text-slate-900">
                            How Manual Upload Works
                        </h2>
                    </div>
                    <button @click="manualGuide = false"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50">
                        ✕
                    </button>
                </div>

                {{-- BODY --}}
                <div class="p-5">
                    <div class="space-y-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-sm font-black text-slate-900">
                                1. Select Product
                            </div>
                            <div class="mt-1 text-xs leading-6 text-slate-500">
                                Choose product or variant from dropdown.
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-sm font-black text-slate-900">
                                2. Upload Images
                            </div>

                            <div class="mt-1 text-xs leading-6 text-slate-500">
                                Drag & drop product images into upload area.
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-sm font-black text-slate-900">
                                3. Save & Continue
                            </div>
                            <div class="mt-1 text-xs leading-6 text-slate-500">
                                Save uploaded images and continue for other products.
                            </div>
                        </div>
                    </div>
                    {{-- NOTE --}}
                    <div class="mt-4 rounded-2xl border border-blue-200 bg-blue-50 p-4">
                        <div class="text-sm font-black text-blue-900">
                            Best Use Case
                        </div>
                        <div class="mt-1 text-xs leading-6 text-blue-700">
                            Recommended for smaller uploads or quick image corrections.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
