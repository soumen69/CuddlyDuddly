@extends('seller.layouts.seller')

@section('content')
    @php

        $batchStatus = $batch->status ?? null;

        $commitLocked = in_array($batchStatus, [
            'publishing',
            'image_upload_pending',
            'image_upload_in_progress',
            'completed',
        ]);

        $canReviewActions = in_array($batchStatus, ['review_required', 'ready_for_publish', 'publish_failed']);

        $blockedProducts = $products
            ->whereIn('status', ['pending_review', 'rejected', 'compile_failed', 'validation_failed'])
            ->count();

        $hasApprovedProducts = $products->where('status', 'approved')->count() > 0;

        $canCommit = $batchStatus === 'ready_for_publish';

        $approvableProducts = $products->filter(function ($product) use ($errors) {
            $errs = $errors[$product->product_code] ?? collect();

            return !$errs->count() &&
                !in_array($product->status, ['approved', 'rejected', 'compile_failed', 'validation_failed']);
        });
    @endphp
    <div x-data="{
        rejectModal: false,
        rejectAction: '',
        allProducts: @js($approvableProducts->pluck('id')->map(fn($id) => (string) $id)->values()),
        selectedProducts: [],
    
        isChecked(id) {
            return this.selectedProducts.includes(String(id));
        },
    
        toggleProduct(id) {
            id = String(id);
    
            if (this.selectedProducts.includes(id)) {
                this.selectedProducts = this.selectedProducts.filter(item => item !== id);
            } else {
                this.selectedProducts.push(id);
            }
        },
    
        toggleAll(event) {
            if (event.target.checked) {
                this.selectedProducts = [...this.allProducts];
            } else {
                this.selectedProducts = [];
            }
        },
    
        allSelected() {
            return this.allProducts.length > 0 &&
                this.selectedProducts.length === this.allProducts.length;
        }
    }" class="min-h-screen flex-1 bg-slate-50">

        @include('seller.layouts.header')

        <div class="px-4 py-4 lg:px-6">

            {{-- HEADER --}}
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-r from-white via-slate-50 to-indigo-50 shadow-sm">

                <div class="flex flex-col gap-4 p-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- LEFT --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('seller.bulk.dashboard', ['seller' => $seller->slug]) }}" class="h-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="24"
                                    height="24">
                                    <path
                                        d="M19,11H9l3.29-3.29a1,1,0,0,0,0-1.42,1,1,0,0,0-1.41,0l-4.29,4.3A2,2,0,0,0,6,12H6a2,2,0,0,0,.59,1.4l4.29,4.3a1,1,0,1,0,1.41-1.42L9,13H19a1,1,0,0,0,0-2Z" />
                                </svg>
                            </a>

                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-indigo-700">

                                <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span>

                                Catalog Review

                            </div>

                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-600">
                                Batch #{{ $batchId }}
                            </div>
                            <div
                                class="inline-flex items-center gap-2 rounded-full border
                                {{ $commitLocked ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-700' }}
                                px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide">
                                {{ ucwords(str_replace('_', ' ', $batchStatus ?? 'review')) }}
                            </div>
                        </div>
                        <h1 class="mt-2 text-xl font-black tracking-tight text-slate-900">
                            Product Review & Approval
                        </h1>
                        <p class="mt-1 max-w-3xl text-sm text-slate-600">
                            Validate products, resolve ingestion issues and prepare products for publishing and image
                            onboarding.
                        </p>
                    </div>

                    {{-- RIGHT --}}
                    <div class="flex flex-col gap-2 lg:w-[260px]">
                        <a href="{{ route('seller.bulk.batches.index', ['seller' => $seller->slug]) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-indigo-300 hover:text-indigo-700">
                            Batch History
                        </a>
                        @if ($commitLocked)
                            @if (in_array($batchStatus, ['image_upload_pending', 'image_upload_in_progress']))
                                <a href="{{ route('seller.bulk.images.gateway', ['seller' => $seller->slug, 'batchId' => $batchId]) }}"
                                    class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-700">

                                    Continue Image Upload

                                </a>
                            @elseif ($batchStatus === 'completed')
                                <div
                                    class="inline-flex items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-bold text-emerald-700">
                                    Products Published
                                </div>
                            @else
                                <div
                                    class="inline-flex items-center justify-center rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-2.5 text-sm font-bold text-indigo-700">
                                    Publishing Products
                                </div>
                            @endif
                        @else
                            @if ($canCommit)
                                <form method="POST"
                                    action="{{ route('seller.bulk.batch.commit', ['seller' => $seller->slug, 'batchId' => $batchId]) }}">

                                    @csrf

                                    <button
                                        class="inline-flex w-full items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">
                                        Publish Products
                                    </button>

                                </form>
                            @else
                                <button
                                    class="inline-flex cursor-not-allowed items-center justify-center rounded-xl bg-slate-200 px-4 py-2.5 text-sm font-bold text-slate-500">
                                    Resolve Product Issues
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- STATS --}}
            <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">

                <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                    <div class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                        Products
                    </div>

                    <div class="mt-1 text-2xl font-black text-slate-900">
                        {{ $summary['products'] }}
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-200 bg-blue-50 p-3 shadow-sm">
                    <div class="text-[10px] font-bold uppercase tracking-wide text-blue-700">
                        Variants
                    </div>

                    <div class="mt-1 text-2xl font-black text-blue-900">
                        {{ $summary['variants'] }}
                    </div>
                </div>

                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-3 shadow-sm">
                    <div class="text-[10px] font-bold uppercase tracking-wide text-rose-700">
                        Product Errors
                    </div>

                    <div class="mt-1 text-2xl font-black text-rose-900">
                        {{ $summary['product_errors'] }}
                    </div>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-3 shadow-sm">
                    <div class="text-[10px] font-bold uppercase tracking-wide text-amber-700">
                        Batch Errors
                    </div>

                    <div class="mt-1 text-2xl font-black text-amber-900">
                        {{ $summary['batch_errors'] }}
                    </div>
                </div>

                <div
                    class="rounded-2xl border {{ $canCommit ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-white' }} p-3 shadow-sm">

                    <div
                        class="text-[10px] font-bold uppercase tracking-wide {{ $canCommit ? 'text-emerald-700' : 'text-slate-400' }}">
                        Publishing Status
                    </div>

                    <div class="mt-1 text-2xl font-black {{ $canCommit ? 'text-emerald-900' : 'text-slate-900' }}">
                        {{ $canCommit ? 'Ready to Publish' : 'Locked' }}
                    </div>

                </div>

            </div>

            {{-- BULK ACTION TOOLBAR --}}
            @if ($approvableProducts->count() && !$commitLocked)
                <div
                    class="sticky top-3 z-30 mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white/95 shadow-sm backdrop-blur">

                    <div class="flex flex-col gap-3 p-3 lg:flex-row lg:items-center lg:justify-between">

                        <div class="flex flex-wrap items-center gap-3">

                            <label
                                class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">

                                <input type="checkbox"
                                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                    :checked="allSelected()" @change="toggleAll($event)">

                                <span class="text-sm font-semibold text-slate-700">
                                    Select All
                                </span>

                            </label>

                            <div
                                class="inline-flex items-center rounded-xl border border-indigo-100 bg-indigo-50 px-3 py-2 text-sm font-bold text-indigo-700">

                                <span x-text="selectedProducts.length"></span>
                                <span class="ml-1">selected</span>

                            </div>

                        </div>

                        <form method="POST"
                            action="{{ route('seller.bulk.batch.bulk-approve', ['seller' => $seller->slug]) }}">

                            @csrf

                            <template x-for="id in selectedProducts" :key="id">
                                <input type="hidden" name="products[]" :value="id">
                            </template>

                            <button type="submit" :disabled="selectedProducts.length === 0"
                                :class="selectedProducts.length === 0 ?
                                    'bg-slate-200 text-slate-500 cursor-not-allowed' :
                                    'bg-emerald-600 text-white hover:bg-emerald-700'"
                                class="inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-bold shadow-sm transition">

                                <span
                                    x-text="selectedProducts.length > 0 ?
                                        `Approve Selected (${selectedProducts.length})` :
                                        'Approve Selected'">
                                </span>

                            </button>

                        </form>

                    </div>

                </div>
            @endif

            {{-- PRODUCT LIST --}}
            <div class="mt-4 space-y-3">

                @foreach ($products as $product)
                    @php

                        $compiled = json_decode($product->compiled_payload, true);

                        $errs = $errors[$product->product_code] ?? collect();

                        $isReviewable =
                            !$errs->count() &&
                            !in_array($product->status, [
                                'approved',
                                'rejected',
                                'compile_failed',
                                'validation_failed',
                            ]);

                        $statusStyles = match ($product->status) {
                            'approved' => [
                                'card' => 'border-emerald-200 bg-emerald-50/60',
                                'badge' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            ],

                            'rejected' => [
                                'card' => 'border-rose-200 bg-rose-50/60',
                                'badge' => 'bg-rose-100 text-rose-700 border-rose-200',
                            ],

                            'compile_failed', 'validation_failed' => [
                                'card' => 'border-rose-200 bg-rose-50/60',
                                'badge' => 'bg-rose-100 text-rose-700 border-rose-200',
                            ],

                            'pending_review' => [
                                'card' => 'border-amber-200 bg-amber-50/60',
                                'badge' => 'bg-amber-100 text-amber-700 border-amber-200',
                            ],

                            default => [
                                'card' => 'border-slate-200 bg-white',
                                'badge' => 'bg-slate-100 text-slate-700 border-slate-200',
                            ],
                        };

                    @endphp

                    <div
                        class="overflow-hidden rounded-2xl border shadow-sm transition hover:shadow-md {{ $statusStyles['card'] }}">

                        <div class="p-4">

                            <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">

                                {{-- LEFT --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start gap-3">

                                        @if ($isReviewable && $canReviewActions)
                                            <label class="mt-1 inline-flex cursor-pointer items-center">
                                                <input type="checkbox"
                                                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                                    :checked="isChecked('{{ $product->id }}')"
                                                    @change="toggleProduct('{{ $product->id }}')">
                                            </label>
                                        @endif

                                        <div class="min-w-0 flex-1">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <h2 class="truncate text-[15px] font-black text-slate-900">
                                                    {{ $compiled['product']['name'] ?? '-' }}
                                                </h2>

                                                <div
                                                    class="rounded-full border px-2 py-1 text-[10px] font-bold uppercase tracking-wide {{ $statusStyles['badge'] }}">

                                                    {{ ucfirst(str_replace('_', ' ', $product->status)) }}

                                                </div>

                                            </div>

                                            <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">

                                                <div>
                                                    <div
                                                        class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                        Product Code
                                                    </div>

                                                    <div class="mt-1 text-sm font-bold text-slate-900">
                                                        {{ $product->product_code }}
                                                    </div>
                                                </div>

                                                <div>
                                                    <div
                                                        class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                        Category
                                                    </div>

                                                    <div class="mt-1 text-sm font-medium text-slate-800">
                                                        {{ $product->category_name ?? '-' }}
                                                    </div>
                                                </div>

                                                <div>
                                                    <div
                                                        class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                        Errors
                                                    </div>

                                                    <div
                                                        class="mt-1 text-sm font-black {{ $errs->count() ? 'text-rose-700' : 'text-emerald-700' }}">
                                                        {{ $errs->count() }}
                                                    </div>
                                                </div>

                                                <div>
                                                    <div
                                                        class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                        Validation
                                                    </div>

                                                    <div class="mt-1 text-sm font-medium text-slate-800">
                                                        {{ $errs->count() ? 'Needs Attention' : 'Passed' }}
                                                    </div>
                                                </div>

                                                <div>
                                                    <div
                                                        class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                        Variants
                                                    </div>

                                                    <div class="mt-1 text-sm font-medium text-slate-800">
                                                        {{ collect($compiled['variants'] ?? [])->count() }}
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- ERRORS --}}
                                            @if ($errs->count())
                                                <div
                                                    class="mt-4 overflow-hidden rounded-xl border border-rose-200 bg-white">

                                                    <div
                                                        class="flex items-center justify-between border-b border-rose-100 bg-rose-50 px-3 py-2">

                                                        <div
                                                            class="text-[11px] font-black uppercase tracking-wide text-rose-700">

                                                            Validation Issues

                                                        </div>

                                                        <div
                                                            class="rounded-full bg-rose-100 px-2 py-0.5 text-[10px] font-bold text-rose-700">

                                                            {{ $errs->count() }}

                                                        </div>

                                                    </div>

                                                    <div class="space-y-2 p-3">

                                                        @foreach ($errs as $e)
                                                            <div
                                                                class="rounded-lg border border-rose-100 bg-rose-50 px-3 py-2 text-xs font-medium text-rose-700">

                                                                {{ $e->message }}

                                                            </div>
                                                        @endforeach

                                                    </div>

                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                                {{-- ACTIONS --}}
                                <div class="w-full xl:w-[200px]">

                                    @if ($product->status === 'approved')
                                        <div
                                            class="rounded-2xl border border-emerald-200 bg-white px-4 py-4 text-center shadow-sm">

                                            <div class="text-sm font-black text-emerald-900">
                                                Approved
                                            </div>

                                            <div class="mt-1 text-xs text-emerald-700">
                                                Ready to Publish
                                            </div>

                                        </div>
                                    @elseif($product->status === 'rejected')
                                        <div
                                            class="rounded-2xl border border-rose-200 bg-white px-4 py-4 text-center shadow-sm">

                                            <div class="text-sm font-black text-rose-900">
                                                Rejected
                                            </div>

                                            <div class="mt-1 text-xs text-rose-700">
                                                Removed from pipeline
                                            </div>

                                        </div>
                                    @elseif($errs->count() || in_array($product->status, ['compile_failed', 'validation_failed']))
                                        <div
                                            class="rounded-2xl border border-slate-200 bg-white px-4 py-4 text-center shadow-sm">

                                            <div class="text-sm font-black text-slate-900">
                                                Validation Blocked
                                            </div>

                                            <div class="mt-1 text-xs text-slate-500">
                                                Resolve issues first
                                            </div>

                                        </div>
                                    @elseif(!$canReviewActions)
                                        <div
                                            class="rounded-2xl border border-indigo-200 bg-white px-4 py-4 text-center shadow-sm">

                                            <div class="text-sm font-black text-indigo-900">
                                                Publishing Started
                                            </div>

                                            <div class="mt-1 text-xs text-indigo-700">
                                                Review locked
                                            </div>

                                        </div>
                                    @else
                                        <div class="space-y-2">

                                            {{-- APPROVE --}}
                                            <form method="POST"
                                                action="{{ route('seller.bulk.batch.approve', ['seller' => $seller->slug, 'productId' => $product->id]) }}">

                                                @csrf

                                                <button
                                                    class="inline-flex w-full items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">

                                                    Approve

                                                </button>

                                            </form>

                                            {{-- REJECT --}}
                                            <button
                                                @click="
                                                    rejectModal = true;
                                                    rejectAction = '{{ route('seller.bulk.batch.reject', ['seller' => $seller->slug, 'productId' => $product->id]) }}';
                                                "
                                                class="inline-flex w-full items-center justify-center rounded-xl border border-rose-300 bg-white px-4 py-2.5 text-sm font-bold text-rose-700 transition hover:bg-rose-50">

                                                Reject

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
                class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">

                <div class="border-b border-slate-100 px-5 py-4">

                    <div class="flex items-start justify-between gap-4">

                        <div>

                            <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Review Action
                            </div>

                            <h2 class="mt-1 text-lg font-black text-slate-900">
                                Reject Product
                            </h2>

                        </div>

                        <button @click="rejectModal = false"
                            class="rounded-xl border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-100">

                            ✕

                        </button>

                    </div>

                </div>

                <form :action="rejectAction" method="POST" class="p-5">

                    @csrf

                    <div>

                        <label class="text-sm font-bold text-slate-900">
                            Rejection Reason
                        </label>

                        <textarea name="reason" rows="5" required placeholder="Enter rejection reason..."
                            class="mt-3 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-900 focus:outline-none focus:ring-0"></textarea>

                    </div>

                    <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:justify-end">

                        <button type="button" @click="rejectModal = false"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                            Cancel

                        </button>

                        <button
                            class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-rose-700">

                            Reject Product

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
