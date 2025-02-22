<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $google2fa = new Google2FA();
        // Create Admin User
        User::create([
            'name' => 'Shofique Admin',
            'email' => 'shofique@crm.com',
            'password' => Hash::make('admin@123'),
            'role' => 'admin',
            'two_factor_secret' => encrypt($google2fa->generateSecretKey()),
            'two_factor_recovery_codes' => encrypt(json_encode(collect(range(1, 8))->map(fn() => Str::random(10))->toArray())), // Encrypted Recovery Codes,
        ]);

        // Create 4 Counselor Users
            User::create([
                'name' => 'Joe Bank',
                'email' => 'joebank@crm.com',
                'password' => Hash::make('joe@123'),
                'role' => 'counselor',
                'two_factor_secret' => encrypt($google2fa->generateSecretKey()),
                'two_factor_recovery_codes' => encrypt(json_encode(collect(range(1, 8))->map(fn() => Str::random(10))->toArray())),
            ]);
            User::create([
                'name' => 'Adam Hanson',
                'email' => 'adam@crm.com',
                'password' => Hash::make('adam@123'),
                'role' => 'counselor',
                'two_factor_secret' => encrypt($google2fa->generateSecretKey()),
                'two_factor_recovery_codes' => encrypt(json_encode(collect(range(1, 8))->map(fn() => Str::random(10))->toArray())),
            ]);
            User::create([
                'name' => 'Paul Cheffery',
                'email' => 'paul@crm.com',
                'password' => Hash::make('paul@123'),
                'role' => 'counselor',
                'two_factor_secret' => encrypt($google2fa->generateSecretKey()),
                'two_factor_recovery_codes' => encrypt(json_encode(collect(range(1, 8))->map(fn() => Str::random(10))->toArray())),
            ]);
            User::create([
                'name' => 'David Backham',
                'email' => 'devid@crm.com',
                'password' => Hash::make('devid@123'),
                'role' => 'counselor',
                'two_factor_secret' => encrypt($google2fa->generateSecretKey()),
                'two_factor_recovery_codes' => encrypt(json_encode(collect(range(1, 8))->map(fn() => Str::random(10))->toArray())),
            ]);
        
    }
}
