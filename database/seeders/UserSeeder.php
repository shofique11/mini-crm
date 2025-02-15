<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@crm.com',
            'password' => Hash::make('admin@123'),
            'role' => 'admin',
        ]);

        // Create 4 Counselor Users
        for ($i = 1; $i <= 4; $i++) {
            User::create([
                'name' => 'Counselor ' . $i,
                'email' => 'counselor' . $i . '@crm.com',
                'password' => Hash::make('counselor@123'),
                'role' => 'counselor',
            ]);
        }
    }
}
