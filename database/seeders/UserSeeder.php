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

        User::firstOrCreate(
            ['email' => 'jay@mybolo.id'],
            [
                'name' => 'Super Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('Kalang123#'),
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
                'role' => 'company_admin',
                'remember_token' => Str::random(10),
            ]
        );

        // 1. Akun HR Global (Superadmin / HR Grup) - Tanpa company_id
        User::create([
            'name' => 'HR Global Group',
            'email' => 'hr@group.com',
            'password' => Hash::make('password'), // password: password
            'role' => 'hr_global',
            'company_id' => null,
        ]);

        // 2. Akun Admin PT Teknologi Arindama Andra (ID: 1)
        User::create([
            'name' => 'Admin TAA',
            'email' => 'admin@taa.com',
            'password' => Hash::make('password'),
            'role' => 'company_admin',
            'company_id' => 1,
        ]);

        // 3. Akun Staff PT Teknologi Arindama Andra (ID: 1)
        User::create([
            'name' => 'Staff TAA',
            'email' => 'staff@taa.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'company_id' => 1,
        ]);

        // 4. Akun Admin PT Lancar Anja Kuwaga (ID: 2)
        User::create([
            'name' => 'Admin LAK',
            'email' => 'admin@lak.com',
            'password' => Hash::make('password'),
            'role' => 'company_admin',
            'company_id' => 2,
        ]);

        // 5. Akun Admin PT Kirana Baskara Kuwara (ID: 3)
        User::create([
            'name' => 'Admin KBK',
            'email' => 'admin@kbk.com',
            'password' => Hash::make('password'),
            'role' => 'company_admin',
            'company_id' => 3,
        ]);
    }
}
