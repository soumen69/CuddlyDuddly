@extends('seller.layouts.seller')

@section('content')

    <div x-data="bulkExcelUpload()" class="min-h-screen flex-1 bg-slate-50">
        @include('seller.layouts.header')
        <div class="px-4 py-4 lg:px-6">
            {{-- HEADER --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-5 px-6 py-5 xl:flex-row xl:items-center xl:justify-between">
                    {{-- LEFT --}}
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('seller.bulk.dashboard', ['seller' => $seller->slug]) }}" class="h-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="24"
                                    height="24">
                                    <path
                                        d="M19,11H9l3.29-3.29a1,1,0,0,0,0-1.42,1,1,0,0,0-1.41,0l-4.29,4.3A2,2,0,0,0,6,12H6a2,2,0,0,0,.59,1.4l4.29,4.3a1,1,0,1,0,1.41-1.42L9,13H19a1,1,0,0,0,0-2Z" />
                                </svg>
                            </a>
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-indigo-700">
                                <span class="h-2 w-2 rounded-full bg-indigo-600"></span>
                                Catalog Intake
                            </div>
                            <div
                                class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-emerald-700">
                                Validation Active
                            </div>
                        </div>
                        <h1 class="mt-4 text-2xl font-black tracking-tight text-slate-900">
                            Product Catalog Upload
                        </h1>
                        <p class="mt-2 text-sm text-slate-500">
                            Upload completed catalog templates for ingestion processing.
                        </p>
                    </div>
                    {{-- RIGHT --}}
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('seller.bulk.template.builder', ['seller' => $seller->slug]) }}"
                            onclick="this.classList.add('pointer-events-none','opacity-70')"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Generate Template
                        </a>
                        <a href="{{ route('seller.bulk.batches.index', ['seller' => $seller->slug]) }}"
                            onclick="this.classList.add('pointer-events-none','opacity-70')"
                            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Batch History
                        </a>
                    </div>
                </div>
            </div>
            {{-- MAIN --}}
            <div class="mt-5">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    {{-- TOP BAR --}}
                    <div
                        class="flex flex-col gap-4 border-b border-slate-100 bg-slate-50 px-5 py-4 lg:flex-row lg:items-center lg:justify-between">
                        {{-- LEFT --}}
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-black text-slate-900">
                                    Intake Requirements
                                </div>
                                <div class="mt-1 text-xs text-slate-500">
                                    XLSX / XLS • Max 25MB • Generated templates only
                                </div>
                            </div>
                        </div>
                        {{-- RIGHT --}}
                        <div class="flex items-center gap-3">
                            <div class="rounded-xl border border-slate-200 bg-white px-3 py-2">
                                <div class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Accepted
                                </div>
                                <div class="mt-1 text-xs font-bold text-slate-900">
                                    XLSX / XLS
                                </div>
                            </div>
                            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2">
                                <div class="text-[10px] font-bold uppercase tracking-wide text-emerald-700">
                                    Validation
                                </div>
                                <div class="mt-1 text-xs font-bold text-emerald-900">
                                    Ready
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- BODY --}}
                    <div class="p-5">
                        <form method="POST"
                            @submit="
                                    if(submitting){
                                        $event.preventDefault();
                                        return;
                                    }
                                    submitting = true;"
                            action="{{ route('seller.bulk.upload.process', ['seller' => $seller->slug]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- COMPACT INTAKE ZONE --}}
                            <label for="excelInput"
                                class="group flex cursor-pointer items-center justify-between gap-5 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-5 transition-all duration-200 hover:border-indigo-400 hover:bg-indigo-50">
                                <input type="file" id="excelInput" name="excel" accept=".xlsx,.xls" class="hidden"
                                    @change="handleFileChange($event)" required>
                                {{-- LEFT --}}
                                <div class="flex items-center gap-4">
                                    {{-- ICON --}}
                                    <div
                                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-indigo-700 shadow-sm">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M8 7h8M8 12h8M8 17h5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M6 3h9l3 3v15H6z" />
                                        </svg>
                                    </div>
                                    {{-- CONTENT --}}
                                    <div>
                                        <div class="text-base font-black text-slate-900">
                                            Catalog Intake File
                                        </div>
                                        <div class="mt-1 text-sm text-slate-500">
                                            Drop completed template or browse locally
                                        </div>
                                    </div>
                                </div>
                                {{-- ACTION --}}
                                <div
                                    class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white transition group-hover:bg-indigo-600">
                                    Select File
                                </div>
                            </label>
                            {{-- STAGED FILE --}}
                            <div x-show="fileName" x-transition
                                class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-[10px] font-bold uppercase tracking-wide text-emerald-700">
                                                Staged File
                                            </div>
                                            <div class="mt-1 text-sm font-black text-slate-900" x-text="fileName">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" @click="resetFile()"
                                        class="inline-flex items-center justify-center rounded-xl border border-emerald-300 bg-white px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">
                                        Remove
                                    </button>
                                </div>
                            </div>
                            {{-- ERRORS --}}
                            @if ($errors->any())
                                <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 p-4">
                                    <div class="space-y-2">
                                        @foreach ($errors->all() as $error)
                                            <div
                                                class="rounded-xl border border-rose-200 bg-white px-4 py-3 text-sm font-medium text-rose-700">
                                                {{ $error }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- FOOTER --}}
                            <div
                                class="mt-5 flex flex-col gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <div class="text-sm font-black text-slate-900">
                                        Ready For Intake
                                    </div>
                                    <div class="mt-1 text-xs text-slate-500">
                                        Catalog will enter validation and ingestion workflow.
                                    </div>
                                </div>
                                <button type="submit" :disabled="!fileName || submitting"
                                    :class="submitting
                                        ?
                                        'bg-slate-700 text-white pointer-events-none opacity-90' :
                                        fileName ?
                                        'bg-slate-900 hover:bg-slate-800 text-white' :
                                        'bg-slate-200 text-slate-400 cursor-not-allowed'"
                                    class="inline-flex min-w-[220px] items-center justify-center rounded-xl px-5 py-3 text-sm font-bold transition-all duration-200">
                                    {{-- NORMAL --}}
                                    <template x-if="!submitting">
                                        <span class="inline-flex items-center gap-2">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v14m7-7H5" />
                                            </svg>
                                            Start Intake
                                        </span>
                                    </template>
                                    {{-- LOADING --}}
                                    <template x-if="submitting">
                                        <span class="inline-flex items-center gap-2">
                                            <span
                                                class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent">
                                            </span>
                                            Initializing Intake...
                                        </span>
                                    </template>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            window.bulkExcelUpload = function() {
                return {
                    fileName: '',
                    submitting: false,
                    handleFileChange(event) {
                        const file = event.target.files[0];
                        this.fileName = file ?
                            file.name :
                            '';
                    },
                    resetFile() {
                        this.fileName = '';
                        document.getElementById(
                            'excelInput'
                        ).value = '';
                    }
                }
            }
        </script>
    @endpush

@endsection
