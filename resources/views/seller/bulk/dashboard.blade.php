@extends('seller.layouts.seller')

@section('content')
    <div class="min-h-screen bg-slate-50">
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

                                Catalog Console
                            </div>

                            <div
                                class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-emerald-700">

                                System Active
                            </div>
                        </div>

                        <h1 class="mt-4 text-2xl font-black tracking-tight text-slate-900">
                            Bulk Catalog Dashboard
                        </h1>

                        <p class="mt-2 text-sm text-slate-500">
                            Manage templates, uploads, image intake and catalog processing.
                        </p>
                    </div>

                    {{-- RIGHT --}}
                    <div class="flex flex-wrap gap-3">

                        <a href="{{ route('seller.bulk.template.builder', ['seller' => $seller->slug]) }}"
                            onclick="this.classList.add('pointer-events-none','opacity-70')"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                            Generate Template
                        </a>

                        <a href="{{ route('seller.bulk.upload.index', ['seller' => $seller->slug]) }}"
                            onclick="this.classList.add('pointer-events-none','opacity-70')"
                            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">

                            Upload Catalog
                        </a>
                    </div>
                </div>
            </div>

            {{-- OVERVIEW --}}
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- TOTAL --}}
                <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400">

                                Total Batches
                            </div>

                            <div class="mt-2 text-2xl font-black text-slate-900">

                                {{ $stats['total_batches'] }}
                            </div>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-700">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- PENDING --}}
                <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="text-[11px] font-bold uppercase tracking-wide text-amber-700">

                                Pending Images
                            </div>

                            <div class="mt-2 text-2xl font-black text-amber-900">

                                {{ $stats['pending_images'] }}
                            </div>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/80 text-amber-700">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- COMPLETED --}}
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="text-[11px] font-bold uppercase tracking-wide text-emerald-700">

                                Completed
                            </div>

                            <div class="mt-2 text-2xl font-black text-emerald-900">

                                {{ $stats['completed_batches'] }}
                            </div>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/80 text-emerald-700">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- HEALTH --}}
                <div
                    class="rounded-2xl border px-5 py-4 shadow-sm

        {{ $health === 'healthy'
            ? 'border-emerald-200 bg-emerald-50'
            : ($health === 'warning'
                ? 'border-amber-200 bg-amber-50'
                : 'border-rose-200 bg-rose-50') }}">

                    <div class="flex items-center justify-between">

                        <div>

                            <div
                                class="text-[11px] font-bold uppercase tracking-wide

                    {{ $health === 'healthy' ? 'text-emerald-700' : ($health === 'warning' ? 'text-amber-700' : 'text-rose-700') }}">

                                System Health
                            </div>

                            <div
                                class="mt-2 text-xl font-black

                    {{ $health === 'healthy' ? 'text-emerald-900' : ($health === 'warning' ? 'text-amber-900' : 'text-rose-900') }}">

                                {{ $health === 'healthy' ? 'Healthy' : ($health === 'warning' ? 'Delayed' : 'Attention Needed') }}
                            </div>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl

                {{ $health === 'healthy'
                    ? 'bg-white/80 text-emerald-700'
                    : ($health === 'warning'
                        ? 'bg-white/80 text-amber-700'
                        : 'bg-white/80 text-rose-700') }}">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WORKFLOW --}}
            <div class="mt-6">

                <div class="mb-4">

                    <div class="text-xs font-bold uppercase tracking-wide text-slate-400">
                        Workflow
                    </div>

                    <h2 class="mt-1 text-xl font-black text-slate-900">
                        Catalog Operations
                    </h2>
                </div>

                <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">

                    {{-- CARD --}}
                    <a href="{{ route('seller.bulk.template.builder', ['seller' => $seller->slug]) }}"
                        onclick="this.classList.add('pointer-events-none','opacity-70')"
                        class="group overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:border-indigo-300 hover:shadow-md">

                        <div class="flex items-start justify-between">

                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700">

                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>

                            <div
                                class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-500">

                                Step 01
                            </div>
                        </div>

                        <div class="mt-5">

                            <div class="text-lg font-black text-slate-900">
                                Generate Template
                            </div>

                            <div class="mt-2 text-sm leading-6 text-slate-500">
                                Build catalog sheets for bulk upload.
                            </div>
                        </div>
                    </a>

                    {{-- CARD --}}
                    <a href="{{ route('seller.bulk.upload.index', ['seller' => $seller->slug]) }}"
                        onclick="this.classList.add('pointer-events-none','opacity-70')"
                        class="group overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:border-blue-300 hover:shadow-md">

                        <div class="flex items-start justify-between">

                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">

                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903" />
                                </svg>
                            </div>

                            <div
                                class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-500">

                                Step 02
                            </div>
                        </div>

                        <div class="mt-5">

                            <div class="text-lg font-black text-slate-900">
                                Upload Catalog
                            </div>

                            <div class="mt-2 text-sm leading-6 text-slate-500">
                                Validate and create upload batches.
                            </div>
                        </div>
                    </a>

                    {{-- CARD --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-start justify-between">

                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">

                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6" />
                                </svg>
                            </div>

                            <div
                                class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-500">

                                Step 03
                            </div>
                        </div>

                        <div class="mt-5">

                            <div class="text-lg font-black text-slate-900">
                                Review Issues
                            </div>

                            <div class="mt-2 text-sm leading-6 text-slate-500">
                                Fix validation errors before processing.
                            </div>
                        </div>
                    </div>

                    {{-- CARD --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-start justify-between">

                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">

                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <div
                                class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-500">

                                Step 04
                            </div>
                        </div>

                        <div class="mt-5">

                            <div class="text-lg font-black text-slate-900">
                                Upload Images
                            </div>

                            <div class="mt-2 text-sm leading-6 text-slate-500">
                                Process ZIP and manual media uploads.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RECENT BATCHES --}}
            <div class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div
                    class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-400">
                            Recent Activity </div>

                        <h2 class="mt-1 text-2xl font-black text-slate-900">
                            Recent Upload Batches </h2>
                    </div>
                    <a href="{{ route('seller.bulk.batches.index', ['seller' => $seller->slug]) }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-indigo-300 hover:text-indigo-700">
                        View All Batches
                    </a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($recentBatches as $batch)
                        @php
                            $statusColors = [
                                'image_completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'image_upload_pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'image_upload_in_progress' => 'bg-blue-100 text-blue-700 border-blue-200',
                            ];
                            $badgeClass =
                                $statusColors[$batch->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                        @endphp
                        <div
                            class="flex flex-col gap-5 px-6 py-5 transition hover:bg-slate-50 lg:flex-row lg:items-center lg:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-3">
                                    <div class="text-base font-black text-slate-900">
                                        Batch #{{ $batch->id }}
                                    </div>
                                    <div class="rounded-full border px-3 py-1 text-xs font-bold {{ $badgeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $batch->status)) }}
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-5 text-sm text-slate-500">
                                    <div>
                                        Created:
                                        <span class="font-semibold text-slate-700">
                                            {{ \Carbon\Carbon::parse($batch->created_at)->format('d M Y h:i A') }}
                                        </span>
                                    </div>
                                    <div>
                                        Pipeline:
                                        <span class="font-semibold text-slate-700">
                                            Enterprise
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ route('seller.bulk.batch.review', ['seller' => $seller->slug, 'batchId' => $batch->id]) }}"
                                    class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                    View Batch
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-20 text-center">
                            <div
                                class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-slate-100 text-slate-400">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 17v-2m3 2v-4m3 4v-6" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-2xl font-black text-slate-900">
                                No Ingestion Batches Yet
                            </h3>
                            <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-500">
                                Generate your first bulk catalog template and begin
                                the enterprise ingestion workflow.
                            </p>
                            <div class="mt-8">
                                <a href="{{ route('seller.bulk.template.builder', ['seller' => $seller->slug]) }}"
                                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                    Generate Template
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
