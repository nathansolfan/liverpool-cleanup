<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CleanupAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure we have at least one user
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Add some test cleanup areas around Liverpool
        $areas = [
            'title' => 'Sefton Park Litter',
            'description' => 'Excessive litter around lake',
            'latitude' => 53.3819,
            'longitude' => -2.9428,
            'severity' => 'medium',
            'status' => 'reported',
        ];

    }
}
