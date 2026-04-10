<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::role('user')->count();
        $totalAdmins = User::role('admin')->count();
        return view('admin.dashboard', compact('totalUsers', 'totalAdmins'));
    }
}