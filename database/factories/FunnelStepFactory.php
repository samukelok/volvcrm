<?php

namespace Database\Factories;

use App\Models\Funnel;
use App\Models\FunnelStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class FunnelStepFactory extends Factory
{
    protected $model = FunnelStep::class;

    public function definition(): array
    {
        return [
            'funnel_id' => Funnel::factory(),
            'name' => 'Step ' . $this->faker->word,
            'step_order' => $this->faker->numberBetween(1, 5),
            'delay_hours' => $this->faker->numberBetween(0, 72),
            'condition' => null,
            'is_active' => true,
        ];
    }
}
