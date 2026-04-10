<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    // List all permissions
    public function index()
    {
        $permissions = Permission::with('roles')->get();
        $roles = Role::whereNotIn('name', ['admin'])->get();
        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    // Store a new permission
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name', 'max:255'],
        ]);

        Permission::create(['name' => $request->name]);

        return back()->with('success', "Permission '{$request->name}' created successfully.");
    }

    // Assign permissions to a role
    public function assignToRole(Request $request)
    {
        $request->validate([
            'role_id'        => ['required', 'exists:roles,id'],
            'permissions'    => ['array'],
            'permissions.*'  => ['exists:permissions,id'],
        ]);

        $role = Role::findById($request->role_id);
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
        $role->syncPermissions($permissions);

        return back()->with('success', "Permissions updated for role '{$role->name}'.");
    }

    // Delete a permission
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', "Permission '{$permission->name}' deleted.");
    }
}