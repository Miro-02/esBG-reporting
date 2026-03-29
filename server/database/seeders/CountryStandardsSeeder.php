<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Country\Models\Country;
use Modules\Country\Models\CountryStandard;

class CountryStandardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create countries
        $germany = Country::firstOrCreate(['code' => 'DE'], ['name' => 'Germany']);
        $uk = Country::firstOrCreate(['code' => 'GB'], ['name' => 'United Kingdom']);
        $sweden = Country::firstOrCreate(['code' => 'SE'], ['name' => 'Sweden']);

        // Clear existing standards
        CountryStandard::whereIn('country_id', [$germany->id, $uk->id, $sweden->id])->delete();

        // ========== GERMANY STANDARDS ==========
        CountryStandard::create([
            'country_id' => $germany->id,
            // Section 2: Governance
            'female_board_percentage' => 40,
            'code_of_conduct_exists' => true,
            'esg_committee_exists' => true,
            'whistleblower_channel_exists' => true,
            'anti_corruption_training_rate' => 75,
            'esg_awareness_training_rate' => 70,
            // Section 3: Environment
            'renewable_energy_percentage' => 56,
            'grid_electricity_percentage' => 50,
            // Section 4: Social
            'female_percentage' => 40,
            'female_leadership_percentage' => 35,
            'employees_in_training_percentage' => 75,
            'employee_assistance_program_exists' => true,
            'survey_participation_rate' => 65,
            // Section 5: Cybersecurity
            'cybersecurity_framework_exists' => true,
            'cybersecurity_training_rate' => 80,
            'data_breach_incidents' => 0,
            'gdpr_compliant' => true,
            'iso27001_certified' => true,
            'security_audit_frequency' => 'Quarterly',
            'incident_response_plan_exists' => true,
            'cybersecurity_training_completion_rate' => 80,
            'number_of_breaches' => 0,
            'customers_affected_by_breaches' => 0,
            // Section 6: Supply Chain
            'supplier_code_exists' => true,
            'suppliers_acknowledged_code_percentage' => 75,
            'procurement_staff_trained_percentage' => 70,
            'third_party_risk_management_exists' => true,
        ]);

        // ========== UNITED KINGDOM STANDARDS ==========
        CountryStandard::create([
            'country_id' => $uk->id,
            // Section 2: Governance
            'female_board_percentage' => 33,
            'code_of_conduct_exists' => true,
            'esg_committee_exists' => false,
            'whistleblower_channel_exists' => true,
            'anti_corruption_training_rate' => 75,
            'esg_awareness_training_rate' => 65,
            // Section 3: Environment
            'renewable_energy_percentage' => 50,
            'grid_electricity_percentage' => 60,
            // Section 4: Social
            'female_percentage' => 40,
            'female_leadership_percentage' => 35,
            'employees_in_training_percentage' => 80,
            'employee_assistance_program_exists' => true,
            'survey_participation_rate' => 60,
            'sickness_rate' => 5.0,
            // Section 5: Cybersecurity
            'cybersecurity_framework_exists' => true,
            'cybersecurity_training_rate' => 75,
            'data_breach_incidents' => 1,
            'gdpr_compliant' => true,
            'iso27001_certified' => true,
            'security_audit_frequency' => 'Biannually',
            'incident_response_plan_exists' => true,
            'cybersecurity_training_completion_rate' => 85,
            'number_of_breaches' => 2,
            'customers_affected_by_breaches' => 0,
            // Section 6: Supply Chain
            'supplier_code_exists' => true,
            'suppliers_acknowledged_code_percentage' => 70,
            'procurement_staff_trained_percentage' => 65,
            'third_party_risk_management_exists' => true,
        ]);

        // ========== SWEDEN STANDARDS ==========
        CountryStandard::create([
            'country_id' => $sweden->id,
            // Section 2: Governance
            'female_board_percentage' => 40,
            'code_of_conduct_exists' => true,
            'esg_committee_exists' => true,
            'whistleblower_channel_exists' => true,
            'anti_corruption_training_rate' => 85,
            'esg_awareness_training_rate' => 80,
            // Section 3: Environment
            'renewable_energy_percentage' => 80,
            'grid_electricity_percentage' => 20,
            // Section 4: Social
            'female_percentage' => 45,
            'female_leadership_percentage' => 40,
            'employees_under_30_percentage' => 15,
            'employees_in_training_percentage' => 85,
            'employee_assistance_program_exists' => true,
            'survey_participation_rate' => 75,
            'sickness_rate' => 4.0,
            // Section 5: Cybersecurity
            'cybersecurity_framework_exists' => true,
            'cybersecurity_training_rate' => 90,
            'data_breach_incidents' => 0,
            'gdpr_compliant' => true,
            'iso27001_certified' => true,
            'security_audit_frequency' => 'Quarterly',
            'incident_response_plan_exists' => true,
            'cybersecurity_training_completion_rate' => 90,
            'number_of_breaches' => 0,
            'customers_affected_by_breaches' => 0,
            // Section 6: Supply Chain
            'supplier_code_exists' => true,
            'suppliers_acknowledged_code_percentage' => 85,
            'procurement_staff_trained_percentage' => 80,
            'third_party_risk_management_exists' => true,
        ]);

        $this->command->info('Country standards seeded successfully!');
        $this->command->table(
            ['Country', 'Standards Created'],
            [
                ['Germany', '1'],
                ['United Kingdom', '1'],
                ['Sweden', '1'],
            ]
        );
    }
}
