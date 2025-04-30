<?php

namespace Database\Seeders;

use App\Models\CleanupArea;
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
            [
                'title' => 'Sefton Park Litter',
                'description' => 'Excessive litter around lake',
                'latitude' => 53.3819,
                'longitude' => -2.9428,
                'severity' => 'medium',
                'status' => 'reported',
            ],
            [
                'title' => 'Albert Dock Cleanup',
                'description' => 'Plastic waste accumulating in the dock',
                'latitude' => 53.4004,
                'longitude' => -2.9912,
                'severity' => 'high',
                'status' => 'scheduled',
            ],
            [
                'title' => 'Crosby Beach',
                'description' => 'Beach cleanup needed after storm',
                'latitude' => 53.4768,
                'longitude' => -3.0568,
                'severity' => 'high',
                'status' => 'reported',
            ],
            [
                'title' => 'Calderstones Park',
                'description' => 'Litter in wooded areas',
                'latitude' => 53.3805,
                'longitude' => -2.9062,
                'severity' => 'low',
                'status' => 'reported',
            ],
        ];

        foreach ($areas as $area) {
            CleanupArea::create(array_merge($area, ['user_id' => $user->idate]));
        }
    }
}
