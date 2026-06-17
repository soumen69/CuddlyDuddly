@extends('seller.layouts.seller')

@section('content')
    <div x-data="manualUploader()" class="min-h-screen flex-1 bg-slate-50">

        @include('seller.layouts.header')

        <div class="px-4 py-4 lg:px-6">

            {{-- HEADER --}}
            <div
                class="overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-r from-indigo-50 via-white to-cyan-50 shadow-sm">

                <div class="flex flex-col gap-5 p-5 lg:flex-row lg:items-center lg:justify-between">

                    {{-- LEFT --}}
                    <div>

                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('seller.bulk.images.gateway', ['seller' => $seller->slug, 'batchId' => $batchId]) }}" class="h-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="24"
                                    height="24">
                                    <path
                                        d="M19,11H9l3.29-3.29a1,1,0,0,0,0-1.42,1,1,0,0,0-1.41,0l-4.29,4.3A2,2,0,0,0,6,12H6a2,2,0,0,0,.59,1.4l4.29,4.3a1,1,0,1,0,1.41-1.42L9,13H19a1,1,0,0,0,0-2Z" />
                                </svg>
                            </a>

                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-white px-3 py-1 text-[11px] font-black uppercase tracking-wide text-indigo-700">

                                <span class="h-2 w-2 rounded-full bg-indigo-600"></span>

                                Catalog Media Intake
                            </div>

                            <div
                                class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1 text-[11px] font-black uppercase tracking-wide text-slate-600">

                                Batch #{{ $batchId }}
                            </div>
                        </div>

                        <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900">
                            Product Media Intake
                        </h1>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Manually ingest catalog media for products and visual variants.
                        </p>
                    </div>

                    {{-- RIGHT --}}
                    {{-- <div>

                        <a href="{{ route('seller.bulk.images.gateway', ['seller' => $seller->slug, 'batchId' => $batchId]) }}"
                            onclick="this.classList.add('pointer-events-none','opacity-70')"
                            class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 transition hover:text-slate-900">
                            ← Gateway
                        </a>
                    </div> --}}
                </div>
            </div>

            {{-- MAIN --}}
            <div class="mt-5">

                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                    {{-- TOP TOOLBAR --}}
                    <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-5 py-4">

                        <div class="flex flex-col gap-4 2xl:flex-row 2xl:items-center 2xl:justify-between">

                            {{-- LEFT --}}
                            <div class="flex flex-1 flex-col gap-4 xl:flex-row xl:items-center">

                                {{-- PRODUCT --}}
                                <div class="w-full max-w-xl">

                                    <label class="mb-2 block text-[11px] font-black uppercase tracking-wide text-slate-500">

                                        Intake Target
                                    </label>

                                    <select x-model="selectedIndex" @change="selectProduct" :disabled="uploading"
                                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-0 disabled:opacity-60">

                                        <option value="">
                                            Select Product / Variant
                                        </option>

                                        @foreach ($products as $product)
                                            <option
                                                value="{{ $product['product_id'] }}_{{ $product['attribute_value_id'] ?? '0' }}">

                                                {{ $product['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- GUIDE --}}
                                <div
                                    class="flex items-center gap-3 rounded-2xl border border-indigo-200 bg-indigo-50 px-4 py-3 xl:min-w-[320px]">

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-indigo-700 shadow-sm">

                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01" />
                                        </svg>
                                    </div>

                                    <div>

                                        <div class="text-xs font-black text-indigo-900">
                                            Intake Workflow
                                        </div>

                                        <div class="mt-1 text-[11px] leading-5 text-indigo-700">
                                            Select target → Add media → Set cover → Process
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT --}}
                            <div class="flex items-center gap-3">

                                {{-- COUNT --}}
                                <div class="min-w-[110px] rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">

                                    <div class="text-[10px] font-black uppercase tracking-wide text-slate-500">

                                        Media
                                    </div>

                                    <div class="mt-1 text-lg font-black text-slate-900" x-text="files.length">
                                    </div>
                                </div>

                                {{-- RULE --}}
                                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3">

                                    <div class="text-[10px] font-black uppercase tracking-wide text-emerald-700">

                                        Rules
                                    </div>

                                    <div class="mt-1 text-xs font-bold text-emerald-900 whitespace-nowrap">
                                        Min 4 • WEBP
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BODY --}}
                    <div class="p-5">

                        {{-- MEDIA WORKSPACE --}}
                        <div @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false"
                            @drop.prevent="dropFiles($event)"
                            :class="dragging
                                ?
                                'border-indigo-500 bg-indigo-50 ring-4 ring-indigo-500/10' :
                                'border-slate-300 bg-gradient-to-br from-slate-50 to-white'"
                            class="overflow-hidden rounded-3xl border-2 border-dashed transition-all duration-200">

                            <input x-ref="fileInput" type="file" multiple hidden accept=".jpg,.jpeg,.png,.webp"
                                @change="pickFiles">

                            {{-- EMPTY --}}
                            <template x-if="!files.length">

                                <div @click="
                                        if(uploading) return;

                                        if(!selectedProductId){

                                            showStatus(
                                                'Select a product first.',
                                                'danger'
                                            );

                                            return;
                                        }

                                        $refs.fileInput.click();
                                    "
                                    class="flex cursor-pointer flex-col items-center justify-center px-6 py-10 text-center">

                                    {{-- ICON --}}
                                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-white shadow-sm">

                                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M7 16V4m0 0L3 8m4-4l4 4" />

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M17 8v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </div>

                                    {{-- TITLE --}}
                                    <div class="mt-4 text-lg font-black text-slate-900">
                                        Media Intake Zone
                                    </div>

                                    {{-- SUB --}}
                                    <div class="mt-2 text-sm text-slate-500">
                                        Drag & drop catalog media or click to browse
                                    </div>

                                    {{-- META --}}
                                    <div
                                        class="mt-4 inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-600 shadow-sm">

                                        JPG • PNG • WEBP • Max 5MB
                                    </div>
                                </div>
                            </template>

                            {{-- PREVIEW --}}
                            <template x-if="files.length">

                                <div class="p-5">

                                    {{-- TOP --}}
                                    <div class="mb-5 flex items-center justify-between">

                                        <div>

                                            <div class="text-lg font-black text-slate-900">
                                                Media Staging
                                            </div>

                                            <div class="mt-1 text-sm text-slate-500">
                                                Click media to set cover image
                                            </div>
                                        </div>

                                        <button @click="$refs.fileInput.click()" :disabled="uploading"
                                            class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-100 disabled:opacity-50">

                                            Add Media
                                        </button>
                                    </div>

                                    {{-- GRID --}}
                                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 xl:grid-cols-6">

                                        <template x-for="(file,index) in files" :key="index">

                                            <div @click="primaryIndex = index"
                                                :class="primaryIndex === index ?
                                                    'border-indigo-500 ring-2 ring-indigo-500/10' :
                                                    'border-slate-200 hover:border-slate-400'"
                                                class="group relative overflow-hidden rounded-2xl border bg-white transition-all duration-200">

                                                {{-- REMOVE --}}
                                                <button type="button" @click.stop="remove(index)" :disabled="uploading"
                                                    class="absolute right-2 top-2 z-10 flex h-7 w-7 items-center justify-center rounded-full bg-white/90 text-xs font-black text-slate-700 shadow-sm transition hover:bg-rose-100 disabled:pointer-events-none">

                                                    ✕
                                                </button>

                                                {{-- IMAGE --}}
                                                <img :src="file.preview" class="aspect-square w-full object-cover">

                                                {{-- COVER --}}
                                                <div x-show="primaryIndex === index"
                                                    class="absolute bottom-2 left-2 rounded-full bg-indigo-600 px-2 py-1 text-[10px] font-black uppercase tracking-wide text-white">

                                                    Cover
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="border-t border-slate-100 bg-slate-50 px-5 py-4">

                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                            {{-- STATUS --}}
                            <div class="min-h-[24px]">

                                <div x-show="statusMessage" x-transition
                                    :class="statusType === 'success'
                                        ?
                                        'text-emerald-700' :
                                        'text-rose-700'"
                                    class="text-sm font-bold">

                                    <span x-text="statusMessage"></span>
                                </div>
                            </div>

                            {{-- ACTIONS --}}
                            <div class="flex flex-wrap gap-3">

                                {{-- CLEAR --}}
                                <button @click="clearAll" :disabled="uploading || !files.length"
                                    class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50">

                                    Clear
                                </button>

                                {{-- UPLOAD --}}
                                <button @click="if(uploading) return; upload()"
                                    :disabled="uploading || !selectedProductId || !files.length"
                                    :class="uploading ? 'pointer-events-none opacity-80' : ''"
                                    class="inline-flex min-w-[190px] items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-black text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:bg-slate-300">

                                    <template x-if="!uploading">

                                        <span class="inline-flex items-center gap-2">

                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v14m7-7H5" />
                                            </svg>

                                            Process Upload
                                        </span>
                                    </template>

                                    <template x-if="uploading">

                                        <span class="inline-flex items-center gap-2">

                                            <span
                                                class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent">
                                            </span>

                                            Processing Media...
                                        </span>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function manualUploader() {

                return {

                    dragging: false,
                    files: [],
                    primaryIndex: 0,

                    selectedIndex: '',
                    selectedProductId: null,
                    selectedAttrId: null,

                    uploading: false,

                    statusMessage: '',
                    statusType: 'success',

                    products: @json($products),

                    selectProduct() {

                        if (!this.selectedIndex) {

                            this.selectedProductId = null;
                            this.selectedAttrId = null;

                            return;
                        }

                        const selected = this.products.find(p => {

                            return `${p.product_id}_${p.attribute_value_id ?? 0}` === this.selectedIndex;
                        });

                        if (!selected) {
                            return;
                        }

                        this.selectedProductId = selected.product_id;
                        this.selectedAttrId = selected.attribute_value_id;

                        this.clearAll();
                    },

                    pickFiles(event) {

                        this.appendFiles(
                            Array.from(event.target.files)
                        );
                    },

                    dropFiles(event) {

                        this.dragging = false;

                        if (!this.selectedProductId) {

                            this.showStatus(
                                'Select a product first.',
                                'danger'
                            );

                            return;
                        }

                        this.appendFiles(
                            Array.from(
                                event.dataTransfer.files
                            )
                        );
                    },

                    appendFiles(newFiles) {

                        newFiles.forEach(file => {

                            if (
                                ![
                                    'image/jpeg',
                                    'image/png',
                                    'image/webp'
                                ].includes(file.type)
                            ) {
                                return;
                            }

                            file.preview =
                                URL.createObjectURL(file);

                            this.files.push(file);
                        });
                    },

                    remove(index) {

                        this.files.splice(index, 1);

                        if (
                            this.primaryIndex >=
                            this.files.length
                        ) {
                            this.primaryIndex = 0;
                        }
                    },

                    clearAll() {

                        this.files = [];
                        this.primaryIndex = 0;

                        this.$refs.fileInput.value = null;
                    },

                    async upload() {

                        if (this.uploading) {
                            return;
                        }

                        if (!this.selectedProductId) {

                            this.showStatus(
                                'Select a product first.',
                                'danger'
                            );

                            return;
                        }

                        if (this.files.length < 4) {

                            this.showStatus(
                                'Minimum 4 images required.',
                                'danger'
                            );

                            return;
                        }

                        this.uploading = true;

                        let formData = new FormData();

                        formData.append(
                            'product_id',
                            this.selectedProductId
                        );

                        if (this.selectedAttrId) {

                            formData.append(
                                'attribute_value_id',
                                this.selectedAttrId
                            );
                        }

                        this.files.forEach(file => {

                            formData.append(
                                'images[]',
                                file
                            );
                        });

                        try {

                            const response =
                                await fetch(
                                    '{{ route('seller.bulk.images.ajax.upload', ['seller' => $seller->slug]) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    }
                                );

                            const data =
                                await response.json();

                            if (!response.ok) {

                                throw new Error(
                                    data.message ||
                                    'Upload failed.'
                                );
                            }

                            this.showStatus(
                                data.message ||
                                'Media processed successfully.',
                                'success'
                            );

                            setTimeout(() => {

                                window.location.reload();

                            }, 900);

                        } catch (e) {

                            this.showStatus(
                                e.message,
                                'danger'
                            );

                        } finally {

                            this.uploading = false;
                        }
                    },

                    showStatus(message, type) {

                        this.statusMessage = message;
                        this.statusType = type;
                    }
                }
            }
        </script>
    </div>
@endsection
