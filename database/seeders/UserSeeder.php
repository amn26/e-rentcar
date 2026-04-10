<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => 'USR0000001',
            'name' => 'Admin',
            'email' => 'admin@erentcar.com',
            'password' => 'admin123',
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'verification_status' => 'verified',
        ]);

        User::create([
            'id' => 'USR0000002',
            'name' => 'John Doe',
            'email' => 'user@erentcar.com',
            'password' => 'user123',
            'role' => 'user',
            'phone' => '081234567891',
            'address' => 'Bandung',
            'verification_status' => 'verified',
        ]);
    }
}
