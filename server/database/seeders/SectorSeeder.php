<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sector\Models\Sector;

class SectorSeeder extends Seeder
{
    /**
     * Seed the sectors table with NACE Rev. 2 codes.
     */
    public function run(): void
    {
        $sectors = [
            ['code' => 'A', 'name' => 'Agriculture, forestry and fishing'],
            ['code' => 'B', 'name' => 'Mining and quarrying'],
            ['code' => 'C', 'name' => 'Manufacturing'],
            ['code' => 'C10', 'name' => 'Manufacture of food products'],
            ['code' => 'C13', 'name' => 'Manufacture of textiles'],
            ['code' => 'C14', 'name' => 'Manufacture of wearing apparel'],
            ['code' => 'C15', 'name' => 'Manufacture of leather and related products'],
            ['code' => 'C16', 'name' => 'Manufacture of wood and wood products'],
            ['code' => 'C17', 'name' => 'Manufacture of paper and paper products'],
            ['code' => 'C18', 'name' => 'Printing and reproduction of recorded media'],
            ['code' => 'C19', 'name' => 'Manufacture of coke and refined petroleum products'],
            ['code' => 'C20', 'name' => 'Manufacture of chemicals and chemical products'],
            ['code' => 'C21', 'name' => 'Manufacture of basic pharmaceutical products'],
            ['code' => 'C22', 'name' => 'Manufacture of rubber and plastic products'],
            ['code' => 'C23', 'name' => 'Manufacture of other non-metallic mineral products'],
            ['code' => 'C24', 'name' => 'Manufacture of basic metals'],
            ['code' => 'C25', 'name' => 'Manufacture of fabricated metal products'],
            ['code' => 'C26', 'name' => 'Manufacture of computer, electronic and optical products'],
            ['code' => 'C27', 'name' => 'Manufacture of electrical equipment'],
            ['code' => 'C28', 'name' => 'Manufacture of machinery and equipment n.e.c.'],
            ['code' => 'C29', 'name' => 'Manufacture of motor vehicles, trailers and semi-trailers'],
            ['code' => 'C30', 'name' => 'Manufacture of other transport equipment'],
            ['code' => 'C31', 'name' => 'Manufacture of furniture'],
            ['code' => 'C32', 'name' => 'Other manufacturing'],
            ['code' => 'C33', 'name' => 'Repair and installation of machinery and equipment'],
            ['code' => 'D', 'name' => 'Electricity, gas, steam and air conditioning supply'],
            ['code' => 'E', 'name' => 'Water supply; sewerage, waste management'],
            ['code' => 'F', 'name' => 'Construction'],
            ['code' => 'G', 'name' => 'Wholesale and retail trade; repair of motor vehicles'],
            ['code' => 'H', 'name' => 'Transportation and storage'],
            ['code' => 'I', 'name' => 'Accommodation and food service activities'],
            ['code' => 'J', 'name' => 'Information and communication'],
            ['code' => 'J58', 'name' => 'Publishing activities'],
            ['code' => 'J61', 'name' => 'Telecommunications'],
            ['code' => 'J62', 'name' => 'Computer programming, consultancy and related activities'],
            ['code' => 'J63', 'name' => 'Information service activities'],
            ['code' => 'K', 'name' => 'Financial and insurance activities'],
            ['code' => 'K64', 'name' => 'Financial service activities, except insurance and pension funding'],
            ['code' => 'K65', 'name' => 'Insurance, reinsurance and pension funding'],
            ['code' => 'K66', 'name' => 'Activities auxiliary to financial services and insurance'],
            ['code' => 'L', 'name' => 'Real estate activities'],
            ['code' => 'M', 'name' => 'Professional, scientific and technical activities'],
            ['code' => 'M69', 'name' => 'Legal and accounting activities'],
            ['code' => 'M70', 'name' => 'Activities of head offices; management consultancy'],
            ['code' => 'M71', 'name' => 'Architectural and engineering activities'],
            ['code' => 'M72', 'name' => 'Scientific research and development'],
            ['code' => 'M73', 'name' => 'Advertising and market research'],
            ['code' => 'M74', 'name' => 'Other professional, scientific and technical activities'],
            ['code' => 'N', 'name' => 'Administrative and support service activities'],
            ['code' => 'O', 'name' => 'Public administration and defence; compulsory social security'],
            ['code' => 'P', 'name' => 'Education'],
            ['code' => 'Q', 'name' => 'Human health and social work activities'],
            ['code' => 'R', 'name' => 'Arts, entertainment and recreation'],
            ['code' => 'S', 'name' => 'Other service activities'],
            ['code' => 'T', 'name' => 'Activities of households as employers'],
            ['code' => 'U', 'name' => 'Activities of extraterritorial organisations and bodies'],
        ];

        foreach ($sectors as $sector) {
            Sector::firstOrCreate(
                ['name' => $sector['name']],
                ['nace_code' => $sector['code'], 'description' => $sector['name']]
            );
        }
    }
}
