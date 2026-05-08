@extends('admin.layouts.admin')

@section('title', 'Payment Settings')

{{-- @push('styles')
    <style>
        /* Page wrapper */
        .settings-wrapper {
            min-height: calc(100vh - 120px);
            background: #f5f7fb;
        }

        /* Layout columns */
        .settings-left {
            padding: 1rem;
        }

        /* Left nav card */
        .settings-nav-card {
            border-radius: 0.9rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .settings-nav-header {
            padding: .8rem 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, .04);
            background: linear-gradient(180deg, rgba(255, 255, 255, .6), rgba(245, 247, 251, .6));
        }

        .settings-nav-search-wrap {
            display: flex;
            gap: .5rem;
            align-items: center;
        }

        .settings-nav-search {
            flex: 1;
            padding: .46rem .65rem;
            border-radius: .5rem;
            border: 1px solid #e3e6ee;
            font-size: .92rem;
        }

        .settings-nav-clear {
            background: transparent;
            border: 0;
            font-size: .95rem;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            color: #6b7280;
        }

        .settings-nav-clear:hover {
            background: rgba(0, 0, 0, .04);
            color: #111827;
        }

        .settings-nav {
            padding: .6rem 1rem 1rem;
        }

        .settings-nav .list-group-item {
            cursor: pointer;
            border-radius: .6rem;
            border: 0;
            font-size: .96rem;
            padding: .9rem;
            display: flex;
            gap: .6rem;
            transition: all .14s ease;
            background: transparent;
        }

        .settings-nav .list-group-item .label {
            font-weight: 600;
            display: block;
            line-height: 1;
        }

        .settings-nav .list-group-item small {
            font-size: .72rem;
            color: #778496;
            margin-top: .15rem;
            font-weight: 500;
        }

        .settings-nav .list-group-item:hover {
            background: #f1f3f7;
            transform: translateX(2px);
        }

        .settings-nav .list-group-item.active {
            background: linear-gradient(90deg, rgba(13, 110, 253, .08), rgba(13, 110, 253, .02));
            color: #0d47a1;
            border-left: 3px solid #0d6efd;
            box-shadow: inset 0 0 0 1px rgba(13, 110, 253, .02);
            font-weight: 700;
        }

        .settings-right {
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        .settings-right-inner {
            height: calc(100vh - 200px);
            overflow-y: auto;
            padding-right: 6px;
            -webkit-overflow-scrolling: touch;
            position: relative;
        }

        .settings-section {
            scroll-margin-top: 8px;
        }

        .settings-section.card {
            border-radius: .75rem;
            border: 1px solid #e3e6ee;
            transition: all .22s ease;
            transform-origin: 50% 0%;
            background: white;
        }

        .settings-section .card-body {
            padding: 1.35rem 1.4rem;
        }

        .settings-section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: .8rem;
        }

        .settings-section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #202633;
        }

        .settings-section-subtitle {
            font-size: .82rem;
            color: #7a8596;
        }

        .settings-section-divider {
            border-top: 1px dashed #e0e3eb;
            margin: .8rem 0 1.2rem;
        }

        .settings-section .form-label {
            font-size: .85rem;
            font-weight: 600;
            color: #343a40;
        }

        .settings-section small.text-muted {
            font-size: .75rem;
        }

        /* Loader wrapper */
        .settings-loading {
            position: absolute;
            top: 35%;
            left: 0;
            right: 0;
            z-index: 40;
            display: none;
            text-align: center;
            opacity: 0;
            transform: translateY(6px) scale(0.96);
            transition: opacity .18s ease, transform .18s ease;
        }

        .settings-loading.is-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .settings-loading .spinner {
            width: 42px;
            height: 42px;
            border: 4px solid #d0d7e4;
            border-top-color: #0d6efd;
            border-radius: 50%;
            animation: spin .75s linear infinite;
            margin: auto;
            opacity: .95;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .no-results {
            display: none;
            padding: 2rem 1rem;
            color: #6b7280;
            font-size: .95rem;

            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem;
        }

        .no-results-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: .2rem;
            color: #374151;
        }

        .no-results-hint {
            font-size: .9rem;
            color: #6b7280;
            margin-bottom: .2rem;
            max-width: 520px;
            text-align: center;
        }

        .no-results-suggestions {
            margin-top: 1rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: .5rem;
        }

        .no-results-chip {
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: .18rem .65rem;
            font-size: .78rem;
            background: #f9fafb;
            cursor: pointer;
            transition: background .16s ease, border-color .16s ease, transform .12s ease;
        }

        .no-results-chip:hover {
            background: #eef2ff;
            border-color: #c7d2fe;
            transform: translateY(-1px);
        }

        /* Manage button: professional, no border */
        .btn-section-manage {
            min-width: 92px;
            display: inline-flex;
            gap: .45rem;
            align-items: center;
            background: transparent;
            border: 0;
            padding: .28rem .6rem;
            color: #0d6efd;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-section-manage:focus {
            outline: 2px solid rgba(13, 110, 253, 0.12);
            border-radius: 8px;
        }

        .section-actions {
            display: flex;
            gap: .5rem;
            align-items: center;
        }

        /* view-mode summary styles */
        .view-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: .75rem;
        }

        .view-row {
            background: #fbfdff;
            padding: .6rem .75rem;
            border-radius: .5rem;
            border: 1px solid #eef3fb;
            font-size: .95rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .6rem;
        }

        .view-row .label {
            display: block;
            font-size: .78rem;
            color: #6b7280;
            margin-bottom: 0.12rem;
            font-weight: 600;
        }

        .view-row .value {
            font-weight: 600;
            color: #202633;
            word-break: break-word;
            margin-right: 12px;
        }

        /* Toggle switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #e6eefc;
            border-radius: 999px;
            transition: .18s ease;
            box-shadow: inset 0 0 0 1px rgba(13, 110, 253, 0.06);
        }

        .slider::after {
            content: "";
            position: absolute;
            height: 20px;
            width: 20px;
            left: 3px;
            top: 3px;
            background: white;
            border-radius: 50%;
            transition: .18s ease;
            box-shadow: 0 2px 6px rgba(20, 25, 40, 0.06);
        }

        .switch input:checked+.slider {
            background-color: #0d6efd;
            box-shadow: inset 0 0 0 1px rgba(13, 110, 253, .05);
        }

        .switch input:checked+.slider::after {
            transform: translateX(18px);
        }

        .switch[aria-disabled="true"] {
            opacity: .6;
            pointer-events: none;
        }

        /* small spinner for toggles */
        .tiny-spinner {
            width: 14px;
            height: 14px;
            border: 2px solid #e6eefc;
            border-top-color: #0d6efd;
            border-radius: 50%;
            animation: spin .8s linear infinite;
            display: inline-block;
        }

        .edit-mode {
            display: none;
        }

        .settings-section.is-editing .edit-mode {
            display: block;
        }

        /* inline action bar styling */
        .inline-action-bar {
            margin-top: .8rem;
        }

        .section-alert {
            margin-top: .6rem;
            display: none;
        }

        .invalid-feedback-custom {
            color: #d9534f;
            font-size: .85rem;
            margin-top: .28rem;
            display: none;
        }

        @media (max-width:991.98px) {
            .settings-nav-card {
                height: auto;
            }

            .settings-right-inner {
                height: auto;
            }
        }

        /* small toast (top-right) */
        .settings-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
            display: none;
            min-width: 220px;
            border-radius: 8px;
            box-shadow: 0 6px 24px rgba(15, 23, 42, .12);
            padding: .7rem 1rem;
            background: #0d6efd;
            color: white;
        }

        .settings-toast.success {
            background: #198754;
        }

        .settings-toast.error {
            background: #dc3545;
        }
    </style>
