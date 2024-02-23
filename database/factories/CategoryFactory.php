<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = $this->faker->unique()->randomNumber;
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'order' => $order,
            'is_active' => $this->faker->boolean,
            'created_by' => rand(1, 2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
