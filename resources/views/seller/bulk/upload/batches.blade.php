@extends('seller.layouts.seller')

@section('content')
    <div class="min-h-screen flex-1 bg-slate-50">

        @include('seller.layouts.header')

        <div class="px-4 py-4 lg:px-6">

            {{-- HERO --}}
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-r from-indigo-50 via-white to-cyan-50 shadow-sm">

                <div class="flex flex-col gap-5 p-5 lg:flex-row lg:items-center lg:justify-between">

                    {{-- LEFT --}}
                    <div class="max-w-3xl">

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

                                Enterprise Ingestion History

                            </div>

                        </div>

                        <h1 class="mt-3 text-2xl font-black tracking-tight text-slate-900">

                            Bulk Upload History

                        </h1>

                        <p class="mt-2 max-w-2xl text-sm text-slate-600">

                            Monitor ingestion batches, validation review, commit progression and media upload lifecycle.

                        </p>

                    </div>

                    {{-- RIGHT --}}
                    <div class="flex flex-wrap gap-2">

                        <a href="{{ route('seller.bulk.upload.index', ['seller' => $seller->slug]) }}"
                            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-800">

                            Upload New Catalog

                        </a>

                    </div>

                </div>

            </div>

            {{-- FILTERS --}}
            <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                <form method="GET" class="grid gap-3 xl:grid-cols-12">

                    {{-- SEARCH --}}
                    <div class="xl:col-span-4">

                        <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wide text-slate-500">

                            Search Batch

                        </label>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by batch ID"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 placeholder:text-slate-400 focus:border-slate-900 focus:outline-none focus:ring-0">

                    </div>

                    {{-- STATUS --}}
                    <div class="xl:col-span-4">

                        <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wide text-slate-500">

                            Pipeline Status

                        </label>

                        <select name="status"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 focus:border-slate-900 focus:outline-none focus:ring-0">

                            <option value="">
                                All Status
                            </option>

                            <option value="review_required" @selected(request('status') == 'review_required')>
                                Review Required
                            </option>

                            <option value="ready_for_publish" @selected(request('status') == 'ready_for_publish')>
                                Ready For Publish
                            </option>

                            <option value="publishing" @selected(request('status') == 'publishing')>
                                Publishing
                            </option>

                            <option value="partially_committed" @selected(request('status') == 'partially_committed')>
                                Partially Committed
                            </option>

                            <option value="committed" @selected(request('status') == 'committed')>
                                Committed
                            </option>

                            <option value="publish_failed" @selected(request('status') == 'publish_failed')>
                                Publish Failed
                            </option>

                            <option value="image_upload_pending" @selected(request('status') == 'image_upload_pending')>
                                Image Upload Pending
                            </option>

                            <option value="image_upload_in_progress" @selected(request('status') == 'image_upload_in_progress')>
                                Image Upload In Progress
                            </option>

                            <option value="completed" @selected(request('status') == 'completed')>
                                Completed
                            </option>

                        </select>

                    </div>

                    {{-- APPLY --}}
                    <div class="flex items-end xl:col-span-2">

                        <button
                            class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">

                            Apply Filters

                        </button>

                    </div>

                    {{-- RESET --}}
                    <div class="flex items-end xl:col-span-2">

                        <a href="{{ route('seller.bulk.batches.index', ['seller' => $seller->slug]) }}"
                            class="inline-flex w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50">

                            Reset

                        </a>

                    </div>

                </form>

            </div>

            {{-- TABLE --}}
            <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- HEADER --}}
                <div
                    class="flex flex-col gap-3 border-b border-slate-100 px-4 py-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>

                        <div class="text-[11px] font-bold uppercase tracking-wide text-slate-400">

                            Batch Monitoring

                        </div>

                        <h2 class="mt-1 text-xl font-black text-slate-900">

                            Ingestion Batches

                        </h2>

                    </div>

                    <div
                        class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-[11px] font-bold uppercase tracking-wide text-slate-600">

                        {{ $batches->total() ?? count($batches) }}
                        Total Batches
                    </div>
                </div>
                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="border-b border-slate-100 bg-slate-50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                    Batch
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                    Status
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                    Products
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                    Approved
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                    Failed
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                    Errors
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                    Created
                                </th>
                                <th
                                    class="px-4 py-3 text-right text-[10px] font-bold uppercase tracking-wide text-slate-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($batches as $batch)
                                @php
                                    $statusStyles = match ($batch->status) {
                                        'review_required' => [
                                            'bg' => 'bg-amber-100',
                                            'text' => 'text-amber-700',
                                        ],
                                        'ready_for_publish' => [
                                            'bg' => 'bg-indigo-100',
                                            'text' => 'text-indigo-700',
                                        ],
                                        'queued' => [
                                            'bg' => 'bg-blue-100',
                                            'text' => 'text-blue-700',
                                        ],
                                        'partially_committed' => [
                                            'bg' => 'bg-cyan-100',
                                            'text' => 'text-cyan-700',
                                        ],
                                        'committed' => [
                                            'bg' => 'bg-emerald-100',
                                            'text' => 'text-emerald-700',
                                        ],
                                        'publish_failed' => [
                                            'bg' => 'bg-rose-100',
                                            'text' => 'text-rose-700',
                                        ],
                                        'image_upload_pending' => [
                                            'bg' => 'bg-amber-100',
                                            'text' => 'text-amber-700',
                                        ],
                                        'image_upload_in_progress' => [
                                            'bg' => 'bg-blue-100',
                                            'text' => 'text-blue-700',
                                        ],
                                        'image_review_required' => [
                                            'bg' => 'bg-violet-100',
                                            'text' => 'text-violet-700',
                                        ],
                                        'completed' => [
                                            'bg' => 'bg-emerald-100',
                                            'text' => 'text-emerald-700',
                                        ],
                                        default => [
                                            'bg' => 'bg-slate-100',
                                            'text' => 'text-slate-700',
                                        ],
                                    };
                                @endphp
                                <tr class="transition hover:bg-slate-50/70">
                                    {{-- BATCH --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-sm font-black text-slate-700">
                                                #{{ $batch->id }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-black text-slate-900">
                                                    Batch #{{ $batch->id }}
                                                </div>
                                                <div class="mt-0.5 text-xs text-slate-500">
                                                    {{ $batch->seller_name ?? 'Unknown Seller' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- STATUS --}}
                                    <td class="px-4 py-4">
                                        <div
                                            class="inline-flex items-center rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide {{ $statusStyles['bg'] }} {{ $statusStyles['text'] }}">
                                            {{ ucfirst(str_replace('_', ' ', $batch->status)) }}
                                        </div>
                                    </td>
                                    {{-- PRODUCTS --}}
                                    <td class="px-4 py-4">
                                        <div class="text-base font-black text-slate-900">
                                            {{ $batch->total_products }}
                                        </div>
                                    </td>
                                    {{-- APPROVED --}}
                                    <td class="px-4 py-4">
                                        <div class="text-base font-black text-emerald-600">
                                            {{ $batch->approved_products }}
                                        </div>
                                    </td>
                                    {{-- FAILED --}}
                                    <td class="px-4 py-4">
                                        <div class="text-base font-black text-rose-600">
                                            {{ $batch->failed_products }}
                                        </div>
                                    </td>
                                    {{-- ERRORS --}}
                                    <td class="px-4 py-4">
                                        @if ($batch->total_errors > 0)
                                            <div class="text-base font-black text-rose-600">
                                                {{ $batch->total_errors }}
                                            </div>
                                        @else
                                            <div class="text-base font-black text-emerald-600">
                                                0
                                            </div>
                                        @endif
                                    </td>
                                    {{-- CREATED --}}
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-bold text-slate-900">
                                            {{ \Carbon\Carbon::parse($batch->created_at)->format('d M Y') }}
                                        </div>
                                        <div class="mt-0.5 text-xs text-slate-500">
                                            {{ \Carbon\Carbon::parse($batch->created_at)->format('h:i A') }}
                                        </div>
                                    </td>
                                    {{-- ACTIONS --}}
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap justify-end gap-2">
                                            {{-- REVIEW --}}
                                            <a href="{{ route('seller.bulk.batch.review', ['seller' => $seller->slug, 'batchId' => $batch->id]) }}"
                                                class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-50">
                                                Review
                                            </a>
                                            {{-- IMAGE REVIEW REQUIRED --}}
                                            @if ($batch->status === 'image_review_required')
                                                <a href="{{ route('seller.bulk.images.review', [
                                                    'seller' => $seller->slug,
                                                    'batchId' => $batch->id,
                                                ]) }}"
                                                    class="inline-flex items-center justify-center rounded-lg bg-violet-600 px-3 py-2 text-xs font-bold text-white transition hover:bg-violet-700">

                                                    Review Images

                                                </a>
                                            @endif
                                            {{-- IMAGE FLOW --}}
                                            @if (in_array($batch->status, ['image_upload_pending', 'image_upload_in_progress']))
                                                <a href="{{ route($batch->status === 'image_upload_pending' ? 'seller.bulk.images.gateway' : 'seller.bulk.images.manual', ['seller' => $seller->slug, 'batchId' => $batch->id]) }}"
                                                    class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-3 py-2 text-xs font-bold text-white transition hover:bg-amber-600">
                                                    {{ $batch->status === 'image_upload_pending' ? 'Image Upload Pending!' : 'Resume Upload' }}
                                                </a>
                                            @endif
                                            {{-- COMPLETED --}}
                                            @if ($batch->status === 'completed')
                                                <div
                                                    class="inline-flex items-center justify-center rounded-lg bg-emerald-100 px-3 py-2 text-xs font-bold text-emerald-700">
                                                    Completed
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-20">
                                        <div class="text-center">
                                            <div
                                                class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-slate-100">
                                                <svg class="h-10 w-10 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6" />
                                                </svg>
                                            </div>
                                            <h2 class="mt-5 text-2xl font-black text-slate-900">
                                                No Batches Found
                                            </h2>
                                            <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                                                Upload your first catalog Excel to begin the ingestion workflow.
                                            </p>
                                            <a href="{{ route('seller.bulk.upload.index', ['seller' => $seller->slug]) }}"
                                                class="mt-5 inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">
                                                Upload New Catalog
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- PAGINATION --}}
                @if (method_exists($batches, 'links'))
                    <div class="border-t border-slate-100 bg-white px-4 py-4">
                        {{ $batches->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
