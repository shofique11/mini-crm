<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Lead;
use App\Models\User;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Fetch available lead and counselor IDs
        $leads = Lead::pluck('id')->toArray();
        $counselors = User::where('role', 'counselor')->pluck('id')->toArray();

        if (empty($leads) || empty($counselors)) {
            $this->command->warn('No leads or counselors found. Please seed them first.');
            return;
        }
        $totalApplications = min(count($leads), 100);

        for ($i = 0; $i <  $totalApplications; $i++) {
            Application::create([
                'lead_id' => $leads[$i], // Assign a unique lead
                'counselor_id' => $faker->randomElement($counselors), // Assign a random counselor
                'status' => $faker->randomElement(['In Progress', 'Approved', 'Rejected']),
            ]);
        }
    }
}
