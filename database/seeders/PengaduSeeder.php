<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Hanafi',
            'email' => 'pengadu@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'pengadu',
            'is_active' => '1',
            'picture' => null,
            'last_signin' => null,
        ]);
    }
}
