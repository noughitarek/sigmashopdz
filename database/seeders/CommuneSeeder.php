<?php

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = file_get_contents('database/seeds/communes.csv');
        $rows = array_map('str_getcsv', explode("\n", $csvFile));
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $user = Commune::create([
                'name' => $row[0],
                'wilaya' => $row[1],
            ]);
        }
    }
}
