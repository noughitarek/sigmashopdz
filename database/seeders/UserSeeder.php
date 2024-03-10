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
            'name' => 'System',
            'email' => 'admin@gmail.com',
            'phone' => '',
            'role' => 'System',
            'password' => Hash::make('password'),
            'is_active' => false,
            'email_verified_at' => now(),
        ]);
        
        $user = User::create([
            'name' => 'Tarek',
            'email' => 'noughitarek@gmail.com',
            'phone' => '0699894417',
            'role' => 'Président directeur général',
            'permissions' => $p,
            'password' => Hash::make('password'),
            'profile_image' => '',
            'is_active' => true,
            'created_by' => 1,
            'email_verified_at' => now(),
        ]);
        return;
        
        $user = User::create([
            'name' => 'Mehdi',
            'email' => 'mehdi@gmail.com',
            'phone' => '0774756492',
            'role' => 'Livreur',
            'permissions' => $p,
            'password' => Hash::make('password'),
            'profile_image' => '',
            'is_active' => true,
            'created_by' => 1,
            'email_verified_at' => now(),
        ]);
    }
}
