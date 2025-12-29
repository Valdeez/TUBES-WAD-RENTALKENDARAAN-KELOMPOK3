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
            'email' => 'Rental@gmail.com',
            'password' => Hash::make('TigaFaktorial'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);
    }
}
