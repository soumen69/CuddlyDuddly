<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\AdminUser;
use App\Models\Sellers;

class RoleController extends Controller
{
    // public function index()
    // {
    //     $roles = Role::withCount('adminUsers')->get();
    //     $adminUsers = AdminUser::with('role')->get();

    //     return view('admin.roles.index', compact('roles', 'adminUsers'));
    // }

    public function index()
    {
        $roles = Role::withCount('adminUsers')->get();

        $sellerCount = Sellers::where('is_active', 1)
            ->count();

        foreach ($roles as $role) {
            if ($role->slug === 'seller') {
                $role->admin_users_count = $sellerCount;
            }
        }

        $adminUsers = AdminUser::with('role')->get();

        return view('admin.roles.index', compact('roles', 'adminUsers'));
    }



    // public function edit($id)
    // {
    //     $role = Role::findOrFail($id);
    //     $permissions = Permission::orderBy('group_name')
    //         ->orderBy('name')
    //         ->get()
    //         ->groupBy('group_name');
    //     $assigned = $role->permissions->pluck('id')->toArray();

    //     return view('admin.roles.edit', compact('role', 'permissions', 'assigned'));
    // }


    public function edit($id)
    {
        $role = Role::findOrFail($id);

        // Fetch all permissions grouped by module
        $permissions = Permission::orderBy('group_name')
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->groupBy('group_name');

        // Get assigned permission IDs
        $assigned = $role->permissions()->pluck('permissions.id')->toArray();

        $modules = [];

        foreach ($permissions as $groupName => $items) {
            $options = $items->where('type', 'option');
            $actions = $items->where('type', 'action');

            $optionActionPairs = [];

            foreach ($options as $option) {
                $optionSlug = $option->slug;

                // Determine action prefix
                if (Str::contains($optionSlug, 'compliance')) {
                    $prefix = 'admin.sellers.kyc';
                } elseif (Str::contains($optionSlug, 'payouts')) {
                    $prefix = 'admin.payouts';
                } else {
                    $prefix = Str::beforeLast($optionSlug, '.');
                }

                // Match actions to options
                $matched = $actions->filter(function ($a) use ($prefix) {
                    $slug = $a->slug;

                    // Exclude KYC actions from All Sellers
                    if ($prefix === 'admin.sellers' && Str::contains($slug, 'admin.sellers.kyc.')) {
                        return false;
                    }

                    return Str::startsWith($slug, $prefix);
                });

                $optionActionPairs[] = [
                    'option' => $option,
                    'actions' => $matched,
                ];
            }

            // Determine if module is active
            $isActive = collect($optionActionPairs)
                ->pluck('option.id')
                ->flatten()
                ->intersect($assigned)
                ->isNotEmpty();

            $modules[$groupName] = [
                'options' => $optionActionPairs,
                'is_active' => $isActive,
            ];
        }

        return view('admin.roles.edit', compact('role', 'modules', 'assigned'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:255',
        ]);

        Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role added successfully.');
    }



    // public function update(Request $request, $id)
    // {
    //     $role = Role::findOrFail($id);

    //     // Sync selected permissions
    //     $role->permissions()->sync($request->permission_ids ?? []);

    //     return redirect()->route('admin.roles.index')->with('success', 'Permissions updated successfully.');
    // }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $permissionIds = $request->input('permission_ids', []);
        $permissionIds = array_map('intval', $permissionIds);
        $permissionIds = array_unique($permissionIds);

        // ✅ Sync permissions
        $role->permissions()->sync($permissionIds);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Permissions updated successfully.');
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:admin_users,id',
            'role_id' => 'nullable|exists:roles,id', // allow empty for revoke
        ]);

        $user = AdminUser::findOrFail($request->user_id);

        if (empty($request->role_id)) {
            // 🧹 Revoke role
            $user->update(['role_id' => null]);
            return redirect()->back()->with('success', 'Role revoked successfully.');
        }

        // 🎯 Assign new role
        $role = Role::findOrFail($request->role_id);
        $user->update(['role_id' => $role->id]);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }
}
