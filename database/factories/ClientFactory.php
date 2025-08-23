<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'brand_name'    => $this->faker->company,
            'website'       => $this->faker->url,
            'company_email' => $this->faker->unique()->companyEmail,
            'subdomain'     => $this->faker->unique()->domainWord,
            'status'        => $this->faker->randomElement(['active', 'inactive', 'pending']),
            'onboarded_at'  => now(),
            'branding'      => [
                'primary_color' => $this->faker->hexColor,
                'logo_url'      => $this->faker->imageUrl(200, 200, 'business', true, 'logo'),
            ],
            'user_id'       => User::factory(), // links client to an owner
        ];
    }
}
