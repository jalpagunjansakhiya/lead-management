<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\User;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $sample = [
            ['name' => 'Ankit Shah', 'email' => 'ankit@example.com', 'status' => 'new', 'source' => 'website'],
            ['name' => 'Priya Mehta', 'email' => 'priya@example.com', 'status' => 'contacted', 'source' => 'referral'],
            ['name' => 'Rohit Patel', 'email' => 'rohit@example.com', 'status' => 'converted', 'source' => 'social_media'],
            ['name' => 'Sneha Joshi', 'email' => 'sneha@example.com', 'status' => 'lost', 'source' => 'cold_call'],
            ['name' => 'Kunal Desai', 'email' => 'kunal@example.com', 'status' => 'new', 'source' => 'other'],
        ];

        foreach ($sample as $row) {
            Lead::create($row + [
                'phone' => '98765' . random_int(10000, 99999),
                'company_name' => fake()->company(),
                'notes' => fake()->sentence(),
                'assigned_to' => $users->isNotEmpty() ? $users->random()->id : null,
                'created_by' => $users->isNotEmpty() ? $users->random()->id : null,
            ]);
        }
    }
}
