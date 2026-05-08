@extends('admin.layouts.admin')

@section('title', 'General Settings')

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
                                <h5 class="mb-0" style="font-size:1rem; font-weight:700;">Settings</h5>
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
                            data-target="#section-platform" tabindex="0" role="tab" aria-controls="section-platform">
                            <div><span class="label">Platform</span><small>Brand & contact</small></div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-target="#section-marketplace" tabindex="0" role="tab"
                            aria-controls="section-marketplace">
                            <div><span class="label">Marketplace</span><small>Access rules</small></div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-target="#section-commission" tabindex="0" role="tab"
                            aria-controls="section-commission">
                            <div><span class="label">Commission</span><small>Revenue share</small></div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-target="#section-notifications" tabindex="0" role="tab"
                            aria-controls="section-notifications">
                            <div><span class="label">Notifications</span><small>Email triggers</small></div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-target="#section-security" tabindex="0" role="tab" aria-controls="section-security">
                            <div><span class="label">Security</span><small>Session & login</small></div>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-target="#section-maintenance" tabindex="0" role="tab"
                            aria-controls="section-maintenance">
                            <div><span class="label">Maintenance</span><small>Downtime control</small></div>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Right: Settings content --}}
            <div class="col-md-8 col-lg-9 settings-right">
                <div class="settings-right-inner" id="settingsRightInner" tabindex="0" aria-live="polite">

                    {{-- Platform --}}
                    <div id="section-platform" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-platform" data-section="platform">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-platform" class="settings-section-title">Platform</div>
                                    <div class="settings-section-subtitle">Basic branding and contact details that appear in
                                        emails, invoices and support.</div>
                                </div>

                                <div class="section-actions">
                                    {{-- only manage button, borderless --}}
                                    <button type="button" class="btn-section-manage" aria-label="Manage Platform"
                                        title="Manage Platform">
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
                                    <div class="view-row" data-key="platform_name">
                                        <div>
                                            <div class="label">Platform Name</div>
                                            <div class="value">{{ $settings['platform_name'] ?? '' }}</div>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="support_email">
                                        <div>
                                            <div class="label">Support Email</div>
                                            <div class="value">{{ $settings['support_email'] ?? '' }}</div>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="support_phone">
                                        <div>
                                            <div class="label">Support Phone</div>
                                            <div class="value">{{ $settings['support_phone'] ?? '' }}</div>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="business_address">
                                        <div>
                                            <div class="label">Business Address</div>
                                            <div class="value">{{ $settings['business_address'] ?? '' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- EDIT --}}
                            <form class="edit-mode section-form mt-2" data-section="platform">
                                <div class="mb-3">
                                    <label class="form-label">Platform Name</label>
                                    <input type="text" name="platform_name" class="form-control"
                                        value="{{ old('platform_name', $settings['platform_name'] ?? '') }}">
                                    <div class="invalid-feedback-custom" data-error-for="platform_name"></div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Support Email</label>
                                        <input type="email" name="support_email" class="form-control"
                                            value="{{ old('support_email', $settings['support_email'] ?? '') }}">
                                        <div class="invalid-feedback-custom" data-error-for="support_email"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Support Phone</label>
                                        <input type="text" name="support_phone" class="form-control"
                                            value="{{ old('support_phone', $settings['support_phone'] ?? '') }}">
                                        <div class="invalid-feedback-custom" data-error-for="support_phone"></div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label">Business Address</label>
                                    <textarea name="business_address" class="form-control" rows="2">{{ old('business_address', $settings['business_address'] ?? '') }}</textarea>
                                    <div class="invalid-feedback-custom" data-error-for="business_address"></div>
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

                    {{-- Marketplace (toggles only: no manage form) --}}
                    <div id="section-marketplace" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-marketplace" data-section="marketplace">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-marketplace" class="settings-section-title">Marketplace</div>
                                    <div class="settings-section-subtitle">Control who can register and how customers
                                        interact with the platform.</div>
                                </div>
                            </div>

                            <div class="settings-section-divider"></div>

                            <div class="view-mode">
                                <div class="view-grid">
                                    <div class="view-row" data-key="allow_seller_registration" data-type="bool">
                                        <div>
                                            <div class="label">Allow Seller Registration</div>
                                            <div class="value">
                                                {{ isset($settings['allow_seller_registration']) && $settings['allow_seller_registration'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Allow Seller Registration">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="allow_seller_registration"
                                                    {{ isset($settings['allow_seller_registration']) && $settings['allow_seller_registration'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="require_seller_kyc" data-type="bool">
                                        <div>
                                            <div class="label">Require Seller KYC</div>
                                            <div class="value">
                                                {{ isset($settings['require_seller_kyc']) && $settings['require_seller_kyc'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Require Seller KYC">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="require_seller_kyc"
                                                    {{ isset($settings['require_seller_kyc']) && $settings['require_seller_kyc'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="allow_customer_registration" data-type="bool">
                                        <div>
                                            <div class="label">Allow Customer Registration</div>
                                            <div class="value">
                                                {{ isset($settings['allow_customer_registration']) && $settings['allow_customer_registration'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Allow Customer Registration">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="allow_customer_registration"
                                                    {{ isset($settings['allow_customer_registration']) && $settings['allow_customer_registration'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="allow_guest_checkout" data-type="bool">
                                        <div>
                                            <div class="label">Allow Guest Checkout</div>
                                            <div class="value">
                                                {{ isset($settings['allow_guest_checkout']) && $settings['allow_guest_checkout'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Allow Guest Checkout">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="allow_guest_checkout"
                                                    {{ isset($settings['allow_guest_checkout']) && $settings['allow_guest_checkout'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- no edit-mode form for marketplace (toggles only) --}}
                        </div>
                    </div>

                    {{-- Commission --}}
                    <div id="section-commission" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-commission" data-section="commission">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-commission" class="settings-section-title">Commission</div>
                                    <div class="settings-section-subtitle">Default commission rate applied on product sales
                                        when no specific rules are set.</div>
                                </div>

                                <div class="section-actions">
                                    <button type="button" class="btn-section-manage" aria-label="Manage Commission">
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
                                    <div class="view-row" data-key="default_commission_percent">
                                        <div>
                                            <div class="label">Default Commission (%)</div>
                                            <div class="value">{{ $settings['default_commission_percent'] ?? '5' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form class="edit-mode section-form mt-2" data-section="commission">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Default Commission (%)</label>
                                        <input type="number" step="0.01" min="0" max="100"
                                            name="default_commission_percent" class="form-control"
                                            value="{{ old('default_commission_percent', $settings['default_commission_percent'] ?? '5') }}">
                                        <div class="invalid-feedback-custom" data-error-for="default_commission_percent">
                                        </div>
                                        <small class="text-muted">Used as base commission when no product/category/badge
                                            rule exists.</small>
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

                    {{-- Notifications (toggles only) --}}
                    <div id="section-notifications" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-notifications" data-section="notifications">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-notifications" class="settings-section-title">Notifications</div>
                                    <div class="settings-section-subtitle">Choose who receives email notifications for
                                        order and status events.</div>
                                </div>
                            </div>

                            <div class="settings-section-divider"></div>

                            <div class="view-mode">
                                <div class="view-grid">
                                    <div class="view-row" data-key="notify_admin_new_order" data-type="bool">
                                        <div>
                                            <div class="label">Notify Admin on New Order</div>
                                            <div class="value">
                                                {{ isset($settings['notify_admin_new_order']) && $settings['notify_admin_new_order'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Notify Admin on New Order">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="notify_admin_new_order"
                                                    {{ isset($settings['notify_admin_new_order']) && $settings['notify_admin_new_order'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="notify_seller_new_order" data-type="bool">
                                        <div>
                                            <div class="label">Notify Seller on New Order</div>
                                            <div class="value">
                                                {{ isset($settings['notify_seller_new_order']) && $settings['notify_seller_new_order'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Notify Seller on New Order">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="notify_seller_new_order"
                                                    {{ isset($settings['notify_seller_new_order']) && $settings['notify_seller_new_order'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="notify_customer_status_update" data-type="bool">
                                        <div>
                                            <div class="label">Notify Customer on Status Change</div>
                                            <div class="value">
                                                {{ isset($settings['notify_customer_status_update']) && $settings['notify_customer_status_update'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Notify Customer on Status Change">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="notify_customer_status_update"
                                                    {{ isset($settings['notify_customer_status_update']) && $settings['notify_customer_status_update'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="enable_email_notifications" data-type="bool">
                                        <div>
                                            <div class="label">Enable Email Notifications</div>
                                            <div class="value">
                                                {{ isset($settings['enable_email_notifications']) && $settings['enable_email_notifications'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Enable Email Notifications">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="enable_email_notifications"
                                                    {{ isset($settings['enable_email_notifications']) && $settings['enable_email_notifications'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- no edit-mode form for notifications (toggles only) --}}
                        </div>
                    </div>

                    {{-- Security --}}
                    <div id="section-security" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-security" data-section="security">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-security" class="settings-section-title">Security</div>
                                    <div class="settings-section-subtitle">Control admin session timeout and whether
                                        multiple logins are allowed.</div>
                                </div>

                                <div class="section-actions">
                                    <button type="button" class="btn-section-manage" aria-label="Manage Security">
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
                                    <div class="view-row" data-key="session_timeout_minutes">
                                        <div>
                                            <div class="label">Session Timeout (minutes)</div>
                                            <div class="value">{{ $settings['session_timeout_minutes'] ?? '60' }}</div>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="allow_multiple_admin_logins" data-type="bool">
                                        <div>
                                            <div class="label">Allow Multiple Admin Logins</div>
                                            <div class="value">
                                                {{ isset($settings['allow_multiple_admin_logins']) && $settings['allow_multiple_admin_logins'] == '1' ? 'Yes' : 'No' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Allow Multiple Admin Logins">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="allow_multiple_admin_logins" data-active="1"
                                                    data-inactive="0"
                                                    {{ isset($settings['allow_multiple_admin_logins']) && $settings['allow_multiple_admin_logins'] == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form class="edit-mode section-form mt-2" data-section="security">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Session Timeout (minutes)</label>
                                        <input type="number" name="session_timeout_minutes" class="form-control"
                                            min="1"
                                            value="{{ old('session_timeout_minutes', $settings['session_timeout_minutes'] ?? '60') }}">
                                        <div class="invalid-feedback-custom" data-error-for="session_timeout_minutes">
                                        </div>
                                        <small class="text-muted">How long an admin session stays active without
                                            activity.</small>
                                    </div>
                                </div>

                                <div class="mt-3 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light btn-sm btn-section-cancel">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm btn-section-save">
                                        <span class="save-text">Save</span>
                                        <span class="save-spinner" style="display:none; margin-left:8px;"><span
                                                class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span></span>
                                    </button>
                                </div>

                                <div class="alert alert-success section-alert" role="alert" style="display:none;">
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Maintenance --}}
                    <div id="section-maintenance" class="settings-section card shadow-sm border-0 mb-3" role="region"
                        aria-labelledby="label-maintenance" data-section="maintenance">
                        <div class="card-body">
                            <div class="settings-section-header">
                                <div>
                                    <div id="label-maintenance" class="settings-section-title">Maintenance Control</div>
                                    <div class="settings-section-subtitle">
                                        Manage availability of the customer site and seller portal. Admin panel always
                                        remains accessible.
                                    </div>
                                </div>

                                <div class="section-actions">
                                    <button type="button" class="btn-section-manage" aria-label="Manage Maintenance">
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

                                    <div class="view-row" data-key="frontend_maintenance">
                                        <div>
                                            <div class="label">Frontend (Customer Site)</div>
                                            <div class="value">
                                                {{ ($settings['frontend_maintenance'] ?? 'active') === 'active' ? 'Active' : 'Maintenance' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Frontend maintenance">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="frontend_maintenance" data-active="active"
                                                    data-inactive="maintenance"
                                                    {{ ($settings['frontend_maintenance'] ?? 'active') === 'active' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="seller_maintenance">
                                        <div>
                                            <div class="label">Seller Portal</div>
                                            <div class="value">
                                                {{ ($settings['seller_maintenance'] ?? 'active') === 'active' ? 'Active' : 'Maintenance' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Seller maintenance">
                                                <input type="checkbox" class="toggle-switch"
                                                    data-for="seller_maintenance" data-active="active"
                                                    data-inactive="maintenance"
                                                    {{ ($settings['seller_maintenance'] ?? 'active') === 'active' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="store_status">
                                        <div>
                                            <div class="label">Store Status (Global)</div>
                                            <div class="value">
                                                {{ ($settings['store_status'] ?? 'active') === 'active' ? 'Active' : 'Full Maintenance' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="switch" aria-label="Store status (global)">
                                                <input type="checkbox" class="toggle-switch" data-for="store_status"
                                                    data-active="active" data-inactive="full_maintenance"
                                                    {{ ($settings['store_status'] ?? 'active') === 'active' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="view-row" data-key="maintenance_message">
                                        <div>
                                            <div class="label">Maintenance Message</div>
                                            <div class="value">{{ $settings['maintenance_message'] ?? '' }}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Manage textarea --}}
                            <form class="edit-mode section-form mt-2" data-section="maintenance">
                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Maintenance Message</label>
                                    <textarea name="maintenance_message" class="form-control" rows="2">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
                                    <div class="invalid-feedback-custom" data-error-for="maintenance_message"></div>
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
                        use
                        Manage to edit full forms.</small></div>
            </div>
        </div>
    </div>

    {{-- Toast --}}
    <div id="settingsToast" class="settings-toast" role="status" aria-live="polite"></div>
    <input type="hidden" id="__post_url" value="{{ route('admin.settings.general.update') }}">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/setting-general-payment.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/settings.js') }}" defer></script>
    @endpush
@endsection


{{-- optimized version --}}

{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const POST_URL = "{{ route('admin.settings.general.update') }}";
            const csrfToken = document.getElementById('__csrf')?.value || '{{ csrf_token() }}';

            // DOM cache
            const rightInner = document.getElementById('settingsRightInner');
            const navItems = Array.from(document.querySelectorAll('#settingsNavList .list-group-item'));
            const sections = Array.from(rightInner.querySelectorAll('.settings-section'));
            const searchInput = document.getElementById('settingsNavSearch');
            const clearBtn = document.getElementById('settingsNavClear');
            const toast = document.getElementById('settingsToast');

            const MIN_SEARCH_CHARS = 6;
            const DEBOUNCE_MS = 200;
            const MIN_VISIBLE_MS = 220;

            /* ---------- tiny utilities ---------- */
            const showToast = (msg, type = 'success', ms = 2800) => {
                toast.textContent = msg;
                toast.className = 'settings-toast ' + (type === 'success' ? 'success' : 'error');
                toast.style.display = 'block';
                // fade in/out
                setTimeout(() => (toast.style.opacity = '1'), 10);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => (toast.style.display = 'none'), 220);
                }, ms);
            };

            const ajaxSubmit = async payload => {
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

            const scrollToSection = target => {
                const rect = target.getBoundingClientRect();
                const cont = rightInner.getBoundingClientRect();
                const y = (rect.top - cont.top) + rightInner.scrollTop;
                rightInner.scrollTo({
                    top: Math.max(0, Math.floor(y)),
                    behavior: 'smooth'
                });
            };

            /* ---------- loading + no-results UI ---------- */
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
            const showLoading = () => {
                if (loadingTimer) clearTimeout(loadingTimer);
                loadingNode.style.display = 'block';
                void loadingNode.offsetWidth;
                loadingNode.classList.add('is-visible');
                loadingTimer = setTimeout(() => loadingTimer = null, MIN_VISIBLE_MS);
            };
            const hideLoading = () => {
                const doHide = () => {
                    loadingNode.classList.remove('is-visible');
                    setTimeout(() => loadingNode.style.display = 'none', 120);
                };
                if (loadingTimer) setTimeout(() => {
                    loadingTimer = null;
                    doHide();
                }, MIN_VISIBLE_MS);
                else doHide();
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
                        if ((rect.top <= containerRect.top + 8) && dist < best.score)
                            best = {
                                score: dist,
                                id: '#' + sec.id
                            };
                    });
                    if (best.id) navItems.forEach(item => item.classList.toggle('active', item
                        .getAttribute('data-target') === best.id));
                    ticking = false;
                });
                ticking = true;
            });

            /* ---------- search (debounced) ---------- */
            let searchTimer = null;
            const resetSearchView = () => {
                sections.forEach(s => s.style.display = '');
                navItems.forEach(i => i.style.display = '');
                noResultsNode.style.display = 'none';
            };

            const performSearch = raw => {
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

            searchInput.addEventListener('keydown', e => {
                if (e.key === 'Escape' && searchInput.value) {
                    clearBtn.click();
                    e.stopPropagation();
                }
            });

            noResultsNode.addEventListener('click', e => {
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

            /* ---------- inline editing (view -> controls) ---------- */
            const findSection = el => el ? el.closest('.settings-section') : null;

            const createActionBar = sectionEl => {
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

            const startInlineEdit = sectionEl => {
                if (!sectionEl || sectionEl.dataset.inlineEditing === '1') return;
                markInlineFlag(sectionEl, true);
                const originalMap = {};
                sectionEl._inlineOriginals = originalMap;

                const editForm = sectionEl.querySelector('.edit-mode');
                let candidates = editForm ? Array.from(editForm.querySelectorAll('[name]')) : [];

                if (!candidates.length) {
                    Array.from(sectionEl.querySelectorAll('.view-row')).forEach(r => {
                        const key = r.getAttribute('data-key');
                        if (!key) return;
                        if (!r.querySelector('.toggle-switch')) candidates.push({
                            name: key
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
                        overrideValues[key]) : (sectionEl._inlineOriginals?.[key] ?? '');
                    const valDiv = document.createElement('div');
                    valDiv.className = 'value';
                    valDiv.textContent = valText;
                    n.replaceWith(valDiv);
                });

                const bar = sectionEl.querySelector('.inline-action-bar');
                if (bar) bar.remove();
                delete sectionEl._inlineOriginals;
                markInlineFlag(sectionEl, false);
            };

            /* ---------- read helpers & validation ---------- */
            const findInputNode = (sectionEl, key) =>
                sectionEl.querySelector(`[name="${key}"], [name="${key}_edit"]`) ||
                sectionEl.querySelector(
                    `.view-row[data-key="${key}"] [data-created] input[name="${key}"], .view-row[data-key="${key}"] [data-created] textarea[name="${key}"], .view-row[data-key="${key}"] [data-created] select[name="${key}"]`
                );

            const readViewValue = (sectionEl, key) => sectionEl.querySelector(`.view-row[data-key="${key}"] .value`)
                ?.textContent?.trim() ?? '';

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

            /* ---------- collect inline payload (note: maintenance comment preserved) ---------- */
            const collectInlinePayload = sectionEl => {
                const payload = {
                    section: sectionEl.dataset.section || ''
                };
                Array.from(sectionEl.querySelectorAll('.view-row[data-key]')).forEach(row => {
                    const key = row.getAttribute('data-key');
                    if (!key) return;
                    const toggle = row.querySelector('.toggle-switch');
                    if (toggle) {
                        // DO NOT include toggles when editing maintenance message (preserve original behavior)
                        if (sectionEl.dataset.section === "maintenance") return;
                        payload[key] = toggle.checked ? (toggle.getAttribute('data-active') || '1') : (
                            toggle.getAttribute('data-inactive') || '0');
                        return;
                    }
                    const control = row.querySelector('input[name], textarea[name], select[name]');
                    if (control) {
                        if (control.type === 'checkbox') payload[key] = control.checked ? (control
                            .value || '1') : '0';
                        else payload[key] = control.value;
                        return;
                    }
                    payload[key] = row.querySelector('.value')?.textContent?.trim() ?? '';
                });
                return payload;
            };

            const applyReturnedValuesToView = (sectionEl, returned) => {
                if (!returned || typeof returned !== 'object') return;
                Object.keys(returned).forEach(k => {
                    const row = sectionEl.querySelector(`.view-row[data-key="${k}"]`);
                    if (!row) return;
                    let v = returned[k];
                    if (v === true || v === '1' || v === 1) v = 'Yes';
                    else if (v === false || v === '0' || v === 0) v = 'No';
                    const valNode = row.querySelector('.value');
                    const text = (v === null || v === undefined) ? '' : String(v);
                    if (valNode) valNode.textContent = text;
                    else {
                        const created = row.querySelector('[data-created="1"]');
                        const newVal = document.createElement('div');
                        newVal.className = 'value';
                        newVal.textContent = text;
                        if (created) created.replaceWith(newVal);
                        else row.appendChild(newVal);
                    }

                    const viewToggle = row.querySelector('.toggle-switch');
                    if (viewToggle) viewToggle.checked = (String(returned[k]) === '1' || returned[k] ===
                        1 || returned[k] === true);

                    const editControl = sectionEl.querySelector(`[name="${k}"], [name="${k}_edit"]`);
                    if (editControl) {
                        if (editControl.type === 'checkbox') editControl.checked = (String(returned[
                            k]) === '1' || returned[k] === 1 || returned[k] === true);
                        else editControl.value = (returned[k] === null || returned[k] === undefined) ?
                            '' : String(returned[k]);
                    }

                    const createdControl = row.querySelector(
                        '[data-created] input[name], [data-created] textarea[name], [data-created] select[name]'
                    );
                    if (createdControl) {
                        if (createdControl.type === 'checkbox') createdControl.checked = (String(
                            returned[k]) === '1' || returned[k] === 1 || returned[k] === true);
                        else createdControl.value = (returned[k] === null || returned[k] ===
                            undefined) ? '' : String(returned[k]);
                    }
                });
            };

            /* ---------- save inline edit ---------- */
            const saveInlineEdit = async (sectionEl, saveBtn) => {
                const spinner = sectionEl.querySelector('.save-spinner') || saveBtn.querySelector(
                    '.save-spinner');
                const saveText = saveBtn.querySelector('.save-text');
                if (saveText) saveText.style.display = 'none';
                if (spinner) spinner.style.display = '';
                saveBtn.disabled = true;

                const payload = collectInlinePayload(sectionEl);

                // preserved: no extra client-side rules here in this file (original did not add special validations for general)
                const {
                    ok,
                    status,
                    data
                } = await ajaxSubmit(payload);

                if (ok) {
                    const returned = (data && data.updated_settings) ? data.updated_settings : payload;
                    applyReturnedValuesToView(sectionEl, returned);
                    showToast((data && data.message) ? data.message : 'Settings saved', 'success');
                    const bar = sectionEl.querySelector('.inline-action-bar');
                    if (bar) bar.remove();
                    delete sectionEl._inlineOriginals;
                    markInlineFlag(sectionEl, false);
                } else if (status === 422 && data) {
                    const editForm = sectionEl.querySelector('.edit-mode');
                    if (editForm) {
                        const errors = data.errors || {};
                        Object.keys(errors).forEach(field => {
                            const errNode = editForm.querySelector(
                                `.invalid-feedback-custom[data-error-for="${field}"]`);
                            const input = editForm.querySelector(`[name="${field}"]`);
                            if (errNode) {
                                errNode.textContent = Array.isArray(errors[field]) ? errors[field]
                                    .join(' ') : String(errors[field]);
                                errNode.style.display = '';
                            }
                            if (input) input.classList.add('is-invalid');
                        });
                    }
                    showToast((data && data.message) ? data.message : 'Validation failed. Check inputs.',
                        'error', 3500);
                } else {
                    let msg = 'Failed to save settings.';
                    if (data && data.message) msg = data.message;
                    showToast(msg, 'error', 3500);
                }

                if (saveText) saveText.style.display = '';
                if (spinner) spinner.style.display = 'none';
                saveBtn.disabled = false;
            };

            /* ---------- delegated clicks: manage / inline save / inline cancel ---------- */
            document.body.addEventListener('click', ev => {
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
            });

            /* ---------- toggles: instant update with section-specific logic ---------- */
            const revertUi = (chk, valNode, originalText) => {
                chk.checked = !chk.checked;
                if (valNode) valNode.textContent = originalText;
            };

            document.body.addEventListener('change', async ev => {
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

                // helper to send and handle fallback
                const sendPayload = async payload => {
                    const res = await ajaxSubmit(payload);
                    if (res.ok) {
                        const returned = (res.data && res.data.updated_settings) ? res.data
                            .updated_settings : payload;
                        applyReturnedValuesToView(sectionEl, returned);
                        showToast((res.data && res.data.message) ? res.data.message : 'Updated',
                            'success');
                    } else {
                        revertUi(chk, valNode, originalText);
                        let msg = 'Failed to update setting';
                        if (res.data && res.data.message) msg = res.data.message;
                        showToast(msg, 'error', 3500);
                    }
                    if (tiny && tiny.parentElement) tiny.remove();
                    chk.disabled = false;
                };

                // Special: maintenance sync rules must be preserved
                if (key === 'store_status') {
                    const payload = {
                        section: sectionEl.dataset.section || '',
                        [key]: newVal
                    };
                    await sendPayload(payload);
                    // reflect to children locally regardless of server response (original did immediate sync)
                    const on = (newVal === 'active');
                    const f = sectionEl.querySelector('input[data-for="frontend_maintenance"]');
                    const s = sectionEl.querySelector('input[data-for="seller_maintenance"]');
                    if (f) f.checked = on;
                    if (s) s.checked = on;
                    return;
                }

                if (key === 'frontend_maintenance' || key === 'seller_maintenance') {
                    // try update, then sync global toggle locally like original
                    const payload = {
                        section: sectionEl.dataset.section || '',
                        [key]: newVal
                    };
                    await sendPayload(payload);

                    const f = sectionEl.querySelector('input[data-for="frontend_maintenance"]');
                    const s = sectionEl.querySelector('input[data-for="seller_maintenance"]');
                    const g = sectionEl.querySelector('input[data-for="store_status"]');

                    if (f && s && g) {
                        if (!f.checked && !s.checked) g.checked = false;
                        if (f.checked || s.checked) g.checked = true;
                    }
                    return;
                }

                // default single-key submit
                const payload = {
                    section: sectionEl.dataset.section || '',
                    [key]: newVal
                };
                await sendPayload(payload);
            });

            /* ---------- escape to cancel inline ---------- */
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    const open = document.querySelector(
                        '.settings-section[data-inline-editing="1"], .settings-section.inline-active');
                    if (open) cancelInlineEdit(open);
                }
            });

            // init flags
            sections.forEach(sec => {
                sec.dataset.inlineEditing = '0';
                sec.classList.remove('inline-active');
            });
        });
    </script>
@endpush --}}
