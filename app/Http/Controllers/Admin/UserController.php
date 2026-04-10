<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'))
            ->get();

        $roles = Role::whereNotIn('name', ['admin'])->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:student,teacher,user'],
        ]);

        $user->syncRoles([$request->role]);
        $user->update(['selected_role' => $request->role]);

        return back()->with('success', "Role updated to {$request->role} for {$user->name}.");
    }
}