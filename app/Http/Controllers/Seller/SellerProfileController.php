<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class SellerProfileController extends Controller
{
    public function index()
    {
        $seller = auth('seller')->user();
        $seller->loadMissing(['businessDetail', 'address', 'pickupAddress', 'bankDetail', 'supplierDetail']);

        $profile = [
            'full_name' => $seller->name ?? $seller->contact_person ?? 'N/A',
            'email' => $seller->email ?? optional($seller->address)->email ?? 'N/A',
            'mobile' => $seller->mobile ?? 'N/A',
            'address' => $this->formatAddress($seller),
            'username' => $seller->slug ?? $seller->name ?? 'seller',
            'role' => 'System Seller',
            'last_login_at' => $seller->last_login_at,
            'avatar_url' => $this->avatarUrl($seller),
        ];

        return view('seller.profile.indexProfile', compact('seller', 'profile'));
    }

    public function update(Request $request)
    {
        $seller = auth('seller')->user();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('sellers', 'email')->ignore($seller->id)],
            'mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $seller->name = $validated['full_name'];
        $seller->email = $validated['email'];

        if (array_key_exists('mobile', $validated)) {
            $seller->mobile = $validated['mobile'];
        }

        if ($request->hasFile('avatar')) {
            $newAvatarPath = $request->file('avatar')->store('seller_docs/avatars', 'public');

            foreach (['avatar', 'logo'] as $column) {
                if (!Schema::hasColumn((new Sellers())->getTable(), $column)) {
                    continue;
                }

                $oldPath = $seller->{$column};
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                $seller->{$column} = $newAvatarPath;
            }
        }

        $seller->save();

        if ($request->filled('address')) {
            $parsedAddress = $this->parseAddress($validated['address'], $seller->address);

            $seller->address()->updateOrCreate(
                ['seller_id' => $seller->id],
                [
                    'email' => $validated['email'],
                    'building_number' => $parsedAddress['building_number'],
                    'street' => $parsedAddress['street'],
                    'district' => $parsedAddress['district'],
                    'city' => $parsedAddress['city'],
                    'state' => $parsedAddress['state'],
                    'pincode' => $parsedAddress['pincode'],
                ]
            );
        } elseif ($seller->address) {
            $seller->address()->delete();
        }

        if ($request->filled('current_password') || $request->filled('new_password')) {
            if (!Hash::check((string) $request->input('current_password'), (string) $seller->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            $seller->password = Hash::make($validated['new_password']);
            $seller->save();
        }

        return redirect()
            ->route('seller.profile', ['seller' => $seller->slug])
            ->with('success', 'Profile updated successfully.');
    }

    private function avatarUrl($seller): string
    {
        $path = $seller->avatar ?: $seller->logo;

        if ($path) {
            return asset('storage/' . $path);
        }

        return asset('storage/images/default-avatar.png');
    }

    private function formatAddress($seller): string
    {
        $address = $seller->address;

        $parts = array_filter([
            $address->building_number ?? null,
            $address->city ?? null,
            $address->state ?? null,
            $address->district ?? null,
            $address->pincode ?? null,
            $address->street ?? null,
        ]);

        if (!empty($parts)) {
            return implode(', ', $parts);
        }

        return optional($seller->pickupAddress)->pickup_address_line1 ?: 'Add your business address';
    }

    private function parseAddress(string $addressText, $existingAddress): array
    {
        $parts = array_values(array_filter(array_map(
            'trim',
            explode(',', $addressText)
        ), static fn ($part) => $part !== ''));

        return [
            'building_number' => $parts[0] ?? $existingAddress?->building_number,
            'street' => $parts[1] ?? $existingAddress?->street,
            'district' => $parts[2] ?? $existingAddress?->district,
            'city' => $parts[3] ?? $existingAddress?->city,
            'state' => $parts[4] ?? $existingAddress?->state,
            'pincode' => isset($parts[5]) && preg_match('/^\d{4,10}$/', $parts[5])
                ? $parts[5]
                : $existingAddress?->pincode,
        ];
    }
}
