<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Framework\Models\Framework;

class FrameworkSeeder extends Seeder
{
    /**
     * Seed the frameworks table.
     */
    public function run(): void
    {
        $frameworks = [
            ['code' => 'ESRS', 'name' => 'European Sustainability Reporting Standard'],
            ['code' => 'SASB', 'name' => 'Sustainability Accounting Standards Board'],
            ['code' => 'TCFD', 'name' => 'Task Force on Climate-related Financial Disclosures'],
            ['code' => 'GRI', 'name' => 'Global Reporting Initiative'],
        ];

        foreach ($frameworks as $framework) {
            Framework::firstOrCreate(
                ['code' => $framework['code']],
                ['name' => $framework['name']]
            );
        }
    }
}
