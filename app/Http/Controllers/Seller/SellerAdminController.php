<?php

namespace App\Http\Controllers\Seller;

use App\Mail\OtpMail;
use App\Models\Sellers;
use App\Models\SellerBusinessDetail;
use App\Models\SellerPickupAddress;
use App\Models\SellerSupplierDetail;
use App\Models\ProductCategory;
use App\Services\Kyc\PanVerifyClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\SellerAddress;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Mail\SellerRegistrationSuccessMail;
use App\Services\NotificationService;
use App\Services\NotificationTemplateService;



class SellerAdminController extends Controller
{
    private function registrationOtpCacheKey(int $authId): string
    {
        return 'seller_registration_otp_auth_' . $authId;
    }

    private function normalizeNameForMatch(string $value): string
    {
        $value = trim(mb_strtolower($value));
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;
        return $value;
    }

    private function generateCaptchaText(int $length = 6): string
    {
        $alphabet = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $max = strlen($alphabet) - 1;
        $out = '';
        for ($i = 0; $i < $length; $i++) {
            $out .= $alphabet[random_int(0, $max)];
        }
        return $out;
    }

    private function generateCaptchaSvg(string $text): string
    {
        $w = 170;
        $h = 52;
        $bg = '#f1f3f4';
        $fg = '#111827';

        $chars = str_split($text);
        $x = 18;
        $svgText = '';
        foreach ($chars as $ch) {
            $y = 34 + random_int(-4, 4);
            $rot = random_int(-18, 18);
            $svgText .= '<text x="' . $x . '" y="' . $y . '" fill="' . $fg . '" font-size="26" font-family="Arial, sans-serif" font-weight="700" transform="rotate(' . $rot . ' ' . $x . ' ' . $y . ')">' . e($ch) . '</text>';
            $x += 24;
        }

        $lines = '';
        for ($i = 0; $i < 6; $i++) {
            $x1 = random_int(0, $w);
            $y1 = random_int(0, $h);
            $x2 = random_int(0, $w);
            $y2 = random_int(0, $h);
            $stroke = sprintf('#%02X%02X%02X', random_int(100, 200), random_int(100, 200), random_int(100, 200));
            $lines .= '<line x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '" stroke="' . $stroke . '" stroke-width="2" opacity="0.65" />';
        }

        return '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $h . '" viewBox="0 0 ' . $w . ' ' . $h . '">' .
            '<rect width="100%" height="100%" rx="10" fill="' . $bg . '"/>' .
            $lines .
            $svgText .
            '</svg>';
    }

    private function ensureSellerSlug(Sellers $seller): void
    {
        if (!blank($seller->slug)) {
            return;
        }

        $base = Str::slug($seller->name ?: 'seller');
        if ($base === '') {
            $base = 'seller';
        }

        $candidate = $base;
        $conflict = Sellers::query()
            ->where('slug', $candidate)
            ->where('id', '!=', $seller->id)
            ->exists();

        if ($conflict) {
            $candidate = $base . '-' . $seller->id;
        }

        if (
            Sellers::query()
                ->where('slug', $candidate)
                ->where('id', '!=', $seller->id)
                ->exists()
        ) {
            $candidate = $base . '-' . $seller->id . '-' . Str::lower(Str::random(4));
        }

        $seller->slug = $candidate;
        $seller->save();
    }

    public function showSellerLoginForm()
    {
        if (Auth::guard('seller')->check()) {
            $seller = Auth::guard('seller')->user();
            $this->ensureSellerSlug($seller);
            return redirect()->route('seller.dashboard', ['seller' => $seller->slug]);
        }

        return view('seller.selleronboard.mobile-number');
    }

