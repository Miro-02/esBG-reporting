<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Framework\Models\EcoVadisRating;

class EcoVadisRatingSeeder extends Seeder
{
    /**
     * Seed the EcoVadis ratings table.
     */
    public function run(): void
    {
        $ratings = [
            ['code' => 'PLATINUM', 'name' => 'Platinum', 'description' => 'Platinum rating for advanced sustainability performance'],
            ['code' => 'GOLD', 'name' => 'Gold', 'description' => 'Gold rating for strong sustainability performance'],
            ['code' => 'SILVER', 'name' => 'Silver', 'description' => 'Silver rating for good sustainability performance'],
            ['code' => 'BRONZE', 'name' => 'Bronze', 'description' => 'Bronze rating for satisfactory sustainability performance'],
            ['code' => 'NOT_RATED', 'name' => 'Not Rated', 'description' => 'Not rated or below target score'],
        ];

        foreach ($ratings as $rating) {
            EcoVadisRating::firstOrCreate(
                ['code' => $rating['code']],
                [
                    'name' => $rating['name'],
                    'description' => $rating['description'],
                ]
            );
        }
    }
}
