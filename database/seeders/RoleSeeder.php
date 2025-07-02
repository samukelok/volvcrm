<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'System Administrator',
                'permissions' => ['*'],
            ],
            [
                'name' => 'client_admin',
                'description' => 'Client Administrator',
                'permissions' => ['manage_users', 'manage_funnels', 'view_reports'],
            ],
            [
                'name' => 'client_user',
                'description' => 'Client User',
                'permissions' => ['view_funnels', 'view_leads'],
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Sphelele Ngcobo',
            'email' => 'sphe@ngcobo.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $admin->assignRole('admin');
    }
}