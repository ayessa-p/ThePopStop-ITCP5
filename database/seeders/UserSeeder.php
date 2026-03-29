<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = array (
  0 => 
  array (
    'id' => 1,
    'username' => 'admin',
    'name' => 'Admin',
    'full_name' => 'Administrator',
    'email' => 'admin@thepopstop.com',
    'phone' => NULL,
    'address' => 'Taguig City',
    'profile_photo' => NULL,
    'role' => 'admin',
    'is_active' => true,
  ),
  1 => 
  array (
    'id' => 2,
    'username' => 'ayessa',
    'name' => 'ayessa',
    'full_name' => 'Ayessa Pili',
    'email' => 'aye@gmail.com',
    'phone' => '09123456789',
    'address' => 'taguig',
    'profile_photo' => 'profiles/wl5JbcgUS8egmd1ElYzeT9rlQxKAGfRvq6QmPNCs.jpg',
    'role' => 'customer',
    'is_active' => true,
  ),
);

        foreach ($users as $userData) {
            User::create(array_merge($userData, [
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]));
        }
    }
}
