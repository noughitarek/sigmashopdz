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
        return;
        Category::create([
            'name' => 'Unadded products',
            'slug' => 'unadded-products',
            'is_active' => false,
            'created_by' => 1
        ]);
    }
}
