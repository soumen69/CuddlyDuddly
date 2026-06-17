<?php

namespace App\Services\Seller;

use App\Models\Sellers;
use App\Models\SellerAddress;
use App\Models\SellerBusinessDetail;
use App\Models\SellerPickupAddress;
use App\Models\SellerSupplierDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class SellerAuthService
{
    public function sendOtp($login)
    {
        if (preg_match('/^\d{10}$/', $login)) {
            $type = 'mobile';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $type = 'email';
        } else {
            throw new \Exception('Invalide login');
        }

        $seller = Sellers::where('mobile', $login)->orWhere('email', $login)->first();

        $otp = random_int(100000, 999999);

        Cache::put('otp_for_login_' . $login, $otp, now()->addMinutes(5));

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

        return [
            'otp' => $otp,
            'success' => true,
            'login_type' => $type,
            'login' => $login,
            'user_exists' => $seller ? true : false,
            'message' => 'OTP sent successfully',
        ];
    }

    public function verifyOtpAndLogin($login, $otp)
    {
        $cachedOtp = Cache::get('otp_for_login_' . $login);

        if (!$cachedOtp || $cachedOtp != $otp) {
            throw new \Exception('Invalid OTP');
        }

        Cache::forget('otp_for_login_' . $login);

        $seller = Sellers::where('mobile', $login)->orWhere('email', $login)->first();

        if (!$seller) {
            $seller = Sellers::create([
                'mobile' => filter_var($login, FILTER_VALIDATE_EMAIL) ? null : $login,
                'email' => filter_var($login, FILTER_VALIDATE_EMAIL) ? $login : null,
                'slug' => 'seller-' . Str::random(8),  
                'verify_business_details' => false,
                'is_onboard' => false,
                'is_active' => false,
                'last_login_at' => now(),
            ]);
        } else {
            $seller->update([
                'last_login_at' => now(),
            ]);
        }

        return [
            'seller_id' => $seller->id,
            'success' => true,
            'seller' => $seller,
            'message' => 'OTP verified successfully',
        ];
    }


    public function saveBusinessDetails(array $data)
    {
        return DB::transaction(function () use ($data) {

            $seller = Sellers::findOrFail($data['seller_id']);

            $seller->update([
                'name' => $data['name'],
                'contact_person' => $data['contact_person'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
            ]);

            SellerBusinessDetail::updateOrCreate(
                ['seller_id' => $seller->id],
                [
                    'legal_business_name' => $data['legal_business_name'],
                    'store_display_name' => $data['store_display_name'],
                    'business_type' => $data['business_type'],
                    'pan_number' => $data['pan_number'],
                    'pan_name' => $data['pan_name'],
                ]
            );

            return [
                'status' => true,
                'next_step' => 'address-details',
            ];
        });
    }

    public function sellerAddress(array $data)
    {
        return DB::transaction(function () use ($data) {

            SellerAddress::updateOrCreate(
                ['seller_id' => $data['seller_id']],
                [
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'district' => $data['district'],
                    'pincode' => $data['pincode'],
                    'building_number' => $data['building_number'],
                ]
            );

            return [
                'status' => true,
                'next_step' => 'pickup-address'
            ];
        });
    }

    public function sellerPickupAddress(array $data)
    {
        return DB::transaction(function () use ($data) {

            SellerPickupAddress::updateOrCreate(
                ['seller_id' => $data['seller_id']],
                [
                    'pickup_address_line1' => $data['pickup_address_line1'],
                    'pickup_address_line2' => $data['pickup_address_line2'],
                    'pickup_city' => $data['pickup_city'],
                    'pickup_state' => $data['pickup_state'],
                    'pickup_pincode' => $data['pickup_pincode'],
                    'pickup_landmark' => $data['pickup_landmark'],
                    'contact_person_name' => $data['contact_person_name'],
                    'contact_mobile' => $data['contact_mobile'],
                    'alternate_mobile' => $data['alternate_mobile']
                ]
            );

            return [
                'status' => true,
                'next_step' => 'supplier-details'
            ];
        });
    }

    public function sellerSupplierDetails(array $data)
    {
        return DB::transaction(function () use ($data) {

            SellerSupplierDetail::updateOrCreate(
                ['seller_id' => $data['seller_id']],
                [
                    'product_categories' => $data['product_categories'],
                    'monthly_order_capacity' => $data['monthly_order_capacity'],
                    'average_dispatch_time' => $data['average_dispatch_time']
                ]
            );

            // FINAL STEP → mark onboarding complete
            $seller = Sellers::findOrFail($data['seller_id']);
            $seller->update([
                'is_onboard' => true,
                'verify_business_details' => true
            ]);

            return [
                'status' => true,
                'next_step' => 'send-final-otp'
            ];
        });
    }

    public function verifyFinalOtp($login, $otp)
    {
        $cachedOtp = Cache::get('otp_for_login_' . $login);

        if (!$cachedOtp || $cachedOtp != $otp) {
            throw new \Exception('Invalid OTP');
        }

        Cache::forget('otp_for_login_' . $login);

        $seller = Sellers::where('mobile', $login)->orWhere('email', $login)->firstOrFail();
        return [
            'status' => true,
            'next_step' => 'login',
            'seller_id' => $seller->id,
            'seller_slug' => $seller->slug,
            'message' => 'Registration completed. Please wait for admin approval.'
        ];

    }
}
