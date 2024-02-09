<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'order' => $this->faker->randomNumber,
            'price' => $this->faker->randomElement(range(11, 99))*100,
            'old_price' => $this->faker->optional()->randomElement(range(11, 99))*100,
            'photos' => 'prod'.$this->faker->randomElement(range(1, 13)).'.jpg',
            'videos' => $this->faker->optional()->word,
            'is_active' => $this->faker->boolean,
            'description' => $this->faker->optional()->paragraph,
            'created_by' => function () {
                return User::factory()->create()->id;
            },
            'category' => function () {
                return Category::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
