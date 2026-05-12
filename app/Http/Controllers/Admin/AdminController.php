<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function showAdminLoginForm()
    {
        // redirect if already logged in
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function showSellerLoginForm()
    {
        // redirect if already logged in
        if (Auth::guard('seller')->check()) {
            $seller = Auth::guard('seller')->user();
            return redirect()->route('seller.dashboard', $seller->slug);
        }

        return view('seller.login');
    }


    public function showCustomerLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('website.home');
        }
        return view('#');
    }


    public function login(Request $request)
    {
        // Prevent mismatch portal access
        if ($request->is('admin/*') && $request->user_type === 'seller') {
            return back()->withErrors(['user_type' => 'You are not allowed to login from the admin portal.']);
        }

        if ($request->is('seller/*') && $request->user_type !== 'seller') {
            return back()->withErrors(['user_type' => 'You are not allowed to login from the seller portal.']);
        }

        $request->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
            'user_type' => 'required|string',
        ]);

        $emailOrPhone = $request->email_or_phone;
        $password = $request->password;
        $userType = $request->user_type;


        // 🔍 Check if email_or_phone exists in BOTH tables (conflict)
        $adminExists = AdminUser::where('email', $emailOrPhone)
            ->orWhere('phone', $emailOrPhone)
            ->exists();

        $sellerExists = Sellers::where('email', $emailOrPhone)
            ->orWhere('mobile', $emailOrPhone)
            ->exists();

        // If both accounts exist, force the user to select correct portal/user type
        if ($adminExists && $sellerExists) {

            // User selects seller but credentials match admin too
            if ($userType === 'seller' && $adminExists) {
                return back()->withErrors([
                    'email_or_phone' => 'This credential also belongs to an Admin account. Please contact with Admin.'
                ])->withInput();
            }

            // User selects admin but credentials match seller too
            if ($userType !== 'seller' && $sellerExists) {
                return back()->withErrors([
                    'email_or_phone' => 'This credential also belongs to a Seller account. Please contact with Admin.'
                ])->withInput();
            }
        }

        /**
         * 🔹 SELLER LOGIN HANDLING
         */
        if ($userType === 'seller') {
            $seller = Sellers::where('email', $emailOrPhone)
                ->orWhere('phone', $emailOrPhone)
                ->first();

            if (!$seller) {
                return back()->withErrors(['email_or_phone' => 'No seller account found.'])->withInput();
            }

            if (!Hash::check($password, $seller->password)) {
                return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
            }

            if (!$seller->is_active) {
                return back()->withErrors(['status' => 'Your seller account is not active or not verified.'])->withInput();
            }

            Auth::guard('seller')->login($seller);
            $request->session()->regenerate();

            return redirect()->route('seller.dashboard', $seller->slug)->with('success', 'Welcome Seller ' . $seller->name . '!');
        }

        /**
         * 🔹 ADMIN LOGIN HANDLING (AdminUser + Roles)
         */
        $user = AdminUser::where('email', $emailOrPhone)
            ->orWhere('phone', $emailOrPhone)
            ->first();

        if (!$user) {
            return back()->withErrors(['email_or_phone' => 'No admin user found.'])->withInput();
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
        }

        if (!$user->isActive()) {
            return back()->withErrors(['status' => 'Your admin account is inactive.'])->withInput();
        }

        // Ensure the user has a role assigned
        if (!$user->role_id || !$user->role) {
            return back()->withErrors(['status' => 'No role assigned to your account. Please contact Super Admin.'])->withInput();
        }

        // 🧩 Match user-selected type with the assigned role slug
        if ($user->role->slug !== $userType) {
            return back()->withErrors(['user_type' => 'You do not have access to this user type.'])->withInput();
        }



        Auth::guard('admin')->login($user);
        $request->session()->regenerate();

        // Always save latest valid session ID for this admin
        $user->session_id = Session::getId();
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
    }



    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $redirect = 'admin.login';
        } elseif (Auth::guard('seller')->check()) {
            Auth::guard('seller')->logout();
            $redirect = 'seller.login';
        } else {
            $redirect = '/seller';
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($redirect)->with('success', 'Logged out successfully.');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|digits:10',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        AdminUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Admin user created successfully.');
    }

    public function update(Request $request, AdminUser $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users,email,' . $user->id,
            'phone' => 'nullable|digits:10',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role_id' => $validated['role_id'] ?? null,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Admin user updated successfully.');
    }

    public function destroy(AdminUser $user)
    {
        $user->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Admin user deleted.');
    }
}
