<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;

class ClientUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $client = Client::create([
            'brand_name' => 'Sphe',
            'website' => 'sphe.com',
            'company_email' => 'admin@sphe.com',
            'subdomain' => 'sphe',
            'branding' => '#4e73df',
        ]);

        // Create a specific user and link to client: 
        $adminUser = User::create([
            'name' => 'Sphelele Ngcobo',
            'email' => 'admin@sphe.com',
            'password' => bcrypt('password'),
            'client_id' => $client->id,
        ]);

        $role = Role::firstOrCreate(['name' => 'client_admin']);
        $adminUser->roles()->attach($role);

        // Optionally, add factory users
        User::factory()->count(3)->create([
            'client_id' => $client->id,
        ]);
    }
}
