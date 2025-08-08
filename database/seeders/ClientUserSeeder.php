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
            'brand_name' => 'Cybernetics Solutions',
            'website' => 'cybernetics.com',
            'company_email' => 'admin@cybernetics.com',
            'subdomain' => 'cybernetics',
            'branding' => '#08153dff, #ffffff',
            'user_id' => 2,
        ]);

        // Create a specific user and link to client: 
        $adminUser = User::create([
            'name' => 'Samukelo Khanya',
            'email' => 'samkelokay2@gmail.com',
            'password' => bcrypt('password'),
            'client_id' => $client->id,
        ]);

        $role = Role::firstOrCreate(['name' => 'client_user']);
        $adminUser->roles()->attach($role);

        // Optionally, add factory users
        User::factory()->count(3)->create([
            'client_id' => $client->id,
        ]);
    }
}
