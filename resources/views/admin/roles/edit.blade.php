@extends('admin.layouts.admin')

@section('title', 'Edit Role Permissions')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold mb-0">
                {{ $role->name === 'Seller' ? 'Seller Role Overview' : 'Edit Permissions — ' . $role->name }}
            </h5>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        @if ($role->name === 'Seller')
            {{-- ===============================
                 SELLER ROLE INFO VIEW (READ-ONLY)
            ================================= --}}
            <div class="alert alert-info small mb-4">
                <i class="bi bi-info-circle me-1"></i>
                The <strong>Seller</strong> role is managed automatically by the system.
                The following overview displays the standard seller portal features and permissions.
            </div>

            {{-- === SELLER PORTAL OVERVIEW CARD === --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-primary text-white fw-semibold py-2 px-3">
                    <i class="bi bi-shop me-2"></i> Seller Portal Overview
                </div>
                <div class="card-body py-3 px-3">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-box-seam text-primary fs-5"></i>
                                <div>
                                    <div class="fw-semibold small">Products Management</div>
                                    <div class="text-muted small">Add, update, and manage product listings</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-bag-check text-success fs-5"></i>
                                <div>
                                    <div class="fw-semibold small">Order Handling</div>
                                    <div class="text-muted small">View, accept, and fulfill customer orders</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-cash-stack text-warning fs-5"></i>
                                <div>
                                    <div class="fw-semibold small">Payouts</div>
                                    <div class="text-muted small">Track earnings and withdrawal status</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle text-info fs-5"></i>
                                <div>
                                    <div class="fw-semibold small">Profile & Settings</div>
                                    <div class="text-muted small">Manage store details and account preferences</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="text-muted small">
                        <i class="bi bi-shield-check me-1"></i>
                        Seller access is restricted to their own products, orders, and data.
                        They cannot view or edit admin-level settings, other sellers, or global configurations.
                    </div>
                </div>
            </div>

            {{-- === SELLER PERMISSIONS DISPLAY === --}}
            <div class="row g-3">
                @foreach ($permissions as $module => $items)
                    @php
                        $isModuleActive = collect($items)->pluck('id')->intersect($assigned)->isNotEmpty();
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                                <div class="fw-bold text-primary text-uppercase small">
                                    {{ $module }}
                                </div>
                                @if ($isModuleActive)
                                    <span class="badge bg-success small">Active</span>
                                @else
                                    <span class="badge bg-secondary small">None</span>
                                @endif
                            </div>

                            <div class="card-body py-2 px-3 small">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($items as $perm)
                                        <li class="d-flex align-items-center gap-2 mb-1">
                                            <i
                                                class="bi {{ in_array($perm->id, $assigned) ? 'bi-check-circle text-success' : 'bi-x-circle text-muted' }}"></i>
                                            <span class="{{ in_array($perm->id, $assigned) ? '' : 'text-muted' }}">
                                                {{ $perm->name }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- ===============================
                 NORMAL ROLE EDIT VIEW (DEFAULT)
            ================================= --}}
            {{-- <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    @foreach ($permissions as $module => $items)
                        @php
                            $moduleSlug = Str::slug($module, '-');
                            $isModuleActive = collect($items)->pluck('id')->intersect($assigned)->isNotEmpty();
                        @endphp

                        <div class="col-md-6 col-xl-4">
                            <div class="card border-0 shadow-sm rounded-3 h-100">
                                <div
                                    class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                                    <div class="fw-bold text-primary text-uppercase small">
                                        {{ $module }}
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input type="checkbox" class="form-check-input master-toggle"
                                            data-target=".group-{{ $moduleSlug }}" {{ $isModuleActive ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="card-body py-2 px-3 small">
                                    <div class="row g-2">
                                        @foreach ($items as $perm)
                                            <div class="col-6">
                                                <div class="form-check d-flex align-items-center gap-2 small">
                                                    <input type="checkbox"
                                                        class="form-check-input group-{{ $moduleSlug }}"
                                                        id="perm{{ $perm->id }}" name="permission_ids[]"
                                                        value="{{ $perm->id }}"
                                                        {{ in_array($perm->id, $assigned) ? 'checked' : '' }}>
                                                    <label for="perm{{ $perm->id }}"
                                                        class="form-check-label text-truncate w-100">
                                                        {{ $perm->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </div>
            </form> --}}
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    @foreach ($modules as $module => $data)
                        @php
                            $moduleSlug = Str::slug($module, '-');
                        @endphp

                        <div class="col-md-6 col-xl-4">
                            <div class="card border-0 shadow-sm rounded-3 h-100">

                                {{-- ===== Module Header ===== --}}
                                <div
                                    class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                                    <div class="fw-bold text-primary text-uppercase small">
                                        {{ $module }}
                                    </div>

                                    <div class="form-check form-switch m-0">
                                        <input type="checkbox" name="module_{{ $moduleSlug }}"
                                            class="form-check-input master-toggle" data-target=".module-{{ $moduleSlug }}"
                                            {{ $data['is_active'] ? 'checked' : '' }}>
                                    </div>
                                </div>

                                {{-- ===== Module Body ===== --}}
                                <div class="card-body py-3 px-3 small">

                                    @foreach ($data['options'] as $opt)
                                        @php
                                            $option = $opt['option'];
                                            $optionSlug = Str::slug($option->slug, '-');
                                            $actions = $opt['actions'];
                                        @endphp

                                        {{-- Option Checkbox --}}
                                        <div class="form-check d-flex align-items-center gap-2 small mb-1">
                                            <input type="checkbox"
                                                class="form-check-input module-{{ $moduleSlug }} option-toggle"
                                                data-actions=".actions-{{ $optionSlug }}" id="perm{{ $option->id }}"
                                                name="permission_ids[]" value="{{ $option->id }}"
                                                {{ in_array($option->id, $assigned) ? 'checked' : '' }}>
                                            <label for="perm{{ $option->id }}"
                                                class="form-check-label fw-semibold text-secondary">
                                                {{ $option->name }}
                                            </label>
                                        </div>

                                        {{-- Actions under this Option --}}
                                        @if ($actions->count())
                                            <div class="ms-4 mb-3 actions-{{ $optionSlug }}">
                                                @foreach ($actions as $action)
                                                    <div class="form-check d-flex align-items-center gap-2 small mb-1">
                                                        <input type="checkbox"
                                                            class="form-check-input module-{{ $moduleSlug }} action-checkbox"
                                                            data-parent="#perm{{ $option->id }}"
                                                            id="perm{{ $action->id }}" name="permission_ids[]"
                                                            value="{{ $action->id }}"
                                                            {{ in_array($action->id, $assigned) ? 'checked' : '' }}>
                                                        <label for="perm{{ $action->id }}" class="form-check-label">
                                                            {{ $action->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 0.6rem;
            font-size: 0.9rem;
        }

        .card-header {
            border-bottom: 1px solid #eee;
        }

        .form-check-input {
            width: 1em;
            height: 1em;
        }

        .form-check-label {
            font-size: 0.85rem;
        }

        .card-body {
            line-height: 1.4;
        }

        .text-truncate {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .form-check-input:indeterminate {
            background-color: #ffc107;
            border-color: #ffc107;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const updateModuleState = (moduleSlug) => {
                const allChecks = document.querySelectorAll(`.module-${moduleSlug}`);
                const master = document.querySelector(`[name="module_${moduleSlug}"]`);
                const total = allChecks.length;
                const checkedCount = Array.from(allChecks).filter(chk => chk.checked).length;
                master.checked = checkedCount > 0;
                master.indeterminate = (checkedCount > 0 && checkedCount < total);
            };

            document.querySelectorAll('.master-toggle').forEach(master => {
                master.addEventListener('change', () => {
                    const moduleSlug = master.dataset.target.replace('.module-', '');
                    const allOptions = document.querySelectorAll(
                        `.module-${moduleSlug}.option-toggle`);
                    const allActions = document.querySelectorAll(
                        `.module-${moduleSlug}.action-checkbox`);
                    if (master.checked) {
                        allOptions.forEach(opt => opt.checked = true);
                        allActions.forEach(act => act.checked = false);
                    } else {
                        allOptions.forEach(opt => opt.checked = false);
                        allActions.forEach(act => act.checked = false);
                    }
                    updateModuleState(moduleSlug);
                });
            });

            document.querySelectorAll('.option-toggle').forEach(option => {
                option.addEventListener('change', () => {
                    const actionsSelector = option.dataset.actions;
                    const moduleSlug = option.classList.value.match(/module-([^\s]+)/)[1];
                    const actions = document.querySelectorAll(actionsSelector +
                        ' .action-checkbox');
                    if (!option.checked) actions.forEach(a => a.checked = false);
                    const master = document.querySelector(`[name="module_${moduleSlug}"]`);
                    if (master) master.checked = Array.from(document.querySelectorAll(
                        `.module-${moduleSlug}.option-toggle`)).some(opt => opt.checked);
                    updateModuleState(moduleSlug);
                });
            });

            document.querySelectorAll('.action-checkbox').forEach(action => {
                action.addEventListener('change', () => {
                    const parentId = action.dataset.parent.replace('#', '');
                    const parentOption = document.getElementById(parentId);
                    const moduleSlug = action.classList.value.match(/module-([^\s]+)/)[1];
                    if (action.checked) {
                        parentOption.checked = true;
                        const master = document.querySelector(`[name="module_${moduleSlug}"]`);
                        if (master) master.checked = true;
                    } else {
                        const actionsContainer = parentOption.dataset.actions;
                        const actions = document.querySelectorAll(actionsContainer +
                            ' .action-checkbox');
                        const stillChecked = Array.from(actions).some(a => a.checked);
                        parentOption.checked = stillChecked;
                    }
                    updateModuleState(moduleSlug);
                });
            });

            document.querySelectorAll('.master-toggle').forEach(master => {
                const moduleSlug = master.dataset.target.replace('.module-', '');
                updateModuleState(moduleSlug);
            });

        });
    </script>
@endpush
