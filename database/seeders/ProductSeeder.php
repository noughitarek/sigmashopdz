<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [1, 5, 3, 2, 4];
        foreach($orders as $order)
        {
            for($i=1;$i<=10;$i++)
            {
                $price = rand(11, 99)*100;
                Product::create([
                    'name' => 'Prod'.$i.$order,
                    'slug' => 'Prod'.$i.$order,
                    
                    'price' => $price,
                    'old_price' => $price+rand(1, 10)*100,
                    'photos' => 'prod'.rand(1,13).'.jpg',
                    'order' => $order,
                    'created_by' => 1,
                    'category' => $i
                ]);
            }
        }
    }
}
