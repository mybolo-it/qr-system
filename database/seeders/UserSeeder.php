<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    User::firstOrCreate(
        ['email' => 'superadmin@example.com'],
        [
            'name' => 'Super Admin',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
            'remember_token' => Str::random(10),
        ]
    );

    // Bisa tambahkan admin biasa
    User::firstOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin Biasa',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]
    );
}
}