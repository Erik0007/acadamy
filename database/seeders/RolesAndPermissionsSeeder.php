<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Use firstOrCreate to avoid duplicates
        $p1 = Permission::firstOrCreate(['name' => 'view dashboard']);
        $p2 = Permission::firstOrCreate(['name' => 'manage users']);
        $p3 = Permission::firstOrCreate(['name' => 'manage roles']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo('view dashboard');

        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $studentRole->givePermissionTo('view dashboard');
        
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $teacherRole->givePermissionTo('view dashboard');

        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');
    }
}