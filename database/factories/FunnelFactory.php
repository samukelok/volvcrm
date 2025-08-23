<?php

namespace Database\Factories;

use App\Models\Funnel;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FunnelFactory extends Factory
{
    protected $model = Funnel::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->catchPhrase,
            'goal' => $this->faker->sentence,
            'target_audience' => $this->faker->jobTitle,
            'cta' => $this->faker->randomElement(['signup', 'download', 'demo']),
            'notes' => $this->faker->paragraph,
            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'is_active' => true,
            'priority' => $this->faker->randomElement(['Low', 'Normal', 'High', 'Urgent']), // ✅
            'status' => $this->faker->randomElement(['Pending', 'In Progress', 'Live', 'Complete']), // ✅
        ];
    }
}
