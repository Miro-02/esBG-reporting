<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Framework\Models\CdpLevel;

class CdpLevelSeeder extends Seeder
{
    /**
     * Seed the CDP levels table.
     */
    public function run(): void
    {
        $levels = [
            ['code' => 'A', 'name' => 'Leadership', 'description' => 'Climate leadership companies'],
            ['code' => 'B', 'name' => 'Management', 'description' => 'Climate management companies'],
            ['code' => 'C', 'name' => 'Awareness', 'description' => 'Awareness companies'],
            ['code' => 'D', 'name' => 'Disclosure', 'description' => 'Disclosure companies'],
            ['code' => 'NOT_PARTICIPATING', 'name' => 'Not Participating', 'description' => 'Not participating in CDP'],
        ];

        foreach ($levels as $level) {
            CdpLevel::firstOrCreate(
                ['code' => $level['code']],
                ['name' => $level['name'], 'description' => $level['description']]
            );
        }
    }
}
