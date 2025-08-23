<?php

namespace Database\Factories;

use App\Models\EmailTemplate;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailTemplateFactory extends Factory
{
    protected $model = EmailTemplate::class;

    public function definition(): array
    {
        return [
            'name' => 'Template ' . $this->faker->word,
            'subject' => $this->faker->sentence,
            'body_html' => '<p>' . $this->faker->paragraph . '</p>',
            'body_text' => $this->faker->paragraph,
            'category' => $this->faker->randomElement(['welcome', 'follow_up', 'promo', 'reminder', 'newsletter']),
            'is_default' => false,
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
        ];
    }
}
