<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Andi Prameswara',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_active' => '1',
            'picture' => null,
            'last_signin' => null,
        ]);
    }
}
