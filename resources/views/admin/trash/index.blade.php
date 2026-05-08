@extends('admin.layouts.admin')

@section('title', 'Trash')

@section('content')
    <div class="settings-wrapper">
        <div class="settings-right">
            <div class="settings-right-inner">

                {{-- 🔥 Compact Header --}}
                <div class="settings-section card mb-2">
                    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">

                        <div>
                            <div class="fw-bold" style="font-size:.95rem;">Trash Management</div>
                            <div class="text-muted small">Permanantly delete or Restore deleted data</div>
                        </div>

                        {{-- Search --}}
                        <form method="GET">
                            <input type="hidden" name="type" value="{{ $type }}">

                            <div class="trash-search">
                                <i class="bi bi-search"></i>
                                <input type="text" name="q" value="{{ $search }}"
                                    placeholder="Search {{ ucfirst($type) }}...">
                            </div>
                        </form>

                    </div>
                </div>
                <div class="mb-3 d-flex gap-2">

                    <a href="{{ route('admin.trash.index', ['type' => 'user']) }}"
                        class="trash-tab-2 {{ $type == 'user' ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Customers
                        <span>{{ $counts['users'] }}</span>
                    </a>

                    <a href="{{ route('admin.trash.index', ['type' => 'seller']) }}"
                        class="trash-tab-2 {{ $type == 'seller' ? 'active' : '' }}">
                        <i class="bi bi-shop"></i>
                        Sellers
                        <span>{{ $counts['sellers'] }}</span>
                    </a>

                </div>
                {{-- Table Section --}}
                <form method="POST" action="{{ route('admin.trash.bulk') }}">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">

                    <div class="settings-section card">

                        {{-- Bulk Bar --}}
                        <div class="card-body py-2 px-3 border-bottom d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center gap-2">

                                <select name="action" class="form-select form-select-sm clean-select">
                                    <option value="">Bulk Actions</option>
                                    <option value="restore">Restore</option>
                                    <option value="delete">Delete Permanently</option>
                                </select>

                                {{-- <button class="btn btn-sm btn-primary px-3">
                                    Apply
                                </button> --}}
                                <button class="btn-section-manage">
                                    <i class="bi bi-check2-circle"></i>
                                    Apply
                                </button>

                            </div>

                            <small class="text-muted">
                                {{ $items->total() }} records
                            </small>

                        </div>
                        {{-- Content --}}
                        <div class="card-body p-0">

                            @if ($items->isEmpty())
                                <div class="no-results d-flex">
                                    <div class="no-results-title">Trash is empty</div>
                                    <div class="no-results-hint">
                                        No deleted records found.
                                    </div>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">

                                        <thead>
                                            <tr>
                                                <th style="width:40px;">
                                                    <input type="checkbox" id="checkAll">
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Deleted</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr class="hover-row">

                                                    <td>
                                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}">
                                                    </td>

                                                    <td class="fw-semibold">{{ $item->name }}</td>

                                                    <td class="text-muted small">{{ $item->email }}</td>

                                                    <td>
                                                        <span class="text-muted small">
                                                            {{ $item->deleted_at->diffForHumans() }}
                                                        </span>
                                                    </td>

                                                    <td class="text-end">

                                                        <div class="d-inline-flex align-items-center gap-1">

                                                            <form method="POST"
                                                                action="{{ route('admin.trash.restore', ['type' => $type, 'id' => $item->id]) }}">
                                                                @csrf
                                                                <button class="icon-btn success" title="Restore">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </form>

                                                            <form method="POST"
                                                                action="{{ route('admin.trash.delete', ['type' => $type, 'id' => $item->id]) }}"
                                                                onsubmit="return confirm('Permanent delete?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="icon-btn danger" title="Delete">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>

                                                        </div>

                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <div class="p-3">
                                    {{ $items->links() }}
                                </div>

                            @endif

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- JS --}}
    <script>
        document.getElementById('checkAll')?.addEventListener('click', function(e) {
            document.querySelectorAll('input[name="ids[]"]').forEach(cb => cb.checked = e.target.checked);
        });
    </script>

    {{-- 🎨 Styling --}}
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/setting-general-payment.css') }}">

        <style>
            .trash-tab-2 {
                display: inline-flex;
                align-items: center;
                gap: .4rem;
                padding: .4rem .8rem;
                border-radius: .6rem;
                font-size: .85rem;
                font-weight: 600;
                background: #eef2f7;
                color: #374151;
                text-decoration: none;
                transition: .15s;
            }

            .trash-tab-2 span {
                font-size: .7rem;
                opacity: .7;
            }

            .trash-tab-2:hover {
                background: #e4e9f2;
            }

            .trash-tab-2.active {
                background: rgba(13, 110, 253, .12);
                color: #0d6efd;
            }

            .clean-select {
                border-radius: .5rem;
                font-size: .85rem;
                padding: .25rem .5rem;
            }

            .trash-search {
                display: flex;
                align-items: center;
                gap: .4rem;
                background: #eef2f7;
                padding: .35rem .7rem;
                border-radius: .6rem;
            }

            .trash-search input {
                border: 0;
                background: transparent;
                outline: none;
                font-size: .85rem;
                width: 200px;
            }

            .trash-tab {
                display: inline-flex;
                align-items: center;
                gap: .35rem;
                padding: .35rem .7rem;
                border-radius: .5rem;
                font-size: .85rem;
                font-weight: 600;
                background: #f1f3f7;
                color: #374151;
                text-decoration: none;
                transition: .15s;
            }

            .trash-tab span {
                font-size: .7rem;
                opacity: .7;
            }

            .trash-tab:hover {
                background: #e7ebf3;
            }

            .trash-tab.active {
                background: rgba(13, 110, 253, .1);
                color: #0d6efd;
            }

            .trash-search {
                display: flex;
                align-items: center;
                gap: .4rem;
                background: #f1f3f7;
                padding: .35rem .6rem;
                border-radius: .5rem;
            }

            .trash-search input {
                border: 0;
                background: transparent;
                outline: none;
                font-size: .85rem;
                width: 180px;
            }

            .icon-btn {
                border: 0;
                background: transparent;
                padding: .3rem;
                border-radius: .4rem;
                transition: .15s;
            }

            .icon-btn:hover {
                background: #f1f3f7;
            }

            .icon-btn.success {
                color: #198754;
            }

            .icon-btn.danger {
                color: #dc3545;
            }

            .hover-row:hover {
                background: #f5f7fb;
            }
        </style>
    @endpush

@endsection
