<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [1, 5, 3, 2, 4];
        foreach($orders as $order)
        {
            Category::create([
                'name' => 'Cate'.$order,
                'slug' => 'cate'.$order,
                'order' => $order,
                'is_active' => true,
                'created_by' => 1
            ]);
            Category::create([
                'name' => 'Cate'.($order+5),
                'slug' => 'cate'.($order+5),
                'order' => $order+5,
                'is_active' => true,
                'created_by' => 1
            ]);
        }
    }
}