@endpush --}}

@section('content')
    <div class="container-fluid py-3 settings-wrapper">
        <input type="hidden" id="__csrf" value="{{ csrf_token() }}">

        <div class="row gx-4">
            {{-- Left: Settings nav --}}
            <div class="col-md-4 col-lg-3 settings-left">
                <div class="card shadow-sm settings-nav-card">
                    <div class="settings-nav-header d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0" style="font-size:1rem; font-weight:700;">Payment Settings</h5>
                                <small class="text-muted">Quick jump to sections</small>
                            </div>
                            <div>
                                <span class="badge bg-light text-muted">v1</span>
                            </div>
                        </div>

                        <div class="mt-2 settings-nav-search-wrap">
                            <input id="settingsNavSearch" class="settings-nav-search" type="search"
                                placeholder="Search settings (min 6 chars)...">
                            <button type="button" id="settingsNavClear" class="settings-nav-clear" title="Clear search"
                                aria-label="Clear search" hidden></button>
                        </div>
                    </div>

                    <div class="list-group list-group-flush settings-nav" id="settingsNavList" role="tablist"
                        aria-label="Settings navigation">
                        <button type="button" class="list-group-item list-group-item-action active"
                            data-target="#section-payout" tabindex="0" role="tab" aria-controls="section-payout">
                            <div><span class="label">Seller Payout</span><small>RazorpayX timing</small></div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" data-target="#section-refund"
                            tabindex="0" role="tab" aria-controls="section-refund">
                            <div><span class="label">Refund Handling</span><small>Refund and approval</small></div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-target="#section-disputes" tabindex="0" role="tab" aria-controls="section-disputes">
                            <div><span class="label">Disputes & Hold</span><small>Payout hold rules</small></div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" data-target="#section-tax"
                            tabindex="0" role="tab" aria-controls="section-tax">
                            <div><span class="label">Tax Settings (GST)</span><small>Commission GST</small></div>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Right: Settings content --}}
            <div class="col-md-8 col-lg-9 settings-right">
                <div class="settings-right-inner" id="settingsRightInner" tabindex="0" aria-live="polite">

                    {{-- Seller Payout --}}
                    <div id="section-payout" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-payout" data-section="payout">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-payout" class="settings-section-title">Seller Payout</div>
                                    <div class="settings-section-subtitle">Control when and how seller balances are
                                        released
                                        via RazorpayX.</div>
                                </div>

                                <div class="section-actions">
                                    <button type="button" class="btn-section-manage" aria-label="Manage Payout"
                                        title="Manage Payout">
                                        <span class="icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                                                stroke="currentColor" stroke-width="1.4" stroke-linecap="round"
                                                stroke-linejoin="round" focusable="false">
                                                <circle cx="12" cy="12" r="3.5"></circle>
                                            </svg>
                                        </span>
                                        Manage
                                    </button>
                                </div>
                            </div>

                            <div class="settings-section-divider"></div>

                            {{-- VIEW --}}
                            <div class="view-mode">
                                <div class="view-grid">
                                    <div class="view-row" data-key="auto_payout_enabled" data-type="bool">
                                        <div>
                                            <div class="label">Enable Auto Payout</div>
                                            <div class="value">
                                                {{ isset($settings['auto_payout_enabled']) && $settings['auto_payout_enabled'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Enable Auto Payout">
                                                <input type="checkbox" class="toggle-switch" data-for="auto_payout_enabled"
                                                    data-active="1" data-inactive="0"
                                                    {{ isset($settings['auto_payout_enabled']) && $settings['auto_payout_enabled'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="auto_payout_delay_days">
                                        <div>
                                            <div class="label">Auto Payout Delay (days)</div>
                                            <div class="value">{{ $settings['auto_payout_delay_days'] ?? '7' }}</div>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="minimum_payout_threshold">
                                        <div>
                                            <div class="label">Minimum Payout Threshold (₹)</div>
                                            <div class="value">{{ $settings['minimum_payout_threshold'] ?? '1000' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- EDIT --}}
                            <form class="edit-mode section-form mt-2" data-section="payout">
                                <div class="mb-3">
                                    <label class="form-label">Enable Auto Payout</label>
                                    <div>
                                        <input type="checkbox" name="auto_payout_enabled" value="1"
                                            {{ old('auto_payout_enabled', $settings['auto_payout_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="invalid-feedback-custom" data-error-for="auto_payout_enabled"></div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Auto Payout Delay (days)</label>
                                        <input type="number" name="auto_payout_delay_days" class="form-control"
                                            min="0" max="365"
                                            value="{{ old('auto_payout_delay_days', $settings['auto_payout_delay_days'] ?? '7') }}">
                                        <div class="invalid-feedback-custom" data-error-for="auto_payout_delay_days">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Minimum Payout Threshold (₹)</label>
                                        <input type="number" step="0.01" name="minimum_payout_threshold"
                                            class="form-control" min="0"
                                            value="{{ old('minimum_payout_threshold', $settings['minimum_payout_threshold'] ?? '1000') }}">
                                        <div class="invalid-feedback-custom" data-error-for="minimum_payout_threshold">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light btn-sm btn-section-cancel">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm btn-section-save">
                                        <span class="save-text">Save</span>
                                        <span class="save-spinner" style="display:none; margin-left:8px;">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="alert alert-success section-alert" role="alert" style="display:none;">
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Refund Handling --}}
                    <div id="section-refund" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-refund" data-section="refund">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-refund" class="settings-section-title">Refund Handling</div>
                                    <div class="settings-section-subtitle">Decide whether refunds are automatic or require
                                        admin approval.</div>
                                </div>

                                <div class="section-actions">
                                </div>
                            </div>

                            <div class="settings-section-divider"></div>

                            <div class="view-mode">
                                <div class="view-grid">
                                    <div class="view-row" data-key="auto_refund_on_order_rejection" data-type="bool">
                                        <div>
                                            <div class="label">Auto-refund when order is rejected/cancelled</div>
                                            <div class="value">
                                                {{ isset($settings['auto_refund_on_order_rejection']) && $settings['auto_refund_on_order_rejection'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Auto refund on order rejection">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="auto_refund_on_order_rejection" data-active="1"
                                                    data-inactive="0"
                                                    {{ isset($settings['auto_refund_on_order_rejection']) && $settings['auto_refund_on_order_rejection'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="refund_needs_admin_approval" data-type="bool">
                                        <div>
                                            <div class="label">Refund requires admin approval</div>
                                            <div class="value">
                                                {{ isset($settings['refund_needs_admin_approval']) && $settings['refund_needs_admin_approval'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Refund requires admin approval">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="refund_needs_admin_approval" data-active="1"
                                                    data-inactive="0"
                                                    {{ isset($settings['refund_needs_admin_approval']) && $settings['refund_needs_admin_approval'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- no edit-mode form for refund (toggles only) --}}
                        </div>
                    </div>

                    {{-- Disputes & Hold --}}
                    <div id="section-disputes" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-disputes" data-section="disputes">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-disputes" class="settings-section-title">Disputes & Payout Hold</div>
                                    <div class="settings-section-subtitle">Control what happens to seller payouts when a
                                        dispute or complaint is raised.</div>
                                </div>

                                <div class="section-actions">
                                    <button type="button" class="btn-section-manage" aria-label="Manage Disputes"
                                        title="Manage Disputes">
                                        <span class="icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                                                stroke="currentColor" stroke-width="1.4" stroke-linecap="round"
                                                stroke-linejoin="round" focusable="false">
                                                <circle cx="12" cy="12" r="3.5"></circle>
                                            </svg>
                                        </span>
                                        Manage
                                    </button>
                                </div>
                            </div>

                            <div class="settings-section-divider"></div>

                            <div class="view-mode">
                                <div class="view-grid">
                                    <div class="view-row" data-key="hold_payout_on_dispute" data-type="bool">
                                        <div>
                                            <div class="label">Hold seller payout if dispute exists</div>
                                            <div class="value">
                                                {{ isset($settings['hold_payout_on_dispute']) && $settings['hold_payout_on_dispute'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Hold payout on dispute">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="hold_payout_on_dispute" data-active="1" data-inactive="0"
                                                    {{ isset($settings['hold_payout_on_dispute']) && $settings['hold_payout_on_dispute'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="dispute_hold_duration_days">
                                        <div>
                                            <div class="label">Dispute Hold Duration (days)</div>
                                            <div class="value">{{ $settings['dispute_hold_duration_days'] ?? '7' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form class="edit-mode section-form mt-2" data-section="disputes">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="hold_payout_on_dispute_edit" id="hold_payout_on_dispute_edit"
                                                value="1"
                                                {{ old('hold_payout_on_dispute', $settings['hold_payout_on_dispute'] ?? '1') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hold_payout_on_dispute_edit">Hold seller
                                                payout if dispute exists</label>
                                        </div>
                                        <div class="invalid-feedback-custom" data-error-for="hold_payout_on_dispute">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Dispute Hold Duration (days)</label>
                                        <input type="number" name="dispute_hold_duration_days" class="form-control"
                                            min="0" max="365"
                                            value="{{ old('dispute_hold_duration_days', $settings['dispute_hold_duration_days'] ?? '7') }}">
                                        <div class="invalid-feedback-custom" data-error-for="dispute_hold_duration_days">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light btn-sm btn-section-cancel">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm btn-section-save">
                                        <span class="save-text">Save</span>
                                        <span class="save-spinner" style="display:none; margin-left:8px;">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="alert alert-success section-alert" role="alert" style="display:none;">
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tax Settings (GST) --}}
                    <div id="section-tax" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-tax" data-section="tax">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-tax" class="settings-section-title">Tax Settings (GST)</div>
                                    <div class="settings-section-subtitle">Configure how GST is applied on platform
                                        commission for seller invoices.</div>
                                </div>
                                <div class="section-actions">
                                    <button type="button" class="btn-section-manage" aria-label="Manage Tax"
                                        title="Manage Tax">
                                        <span class="icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                                                stroke="currentColor" stroke-width="1.4" stroke-linecap="round"
                                                stroke-linejoin="round" focusable="false">
                                                <circle cx="12" cy="12" r="3.5"></circle>
                                            </svg>
                                        </span>
                                        Manage
                                    </button>
                                </div>
                            </div>

                            <div class="settings-section-divider"></div>

                            <div class="view-mode">
                                <div class="view-grid">
                                    <div class="view-row" data-key="deduct_gst_on_commission" data-type="bool">
                                        <div>
                                            <div class="label">Apply GST on platform commission</div>
                                            <div class="value">
                                                {{ isset($settings['deduct_gst_on_commission']) && $settings['deduct_gst_on_commission'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Apply GST on commission">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="deduct_gst_on_commission" data-active="1" data-inactive="0"
                                                    {{ isset($settings['deduct_gst_on_commission']) && $settings['deduct_gst_on_commission'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="platform_gst_percent">
                                        <div>
                                            <div class="label">Platform GST %</div>
                                            <div class="value">
                                                {{ isset($settings['platform_gst_percent']) ? $settings['platform_gst_percent'] : '0' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form class="edit-mode section-form mt-2" data-section="tax">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="deduct_gst_on_commission_edit" id="deduct_gst_on_commission_edit"
                                                value="1"
                                                {{ old('deduct_gst_on_commission', $settings['deduct_gst_on_commission'] ?? '1') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="deduct_gst_on_commission_edit">Apply GST
                                                on platform commission</label>
                                        </div>
                                        <div class="invalid-feedback-custom" data-error-for="deduct_gst_on_commission">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Platform GST %</label>
                                        <input type="number" step="0.01" min="0" max="28"
                                            name="platform_gst_percent" class="form-control"
                                            value="{{ old('platform_gst_percent', $settings['platform_gst_percent'] ?? '18') }}">
                                        <div class="invalid-feedback-custom" data-error-for="platform_gst_percent"></div>
                                    </div>
                                </div>

                                <div class="mt-3 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light btn-sm btn-section-cancel">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm btn-section-save">
                                        <span class="save-text">Save</span>
                                        <span class="save-spinner" style="display:none; margin-left:8px;">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="alert alert-success section-alert" role="alert" style="display:none;">
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- End scrollable content --}}
                </div>

                <div class="mt-3 text-muted small"><small>Changes are saved per-section. Toggle switches save instantly;
                        use Manage to edit full forms.</small></div>
            </div>
        </div>
    </div>

    {{-- Toast --}}
    <div id="settingsToast" class="settings-toast" role="status" aria-live="polite"></div>
    <input type="hidden" id="__post_url" value="{{ route('admin.settings.payments.update') }}">

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/setting-general-payment.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/settings.js') }}" defer></script>
    @endpush
@endsection

{{-- Optmizied version --}}

{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const POST_URL = "{{ route('admin.settings.payments.update') }}";
            const csrfToken = document.getElementById('__csrf')?.value || '{{ csrf_token() }}';

            // cached nodes
            const rightInner = document.getElementById('settingsRightInner');
            const navItems = Array.from(document.querySelectorAll('#settingsNavList .list-group-item'));
            const sections = Array.from(rightInner.querySelectorAll('.settings-section'));
            const searchInput = document.getElementById('settingsNavSearch');
            const clearBtn = document.getElementById('settingsNavClear');
            const toast = document.getElementById('settingsToast');
            const MIN_SEARCH_CHARS = 6;
            const DEBOUNCE_MS = 200;

            /* ---------- small utilities ---------- */
            const showToast = (msg, type = 'success', ms = 2800) => {
                toast.textContent = msg;
                toast.className = 'settings-toast ' + (type === 'success' ? 'success' : 'error');
                toast.style.display = 'block';
                // fade in
                setTimeout(() => toast.style.opacity = '1', 10);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.style.display = 'none', 220);
                }, ms);
            };

            const ajaxSubmit = async (payload) => {
                try {
                    const res = await fetch(POST_URL, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });
                    const isJson = res.headers.get('content-type')?.includes('application/json');
                    return {
                        ok: res.ok,
                        status: res.status,
                        data: isJson ? await res.json() : null
                    };
                } catch (err) {
                    console.error('ajaxSubmit', err);
                    return {
                        ok: false,
                        status: 0,
                        data: null,
                        error: err
                    };
                }
            };

            const scrollToSection = (target) => {
                const rect = target.getBoundingClientRect();
                const cont = rightInner.getBoundingClientRect();
                const y = (rect.top - cont.top) + rightInner.scrollTop;
                rightInner.scrollTo({
                    top: Math.max(0, Math.floor(y)),
                    behavior: 'smooth'
                });
            };

            /* ---------- loading + no-results nodes ---------- */
            const noResultsNode = document.createElement('div');
            noResultsNode.className = 'no-results';
            noResultsNode.innerHTML = `
        <div class="no-results-title">No results found</div>
        <div class="no-results-hint">Try different keywords or open one of these sections:</div>
        <div class="no-results-suggestions" id="noResultsSuggestions"></div>`;
            noResultsNode.style.display = 'none';
            rightInner.appendChild(noResultsNode);
            const suggestionsContainer = noResultsNode.querySelector('#noResultsSuggestions');

            const buildSuggestionChips = () => {
                suggestionsContainer.innerHTML = '';
                navItems.forEach(item => {
                    const label = item.querySelector('.label')?.textContent?.trim();
                    const target = item.getAttribute('data-target');
                    if (!label || !target) return;
                    const chip = document.createElement('button');
                    chip.type = 'button';
                    chip.className = 'no-results-chip';
                    chip.textContent = label;
                    chip.setAttribute('data-target', target);
                    suggestionsContainer.appendChild(chip);
                });
            };
            buildSuggestionChips();

            const loadingNode = document.createElement('div');
            loadingNode.className = 'settings-loading';
            loadingNode.innerHTML = `<div class="spinner" role="status" aria-hidden="true"></div>`;
            loadingNode.style.display = 'none';
            rightInner.appendChild(loadingNode);

            let loadingTimer = null;
            const MIN_VISIBLE_MS = 220;
            const showLoading = () => {
                if (loadingTimer) clearTimeout(loadingTimer);
                loadingNode.style.display = 'block';
                // force reflow
                void loadingNode.offsetWidth;
                loadingNode.classList.add('is-visible');
                loadingTimer = setTimeout(() => loadingTimer = null, MIN_VISIBLE_MS);
            };
            const hideLoading = () => {
                const hideNow = () => {
                    loadingNode.classList.remove('is-visible');
                    setTimeout(() => loadingNode.style.display = 'none', 120);
                };
                if (loadingTimer) {
                    setTimeout(() => {
                        loadingTimer = null;
                        hideNow();
                    }, MIN_VISIBLE_MS);
                } else hideNow();
            };

            /* ---------- nav / scrollspy ---------- */
            navItems.forEach(item => item.addEventListener('click', () => {
                const target = document.querySelector(item.getAttribute('data-target'));
                if (!target) return;
                scrollToSection(target);
                navItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            }));

            let ticking = false;
            rightInner.addEventListener('scroll', () => {
                if (ticking) return;
                window.requestAnimationFrame(() => {
                    const containerRect = rightInner.getBoundingClientRect();
                    let best = {
                        score: Infinity,
                        id: null
                    };
                    sections.forEach(sec => {
                        const rect = sec.getBoundingClientRect();
                        const dist = Math.abs(rect.top - containerRect.top);
                        if ((rect.top <= containerRect.top + 8) && dist < best.score) {
                            best = {
                                score: dist,
                                id: '#' + sec.id
                            };
                        }
                    });
                    if (best.id) {
                        navItems.forEach(item => item.classList.toggle('active', item.getAttribute(
                            'data-target') === best.id));
                    }
                    ticking = false;
                });
                ticking = true;
            });

            /* ---------- Search (debounced) ---------- */
            let searchTimer = null;
            const resetSearchView = () => {
                sections.forEach(s => s.style.display = '');
                navItems.forEach(i => i.style.display = '');
                noResultsNode.style.display = 'none';
            };

            const performSearch = (raw) => {
                const q = (raw || '').trim().toLowerCase();
                clearBtn.hidden = !q.length;
                if (!q.length || q.length < MIN_SEARCH_CHARS) {
                    resetSearchView();
                    hideLoading();
                    rightInner.dataset.searching = "0";
                    return;
                }
                rightInner.dataset.searching = "1";
                showLoading();

                let visibleCount = 0,
                    firstMatchSection = null;
                sections.forEach(section => {
                    const ok = section.innerText.toLowerCase().includes(q);
                    section.style.display = ok ? '' : 'none';
                    if (ok) {
                        visibleCount++;
                        if (!firstMatchSection) firstMatchSection = section;
                    }
                });
                navItems.forEach(item => {
                    const label = item.innerText.toLowerCase();
                    item.style.display = label.includes(q) ? '' : 'none';
                });

                if (!visibleCount) {
                    noResultsNode.style.display = 'flex';
                    rightInner.scrollTop = 0;
                    navItems.forEach(i => i.classList.remove('active'));
                } else {
                    noResultsNode.style.display = 'none';
                    if (firstMatchSection) {
                        setTimeout(() => scrollToSection(firstMatchSection), 60);
                        navItems.forEach(i => i.classList.toggle('active', i.getAttribute('data-target') ===
                            `#${firstMatchSection.id}`));
                    }
                }
                hideLoading();
            };

            searchInput.addEventListener('input', () => {
                if (searchTimer) clearTimeout(searchTimer);
                searchTimer = setTimeout(() => performSearch(searchInput.value), DEBOUNCE_MS);
            });

            clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                resetSearchView();
                noResultsNode.style.display = 'none';
                clearBtn.hidden = true;
                searchInput.focus();
            });

            searchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (searchInput.value) {
                        clearBtn.click();
                        e.stopPropagation();
                    }
                }
            });

            noResultsNode.addEventListener('click', (e) => {
                const chip = e.target.closest('.no-results-chip');
                if (!chip) return;
                const targetSelector = chip.getAttribute('data-target');
                const section = document.querySelector(targetSelector);
                if (!section) return;
                searchInput.value = '';
                clearBtn.hidden = true;
                resetSearchView();
                noResultsNode.style.display = 'none';
                scrollToSection(section);
                navItems.forEach(item => item.classList.toggle('active', item.getAttribute(
                    'data-target') === targetSelector));
            });

            /* ---------- inline edit helpers (preserve original semantics) ---------- */
            const findSection = el => el ? el.closest('.settings-section') : null;

            const createActionBar = (sectionEl) => {
                const existing = sectionEl.querySelector('.inline-action-bar');
                if (existing) return existing;
                const bar = document.createElement('div');
                bar.className = 'inline-action-bar mt-3 d-flex justify-content-end gap-2';
                bar.innerHTML = `
            <button type="button" class="btn btn-light btn-sm btn-inline-cancel">Cancel</button>
            <button type="button" class="btn btn-primary btn-sm btn-inline-save">
                <span class="save-text">Save</span>
                <span class="save-spinner" style="display:none; margin-left:8px;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </button>`;
                sectionEl.querySelector('.card-body').appendChild(bar);
                return bar;
            };

            const markInlineFlag = (sectionEl, yes = true) => {
                sectionEl.dataset.inlineEditing = yes ? '1' : '0';
                sectionEl.classList.toggle('inline-active', yes);
            };

            const startInlineEdit = (sectionEl) => {
                if (!sectionEl || sectionEl.dataset.inlineEditing === '1') return;
                markInlineFlag(sectionEl, true);
                const originalMap = {};
                sectionEl._inlineOriginals = originalMap;

                const editForm = sectionEl.querySelector('.edit-mode');
                let candidates = editForm ? Array.from(editForm.querySelectorAll('[name]')) : [];

                if (candidates.length === 0) {
                    const rows = Array.from(sectionEl.querySelectorAll('.view-row'));
                    rows.forEach(r => {
                        const key = r.getAttribute('data-key');
                        if (!key) return;
                        const hasToggle = !!r.querySelector('.toggle-switch');
                        if (!hasToggle) candidates.push({
                            name: key,
                            tagName: 'INPUT',
                            type: 'text'
                        });
                    });
                }

                const mapByName = {};
                if (editForm) Array.from(editForm.querySelectorAll('[name]')).forEach(inp => mapByName[inp
                    .name] = inp);

                candidates.forEach(candidate => {
                    const name = candidate.name || candidate.getAttribute?.('name');
                    if (!name) return;
                    const row = sectionEl.querySelector(`.view-row[data-key="${name}"]`);
                    if (!row) return;
                    if (row.querySelector('.toggle-switch')) return;
                    if (row.querySelector('input[name], textarea[name], select[name]')) return;

                    const valNode = row.querySelector('.value');
                    const origText = valNode ? valNode.textContent.trim() : '';
                    originalMap[name] = origText;
                    const src = mapByName[name];
                    let inputEl;
                    if (src) {
                        const tag = src.tagName.toLowerCase();
                        if (tag === 'select') {
                            inputEl = document.createElement('select');
                            inputEl.className = 'form-select form-control';
                            inputEl.name = name;
                            Array.from(src.options).forEach(o => {
                                const opt = document.createElement('option');
                                opt.value = o.value;
                                opt.textContent = o.textContent;
                                if (o.selected) opt.selected = true;
                                inputEl.appendChild(opt);
                            });
                            const selectedOpt = Array.from(inputEl.options).find(o => o.text ===
                                origText || o.value === origText);
                            if (selectedOpt) inputEl.value = selectedOpt.value;
                        } else if (tag === 'textarea') {
                            inputEl = document.createElement('textarea');
                            inputEl.className = 'form-control';
                            inputEl.name = name;
                            inputEl.rows = src.getAttribute('rows') || 2;
                            inputEl.value = origText;
                        } else {
                            inputEl = document.createElement('input');
                            inputEl.className = 'form-control';
                            inputEl.type = src.type || 'text';
                            inputEl.name = name;
                            ['step', 'min', 'max', 'placeholder'].forEach(attr => src.hasAttribute(
                                attr) && inputEl.setAttribute(attr, src.getAttribute(attr)));
                            inputEl.value = origText;
                        }
                    } else {
                        inputEl = document.createElement('input');
                        inputEl.className = 'form-control';
                        inputEl.type = 'text';
                        inputEl.name = name;
                        inputEl.value = origText;
                    }

                    if (valNode) {
                        const wrapper = document.createElement('div');
                        wrapper.style.minWidth = '180px';
                        wrapper.setAttribute('data-created', '1');
                        wrapper.appendChild(inputEl);
                        valNode.replaceWith(wrapper);
                        originalMap[`__node_${name}`] = valNode;
                    } else {
                        const wrapper = document.createElement('div');
                        wrapper.style.minWidth = '180px';
                        wrapper.setAttribute('data-created', '1');
                        wrapper.appendChild(inputEl);
                        row.appendChild(wrapper);
                        originalMap[`__node_${name}`] = null;
                    }
                });

                createActionBar(sectionEl);
                const firstInput = sectionEl.querySelector(
                    '.view-row .form-control, .view-row select, .view-row textarea');
                if (firstInput) firstInput.focus();
            };

            const cancelInlineEdit = (sectionEl, overrideValues = null) => {
                if (!sectionEl) return;
                const originalMap = sectionEl._inlineOriginals || {};

                Object.keys(originalMap).forEach(k => {
                    if (!k.startsWith('__node_')) return;
                    const name = k.replace('__node_', '');
                    const oldNode = originalMap[`__node_${name}`];
                    const row = sectionEl.querySelector(`.view-row[data-key="${name}"]`);
                    if (!row) return;
                    const created = row.querySelector('[data-created="1"]');
                    const newValText = overrideValues && (overrideValues[name] !== undefined) ? String(
                        overrideValues[name]) : (originalMap[name] ?? '');
                    if (oldNode) {
                        if (created) created.replaceWith(oldNode);
                    } else {
                        if (created) {
                            const valDiv = document.createElement('div');
                            valDiv.className = 'value';
                            valDiv.textContent = newValText;
                            created.replaceWith(valDiv);
                        }
                    }
                });

                Array.from(sectionEl.querySelectorAll('.view-row [data-created="1"]')).forEach(n => {
                    const row = n.closest('.view-row');
                    const key = row?.getAttribute('data-key');
                    const valText = overrideValues && (overrideValues[key] !== undefined) ? String(
                        overrideValues[key]) : (originalMap[key] ?? '');
                    const valDiv = document.createElement('div');
                    valDiv.className = 'value';
                    valDiv.textContent = valText;
                    n.replaceWith(valDiv);
                });

                const bar = sectionEl.querySelector('.inline-action-bar');
                if (bar) bar.remove();
                delete sectionEl._inlineOriginals;
                sectionEl.dataset.inlineEditing = '0';
                sectionEl.classList.remove('inline-active', 'is-editing');
            };

            /* ---------- helpers to read inputs & validation ---------- */
            const findInputNode = (sectionEl, key) =>
                sectionEl.querySelector(`[name="${key}"], [name="${key}_edit"]`) ||
                sectionEl.querySelector(
                    `.view-row[data-key="${key}"] [data-created] input[name="${key}"], .view-row[data-key="${key}"] [data-created] textarea[name="${key}"], .view-row[data-key="${key}"] [data-created] select[name="${key}"]`
                );

            const readViewValue = (sectionEl, key) =>
                sectionEl.querySelector(`.view-row[data-key="${key}"] .value`)?.textContent?.trim() ?? '';

            const isValidIntegerAtLeast = (val, min) => {
                if (val === null || val === undefined) return false;
                if (String(val).trim() === '') return false;
                const n = parseInt(String(val).trim(), 10);
                return !isNaN(n) && n >= min;
            };
            const isValidNumberGreaterThan = (val, minExclusive) => {
                if (val === null || val === undefined) return false;
                if (String(val).trim() === '') return false;
                const f = parseFloat(String(val).trim());
                return !isNaN(f) && f > minExclusive;
            };

            /* ---------- collect payload from inline edited view ---------- */
            const collectInlinePayload = (sectionEl) => {
                const payload = {
                    section: sectionEl.dataset.section || ''
                };
                const rows = Array.from(sectionEl.querySelectorAll('.view-row[data-key]'));
                rows.forEach(row => {
                    const key = row.getAttribute('data-key');
                    if (!key) return;
                    const toggle = row.querySelector('.toggle-switch');
                    if (toggle) {
                        payload[key] = toggle.checked ? (toggle.getAttribute('data-active') || '1') : (
                            toggle.getAttribute('data-inactive') || '0');
                        return;
                    }
                    const control = row.querySelector(
                        '[data-created] input[name], [data-created] textarea[name], [data-created] select[name]'
                    ) || row.querySelector('input[name], textarea[name], select[name]');
                    if (control) {
                        if (control.type === 'checkbox') payload[key] = control.checked ? (control
                            .value || '1') : '0';
                        else payload[key] = control.value;
                        return;
                    }
                    const val = row.querySelector('.value')?.textContent?.trim() ?? '';
                    payload[key] = val;
                });
                return payload;
            };

            const applyReturnedValuesToView = (sectionEl, returned = {}) => {
                if (!returned || typeof returned !== 'object') return;
                Object.keys(returned).forEach(k => {
                    const row = sectionEl.querySelector(`.view-row[data-key="${k}"]`);
                    if (!row) return;
                    const rawVal = returned[k];
                    const isBoolRow = row.getAttribute('data-type') === 'bool';
                    let displayStr;
                    if (isBoolRow) {
                        if (rawVal === true || rawVal === '1' || rawVal === 1) displayStr = 'Yes';
                        else if (rawVal === false || rawVal === '0' || rawVal === 0) displayStr = 'No';
                        else displayStr = (rawVal === null || rawVal === undefined) ? '' : String(
                            rawVal);
                    } else {
                        displayStr = (rawVal === null || rawVal === undefined) ? '' : String(rawVal);
                    }
                    const valNode = row.querySelector('.value');
                    if (valNode) valNode.textContent = displayStr;
                    else {
                        const newVal = document.createElement('div');
                        newVal.className = 'value';
                        newVal.textContent = displayStr;
                        row.appendChild(newVal);
                    }

                    const viewToggle = row.querySelector('.toggle-switch');
                    if (viewToggle) {
                        const shouldBeChecked = (String(rawVal) === '1' || rawVal === 1 || rawVal ===
                            true);
                        viewToggle.checked = shouldBeChecked;
                    }

                    const editControl = sectionEl.querySelector(`[name="${k}"], [name="${k}_edit"]`);
                    if (editControl) {
                        if (editControl.type === 'checkbox') editControl.checked = (String(rawVal) ===
                            '1' || rawVal === 1 || rawVal === true);
                        else editControl.value = (rawVal === null || rawVal === undefined) ? '' :
                            String(rawVal);
                    }

                    const createdControl = row.querySelector(
                        '[data-created] input[name], [data-created] textarea[name], [data-created] select[name]'
                    );
                    if (createdControl) {
                        if (createdControl.type === 'checkbox') createdControl.checked = (String(
                            rawVal) === '1' || rawVal === 1 || rawVal === true);
                        else createdControl.value = (rawVal === null || rawVal === undefined) ? '' :
                            String(rawVal);
                    }
                });
            };

            /* ---------- generic ajax result handler to reduce duplication ---------- */
            const handleAjaxResult = async ({
                ok,
                status,
                data
            }, sectionEl, payload, onOkMsg = 'Updated') => {
                if (ok) {
                    const returned = (data && data.updated_settings) ? data.updated_settings : payload;
                    applyReturnedValuesToView(sectionEl, returned);
                    showToast((data && data.message) ? data.message : onOkMsg, 'success');
                    return {
                        ok: true,
                        returned
                    };
                } else if (status === 422 && data) {
                    // validation errors for a form: show in-edit form if present
                    const editForm = sectionEl.querySelector('.edit-mode');
                    if (editForm) {
                        const errors = data.errors || {};
                        Object.keys(errors).forEach(field => {
                            const errNode = editForm.querySelector(
                                `.invalid-feedback-custom[data-error-for="${field}"]`);
                            const input = editForm.querySelector(
                                `[name="${field}"], [name="${field}_edit"]`);
                            if (errNode) {
                                errNode.textContent = Array.isArray(errors[field]) ? errors[field]
                                    .join(' ') : String(errors[field]);
                                errNode.style.display = '';
                            }
                            if (input) input.classList.add('is-invalid');
                        });
                    }
                    showToast((data.message) ? data.message : 'Validation failed. Check inputs.', 'error',
                        4500);
                    return {
                        ok: false,
                        validation: true
                    };
                } else {
                    let msg = 'Failed to save settings.';
                    if (data && data.message) msg = data.message;
                    showToast(msg, 'error', 3500);
                    return {
                        ok: false
                    };
                }
            };

            /* ---------- save inline edit (view-based Save) ---------- */
            const saveInlineEdit = async (sectionEl, saveBtn) => {
                const spinner = sectionEl.querySelector('.save-spinner') || saveBtn.querySelector(
                    '.save-spinner');
                const saveText = saveBtn.querySelector('.save-text');
                if (saveText) saveText.style.display = 'none';
                if (spinner) spinner.style.display = '';
                saveBtn.disabled = true;

                const payload = collectInlinePayload(sectionEl);

                // client-side pre-validation matching server rules
                const section = sectionEl.dataset.section;
                if (section === 'payout' && payload.auto_payout_enabled === '1') {
                    if (!isValidIntegerAtLeast(payload.auto_payout_delay_days, 1)) {
                        showToast('Auto Payout requires delay >= 1 day.', 'error', 4500);
                        spinner && (spinner.style.display = 'none');
                        saveText && (saveText.style.display = '');
                        saveBtn.disabled = false;
                        return;
                    }
                    if (!isValidNumberGreaterThan(payload.minimum_payout_threshold, 0)) {
                        showToast('Minimum payout threshold must be greater than 0.', 'error', 4500);
                        spinner && (spinner.style.display = 'none');
                        saveText && (saveText.style.display = '');
                        saveBtn.disabled = false;
                        return;
                    }
                }
                if (section === 'disputes') {
                    if ((payload.hold_payout_on_dispute === '1' || payload.hold_payout_on_dispute === 1) &&
                        !isValidIntegerAtLeast(payload.dispute_hold_duration_days, 1)) {
                        showToast('When holding payouts on disputes, duration must be at least 1 day.',
                            'error', 4500);
                        spinner && (spinner.style.display = 'none');
                        saveText && (saveText.style.display = '');
                        saveBtn.disabled = false;
                        return;
                    }
                }
                if (section === 'tax') {
                    if ((payload.deduct_gst_on_commission === '1' || payload.deduct_gst_on_commission ===
                            1) && !isValidNumberGreaterThan(payload.platform_gst_percent, 0)) {
                        showToast('When GST is enabled, Platform GST % must be at least 1.', 'error', 4500);
                        spinner && (spinner.style.display = 'none');
                        saveText && (saveText.style.display = '');
                        saveBtn.disabled = false;
                        return;
                    }
                }

                const result = await ajaxSubmit(payload);
                if (result.ok) {
                    const returned = (result.data && result.data.updated_settings) ? result.data
                        .updated_settings : payload;
                    cancelInlineEdit(sectionEl, returned);
                    applyReturnedValuesToView(sectionEl, returned);
                    showToast((result.data && result.data.message) ? result.data.message : 'Settings saved',
                        'success');
                    const editForm = sectionEl.querySelector('.edit-mode');
                    if (editForm) {
                        try {
                            editForm.style.display = 'none';
                        } catch (e) {}
                        Array.from(editForm.querySelectorAll('.is-invalid')).forEach(i => i.classList
                            .remove('is-invalid'));
                        Array.from(editForm.querySelectorAll('.invalid-feedback-custom')).forEach(n => n
                            .style.display = 'none');
                    }
                    sectionEl.dataset.inlineEditing = '0';
                    sectionEl.classList.remove('inline-active', 'is-editing');
                } else if (result.status === 422 && result.data) {
                    // handled by generic handler
                    const errors = result.data.errors || {};
                    const editForm = sectionEl.querySelector('.edit-mode');
                    if (editForm) {
                        Object.keys(errors).forEach(field => {
                            const errNode = editForm.querySelector(
                                `.invalid-feedback-custom[data-error-for="${field}"]`);
                            const input = editForm.querySelector(
                                `[name="${field}"], [name="${field}_edit"]`);
                            if (errNode) {
                                errNode.textContent = Array.isArray(errors[field]) ? errors[field]
                                    .join(' ') : String(errors[field]);
                                errNode.style.display = '';
                            }
                            if (input) input.classList.add('is-invalid');
                        });
                    }
                    showToast((result.data.message) ? result.data.message :
                        'Validation failed. Check inputs.', 'error', 4500);
                } else {
                    let msg = 'Failed to save settings.';
                    if (result.data && result.data.message) msg = result.data.message;
                    showToast(msg, 'error', 3500);
                }

                if (saveText) saveText.style.display = '';
                if (spinner) spinner.style.display = 'none';
                saveBtn.disabled = false;
            };

            /* ---------- Event delegation for Manage / Save / Cancel ---------- */
            document.body.addEventListener('click', (ev) => {
                const manageBtn = ev.target.closest('.btn-section-manage');
                if (manageBtn) {
                    ev.preventDefault();
                    const sec = findSection(manageBtn);
                    if (!sec) return;
                    if (sec.dataset.inlineEditing === '1') cancelInlineEdit(sec);
                    else {
                        startInlineEdit(sec);
                        scrollToSection(sec);
                    }
                    return;
                }

                const inlineCancel = ev.target.closest('.btn-inline-cancel');
                if (inlineCancel) {
                    ev.preventDefault();
                    const sec = findSection(inlineCancel);
                    if (!sec) return;
                    cancelInlineEdit(sec);
                    return;
                }

                const inlineSave = ev.target.closest('.btn-inline-save');
                if (inlineSave) {
                    ev.preventDefault();
                    const sec = findSection(inlineSave);
                    if (!sec) return;
                    saveInlineEdit(sec, inlineSave);
                    return;
                }

                const sectionCancel = ev.target.closest('.btn-section-cancel');
                if (sectionCancel) {
                    ev.preventDefault();
                    const sec = findSection(sectionCancel);
                    if (!sec) return;
                    cancelInlineEdit(sec);
                    return;
                }

                const sectionSave = ev.target.closest('.btn-section-save');
                if (sectionSave) {
                    ev.preventDefault();
                    const sec = findSection(sectionSave);
                    if (!sec) return;
                    const editForm = sec.querySelector('.edit-mode');
                    if (!editForm) return;

                    const formData = new FormData(editForm);
                    const payload = {
                        section: sec.dataset.section || ''
                    };
                    for (const [k, v] of formData.entries()) {
                        const el = editForm.querySelector(`[name="${k}"]`);
                        if (el && el.type === 'checkbox') payload[k.replace(/_edit$/, '')] = el.checked ? (
                            el.value || '1') : '0';
                        else payload[k.replace(/_edit$/, '')] = v;
                    }

                    // client-side validation (same rules)
                    const section = sec.dataset.section;
                    if (section === 'payout' && payload.auto_payout_enabled === '1') {
                        if (!isValidIntegerAtLeast(payload.auto_payout_delay_days, 1)) {
                            showToast('Auto Payout requires delay >= 1 day.', 'error', 4500);
                            return;
                        }
                        if (!isValidNumberGreaterThan(payload.minimum_payout_threshold, 0)) {
                            showToast('Minimum payout threshold must be greater than 0.', 'error', 4500);
                            return;
                        }
                    }
                    if (section === 'disputes') {
                        if ((payload.hold_payout_on_dispute === '1') && !isValidIntegerAtLeast(payload
                                .dispute_hold_duration_days, 1)) {
                            showToast('When holding payouts on disputes, duration must be at least 1 day.',
                                'error', 4500);
                            return;
                        }
                    }
                    if (section === 'tax') {
                        if ((payload.deduct_gst_on_commission === '1') && !isValidNumberGreaterThan(payload
                                .platform_gst_percent, 0)) {
                            showToast('When GST is enabled, Platform GST % must be at least 1.', 'error',
                                4500);
                            return;
                        }
                    }

                    const saveBtn = sectionSave;
                    const spinner = saveBtn.querySelector('.save-spinner');
                    const saveText = saveBtn.querySelector('.save-text');
                    if (saveText) saveText.style.display = 'none';
                    if (spinner) spinner.style.display = '';
                    saveBtn.disabled = true;

                    ajaxSubmit(payload).then(result => handleAjaxResult(result, sec, payload,
                        'Settings saved').then(res => {
                        if (res && res.ok) {
                            const alertNode = sec.querySelector('.section-alert');
                            if (alertNode) alertNode.style.display = 'none';
                        } else if (result.status === 422 && result.data) {
                            // errors handled by handleAjaxResult
                        } else {
                            // generic failure handled
                        }
                        if (saveText) saveText.style.display = '';
                        if (spinner) spinner.style.display = 'none';
                        saveBtn.disabled = false;
                    }));
                    return;
                }
            });

            /* ---------- Toggle switches handler (one central handler) ---------- */

            const revertToggle = (chk, otherToggle, valNode, originalText) => {
                chk.checked = !chk.checked;
                if (otherToggle) otherToggle.checked = !otherToggle.checked;
                if (valNode) valNode.textContent = originalText;
            };

            document.body.addEventListener('change', async (ev) => {
                const chk = ev.target;
                if (!chk.classList || !chk.classList.contains('toggle-switch')) return;
                ev.preventDefault();

                const key = chk.getAttribute('data-for');
                const sectionEl = findSection(chk);
                if (!sectionEl || !key) return;

                const row = sectionEl.querySelector(`.view-row[data-key="${key}"]`);
                if (!row) return;
                const valNode = row.querySelector('.value');
                const originalText = valNode ? valNode.textContent : '';
                if (valNode) valNode.textContent = '...';

                const tiny = document.createElement('span');
                tiny.className = 'tiny-spinner';
                tiny.setAttribute('aria-hidden', 'true');
                chk.parentElement.appendChild(tiny);

                const newVal = chk.checked ? (chk.getAttribute('data-active') ?? '1') : (chk
                    .getAttribute('data-inactive') ?? '0');

                // helper to send payload and handle revert on failure
                const sendPayload = async (payload, revertOnFail = true, onSuccessMsg = 'Updated') => {
                    const res = await ajaxSubmit(payload);
                    const handled = await handleAjaxResult(res, sectionEl, payload,
                        onSuccessMsg);
                    if (!handled.ok && revertOnFail) {
                        // revert UI
                        chk.checked = !chk.checked;
                        if (valNode) valNode.textContent = originalText;
                    }
                    if (tiny && tiny.parentElement) tiny.remove();
                    chk.disabled = false;
                    return handled;
                };

                // SPECIAL: REFUND - ensure exactly one active (flip the other) and submit both keys
                if (sectionEl.dataset.section === 'refund' && (key ===
                        'auto_refund_on_order_rejection' || key === 'refund_needs_admin_approval')) {
                    const otherKey = (key === 'auto_refund_on_order_rejection') ?
                        'refund_needs_admin_approval' : 'auto_refund_on_order_rejection';
                    const otherToggle = sectionEl.querySelector(
                        `.view-row[data-key="${otherKey}"] .toggle-switch`);
                    if (otherToggle) otherToggle.checked = (newVal === '1') ? false : true;

                    const payload = {
                        section: sectionEl.dataset.section || '',
                        [key]: newVal
                    };
                    payload[otherKey] = otherToggle ? (otherToggle.checked ? (otherToggle.getAttribute(
                        'data-active') ?? '1') : (otherToggle.getAttribute('data-inactive') ??
                        '0')) : (newVal === '1' ? '0' : '1');

                    const result = await ajaxSubmit(payload);
                    if (result.ok) {
                        const returned = (result.data && result.data.updated_settings) ? result.data
                            .updated_settings : payload;
                        applyReturnedValuesToView(sectionEl, returned);
                        showToast((result.data && result.data.message) ? result.data.message :
                            'Updated', 'success');
                    } else {
                        // revert toggles
                        chk.checked = !chk.checked;
                        if (otherToggle) otherToggle.checked = !otherToggle.checked;
                        if (valNode) valNode.textContent = originalText;
                        let msg = 'Failed to update setting';
                        if (result.data && result.data.message) msg = result.data.message;
                        showToast(msg, 'error', 3500);
                    }
                    if (tiny && tiny.parentElement) tiny.remove();
                    chk.disabled = false;
                    return;
                }

                // PAYOUT: enabling requires delay >=1 and threshold >0 -> include both in payload when enabling
                if (sectionEl.dataset.section === 'payout' && key === 'auto_payout_enabled') {
                    const tryingEnable = (newVal === (chk.getAttribute('data-active') ?? '1'));
                    if (tryingEnable) {
                        const delayNode = findInputNode(sectionEl, 'auto_payout_delay_days');
                        const threshNode = findInputNode(sectionEl, 'minimum_payout_threshold');

                        let delayVal = delayNode ? delayNode.value : readViewValue(sectionEl,
                            'auto_payout_delay_days');
                        let threshVal = threshNode ? threshNode.value : readViewValue(sectionEl,
                            'minimum_payout_threshold');

                        delayVal = String(delayVal ?? '').trim();
                        threshVal = String(threshVal ?? '').trim();

                        if (!isValidIntegerAtLeast(delayVal, 1) || !isValidNumberGreaterThan(threshVal,
                                0)) {
                            chk.checked = false;
                            if (valNode) valNode.textContent = originalText;
                            showToast(
                                'To enable Auto Payout you must set: delay >= 1 day and minimum payout threshold > 0.',
                                'error', 4800);
                            if (tiny && tiny.parentElement) tiny.remove();
                            chk.disabled = false;
                            if (!isValidIntegerAtLeast(delayVal, 1) && delayNode) delayNode.focus();
                            else if (!isValidNumberGreaterThan(threshVal, 0) && threshNode) threshNode
                                .focus();
                            return;
                        }

                        const payload = {
                            section: sectionEl.dataset.section || '',
                            auto_payout_enabled: newVal,
                            auto_payout_delay_days: delayVal,
                            minimum_payout_threshold: threshVal
                        };
                        await sendPayload(payload);
                        return;
                    } else {
                        // disabling allowed independently
                        const payload = {
                            section: sectionEl.dataset.section || '',
                            auto_payout_enabled: newVal
                        };
                        await sendPayload(payload);
                        return;
                    }
                }

                // DISPUTES: enabling requires dispute_hold_duration_days >=1
                if (sectionEl.dataset.section === 'disputes' && key === 'hold_payout_on_dispute') {
                    const tryingEnable = (newVal === (chk.getAttribute('data-active') ?? '1'));
                    if (tryingEnable) {
                        const durationNode = findInputNode(sectionEl, 'dispute_hold_duration_days');
                        let durVal = durationNode ? durationNode.value : readViewValue(sectionEl,
                            'dispute_hold_duration_days');
                        durVal = String(durVal ?? '').trim();
                        if (!isValidIntegerAtLeast(durVal, 1)) {
                            chk.checked = false;
                            if (valNode) valNode.textContent = originalText;
                            showToast('To enable dispute hold, set duration >= 1 day.', 'error', 4200);
                            if (tiny && tiny.parentElement) tiny.remove();
                            chk.disabled = false;
                            if (durationNode) durationNode.focus();
                            return;
                        }
                        const payload = {
                            section: sectionEl.dataset.section || '',
                            hold_payout_on_dispute: newVal,
                            dispute_hold_duration_days: durVal
                        };
                        await sendPayload(payload);
                        return;
                    } else {
                        const payload = {
                            section: sectionEl.dataset.section || '',
                            hold_payout_on_dispute: newVal
                        };
                        await sendPayload(payload);
                        return;
                    }
                }

                // TAX: enabling requires platform_gst_percent >=1
                if (sectionEl.dataset.section === 'tax' && key === 'deduct_gst_on_commission') {
                    const tryingEnable = (newVal === (chk.getAttribute('data-active') ?? '1'));
                    if (tryingEnable) {
                        const gstNode = findInputNode(sectionEl, 'platform_gst_percent');
                        let gstVal = gstNode ? gstNode.value : readViewValue(sectionEl,
                            'platform_gst_percent');
                        gstVal = String(gstVal ?? '').trim();
                        if (!isValidNumberGreaterThan(gstVal, 0)) {
                            chk.checked = false;
                            if (valNode) valNode.textContent = originalText;
                            showToast('To enable GST deduction, set Platform GST % >= 1.', 'error',
                                4200);
                            if (tiny && tiny.parentElement) tiny.remove();
                            chk.disabled = false;
                            if (gstNode) gstNode.focus();
                            return;
                        }
                        const payload = {
                            section: sectionEl.dataset.section || '',
                            deduct_gst_on_commission: newVal,
                            platform_gst_percent: gstVal
                        };
                        await sendPayload(payload);
                        return;
                    } else {
                        const payload = {
                            section: sectionEl.dataset.section || '',
                            deduct_gst_on_commission: newVal
                        };
                        await sendPayload(payload);
                        return;
                    }
                }

                // DEFAULT: single-key submit
                const payload = {
                    section: sectionEl.dataset.section || '',
                    [key]: newVal
                };
                await sendPayload(payload);
            });

            /* ---------- Escape to cancel active inline edit ---------- */
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    const open = document.querySelector(
                        '.settings-section[data-inline-editing="1"], .settings-section.inline-active');
                    if (open) cancelInlineEdit(open);
                }
            });

            // initialize flags
            sections.forEach(sec => {
                sec.dataset.inlineEditing = '0';
                sec.classList.remove('inline-active');
            });
        });
    </script>
@endpush --}}
