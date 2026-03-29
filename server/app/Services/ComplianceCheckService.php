<?php

namespace App\Services;

use Modules\Reports\Models\Report;

class ComplianceCheckService
{
    /**
     * Check which fields in a report violate country standards.
     * Returns an array of field names that violate standards.
     *
     * @param Report $report
     * @return array Fields that have violations
     */
    public function getViolatingFields(Report $report): array
    {
        $violatingFields = [];

        // Get the country from the report's company profile (section1)
        if (!$report->section1 || !$report->section1->country_id) {
            return $violatingFields;
        }

        // Get the country standard
        $countryStandard = $report->section1->country->standard ?? null;
        if (!$countryStandard) {
            return $violatingFields;
        }

        // Check Section 2: Governance
        if ($report->section2) {
            $this->checkSection2($report->section2, $countryStandard, $violatingFields);
        }

        // Check Section 3: Environment
        if ($report->section3) {
            $this->checkSection3($report->section3, $countryStandard, $violatingFields);
        }

        // Check Section 4: Social
        if ($report->section4) {
            $this->checkSection4($report->section4, $countryStandard, $violatingFields);
        }

        // Check Section 5: Cybersecurity
        if ($report->section5) {
            $this->checkSection5($report->section5, $countryStandard, $violatingFields);
        }

        // Check Section 6: Supply Chain
        if ($report->section6) {
            $this->checkSection6($report->section6, $countryStandard, $violatingFields);
        }

        // Check Section 7: Targets
        if ($report->section7) {
            $this->checkSection7($report->section7, $countryStandard, $violatingFields);
        }

        return $violatingFields;
    }

    /**
     * Check if a specific field violates country standard.
     *
     * @param string $fieldName
     * @param mixed $reportValue
     * @param Report $report
     * @return bool True if violates standard
     */
    public function isFieldViolating(string $fieldName, $reportValue, Report $report): bool
    {
        if (!$report->section1 || !$report->section1->country_id) {
            return false;
        }

        $countryStandard = $report->section1->country->standard ?? null;
        if (!$countryStandard) {
            return false;
        }

        return !$countryStandard->meetsStandard($fieldName, $reportValue);
    }

    private function checkSection2($section2, $standard, &$violations): void
    {
        $fields = [
            'female_board_percentage',
            'code_of_conduct_exists',
            'esg_committee_exists',
            'whistleblower_channel_exists',
            'anti_corruption_training_rate',
            'esg_awareness_training_rate',
        ];

        foreach ($fields as $field) {
            if ($section2->{$field} !== null && !$standard->meetsStandard($field, $section2->{$field})) {
                $violations[] = $field;
            }
        }
    }

    private function checkSection3($section3, $standard, &$violations): void
    {
        $fields = [
            'renewable_energy_percentage',
            'grid_electricity_percentage',
            'total_energy_consumed',
            'ghg_intensity_value',
        ];

        foreach ($fields as $field) {
            if ($section3->{$field} !== null && !$standard->meetsStandard($field, $section3->{$field})) {
                $violations[] = $field;
            }
        }
    }

    private function checkSection4($section4, $standard, &$violations): void
    {
        $fields = [
            'female_percentage',
            'female_leadership_percentage',
            'employees_under_30_percentage',
            'employees_in_training_percentage',
            'sickness_rate',
            'employee_assistance_program_exists',
            'survey_participation_rate',
        ];

        foreach ($fields as $field) {
            if ($section4->{$field} !== null && !$standard->meetsStandard($field, $section4->{$field})) {
                $violations[] = $field;
            }
        }
    }

    private function checkSection5($section5, $standard, &$violations): void
    {
        $fields = [
            'cybersecurity_framework_exists',
            'cybersecurity_training_rate',
            'data_breach_incidents',
            'gdpr_compliant',
            'iso27001_certified',
            'security_audit_frequency',
            'incident_response_plan_exists',
            'cybersecurity_training_completion_rate',
            'number_of_breaches',
            'customers_affected_by_breaches',
        ];

        foreach ($fields as $field) {
            if ($section5->{$field} !== null && !$standard->meetsStandard($field, $section5->{$field})) {
                $violations[] = $field;
            }
        }
    }

    private function checkSection6($section6, $standard, &$violations): void
    {
        $fields = [
            'supplier_code_exists',
            'suppliers_acknowledged_code_percentage',
            'procurement_staff_trained_percentage',
            'third_party_risk_management_exists',
        ];

        foreach ($fields as $field) {
            if ($section6->{$field} !== null && !$standard->meetsStandard($field, $section6->{$field})) {
                $violations[] = $field;
            }
        }
    }

    private function checkSection7($section7, $standard, &$violations): void
    {
        $fields = [
            'netzero_target_year',
        ];

        foreach ($fields as $field) {
            if ($section7->{$field} !== null && !$standard->meetsStandard($field, $section7->{$field})) {
                $violations[] = $field;
            }
        }
    }
}
