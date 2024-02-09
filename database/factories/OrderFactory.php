<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'phone' => $this->faker->phoneNumber,
            'phone2' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'commune' => $this->faker->word,
            'wilaya' => $this->faker->randomElement(range(1, 58)),
            'campaign' => $this->faker->word,
            'product' => function () {
                return Product::factory()->create()->id;
            },
            'quantity' => $this->faker->randomNumber,
            'total_price' => $this->faker->randomFloat(2, 0, 1000),
            'delivery_price' => $this->faker->randomFloat(2, 0, 100),
            'clean_price' => $this->faker->randomFloat(2, 0, 1000),
            'tracking' => $this->faker->word,
            'ip' => $this->faker->ipv4,
            'confirmation_attempts' => $this->faker->text,
            'confirmed_at' => $this->faker->optional()->dateTime,
            'shipped_at' => $this->faker->optional()->dateTime,
            'validated_at' => $this->faker->optional()->dateTime,
            'delivery_at' => $this->faker->optional()->dateTime,
            'delivered_at' => $this->faker->optional()->dateTime,
            'ready_at' => $this->faker->optional()->dateTime,
            'recovered_at' => $this->faker->optional()->dateTime,
            'back_at' => $this->faker->optional()->dateTime,
            'back_ready_at' => $this->faker->optional()->dateTime,
            'canceled_at' => $this->faker->optional()->dateTime,
            'archived_at' => $this->faker->optional()->dateTime,
            'doubled_at' => $this->faker->optional()->dateTime,
            'confirmed_by' => function () {
                return User::factory()->create()->id;
            },
            'recovered_by' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
