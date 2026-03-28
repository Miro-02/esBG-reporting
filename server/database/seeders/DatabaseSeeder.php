<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed reference data first
        $this->call([
            CountrySeeder::class,
            SectorSeeder::class,
            LegalFormSeeder::class,
            FrameworkSeeder::class,
            CertificationSeeder::class,
            CdpLevelSeeder::class,
            EcoVadisRatingSeeder::class,
        ]);
    }
}
