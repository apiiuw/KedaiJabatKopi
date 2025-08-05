<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Owner
        User::create([
            'name' => 'Nuzulul Firdaus',
            'email' => 'owner@jabatkopi.com',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
        ]);

        // Cashier
        User::create([
            'name' => 'Rafi Rizqallah Andila',
            'email' => 'rafirizqallahandilla@gmail.com',
            'password' => Hash::make('cashier123'),
            'role' => 'cashier',
        ]);
        User::create([
            'name' => 'Syawalia Nurul Fitri',
            'email' => 'cashier@jabatkopi.com',
            'password' => Hash::make('cashier123'),
            'role' => 'cashier',
        ]);
    }
}
