<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Framework\Models\Certification;

class CertificationSeeder extends Seeder
{
    /**
     * Seed the certifications table.
     */
    public function run(): void
    {
        $certifications = [
            ['code' => 'ISO14001', 'name' => 'ISO 14001 - Environmental Management'],
            ['code' => 'ISO45001', 'name' => 'ISO 45001 - Occupational Health and Safety'],
            ['code' => 'ISO27001', 'name' => 'ISO 27001 - Information Security Management'],
            ['code' => 'ISO50001', 'name' => 'ISO 50001 - Energy Management'],
            ['code' => 'SOC1', 'name' => 'SOC 1 - Service Organization Control'],
            ['code' => 'SOC2', 'name' => 'SOC 2 - Service Organization Control'],
            ['code' => 'B-CORP', 'name' => 'B Corporation'],
            ['code' => 'FSSC22000', 'name' => 'FSSC 22000 - Food Safety'],
            ['code' => 'SA8000', 'name' => 'SA 8000 - Social Accountability'],
            ['code' => 'LEED', 'name' => 'LEED - Leadership in Energy and Environmental Design'],
        ];

        foreach ($certifications as $certification) {
            Certification::firstOrCreate(
                ['code' => $certification['code']],
                ['name' => $certification['name']]
            );
        }
    }
}
