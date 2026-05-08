<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\UserOtp;

class CustomerAuthController extends Controller
{

    public function index()
    {
        return view('website.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'identifier' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL);
                    $isPhone = preg_match('/^[0-9\+\-\s\(\)]{10,20}$/', $value);

                    if (!$isEmail && !$isPhone) {
                        $fail('Enter valid email or mobile number.');
                    }
                },
            ],
            'is_resend' => 'nullable|boolean'
        ]);

        $identifier = $this->normalizeIdentifier($request->identifier);
        $isResend = $request->boolean('is_resend');

        $existing = UserOtp::where('identifier', $identifier)->first();

        // ✅ APPLY RATE LIMIT ONLY FOR RESEND
        if ($isResend && $existing && now()->diffInSeconds($existing->updated_at) < 30) {
            return response()->json([
                'message' => 'Please wait before requesting a new OTP.'
            ], 429);
        }

        $otp = random_int(100000, 999999);

        if ($existing) {
            $existing->update([
                'otp' => Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
            ]);
        } else {
            UserOtp::create([
                'identifier' => $identifier,
                'otp' => Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
            ]);
        }

        // SEND OTP (same as yours)
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $sent = $this->sendEmailOtp($identifier, $otp);
        } else {
            $sent = $this->sendSmsOtp($identifier, $otp);
        }

        if (!$sent) {
            return response()->json([
                'message' => 'OTP service temporarily unavailable. Try again later.'
            ], 503);
        }

        return response()->json([
            'message' => 'OTP sent successfully',
            'expires_in' => 300
        ]);
    }

    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'identifier' => 'required',
    //         'otp' => 'required|digits:6'
    //     ]);

    //     $identifier = $this->normalizeIdentifier($request->identifier);

    //     $record = UserOtp::where('identifier', $identifier)->first();

    //     if (!$record || now()->greaterThan($record->expires_at)) {
    //         return response()->json(['message' => 'OTP expired'], 400);
    //     }

    //     if ($record->attempts >= 5) {
    //         return response()->json(['message' => 'Too many attempts'], 429);
    //     }

    //     if (!Hash::check($request->otp, $record->otp)) {

    //         Log::warning('OTP mismatch', [
    //             'identifier' => $identifier,
    //             'entered' => $request->otp,
    //         ]);

    //         $record->increment('attempts');

    //         return response()->json(['message' => 'Invalid OTP'], 400);
    //     }

    //     // ✅ SUCCESS
    //     $record->delete();

    //     $user = User::where('email', $identifier)
    //         ->orWhere('phone', $identifier)
    //         ->first();

    //     if ($user) {
    //         Auth::guard('customer')->login($user, true);

    //         return response()->json([
    //             'is_new' => false,
    //             'redirect' => session()->pull('url.intended', route('home'))
    //         ]);
    //     }

    //     return response()->json([
    //         'is_new' => true
    //     ]);
    // }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'otp' => 'required|digits:6'
        ]);
        $identifier = $this->normalizeIdentifier($request->identifier);
        $record = UserOtp::where('identifier', $identifier)->first();
        if (!$record) {
            return response()->json(['message' => 'OTP expired'], 400);
        }
        if (now()->timestamp > strtotime($record->expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }
        if ($record->attempts >= 5) {
            return response()->json(['message' => 'Too many attempts'], 429);
        }
        if (!Hash::check($request->otp, $record->otp)) {
            $record->increment('attempts');
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
        UserOtp::where('identifier', $identifier)->delete();
        $user = User::where('email', $identifier)
            ->orWhere('phone', $identifier)
            ->first();
        if ($user) {
            Auth::guard('customer')->login($user, true);
            return response()->json([
                'is_new' => false,
                'redirect' => session()->pull('url.intended', route('home'))
            ]);
        }
        return response()->json([
            'is_new' => true
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    private function sendEmailOtp($email, $otp)
    {
        try {
            Mail::to($email)->send(new OtpMail($otp));
            return true; // if no exception, assume success
        } catch (\Throwable $e) {
            Log::error('Mail Failed: ' . $e->getMessage());
            return false;
        }
    }

    private function sendSmsOtp($phone, $otp)
    {
        // Normalize phone
        $phone = preg_replace('/\D/', '', $phone);

        // LOCAL MOCK
        if (app()->environment('local')) {
            Log::info("MOCK SMS OTP for {$phone} : {$otp}");
            return true;
        }

        try {
            $response = Http::timeout(10)
                ->retry(2, 200)
                ->get('https://www.fast2sms.com/dev/bulkV2', [
                    'authorization' => config('services.fast2sms.key'),
                    'route' => 'otp',
                    'variables_values' => $otp,
                    'flash' => 0,
                    'numbers' => $phone,
                ]);

            if (!$response->successful()) {
                return false;
            }

            $data = $response->json();

            // Fast2SMS specific check
            return isset($data['return']) && $data['return'] === true;
        } catch (\Throwable $e) {
            Log::error('SMS Failed: ' . $e->getMessage());
            return false;
        }
    }

    private function normalizeIdentifier($identifier)
    {
        $identifier = trim($identifier);

        // If NOT email → treat as phone and keep digits only
        if (!filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $identifier = preg_replace('/\D/', '', $identifier);
        }

        return $identifier;
    }

    public function completeProfile(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'name' => 'required|string|max:100',
            'secondary' => 'required|string|max:100',
        ]);

        $identifier = $this->normalizeIdentifier($request->identifier);

        $user = User::where('email', $identifier)
            ->orWhere('phone', $identifier)
            ->first();

        if (!$user) {
            $user = new User();
        }

        // ✅ Directly store full name (trimmed & sanitized)
        $user->name = trim($request->name);

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user->email = $identifier;
            $user->phone = preg_replace('/\D/', '', $request->secondary);
        } else {
            $user->phone = preg_replace('/\D/', '', $identifier);
            $user->email = $request->secondary;
        }

        $user->save();

        Auth::guard('customer')->login($user, true);

        return response()->json([
            'redirect' => route('home')
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $email = $googleUser->getEmail();

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => trim($googleUser->getName() ?? 'User'),
                    'email' => $email,
                    'profile_image' => $googleUser->getAvatar(),
                    'is_verified' => true,
                ]);
            }
            Auth::guard('customer')->login($user, true);
            return redirect()->route('home');
        } catch (\Throwable $e) {
            Log::error('Google Login Error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('customer.login')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function profile()
    {
        echo 'Hamba Hamba Ramba Ramba';
    }
}
