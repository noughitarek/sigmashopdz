<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Commune;
use App\Models\Product;
use App\Models\Campaign;
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
        $cleanPrice = rand(10, 19)*100;
        $deliveryPrice = rand(8, 24)*50;
        $commune = rand(1, 1542);
        $quantity = rand(1, 10)!=1?1:rand(2, 3);
        $tracking = rand(1, 5)==1?null:"EC4UQE".rand(10000000000, 99999999999);
        return [
            'name' => $this->faker->name,
            'phone' => "0".rand(5, 7).rand(10000000, 99999999),
            'phone2' => "0".rand(5, 7).rand(10000000, 99999999),
            'address' => $this->faker->address,
            'commune' => $commune,
            'wilaya' => Commune::where('id', $commune)->first()->wilaya,
            'campaign' => Campaign::factory()->create()->id,
            'product' => function () {
                return Product::factory()->create()->id;
            },
            'quantity' => $quantity,
            'total_price' => $cleanPrice*$quantity+$deliveryPrice,
            'delivery_price' => $deliveryPrice,
            'clean_price' => $cleanPrice*$quantity,
            'tracking' => null,
            'ip' => $this->faker->ipv4,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
