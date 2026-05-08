<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function general()
    {
        $settings = Setting::allToArray();

        return view('admin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        // Section is passed always from frontend (platform / marketplace / commission / security / maintenance / notifications)
        $section = $request->input('section', null);

        // All possible validation rules
        $rules = [
            // Platform
            'platform_name'    => 'nullable|string|max:255',
            'support_email'    => 'nullable|email|max:255',
            'support_phone'    => 'nullable|string|max:50',
            'business_address' => 'nullable|string|max:1000',

            // Marketplace (boolean)
            'allow_seller_registration'    => 'nullable|boolean',
            'require_seller_kyc'           => 'nullable|boolean',
            'allow_customer_registration'  => 'nullable|boolean',
            'allow_guest_checkout'         => 'nullable|boolean',

            // Commission
            'default_commission_percent' => 'nullable|numeric|min:0|max:100',

            // Notifications (boolean)
            'notify_admin_new_order'        => 'nullable|boolean',
            'notify_seller_new_order'       => 'nullable|boolean',
            'notify_customer_status_update' => 'nullable|boolean',
            'enable_email_notifications'    => 'nullable|boolean',

            // Security
            'session_timeout_minutes'     => 'nullable|integer|min:1|max:10000',
            'allow_multiple_admin_logins' => 'nullable|boolean',

            // Maintenance
            'store_status'         => ['nullable', Rule::in(['active', 'full_maintenance'])],
            'frontend_maintenance' => ['nullable', Rule::in(['active', 'maintenance'])],
            'seller_maintenance'   => ['nullable', Rule::in(['active', 'maintenance'])],
            'maintenance_message'  => 'nullable|string|max:1000',
        ];

        /**
         * Filter rules to ONLY validate fields that were received
         */
        $payload = $request->only(array_keys($rules));
        $rulesToApply = array_intersect_key($rules, $payload);

        // Validate actual incoming fields (not full form)
        $validated = $request->validate($rulesToApply);

        // All boolean keys
        $booleanKeys = [
            'allow_seller_registration',
            'require_seller_kyc',
            'allow_customer_registration',
            'allow_guest_checkout',

            'notify_admin_new_order',
            'notify_seller_new_order',
            'notify_customer_status_update',
            'enable_email_notifications',

            'allow_multiple_admin_logins',
        ];

        $updated = [];

        // Store boolean values correctly
        foreach ($booleanKeys as $bk) {
            if ($request->has($bk)) {
                $val = $request->boolean($bk) ? '1' : '0';
                Setting::setValue($bk, $val);
                $updated[$bk] = $val;
            }
        }

        // store other direct values
        foreach ($validated as $key => $value) {
            if (!in_array($key, $booleanKeys)) {
                Setting::setValue($key, (string)($value ?? ''));
                $updated[$key] = $value;
            }
        }
        /* 🔥 Final maintenance backend sync */
        if ($section === 'maintenance') {

            // fetch latest values after partial payload update
            $store    = $payload['store_status']         ?? Setting::getValue('store_status');
            $frontend = $payload['frontend_maintenance'] ?? Setting::getValue('frontend_maintenance');
            $seller   = $payload['seller_maintenance']   ?? Setting::getValue('seller_maintenance');

            /* ---------- 1) Global switch takes full control if present in payload ---------- */
            if (array_key_exists('store_status', $payload)) {
                if ($store === 'full_maintenance') {
                    $frontend = 'maintenance';
                    $seller   = 'maintenance';
                }
                if ($store === 'active') {
                    $frontend = 'active';
                    $seller   = 'active';
                }
            }

            /* ---------- 2) Child toggles are allowed to override individually ---------- */
            if (array_key_exists('frontend_maintenance', $payload)) {
                $frontend = $payload['frontend_maintenance'];
            }
            if (array_key_exists('seller_maintenance', $payload)) {
                $seller = $payload['seller_maintenance'];
            }

            /* ---------- 3) Recompute store_status from final children ---------- */
            if ($frontend === 'maintenance' && $seller === 'maintenance') {
                $store = 'full_maintenance';
            } else {
                $store = 'active';
            }

            /* ---------- Final database update ---------- */
            Setting::setValue('frontend_maintenance', $frontend);
            Setting::setValue('seller_maintenance', $seller);
            Setting::setValue('store_status', $store);

            $updated['frontend_maintenance'] = $frontend;
            $updated['seller_maintenance']   = $seller;
            $updated['store_status']         = $store;
        }

        return response()->json([
            'success' => true,
            'message' => "Settings updated successfully.",
            'updated_settings' => $updated
        ]);
    }

    public function payments()
    {
        $settings = Setting::allToArray();

        return view('admin.settings.payment', compact('settings'));
    }

    public function updatePayment(Request $request)
    {
        $section = $request->input('section', null);

        $rules = [
            // Seller Payout
            'auto_payout_enabled'      => 'nullable|boolean',
            'auto_payout_delay_days'   => 'nullable|integer|min:0|max:365',
            'minimum_payout_threshold' => 'nullable|numeric|min:0',

            // Refund Handling
            'auto_refund_on_order_rejection' => 'nullable|boolean',
            'refund_needs_admin_approval'    => 'nullable|boolean',

            // Disputes & Hold
            'hold_payout_on_dispute'     => 'nullable|boolean',
            'dispute_hold_duration_days' => 'nullable|integer|min:0|max:365',

            // Tax Settings
            'deduct_gst_on_commission' => 'nullable|boolean',
            'platform_gst_percent'     => 'nullable|numeric|min:0|max:28',
        ];

        // Only validate what's sent
        $payload      = $request->only(array_keys($rules));
        $rulesToApply = array_intersect_key($rules, $payload);

        $validated = [];
        if (!empty($rulesToApply)) {
            $validated = $request->validate($rulesToApply);
        }

        // Boolean keys
        $booleanKeys = [
            'auto_payout_enabled',
            'auto_refund_on_order_rejection',
            'refund_needs_admin_approval',
            'hold_payout_on_dispute',
            'deduct_gst_on_commission',
        ];

        $updated = [];

        // STEP 1: Store boolean values that are present
        foreach ($booleanKeys as $bk) {
            if ($request->has($bk)) {
                $val = $request->boolean($bk) ? '1' : '0';
                Setting::setValue($bk, $val);
                $updated[$bk] = $val;
            }
        }

        // STEP 2: Store non-boolean values that are present (we'll adjust/validate further below)
        foreach ($validated as $key => $value) {
            if (!in_array($key, $booleanKeys)) {
                Setting::setValue($key, (string)($value ?? ''));
                $updated[$key] = $value;
            }
        }

        // --- REFUND: EXACTLY ONE MUST BE TRUE. Normalize/validate.
        if ($section === 'refund') {
            $autoRefund = $updated['auto_refund_on_order_rejection'] ?? Setting::getValue('auto_refund_on_order_rejection');
            $needsApproval = $updated['refund_needs_admin_approval'] ?? Setting::getValue('refund_needs_admin_approval');

            // Normalize: if both '1' -> prefer auto_refund = 1 and set needsApproval = 0
            if ($autoRefund === '1' && $needsApproval === '1') {
                $needsApproval = '0';
                Setting::setValue('refund_needs_admin_approval', '0');
                $updated['refund_needs_admin_approval'] = '0';
            }

            // If both '0' -> default to auto_refund_on_order_rejection = 1 (cannot have both disabled)
            if ($autoRefund === '0' && $needsApproval === '0') {
                $autoRefund = '1';
                Setting::setValue('auto_refund_on_order_rejection', '1');
                $updated['auto_refund_on_order_rejection'] = '1';
            }

            // Persist normalized values (ensures DB has the canonical state)
            Setting::setValue('auto_refund_on_order_rejection', $autoRefund);
            Setting::setValue('refund_needs_admin_approval', $needsApproval);
            $updated['auto_refund_on_order_rejection'] = $autoRefund;
            $updated['refund_needs_admin_approval'] = $needsApproval;
        }

        // --- PAYOUT: enabling requires valid delay >=1 and minimum threshold > 0
        if ($section === 'payout') {
            $enabled = $updated['auto_payout_enabled'] ?? Setting::getValue('auto_payout_enabled');
            $delay = array_key_exists('auto_payout_delay_days', $updated) ? $updated['auto_payout_delay_days'] : Setting::getValue('auto_payout_delay_days');
            $threshold = array_key_exists('minimum_payout_threshold', $updated) ? $updated['minimum_payout_threshold'] : Setting::getValue('minimum_payout_threshold');

            // Normalize values to primitive types for checks
            $delayInt = is_null($delay) || $delay === '' ? null : (int)$delay;
            $thresholdFloat = is_null($threshold) || $threshold === '' ? null : (float)$threshold;

            if ($enabled === '1') {
                // When enabling, both fields must be present and valid
                $errors = [];
                if ($delayInt === null || $delayInt < 1) {
                    $errors['auto_payout_delay_days'] = 'Auto Payout Delay must be at least 1 day when enabling Auto Payout.';
                }
                if ($thresholdFloat === null || $thresholdFloat <= 0) {
                    $errors['minimum_payout_threshold'] = 'Minimum payout threshold must be greater than 0 when enabling Auto Payout.';
                }
                if (!empty($errors)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed for Auto Payout enabling.',
                        'errors'  => $errors
                    ], 422);
                }
                // persist validated values
                Setting::setValue('auto_payout_delay_days', (string)$delayInt);
                Setting::setValue('minimum_payout_threshold', (string)$thresholdFloat);
                $updated['auto_payout_delay_days'] = $delayInt;
                $updated['minimum_payout_threshold'] = $thresholdFloat;
            } else {
                // if disabled, store disabled and keep delay as-is or 0 depending on your domain rule
                // We'll not force-reset the numeric values here; UI already indicates that disabled auto payout leaves numeric independent.
                if (array_key_exists('auto_payout_delay_days', $updated)) {
                    Setting::setValue('auto_payout_delay_days', (string)$delayInt);
                    $updated['auto_payout_delay_days'] = $delayInt;
                }
                if (array_key_exists('minimum_payout_threshold', $updated)) {
                    Setting::setValue('minimum_payout_threshold', (string)$thresholdFloat);
                    $updated['minimum_payout_threshold'] = $thresholdFloat;
                }
            }
        }

        // --- DISPUTE: if hold ON -> duration must be >= 1
        if ($section === 'disputes') {
            $hold = $updated['hold_payout_on_dispute'] ?? Setting::getValue('hold_payout_on_dispute');
            $duration = array_key_exists('dispute_hold_duration_days', $updated) ? $updated['dispute_hold_duration_days'] : Setting::getValue('dispute_hold_duration_days');

            $durationInt = is_null($duration) || $duration === '' ? null : (int)$duration;

            if ($hold === '1') {
                if ($durationInt === null || $durationInt < 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'When holding payouts on disputes, duration must be at least 1 day.',
                        'errors'  => ['dispute_hold_duration_days' => 'Duration must be >= 1 when hold is enabled.']
                    ], 422);
                }
                Setting::setValue('dispute_hold_duration_days', (string)$durationInt);
                $updated['dispute_hold_duration_days'] = $durationInt;
            } else {
                // if disabling hold, we choose to set duration to 0 (keeping consistent)
                if ($durationInt !== null) {
                    Setting::setValue('dispute_hold_duration_days', (string)$durationInt);
                    $updated['dispute_hold_duration_days'] = $durationInt;
                }
            }
        }

        // --- TAX: enabling GST requires platform_gst_percent >= 1
        if ($section === 'tax') {
            $deduct = $updated['deduct_gst_on_commission'] ?? Setting::getValue('deduct_gst_on_commission');
            $gst = array_key_exists('platform_gst_percent', $updated) ? $updated['platform_gst_percent'] : Setting::getValue('platform_gst_percent');

            $gstFloat = is_null($gst) || $gst === '' ? null : (float)$gst;

            if ($deduct === '1') {
                if ($gstFloat === null || $gstFloat < 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'When GST deduction is enabled, Platform GST % must be at least 1.',
                        'errors'  => ['platform_gst_percent' => 'Platform GST % must be >= 1 when GST deduction is enabled.']
                    ], 422);
                }
                // clamp to allowed max 28
                if ($gstFloat > 28) $gstFloat = 28;
                Setting::setValue('platform_gst_percent', (string)$gstFloat);
                $updated['platform_gst_percent'] = $gstFloat;
            } else {
                // if disabling, set percent to 0 for consistency
                Setting::setValue('platform_gst_percent', '0');
                $updated['platform_gst_percent'] = '0';
            }
        }

        // return canonical updated settings that were affected
        return response()->json([
            'success'          => true,
            'message'          => "Payment settings updated.",
            'updated_settings' => $updated
        ]);
    }
}