    public function businessDetails(Request $request)
    {
        if (!$request->session()->has('seller_onboard_login')) {
            return redirect()->route('seller.login');
        }

        $categoryTree = ProductCategory::where('status', 1)->get(['id', 'slug', 'name']);
        $sellerLogin = (string) $request->session()->get('seller_onboard_login', '');
        $sellerLoginType = filter_var($sellerLogin, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $sellerLoginMobile = $sellerLoginType === 'mobile' ? preg_replace('/\D/', '', $sellerLogin) : '';


        return view('seller.selleronboard.seller-registration-details', compact(
            'categoryTree',
            'sellerLogin',
            'sellerLoginType',
            'sellerLoginMobile'
        ));
    }

    public function captcha(Request $request)
    {
        if (!$request->session()->has('seller_onboard_login')) {
            return response()->json(['status' => false, 'message' => 'Session expired. Please login again.'], 401);
        }

        $text = $this->generateCaptchaText(6);
        $svg = $this->generateCaptchaSvg($text);

        // ✅ DEBUG (only local)
        if (app()->environment('local')) {
            Log::info('SELLER CAPTCHA: ' . $text);
        }

        $request->session()->put('seller_onboard_captcha', $text);
        $request->session()->put('seller_onboard_captcha_expires_at', now()->addMinutes(10)->timestamp);
        $request->session()->forget('seller_onboard_captcha_attempts');

        return response()->json([
            'status' => true,
            'image' => 'data:image/svg+xml;base64,' . base64_encode($svg),
            'expires_in' => 600,
        ]);
    }

    public function captchaVerify(Request $request)
    {
        if (!$request->session()->has('seller_onboard_login')) {
            return response()->json(['valid' => false, 'message' => 'Session expired. Please login again.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'captcha' => ['required', 'string', 'min:4', 'max:10'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'message' => $validator->errors()->first('captcha'),
            ], 422);
        }

        $expectedCaptcha = (string) $request->session()->get('seller_onboard_captcha', '');
        $expiresAt = (int) $request->session()->get('seller_onboard_captcha_expires_at', 0);
        if ($expectedCaptcha === '' || $expiresAt < now()->timestamp) {
            return response()->json([
                'valid' => false,
                'message' => 'CAPTCHA expired. Please refresh and try again.',
            ], 422);
        }

        $attempts = (int) $request->session()->get('seller_onboard_captcha_attempts', 0);
        $attempts++;
        $request->session()->put('seller_onboard_captcha_attempts', $attempts);

        $provided = strtoupper(trim((string) $request->input('captcha')));
        if ($provided !== strtoupper($expectedCaptcha)) {
            if ($attempts >= 5) {
                $request->session()->forget(['seller_onboard_captcha', 'seller_onboard_captcha_expires_at']);
                return response()->json([
                    'valid' => false,
                    'message' => 'Too many attempts. Please refresh CAPTCHA.',
                ], 429);
            }

            return response()->json([
                'valid' => false,
                'message' => 'Incorrect CAPTCHA. Please try again.',
            ], 422);
        }

        return response()->json(['valid' => true]);
    }

    /*
    public function bankAccountVerify(Request $request)
    {
        if (!$request->session()->has('seller_onboard_login')) {
            return response()->json(['valid' => false, 'message' => 'Session expired. Please login again.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'account_holder_name' => ['required', 'string', 'max:255'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'min:6', 'max:50'],
            'ifsc_code' => ['required', 'string', 'size:11', 'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $holder = trim((string) $request->input('account_holder_name'));
        $bankName = trim((string) $request->input('bank_name'));
        $accountNumber = trim((string) $request->input('account_number'));
        $ifsc = strtoupper(trim((string) $request->input('ifsc_code')));

        try {
            $ifscData = (new IfscLookupClient())->lookup($ifsc);
        } catch (\Throwable $e) {
            return response()->json(['valid' => false, 'message' => 'Invalid IFSC code.'], 422);
        }

        if (mb_strtolower($bankName) !== 'other' && !empty($ifscData['bank'])) {
            $selected = mb_strtolower(trim($bankName));
            $actual = mb_strtolower(trim((string) $ifscData['bank']));
            if ($selected !== $actual) {
                return response()->json([
                    'valid' => false,
                    'message' => 'IFSC belongs to ' . $ifscData['bank'] . '. Please select the same bank.',
                ], 422);
            }
        }

        // Sandbox verifier (no paid API yet). Replace this block when you have a penny-drop provider.
        $verifiedName = $holder;
        $referenceId = 'sandbox_' . Str::lower(Str::random(12));
        $provider = 'sandbox';

        $hash = hash('sha256', $accountNumber . '|' . $ifsc);
        $request->session()->put('seller_onboard_bank_verification', [
            'account_hash' => $hash,
            'ifsc' => $ifsc,
            'verified_name' => $verifiedName,
            'reference_id' => $referenceId,
            'provider' => $provider,
            'verified_at' => now()->timestamp,
            'expires_at' => now()->addMinutes(30)->timestamp,
        ]);

        return response()->json([
            'valid' => true,
            'verified_name' => $verifiedName,
            'reference_id' => $referenceId,
            'provider' => $provider,
        ]);
    }
    */

    public function lookupPincode($pin)
    {
        if (!preg_match('/^\d{6}$/', $pin)) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid pincode format'
            ], 422);
        }

        try {
            $providers = [
                "https://api.postalpincode.in/pincode/" . $pin,
            ];

            $po = null;
            $lastError = null;

            foreach ($providers as $endpoint) {

                $response = Http::withOptions([
                    'verify' => false, // helps with SSL issues sometimes
                ])
                    ->timeout(5)
                    ->retry(3, 300)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0', // 🔥 VERY IMPORTANT (prevents blocking)
                    ])
                    ->get($endpoint);

                if (!$response->successful()) {
                    $lastError = $response->body();
                    continue;
                }

                $data = $response->json();

                if (
                    empty($data) ||
                    $data[0]['Status'] !== 'Success' ||
                    empty($data[0]['PostOffice'])
                ) {
                    $lastError = $data;
                    continue;
                }

                $po = $data[0]['PostOffice'][0];
                break;
            }

            if (!$po) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Pincode not found'
                ], 404);
            }

            return response()->json([
                'valid' => true,
                'city' => $po['District'],
                'state' => $po['State'],
            ]);
        } catch (\Throwable $e) {
            Log::error('Pincode lookup failed', [
                'pin' => $pin,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'valid' => false,
                'message' => 'Service temporarily unavailable'
            ], 500);
        }
    }

    public function businessDetailsRegister(Request $request)
    {
        if (!$request->session()->has('seller_onboard_login')) {
            return $request->expectsJson()
                ? response()->json([
                    'status' => false,
                    'message' => 'Session expired. Please login again.',
                    'redirect_url' => route('seller.login'),
                ], 401)
                : redirect()->route('seller.login');
        }

        $login = (string) $request->session()->get('seller_onboard_login', '');
        $sessionMobile = (string) $request->session()->get('seller_onboard_mobile', '');
        $existingSeller = null;
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $existingSeller = Sellers::query()->where('email', $login)->first();
        } else {
            $normalizedLogin = preg_replace('/\D/', '', $login);
            $existingSeller = Sellers::query()
                ->where('mobile', $normalizedLogin)
                ->orWhere('mobile', '+91' . $normalizedLogin)
                ->first();
        }
        $existingSellerId = $existingSeller?->id;

        $emailRules = ['required', 'email', 'max:255'];
        if (Schema::hasColumn('sellers', 'email')) {
            $emailRules[] = Rule::unique('sellers', 'email')->ignore($existingSellerId);
        }

        $validated = $request->validate([
            'legal_business_name' => ['required', 'string', 'max:255'],
            'store_display_name' => ['required', 'string', 'max:150'],
            'business_type' => ['required', 'in:sole,partnership,pvt,llp,other'],

            'pan_number' => ['required', 'string', 'size:10', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/'],
            'pan_name' => ['required', 'string', 'max:255'],
            'email' => $emailRules,
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:150'],
            'district' => ['required', 'string', 'max:150'],
            'pincode' => ['required', 'digits:6'],
            'building_number' => ['required', 'string', 'max:255'],
            'street' => ['nullable', 'string', 'max:150'],

            'pickup_address_line1' => ['required', 'string', 'max:255'],
            'pickup_address_line2' => ['required', 'string', 'max:255'],
            'pickup_pincode' => ['required', 'digits:6'],
            'pickup_city' => ['required', 'string', 'max:255'],
            'pickup_state' => ['required', 'string', 'max:255'],
            'pickup_landmark' => ['nullable', 'string', 'max:255'],
            'contact_person_name' => ['required', 'string', 'max:255'],
            'contact_mobile' => ['required', 'digits:10'],
            'alternate_mobile' => ['nullable', 'digits:10'],

            // Bank details step temporarily disabled.
            'product_categories' => ['required', 'array', 'min:1'],
            'product_categories.*' => ['required', 'integer', 'exists:master_category_sections,id'],
            'monthly_order_capacity' => ['required', 'string', 'max:50'],
            'average_dispatch_time' => ['required', 'string', 'max:50'],

            'captcha' => ['required', 'string', 'min:4', 'max:10'],
        ], [
            'email.unique' => 'This email is already registered. Please use a different email.',
        ]);

        $contactMobile = preg_replace('/\D/', '', (string) ($validated['contact_mobile'] ?? ''));
        $sellerMobile = $contactMobile !== '' ? $contactMobile : preg_replace('/\D/', '', $sessionMobile);
        if (Schema::hasColumn('sellers', 'mobile') && $sellerMobile !== '') {
            $phoneTaken = Sellers::query()
                ->where('mobile', $sellerMobile)
                ->when($existingSellerId, fn($q) => $q->where('id', '!=', $existingSellerId))
                ->exists();

            if ($phoneTaken) {
                throw ValidationException::withMessages([
                    'mobile' => ['This mobile number is already registered. Please use another number.'],
                ]);
            }
        }

        try {
            // CAPTCHA validation (single-use, 10 minutes).
            $expectedCaptcha = (string) $request->session()->get('seller_onboard_captcha', '');
            $expiresAt = (int) $request->session()->get('seller_onboard_captcha_expires_at', 0);
            if ($expectedCaptcha === '' || $expiresAt < now()->timestamp) {
                throw ValidationException::withMessages([
                    'captcha' => ['CAPTCHA expired. Please refresh and try again.'],
                ]);
            }
            if (strtoupper(trim($validated['captcha'])) !== strtoupper($expectedCaptcha)) {
                throw ValidationException::withMessages([
                    'captcha' => ['Incorrect CAPTCHA. Please try again.'],
                ]);
            }

            $panClient = new PanVerifyClient();
            if ($panClient->isConfigured()) {
                $panData = $panClient->lookup($validated['pan_number']);
                $holder = $panData['holder_name'] ?? null;
                if (is_string($holder) && trim($holder) !== '') {
                    if ($this->normalizeNameForMatch($validated['pan_name']) !== $this->normalizeNameForMatch($holder)) {
                        throw ValidationException::withMessages([
                            'pan_name' => ['PAN name does not match PAN holder name.'],
                        ]);
                    }
                }
            }

            $seller = DB::transaction(function () use ($login, $sellerMobile, $validated) {
                if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                    $seller = Sellers::query()->firstOrNew(['email' => $login]);
                } else {
                    $normalizedLogin = preg_replace('/\D/', '', $login);
                    $seller = Sellers::query()->firstOrNew(['mobile' => $normalizedLogin]);
                }

                if (Schema::hasColumn('sellers', 'email')) {
                    $seller->email = (string) ($validated['email'] ?? $login);
                }
                if (Schema::hasColumn('sellers', 'mobile') && $sellerMobile !== '') {
                    $seller->mobile = $sellerMobile;
                }
                if (Schema::hasColumn('sellers', 'name')) {
                    $seller->name = (string) ($validated['store_display_name'] ?? '');
                }
                if (Schema::hasColumn('sellers', 'contact_person')) {
                    $seller->contact_person = (string) ($validated['contact_person_name'] ?? '');
                }
                if (Schema::hasColumn('sellers', 'is_onboard')) {
                    $seller->is_onboard = 1;
                }
                if (Schema::hasColumn('sellers', 'is_active') && $seller->is_active === null) {
                    $seller->is_active = 0;
                }
                $seller->save();

                return $seller;
            });
        } catch (ValidationException $e) {
            throw $e;
        } catch (QueryException $e) {
            $errno = (int) ($e->errorInfo[1] ?? 0);
            if ($errno === 1062) {
                $key = '';
                if (preg_match("/for key '([^']+)'/i", $e->getMessage(), $m)) {
                    $key = (string) ($m[1] ?? '');
                }

                if ($key !== '' && (str_contains($key, 'email') || str_contains($key, 'EMAIL'))) {
                    throw ValidationException::withMessages([
                        'email' => ['This email is already registered. Please use a different email.'],
                    ]);
                }
                if ($key !== '' && (str_contains($key, 'mobile') || str_contains($key, 'MOBILE'))) {
                    throw ValidationException::withMessages([
                        'mobile' => ['This mobile number is already registered. Please use another number.'],
                    ]);
                }

                throw ValidationException::withMessages([
                    'email' => ['These details are already registered. Please use different details.'],
                ]);
            }

            Log::error('Seller onboarding save failed (db)', [
                'login' => $login,
                'mobile' => $sellerMobile,
                'exception' => $e,
            ]);

            return $request->expectsJson()
                ? response()->json([
                    'status' => false,
                    'message' => config('app.debug')
                        ? ('Unable to save seller details: ' . $e->getMessage())
                        : 'Unable to save seller details. Please try again.',
                ], 500)
                : back()->with('error', 'Unable to save seller details. Please try again.');
        } catch (\Throwable $e) {
            Log::error('Seller onboarding save failed', [
                'login' => $login,
                'mobile' => $sellerMobile,
                'exception' => $e,
            ]);

            return $request->expectsJson()
                ? response()->json([
                    'status' => false,
                    'message' => config('app.debug')
                        ? ('Unable to save seller details: ' . $e->getMessage())
                        : 'Unable to save seller details. Please try again.',
                ], 500)
                : back()->with('error', 'Unable to save seller details. Please try again.');
        }

        if ((int) $seller->is_active === 1) {
            $this->ensureSellerSlug($seller);
            Auth::guard('seller')->login($seller);
            $request->session()->regenerate();
            $request->session()->forget([
                'seller_onboard_mobile',
                'seller_onboard_login',
                'seller_onboard_captcha',
                'seller_onboard_captcha_expires_at',
            ]);

            return $request->expectsJson()
                ? response()->json([
                    'status' => true,
                    'message' => 'Registration already completed.',
                    'redirect_url' => route('seller.dashboard', ['seller' => $seller->slug]),
                ])
                : redirect()->route('seller.dashboard', ['seller' => $seller->slug]);
        }

        $pendingPayload = $validated;
        $pendingPayload['mobile'] = $sellerMobile;
        $pendingPayload['otp_mobile'] = (string) ($validated['contact_mobile'] ?? '');
        $pendingPayload['otp_email'] = (string) ($validated['email'] ?? '');

        $request->session()->put('seller_registration_pending_login', $login);
        $request->session()->put('seller_registration_pending_payload', $pendingPayload);
        $request->session()->put('seller_registration_pending_expires_at', now()->addMinutes(30)->timestamp);

        $sendResult = $this->sendRegistrationOtpToContacts(
            $login,
            (string) ($validated['email'] ?? ''),
            $sellerMobile
        );
        $sent = (bool) ($sendResult['email_sent'] ?? false) || (bool) ($sendResult['sms_sent'] ?? false);
        if (!$sent) {
            return $request->expectsJson()
                ? response()->json([
                    'status' => false,
                    'message' => 'Unable to send OTP right now. Please try again.',
                ], 500)
                : back()->with('error', 'Unable to send OTP right now. Please try again.');
        }

        $request->session()->forget([
            'seller_onboard_mobile',
            'seller_onboard_login',
            'seller_onboard_captcha',
            'seller_onboard_captcha_expires_at',
        ]);

        if ($request->expectsJson()) {
            $payload = [
                'status' => true,
                'message' => 'OTP sent to your seller email and phone. Please verify to continue.',
                'redirect_url' => route('seller.registration-otp'),
            ];
            if (app()->environment('local') || config('app.debug')) {
                $payload['otp'] = $sendResult['otp'] ?? null;
            }
            return response()->json($payload);
        }

        return redirect()->route('seller.registration-otp')->with('success', 'OTP sent to your seller email and contact phone. Please verify to continue.');
    }


    private function sendRegistrationOtpToContacts(string $login, string $email, string $phone): array
    {
        $otp = random_int(100000, 999999);

        Cache::put($this->registrationOtpCacheKey(crc32($login)), $otp, now()->addMinutes(5));

        $emailSent = false;
        $smsSent = false;
        $smsMocked = false;
        $normalizedMobile = preg_replace('/\D/', '', $phone);

        try {
            $sellerEmail = trim($email);
            if (filter_var($sellerEmail, FILTER_VALIDATE_EMAIL)) {
                try {
                    Mail::to($sellerEmail)->send(new OtpMail($otp));
                    $emailSent = true;
                } catch (\Throwable $e) {
                    Log::warning('Seller registration OTP email send failed', [
                        'login' => $login,
                        'email' => $sellerEmail,
                        'exception' => $e,
                    ]);
                }
            } else {
                Log::warning('Seller registration OTP email skipped: invalid email', [
                    'login' => $login,
                    'email' => $sellerEmail,
                ]);
            }

            if ($normalizedMobile !== '') {
                if (app()->environment('local')) {
                    Log::info("MOCK SELLER REGISTRATION OTP for {$normalizedMobile} : {$otp}");
                    $smsSent = true;
                    $smsMocked = true;
                } else {
                    $apiKey = (string) config('services.fast2sms.key');
                    if ($apiKey === '') {
                        Log::warning('Seller registration OTP SMS skipped: missing FAST2SMS key', [
                            'login' => $login,
                            'mobile' => $normalizedMobile,
                        ]);
                    } else {
                        $response = Http::timeout(10)
                            ->retry(2, 200)
                            ->asForm()
                            ->withHeaders([
                                'authorization' => $apiKey,
                            ])->post('https://www.fast2sms.com/dev/bulkV2', [
                                    'route' => 'q',
                                    'message' => "Your seller registration OTP is: {$otp}",
                                    'language' => 'english',
                                    'numbers' => $normalizedMobile,
                                ]);

                        if ($response->successful()) {
                            $smsSent = true;
                        } else {
                            Log::warning('Seller registration OTP SMS failed', [
                                'login' => $login,
                                'mobile' => $normalizedMobile,
                                'response' => $response->json(),
                            ]);
                        }
                    }
                }
            }

            Log::info('Seller registration OTP sent', [
                'login' => $login,
                'email' => $sellerEmail ?? null,
                'mobile' => $normalizedMobile,
                'email_sent' => $emailSent,
                'sms_sent' => $smsSent,
                'sms_mocked' => $smsMocked,
            ]);
        } catch (\Throwable $e) {
            Log::error('Seller registration OTP send failed', [
                'login' => $login,
                'email' => $email ?: null,
                'mobile' => $phone ?: null,
                'exception' => $e,
            ]);
        }

        return [
            'otp' => $otp,
            'email_sent' => $emailSent,
            'sms_sent' => $smsSent,
            'sms_mocked' => $smsMocked,
            'mobile' => $normalizedMobile,
        ];
    }


    public function showRegistrationOtpForm(Request $request)
    {
        $login = (string) $request->session()->get('seller_registration_pending_login', '');
        $payload = $request->session()->get('seller_registration_pending_payload');
        $expiresAt = (int) $request->session()->get('seller_registration_pending_expires_at', 0);

        if ($login === '' || !is_array($payload) || ($expiresAt > 0 && $expiresAt < now()->timestamp)) {
            return redirect()->route('seller.login');
        }

        $sellerEmail = (string) ($payload['otp_email'] ?? $payload['email'] ?? '');
        $sellerPhone = (string) ($payload['otp_mobile'] ?? $payload['mobile'] ?? '');


        return view('seller.selleronboard.registration-otp', compact('sellerEmail', 'sellerPhone'));
    }


    public function verifyRegistrationOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $login = (string) $request->session()->get('seller_registration_pending_login', '');
        $payload = $request->session()->get('seller_registration_pending_payload');
        $expiresAt = (int) $request->session()->get('seller_registration_pending_expires_at', 0);

        if ($login === '' || !is_array($payload) || ($expiresAt > 0 && $expiresAt < now()->timestamp)) {
            return redirect()->route('seller.login')->with('error', 'Session expired. Please login again.');
        }

        $storedOtp = Cache::get($this->registrationOtpCacheKey(crc32($login)));
        if (!$storedOtp || (string) $storedOtp !== (string) $request->otp) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        $otpCacheKey = $this->registrationOtpCacheKey(crc32($login));
        $processingLockKey = $otpCacheKey . '_processing';

        // Prevent double-submit races from creating duplicate save attempts.
        if (!Cache::add($processingLockKey, true, now()->addMinutes(2))) {
            $seller = filter_var($login, FILTER_VALIDATE_EMAIL)
                ? Sellers::query()->firstWhere('email', $login)
                : Sellers::query()->firstWhere('mobile', preg_replace('/\D/', '', $login));
            if ($seller && (int) $seller->is_onboard === 1) {
                $this->ensureSellerSlug($seller);

                $request->session()->forget([
                    'seller_registration_pending_login',
                    'seller_registration_pending_payload',
                    'seller_registration_pending_expires_at',
                    'seller_onboard_mobile',
                    'seller_onboard_login',
                    'seller_onboard_captcha',
                    'seller_onboard_captcha_expires_at',
                ]);

                Auth::guard('seller')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('seller.login')
                    ->with('success', 'Seller registration verified successfully. Please log in to continue.');
            }

            return back()->with('error', 'Your OTP verification is already in progress. Please wait and try again.');
        }

        Cache::forget($otpCacheKey);

        $mobile = (string) ($payload['contact_mobile'] ?? $payload['mobile'] ?? '');

        try {
            $seller = DB::transaction(function () use ($login, $mobile, $payload) {
                if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                    $seller = Sellers::query()->firstOrNew(['email' => $login]);
                } else {
                    $seller = Sellers::query()->firstOrNew(['mobile' => preg_replace('/\D/', '', $login)]);
                }

                if (Schema::hasColumn('sellers', 'email')) {
                    $seller->email = (string) ($payload['email'] ?? '');
                }
                if (Schema::hasColumn('sellers', 'mobile') && $mobile !== '') {
                    $seller->mobile = $mobile;
                }
                if (Schema::hasColumn('sellers', 'name') && blank($seller->name)) {
                    $seller->name = (string) ($payload['store_display_name'] ?? '');
                }
                if (Schema::hasColumn('sellers', 'contact_person') && blank($seller->contact_person)) {
                    $seller->contact_person = (string) ($payload['contact_person_name'] ?? '');
                }
                if (Schema::hasColumn('sellers', 'compliance_status')) {
                    $seller->compliance_status = $seller->compliance_status ?: 'pending';
                }
                if (Schema::hasColumn('sellers', 'is_active') && $seller->is_active === null) {
                    $seller->is_active = 0;
                }
                if (Schema::hasColumn('sellers', 'is_onboard')) {
                    $seller->is_onboard = 1;
                }

                $seller->save();
                $this->ensureSellerSlug($seller);

                SellerBusinessDetail::updateOrCreate(
                    ['seller_id' => $seller->id],
                    [
                        'legal_business_name' => (string) ($payload['legal_business_name'] ?? ''),
                        'store_display_name' => (string) ($payload['store_display_name'] ?? ''),
                        'business_type' => (string) ($payload['business_type'] ?? ''),
                        'pan_number' => (string) ($payload['pan_number'] ?? ''),
                        'pan_name' => (string) ($payload['pan_name'] ?? ''),
                    ],
                );

                SellerAddress::updateOrCreate(
                    ['seller_id' => $seller->id],
                    [
                        'email' => (string) ($payload['email'] ?? ''),
                        'city' => (string) ($payload['city'] ?? ''),
                        'state' => (string) ($payload['state'] ?? ''),
                        'district' => (string) ($payload['district'] ?? ''),
                        'pincode' => (string) ($payload['pincode'] ?? ''),
                        'building_number' => (string) ($payload['building_number'] ?? ''),
                        'street' => $payload['street'] ?? null,
                    ],
                );

                SellerPickupAddress::updateOrCreate(
                    ['seller_id' => $seller->id],
                    [
                        'pickup_address_line1' => (string) ($payload['pickup_address_line1'] ?? ''),
                        'pickup_address_line2' => (string) ($payload['pickup_address_line2'] ?? ''),
                        'pickup_city' => (string) ($payload['pickup_city'] ?? ''),
                        'pickup_state' => (string) ($payload['pickup_state'] ?? ''),
                        'pickup_pincode' => (string) ($payload['pickup_pincode'] ?? ''),
                        'pickup_landmark' => $payload['pickup_landmark'] ?? null,
                        'contact_person_name' => (string) ($payload['contact_person_name'] ?? ''),
                        'contact_mobile' => (string) ($payload['contact_mobile'] ?? ''),
                        'alternate_mobile' => $payload['alternate_mobile'] ?? null,
                    ],
                );

                SellerSupplierDetail::updateOrCreate(
                    ['seller_id' => $seller->id],
                    [
                        'product_categories' => is_array($payload['product_categories'] ?? null)
                            ? implode(',', array_map('intval', $payload['product_categories']))
                            : '',
                        'monthly_order_capacity' => (string) ($payload['monthly_order_capacity'] ?? ''),
                        'average_dispatch_time' => (string) ($payload['average_dispatch_time'] ?? ''),
                    ],
                );

                return $seller;
            });

            // send welcome mail
            Mail::to($seller->email)->send(
                new SellerRegistrationSuccessMail($seller)
            );

            // create notification
            $payloadNotification = NotificationTemplateService::sellerWelcome($seller);

            NotificationService::create([
                'receiver_id' => $seller->id,
                'receiver_type' => 'seller',
                'title' => $payloadNotification['title'],
                'message' => $payloadNotification['message'],
                'type' => $payloadNotification['type'],
                'details' => $payloadNotification['details'],
                'reference_id' => $payloadNotification['reference_id'],
                'is_read' => false,
            ]);

        } catch (\Throwable $e) {
            Log::error('Seller onboarding save failed (post-otp)', [
                'login' => $login,
                'mobile' => $mobile,
                'exception' => $e,
            ]);

            Cache::forget($processingLockKey);
            return back()->with('error', 'Unable to save details right now. Please try again.');
        }

        Cache::forget($processingLockKey);

        $request->session()->forget([
            'seller_registration_pending_login',
            'seller_registration_pending_payload',
            'seller_registration_pending_expires_at',
            'seller_onboard_mobile',
            'seller_onboard_login',
            'seller_onboard_captcha',
            'seller_onboard_captcha_expires_at',
        ]);

        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login')
            ->with('success', 'Seller registration verified successfully. Please log in to continue.');
    }

    public function resendRegistrationOtp(Request $request)
    {
        $login = (string) $request->session()->get('seller_registration_pending_login', '');
        $payload = $request->session()->get('seller_registration_pending_payload');
        $expiresAt = (int) $request->session()->get('seller_registration_pending_expires_at', 0);

        if ($login === '' || !is_array($payload) || ($expiresAt > 0 && $expiresAt < now()->timestamp)) {
            return response()->json([
                'status' => false,
                'message' => 'Session expired. Please login again.',
                'redirect_url' => route('seller.login'),
            ], 401);
        }

        $result = $this->sendRegistrationOtpToContacts(
            $login,
            (string) ($payload['otp_email'] ?? $payload['email'] ?? ''),
            (string) ($payload['otp_mobile'] ?? $payload['mobile'] ?? ''),
        );
        $sent = (bool) ($result['email_sent'] ?? false) || (bool) ($result['sms_sent'] ?? false);

        if (!$sent) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to resend OTP right now. Please try again later.',
            ], 500);
        }

        $payload = [
            'status' => true,
            'message' => 'OTP resent successfully.',
        ];

        if (app()->environment('local') || config('app.debug')) {
            $payload['otp'] = $result['otp'] ?? null;
        }

        return response()->json($payload);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $login = trim($request->login);

        try {

            if (preg_match('/^\d{10}$/', $login)) {
                $type = 'mobile';
            } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $type = 'email';
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Enter valid mobile number or email',
                ], 422);
            }

            $normalizedLogin = preg_replace('/\D/', '', $login);
            $sellerAuth = Sellers::where('mobile', $login)
                ->orWhere('mobile', $normalizedLogin)
                ->orWhere('mobile', '+91' . $normalizedLogin)
                ->orWhere('email', $login)
                ->first();
            if ($sellerAuth) {
                if ((int) $sellerAuth->is_onboard === 1 && (int) $sellerAuth->is_active === 1) {
                    // Existing sellers must still verify OTP before login completes.
                    // We only send the OTP here; the actual guard login happens in verifyOtp().
                }

                if ((int) $sellerAuth->is_onboard === 1 && (int) $sellerAuth->is_active !== 1) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Your account is waiting for admin approval.',
                    ], 403);
                }
            }

            $otp = random_int(100000, 999999);

            Cache::put('otp_' . $login, $otp, now()->addMinutes(5));
            Cache::put('otp_login_type_' . $login, $type, now()->addMinutes(5));

            if ($type === 'mobile') {

                if (app()->environment('local')) {
                    Log::info("LOGIN OTP for {$login}: {$otp}");
                } else {
                    $response = Http::asForm()->withHeaders([
                        'authorization' => config('services.fast2sms.key'),
                        'accept' => 'application/json',
                    ])->post('https://www.fast2sms.com/dev/bulkV2', [
                                'route' => 'q',
                                'message' => "Your login OTP is: $otp",
                                'language' => 'english',
                                'numbers' => $login,
                            ]);

                    if (!$response->successful()) {
                        Log::warning('OTP SMS failed', [
                            'login' => $login,
                            'response' => $response->body(),
                        ]);

                        return response()->json([
                            'status' => false,
                            'message' => 'Failed to send OTP. Try again.',
                        ], 500);
                    }
                }
            } else {

                Mail::raw("Your login OTP is: $otp", function ($message) use ($login) {
                    $message->to($login)
                        ->subject('Your OTP Code');
                });
            }

            return response()->json([
                'status' => true,
                'next_step' => 'verify-otp',
                'message' => 'OTP sent successfully. Please verify to continue.',
                'type' => $type,
                'login' => $login,
                'user_exists' => $sellerAuth ? true : false,

                'otp' => (app()->environment('local') || config('app.debug')) ? $otp : null,
            ]);
        } catch (\Throwable $e) {

            Log::error('Login OTP failed', [
                'login' => $login,
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }


    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $login = trim($request->login);
        $otp = $request->otp;

        $storedOtp = Cache::get('otp_' . $login);

        if (!$storedOtp || $storedOtp != $otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired OTP',
            ], 401);
        }

        $loginType = Cache::get('otp_login_type_' . $login);
        Cache::forget('otp_' . $login);
        Cache::forget('otp_login_type_' . $login);

        $seller = null;
        $isEmailLogin = $loginType === 'email' || filter_var($login, FILTER_VALIDATE_EMAIL);
        $normalizedMobile = null;

        if ($isEmailLogin) {
            $seller = Sellers::where('email', $login)->first();
        } else {
            $normalizedMobile = preg_replace('/\D/', '', $login);
            $seller = Sellers::where('mobile', $normalizedMobile)->first();
            if (!$seller && $normalizedMobile !== '') {
                $seller = Sellers::where('mobile', '+91' . $normalizedMobile)->first();
            }
        }

        // Always store session for the registration flow.
        $request->session()->put('seller_onboard_login', $login);
        if ($isEmailLogin) {
            $request->session()->put('seller_onboard_email', $login);
        } else {
            $request->session()->put('seller_onboard_mobile', $normalizedMobile ?: $login);
        }

        /**
         * ============================
         * EXISTING USER (LOGIN FLOW)
         * ============================
         */
        if ($seller && (int) $seller->is_onboard === 1) {

            if ((int) $seller->is_active !== 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is waiting for admin approval',
                ], 403);
            }

            $this->ensureSellerSlug($seller);
            Auth::guard('seller')->login($seller);
            $request->session()->regenerate();

            return response()->json([
                'status' => true,
                'next_step' => 'dashboard',
                'redirect_url' => route('seller.dashboard', ['seller' => $seller->slug]),
                'seller_slug' => $seller->slug,
                'message' => 'Login successful',
            ]);
        }

        /**
         * ============================
         * NEW USER (REGISTRATION FLOW)
         * ============================
         */
        return response()->json([
            'status' => true,
            'next_step' => 'business-details',
            'redirect_url' => route('seller.business-details'),
            'message' => 'Please complete your registration',
        ]);
    }
}
