@extends('seller.layouts.seller')

@section('content')
    @php

        $blockedProducts = $products->whereIn('status', ['pending_review', 'rejected'])->count();

        $canCommit = $summary['product_errors'] + $summary['batch_errors'] === 0 && $blockedProducts === 0;

    @endphp

    <div x-data="{ rejectModal: false, rejectAction: '' }" class="min-h-screen bg-slate-50">

        @include('seller.layouts.header')

        <div class="px-4 py-5 lg:px-6">

            {{-- HERO --}}
            <div
                class="overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-r from-indigo-50 via-white to-cyan-50 shadow-sm">

                <div class="flex flex-col gap-8 p-6 lg:flex-row lg:items-center lg:justify-between">

                    {{-- LEFT --}}
                    <div class="max-w-3xl">

                        <div class="flex flex-wrap items-center gap-2">

                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-white px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-indigo-700">

                                <span class="h-2 w-2 rounded-full bg-indigo-600"></span>

                                Validation Review Pipeline

                            </div>

                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-slate-600">

                                Batch #{{ $batchId }}

                            </div>

                        </div>

                        <h1 class="mt-5 text-3xl font-black tracking-tight text-slate-900 lg:text-4xl">

                            Product Validation Review

                        </h1>

                        <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600">

                            Review imported catalog products before final ingestion commit
                            into the production product system.

                        </p>

                        {{-- PIPELINE --}}
                        <div class="mt-7 flex flex-wrap gap-3">

                            <div class="rounded-2xl border border-indigo-200 bg-white px-4 py-3 shadow-sm">

                                <div class="text-[11px] font-bold uppercase tracking-wide text-indigo-700">
                                    Products
                                </div>

                                <div class="mt-1 text-lg font-black text-slate-900">
                                    {{ $summary['products'] }}
                                </div>

                            </div>

                            <div class="rounded-2xl border border-blue-200 bg-white px-4 py-3 shadow-sm">

                                <div class="text-[11px] font-bold uppercase tracking-wide text-blue-700">
                                    Variants
                                </div>

                                <div class="mt-1 text-lg font-black text-slate-900">
                                    {{ $summary['variants'] }}
                                </div>

                            </div>

                            <div class="rounded-2xl border border-rose-200 bg-white px-4 py-3 shadow-sm">

                                <div class="text-[11px] font-bold uppercase tracking-wide text-rose-700">
                                    Validation Errors
                                </div>

                                <div class="mt-1 text-lg font-black text-slate-900">
                                    {{ $summary['product_errors'] + $summary['batch_errors'] }}
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="flex flex-col gap-3 lg:w-[340px]">

                        <a href="{{ route('seller.bulk.batches.index', ['seller' => $seller->slug]) }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm font-bold text-slate-700 shadow-sm transition hover:border-indigo-300 hover:text-indigo-700">

                            Back To Batch History

                        </a>

                        @if ($canCommit)
                            <form method="POST"
                                action="{{ route('seller.bulk.batch.commit', ['seller' => $seller->slug, 'batchId' => $batchId]) }}">

                                @csrf

                                <button
                                    class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-5 py-4 text-sm font-black text-white shadow-xl transition hover:bg-emerald-700">

                                    Queue Product Commit

                                </button>

                            </form>
                        @else
                            <button
                                class="inline-flex cursor-not-allowed items-center justify-center rounded-2xl bg-slate-200 px-5 py-4 text-sm font-black text-slate-500">

                                Resolve Validation Issues First

                            </button>
                        @endif

                    </div>

                </div>

            </div>

            {{-- STATS --}}
            <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">

                {{-- PRODUCTS --}}
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <div class="text-sm font-semibold text-slate-500">
                                Products
                            </div>

                            <div class="mt-3 text-3xl font-black text-slate-900">
                                {{ $summary['products'] }}
                            </div>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">

                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6" />

                            </svg>

                        </div>

                    </div>

                </div>

                {{-- VARIANTS --}}
                <div class="rounded-3xl border border-blue-200 bg-blue-50 p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <div class="text-sm font-semibold text-blue-700">
                                Variants
                            </div>

                            <div class="mt-3 text-3xl font-black text-blue-900">
                                {{ $summary['variants'] }}
                            </div>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/70 text-blue-700">

                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5V4H2v16h5" />

                            </svg>

                        </div>

                    </div>

                </div>

                {{-- PRODUCT ERRORS --}}
                <div class="rounded-3xl border border-rose-200 bg-rose-50 p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <div class="text-sm font-semibold text-rose-700">
                                Product Errors
                            </div>

                            <div class="mt-3 text-3xl font-black text-rose-900">
                                {{ $summary['product_errors'] }}
                            </div>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/70 text-rose-700">

                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />

                            </svg>

                        </div>

                    </div>

                </div>

                {{-- BATCH ERRORS --}}
                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <div class="text-sm font-semibold text-amber-700">
                                Batch Errors
                            </div>

                            <div class="mt-3 text-3xl font-black text-amber-900">
                                {{ $summary['batch_errors'] }}
                            </div>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/70 text-amber-700">

                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />

                            </svg>

                        </div>

                    </div>

                </div>

                {{-- READY --}}
                <div
                    class="rounded-3xl border {{ $canCommit ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-white' }} p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <div class="text-sm font-semibold {{ $canCommit ? 'text-emerald-700' : 'text-slate-500' }}">
                                Commit Status
                            </div>

                            <div class="mt-3 text-2xl font-black {{ $canCommit ? 'text-emerald-900' : 'text-slate-900' }}">

                                {{ $canCommit ? 'Ready' : 'Blocked' }}

                            </div>

                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $canCommit ? 'bg-white/70 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">

                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

                            </svg>

                        </div>

                    </div>

                </div>

            </div>

            {{-- REVIEW FLOW --}}
            <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="flex flex-col gap-5 p-5 lg:flex-row lg:items-center lg:justify-between">

                    <div>

                        <div class="text-xs font-bold uppercase tracking-wide text-slate-400">
                            Validation Workflow
                        </div>

                        <h2 class="mt-1 text-xl font-black text-slate-900">
                            Review & Approval Pipeline
                        </h2>

                    </div>

                    <div class="flex flex-wrap gap-2">

                        <div
                            class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-bold uppercase tracking-wide text-emerald-700">

                            Approved

                        </div>

                        <div
                            class="rounded-full border border-amber-200 bg-amber-50 px-4 py-2 text-xs font-bold uppercase tracking-wide text-amber-700">

                            Pending Review

                        </div>

                        <div
                            class="rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-bold uppercase tracking-wide text-rose-700">

                            Validation Failed

                        </div>

                    </div>

                </div>

            </div>

            {{-- PRODUCTS --}}
            <div class="mt-6 space-y-4">

                @foreach ($products as $product)
                    @php

                        $compiled = json_decode($product->compiled_payload, true);

                        $errs = $errors[$product->product_code] ?? collect();

                        $statusStyles = match ($product->status) {
                            'approved' => [
                                'card' => 'border-emerald-200 bg-emerald-50',
                                'badge' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            ],

                            'rejected' => [
                                'card' => 'border-rose-200 bg-rose-50',
                                'badge' => 'bg-rose-100 text-rose-700 border-rose-200',
                            ],

                            'compile_failed', 'validation_failed' => [
                                'card' => 'border-rose-200 bg-rose-50',
                                'badge' => 'bg-rose-100 text-rose-700 border-rose-200',
                            ],

                            'pending_review' => [
                                'card' => 'border-amber-200 bg-amber-50',
                                'badge' => 'bg-amber-100 text-amber-700 border-amber-200',
                            ],

                            default => [
                                'card' => 'border-slate-200 bg-white',
                                'badge' => 'bg-slate-100 text-slate-700 border-slate-200',
                            ],
                        };

                    @endphp

                    <div class="overflow-hidden rounded-3xl border shadow-sm {{ $statusStyles['card'] }}">

                        <div class="p-5">

                            <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">

                                {{-- LEFT --}}
                                <div class="min-w-0 flex-1">

                                    {{-- TITLE --}}
                                    <div class="flex flex-wrap items-center gap-3">

                                        <div class="truncate text-xl font-black text-slate-900">

                                            {{ $compiled['product']['name'] ?? '-' }}

                                        </div>

                                        <div
                                            class="rounded-full border px-3 py-1 text-[11px] font-bold uppercase tracking-wide {{ $statusStyles['badge'] }}">

                                            {{ ucfirst(str_replace('_', ' ', $product->status)) }}

                                        </div>

                                    </div>

                                    {{-- META --}}
                                    <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                                        <div>

                                            <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400">

                                                Product Code

                                            </div>

                                            <div class="mt-1 text-sm font-bold text-slate-900">

                                                {{ $product->product_code }}

                                            </div>

                                        </div>

                                        <div>

                                            <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400">

                                                Category

                                            </div>

                                            <div class="mt-1 text-sm font-bold text-slate-900">

                                                {{ $product->category_name ?? '-' }}

                                            </div>

                                        </div>

                                        <div>

                                            <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400">

                                                Errors

                                            </div>

                                            <div
                                                class="mt-1 text-sm font-bold {{ $errs->count() ? 'text-rose-700' : 'text-emerald-700' }}">

                                                {{ $errs->count() }}

                                            </div>

                                        </div>

                                        <div>

                                            <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400">

                                                Validation

                                            </div>

                                            <div class="mt-1 text-sm font-bold text-slate-900">

                                                {{ $errs->count() ? 'Needs Review' : 'Passed' }}

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ERRORS --}}
                                    @if ($errs->count())
                                        <div class="mt-5 overflow-hidden rounded-2xl border border-rose-200 bg-white">

                                            <div class="border-b border-rose-100 px-4 py-3">

                                                <div class="text-sm font-black text-rose-900">

                                                    Validation Errors

                                                </div>

                                            </div>

                                            <div class="space-y-2 p-4">

                                                @foreach ($errs as $e)
                                                    <div
                                                        class="rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">

                                                        {{ $e->message }}

                                                    </div>
                                                @endforeach

                                            </div>

                                        </div>
                                    @else
                                        <div
                                            class="mt-5 flex items-center gap-4 rounded-2xl border border-emerald-200 bg-white p-4">

                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">

                                                <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />

                                                </svg>

                                            </div>

                                            <div>

                                                <div class="text-sm font-black text-emerald-900">

                                                    Validation Passed

                                                </div>

                                                <div class="mt-1 text-xs text-emerald-700">

                                                    Product is ready for review actions.

                                                </div>

                                            </div>

                                        </div>
                                    @endif

                                </div>

                                {{-- RIGHT ACTIONS --}}
                                <div class="w-full xl:w-[250px]">

                                    @if ($product->status === 'approved')
                                        <div class="rounded-3xl border border-emerald-200 bg-white p-5">

                                            <div class="text-center text-sm font-black text-emerald-900">

                                                Product Approved

                                            </div>

                                            <div class="mt-2 text-center text-xs text-emerald-700">

                                                Ready for commit pipeline.

                                            </div>

                                        </div>
                                    @elseif($product->status === 'rejected')
                                        <div class="rounded-3xl border border-rose-200 bg-white p-5">

                                            <div class="text-center text-sm font-black text-rose-900">

                                                Product Rejected

                                            </div>

                                            <div class="mt-2 text-center text-xs text-rose-700">

                                                Product was rejected during review.

                                            </div>

                                        </div>
                                    @elseif($errs->count() || in_array($product->status, ['compile_failed', 'validation_failed']))
                                        <div class="rounded-3xl border border-slate-200 bg-white p-5">

                                            <div class="text-center text-sm font-black text-slate-900">

                                                Validation Blocked

                                            </div>

                                            <div class="mt-2 text-center text-xs text-slate-500">

                                                Resolve validation errors before approval.

                                            </div>

                                        </div>
                                    @else
                                        <div class="space-y-3">

                                            {{-- APPROVE --}}
                                            <form method="POST"
                                                action="{{ route('seller.bulk.batch.approve', ['seller' => $seller->slug, 'productId' => $product->id]) }}">

                                                @csrf

                                                <button
                                                    class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-5 py-4 text-sm font-black text-white shadow-lg transition hover:bg-emerald-700">

                                                    Approve Product

                                                </button>

                                            </form>

                                            {{-- REJECT --}}
                                            <button
                                                @click="
                                                    rejectModal = true;
                                                    rejectAction = '{{ route('seller.bulk.batch.reject', ['seller' => $seller->slug, 'productId' => $product->id]) }}';
                                                "
                                                class="inline-flex w-full items-center justify-center rounded-2xl border border-rose-300 bg-white px-5 py-4 text-sm font-black text-rose-700 transition hover:bg-rose-50">

                                                Reject Product

                                            </button>

                                        </div>
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

        {{-- REJECT MODAL --}}
        <div x-cloak x-show="rejectModal" x-transition.opacity
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4"
            :class="rejectModal ? 'flex' : 'hidden'">

            <div @click.away="rejectModal = false"
                class="w-full max-w-xl overflow-hidden rounded-3xl bg-white shadow-2xl">

                <div class="border-b border-slate-100 px-6 py-5">

                    <div class="flex items-start justify-between gap-4">

                        <div>

                            <div class="text-xs font-bold uppercase tracking-wide text-slate-400">

                                Product Review

                            </div>

                            <h2 class="mt-1 text-2xl font-black text-slate-900">

                                Reject Product

                            </h2>

                        </div>

                        <button @click="rejectModal = false"
                            class="rounded-2xl border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-100">

                            ✕

                        </button>

                    </div>

                </div>

                <form :action="rejectAction" method="POST" class="p-6">

                    @csrf

                    <div>

                        <label class="text-sm font-bold text-slate-900">

                            Rejection Reason

                        </label>

                        <textarea name="reason" rows="6" required placeholder="Enter rejection reason..."
                            class="mt-3 w-full rounded-2xl border border-slate-300 px-4 py-4 text-sm focus:border-slate-900 focus:outline-none focus:ring-0"></textarea>

                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">

                        <button type="button" @click="rejectModal = false"
                            class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50">

                            Cancel

                        </button>

                        <button
                            class="inline-flex items-center justify-center rounded-2xl bg-rose-600 px-5 py-3 text-sm font-black text-white transition hover:bg-rose-700">

                            Reject Product

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
