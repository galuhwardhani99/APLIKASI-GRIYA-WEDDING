<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@griyaelly.com'],
            [
                'name'     => 'Administrator',
                'phone'    => '081234567890',
                'password' => 'password123', // otomatis di-hash oleh casts
                'role'     => 'admin',
            ]
        );
    }
}