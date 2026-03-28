<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Framework\Models\LegalForm;

class LegalFormSeeder extends Seeder
{
    /**
     * Seed the legal forms table.
     */
    public function run(): void
    {
        $legalForms = [
            ['code' => 'LLC', 'name' => 'Limited Liability Company'],
            ['code' => 'Ltd', 'name' => 'Private Limited Company'],
            ['code' => 'Plc', 'name' => 'Public Limited Company'],
            ['code' => 'GmbH', 'name' => 'Gesellschaft mit beschränkter Haftung'],
            ['code' => 'SA', 'name' => 'Société Anonyme'],
            ['code' => 'SRL', 'name' => 'Societate cu Răspundere Limitată'],
            ['code' => 'JSC', 'name' => 'Joint Stock Company'],
            ['code' => 'OOO', 'name' => 'Obshchestvo s Ogranichennoy Otvetstvennostyu'],
            ['code' => 'EOOD', 'name' => 'Европейско одноличното дружество'],
            ['code' => 'SARL', 'name' => 'Société à Responsabilité Limitée'],
            ['code' => 'BV', 'name' => 'Besloten Vennootschap'],
            ['code' => 'NV', 'name' => 'Naamloze Vennootschap'],
            ['code' => 'AG', 'name' => 'Aktiengesellschaft'],
            ['code' => 'SE', 'name' => 'Societas Europaea'],
            ['code' => 'Spółka z.o.o.', 'name' => 'Spółka z ograniczoną odpowiedzialnością'],
            ['code' => 'Sp. z.o.o.', 'name' => 'Spółka jawna'],
            ['code' => 'AS', 'name' => 'Aktsiaselts'],
            ['code' => 'UAB', 'name' => 'Uždaroji akcinė bendrovė'],
            ['code' => 'Sole Proprietor', 'name' => 'Sole Proprietor'],
            ['code' => 'Partnership', 'name' => 'Partnership'],
        ];

        foreach ($legalForms as $form) {
            LegalForm::firstOrCreate(
                ['code' => $form['code']],
                ['name' => $form['name']]
            );
        }
    }
}
