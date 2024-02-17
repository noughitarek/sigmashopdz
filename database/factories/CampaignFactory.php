<?php

namespace Database\Factories;

use App\Models\User;
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

            'daily_budget' => rand(5, 10),
            'total_budget' => rand(5, 10)*5,
            
            'is_active' => $this->faker->boolean,
            'changed_at' => $this->faker->dateTime,
            'started_at' => $this->faker->dateTime,
            'ended_at' => $this->faker->optional()->dateTime,
            
            'created_by' => function () {
                return User::factory()->create()->id;
            }
        ];
    }
}
