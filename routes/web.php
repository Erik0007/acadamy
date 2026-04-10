<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\UserController;
 use App\Http\controllers\Admin\PermissionController;
 use App\Http\Controllers\Admin\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin'))   return redirect()->route('admin.dashboard');
    if ($user->hasRole('teacher')) return redirect()->route('user.dashboard'); 
    if ($user->hasRole('student')) return redirect()->route('user.dashboard'); 

    return redirect()->route('user.dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');

    Route::get('/permissions',                  [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions',                 [PermissionController::class, 'store'])->name('permissions.store');
    Route::post('/permissions/assign-to-role',  [PermissionController::class, 'assignToRole'])->name('permissions.assignToRole');
    Route::delete('/permissions/{permission}',  [PermissionController::class, 'destroy'])->name('permissions.destroy');
     Route::resource('students', StudentController::class);
});

Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
});


require __DIR__.'/auth.php';
