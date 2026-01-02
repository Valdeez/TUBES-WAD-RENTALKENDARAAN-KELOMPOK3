<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::Create([
            'name' => 'AdminRental',
            'email' => 'admin@gmail.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Admin No.1, Kota Admin',
            'password' => Hash::make('admin12345'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);
    }
}
