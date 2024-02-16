<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->unique()->slug,
            'daily_budget' => $this->faker->randomFloat(2, 0, 1000),
            'started_at' => $this->faker->optional()->dateTime,
            'ended_at' => $this->faker->optional()->dateTime
        ];
    }
}
