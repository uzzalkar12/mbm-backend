<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** Employee user*/
        $employee_role = Role::query()->create([
            'name'       => 'Employee',
            'guard_name' => 'web',
        ]);

        $employee_user = User::query()->create([
            'name'     => 'Employee',
            'email'    => 'employee@example.com',
            'password' => Hash::make('password'),
        ]);
        $employee_user->assignRole($employee_role);

        /** Employee user*/
        $admin_role = Role::query()->create([
            'name'       => 'Admin',
            'guard_name' => 'web',
        ]);

        $admin_user = User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin_user->assignRole($admin_role);

        /** Store Executive user*/
        $store_role = Role::query()->create([
            'name'       => 'Store Executive',
            'guard_name' => 'web',
        ]);

        $store_user = User::query()->create([
            'name' => 'Store Executive',
            'email' => 'store@example.com',
            'password' => Hash::make('password'),
        ]);
        $store_user->assignRole($store_role);

    }
}
