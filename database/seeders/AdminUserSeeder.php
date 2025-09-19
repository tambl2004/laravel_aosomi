<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo user admin mẫu
        User::create([
            'name' => 'Admin',
            'email' => 'admin@aosomi.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(), // Đã xác thực email
        ]);

        // Tạo user customer mẫu
        User::create([
            'name' => 'Customer',
            'email' => 'customer@aosomi.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'email_verified_at' => now(), // Đã xác thực email
        ]);

        $this->command->info('Đã tạo user admin và customer mẫu thành công!');
        $this->command->info('Admin: admin@aosomi.com / 12345678');
        $this->command->info('Customer: customer@aosomi.com / 12345678');
    }
}