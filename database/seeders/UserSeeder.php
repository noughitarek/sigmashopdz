<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p = "";
        foreach(config("webmaster.permissions") as $title=>$permission){
            foreach($permission as $sub_title=>$sub_permission){
                $p .= $sub_permission."_".$title.",";
            }
        }
        
        $user = User::create([
            'name' => 'Tarek',
            'email' => 'noughitarek@gmail.com',
            'role' => 'Président directeur général',
            'permissions' => $p,
            'password' => Hash::make('password'),
            'profile_image' => '',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
