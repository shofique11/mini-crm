<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Lead;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all counselor users
        $counselors = User::where('role', 'counselor')->pluck('id')->toArray();

        if (empty($counselors)) {
            $this->command->warn('No counselors found. Please seed users first.');
            return;
        }

        for ($i = 0; $i < 100; $i++) {
            Lead::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'status' => $faker->randomElement(['In Progress', 'Bad Timing', 'Not Interested', 'Not Qualified']),
                'counselor_id' => $faker->randomElement($counselors), // Assign to a random counselor
            ]);
        }
    }
}
