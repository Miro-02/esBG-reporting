<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Country\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Seed the countries table.
     */
    public function run(): void
    {
        $countries = [
            ['code' => 'AT', 'name' => 'Austria'],
            ['code' => 'BE', 'name' => 'Belgium'],
            ['code' => 'BG', 'name' => 'Bulgaria'],
            ['code' => 'HR', 'name' => 'Croatia'],
            ['code' => 'CY', 'name' => 'Cyprus'],
            ['code' => 'CZ', 'name' => 'Czech Republic'],
            ['code' => 'DK', 'name' => 'Denmark'],
            ['code' => 'EE', 'name' => 'Estonia'],
            ['code' => 'FI', 'name' => 'Finland'],
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'DE', 'name' => 'Germany'],
            ['code' => 'GR', 'name' => 'Greece'],
            ['code' => 'HU', 'name' => 'Hungary'],
            ['code' => 'IE', 'name' => 'Ireland'],
            ['code' => 'IT', 'name' => 'Italy'],
            ['code' => 'LV', 'name' => 'Latvia'],
            ['code' => 'LT', 'name' => 'Lithuania'],
            ['code' => 'LU', 'name' => 'Luxembourg'],
            ['code' => 'MT', 'name' => 'Malta'],
            ['code' => 'NL', 'name' => 'Netherlands'],
            ['code' => 'PL', 'name' => 'Poland'],
            ['code' => 'PT', 'name' => 'Portugal'],
            ['code' => 'RO', 'name' => 'Romania'],
            ['code' => 'SK', 'name' => 'Slovakia'],
            ['code' => 'SI', 'name' => 'Slovenia'],
            ['code' => 'ES', 'name' => 'Spain'],
            ['code' => 'SE', 'name' => 'Sweden'],
            ['code' => 'GB', 'name' => 'United Kingdom'],
            ['code' => 'CH', 'name' => 'Switzerland'],
            ['code' => 'NO', 'name' => 'Norway'],
            ['code' => 'IS', 'name' => 'Iceland'],
            ['code' => 'TR', 'name' => 'Turkey'],
            ['code' => 'US', 'name' => 'United States'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'JP', 'name' => 'Japan'],
            ['code' => 'AU', 'name' => 'Australia'],
            ['code' => 'CN', 'name' => 'China'],
            ['code' => 'IN', 'name' => 'India'],
            ['code' => 'BR', 'name' => 'Brazil'],
            ['code' => 'MX', 'name' => 'Mexico'],
            ['code' => 'ZA', 'name' => 'South Africa'],
            ['code' => 'KR', 'name' => 'South Korea'],
            ['code' => 'SG', 'name' => 'Singapore'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(
                ['code' => $country['code']],
                ['name' => $country['name']]
            );
        }
    }
}
