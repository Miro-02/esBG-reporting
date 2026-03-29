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

    /**
     * Get detailed information about all field violations for a report.
     * Includes current values, standard values, and human-readable labels.
     *
     * @param Report $report
     * @return array Array of violation details
     */
    public function getDetailedViolations(Report $report): array
    {
        $violations = [];

        // Get the country from the report's company profile (section1)
        if (!$report->section1 || !$report->section1->country_id) {
            return $violations;
        }

        // Get the country standard
        $countryStandard = $report->section1->country->standard ?? null;
        if (!$countryStandard) {
            return $violations;
        }

        $fieldLabels = $this->getFieldLabels();

        // Check Section 2: Governance
        if ($report->section2) {
            $this->checkSection2Detailed($report->section2, $countryStandard, $violations, $fieldLabels, 2);
        }

        // Check Section 3: Environment
        if ($report->section3) {
            $this->checkSection3Detailed($report->section3, $countryStandard, $violations, $fieldLabels, 3);
        }

        // Check Section 4: Social
        if ($report->section4) {
            $this->checkSection4Detailed($report->section4, $countryStandard, $violations, $fieldLabels, 4);
        }

        // Check Section 5: Cybersecurity
        if ($report->section5) {
            $this->checkSection5Detailed($report->section5, $countryStandard, $violations, $fieldLabels, 5);
        }

        // Check Section 6: Supply Chain
        if ($report->section6) {
            $this->checkSection6Detailed($report->section6, $countryStandard, $violations, $fieldLabels, 6);
        }

        // Check Section 7: Targets
        if ($report->section7) {
            $this->checkSection7Detailed($report->section7, $countryStandard, $violations, $fieldLabels, 7);
        }

        return $violations;
    }

    /**
     * Get human-readable labels for all fields.
     */
    private function getFieldLabels(): array
    {
        return [
            // Section 2: Governance
            'female_board_percentage' => ['label' => 'Female Board Percentage', 'section' => 2, 'type' => 'percentage'],
            'code_of_conduct_exists' => ['label' => 'Code of Conduct Exists', 'section' => 2, 'type' => 'boolean'],
            'esg_committee_exists' => ['label' => 'ESG Committee Exists', 'section' => 2, 'type' => 'boolean'],
            'whistleblower_channel_exists' => ['label' => 'Whistleblower Channel Exists', 'section' => 2, 'type' => 'boolean'],
            'anti_corruption_training_rate' => ['label' => 'Anti-Corruption Training Rate', 'section' => 2, 'type' => 'percentage'],
            'esg_awareness_training_rate' => ['label' => 'ESG Awareness Training Rate', 'section' => 2, 'type' => 'percentage'],

            // Section 3: Environment
            'renewable_energy_percentage' => ['label' => 'Renewable Energy Percentage', 'section' => 3, 'type' => 'percentage'],
            'grid_electricity_percentage' => ['label' => 'Grid Electricity Percentage', 'section' => 3, 'type' => 'percentage'],
            'total_energy_consumed' => ['label' => 'Total Energy Consumed (MWh)', 'section' => 3, 'type' => 'number'],
            'ghg_intensity_value' => ['label' => 'GHG Intensity Value', 'section' => 3, 'type' => 'number'],

            // Section 4: Social
            'female_percentage' => ['label' => 'Female Employees Percentage', 'section' => 4, 'type' => 'percentage'],
            'female_leadership_percentage' => ['label' => 'Female Leadership Percentage', 'section' => 4, 'type' => 'percentage'],
            'employees_under_30_percentage' => ['label' => 'Employees Under 30 Percentage', 'section' => 4, 'type' => 'percentage'],
            'employees_in_training_percentage' => ['label' => 'Employees in Training Percentage', 'section' => 4, 'type' => 'percentage'],
            'sickness_rate' => ['label' => 'Sickness Rate', 'section' => 4, 'type' => 'percentage'],
            'employee_assistance_program_exists' => ['label' => 'Employee Assistance Program Exists', 'section' => 4, 'type' => 'boolean'],
            'survey_participation_rate' => ['label' => 'Survey Participation Rate', 'section' => 4, 'type' => 'percentage'],

            // Section 5: Cybersecurity
            'cybersecurity_framework_exists' => ['label' => 'Cybersecurity Framework Exists', 'section' => 5, 'type' => 'boolean'],
            'cybersecurity_training_rate' => ['label' => 'Cybersecurity Training Rate', 'section' => 5, 'type' => 'percentage'],
            'data_breach_incidents' => ['label' => 'Data Breach Incidents', 'section' => 5, 'type' => 'number'],
            'gdpr_compliant' => ['label' => 'GDPR Compliant', 'section' => 5, 'type' => 'boolean'],
            'iso27001_certified' => ['label' => 'ISO 27001 Certified', 'section' => 5, 'type' => 'boolean'],
            'security_audit_frequency' => ['label' => 'Security Audit Frequency', 'section' => 5, 'type' => 'text'],
            'incident_response_plan_exists' => ['label' => 'Incident Response Plan Exists', 'section' => 5, 'type' => 'boolean'],
            'cybersecurity_training_completion_rate' => ['label' => 'Cybersecurity Training Completion Rate', 'section' => 5, 'type' => 'percentage'],
            'number_of_breaches' => ['label' => 'Number of Breaches', 'section' => 5, 'type' => 'number'],
            'customers_affected_by_breaches' => ['label' => 'Customers Affected by Breaches', 'section' => 5, 'type' => 'number'],

            // Section 6: Supply Chain
            'supplier_code_exists' => ['label' => 'Supplier Code Exists', 'section' => 6, 'type' => 'boolean'],
            'suppliers_acknowledged_code_percentage' => ['label' => 'Suppliers Acknowledged Code Percentage', 'section' => 6, 'type' => 'percentage'],
            'procurement_staff_trained_percentage' => ['label' => 'Procurement Staff Trained Percentage', 'section' => 6, 'type' => 'percentage'],
            'third_party_risk_management_exists' => ['label' => 'Third Party Risk Management Exists', 'section' => 6, 'type' => 'boolean'],

            // Section 7: Targets
            'netzero_target_year' => ['label' => 'Net-Zero Target Year', 'section' => 7, 'type' => 'year'],
        ];
    }

    /**
     * Format a value for display based on its type.
     */
    private function formatValue($value, string $type): string
    {
        if ($value === null) {
            return 'N/A';
        }

        return match ($type) {
            'percentage' => round((float) $value * 100, 2) . '%',
            'boolean' => $value ? 'Yes' : 'No',
            'year' => (string) $value,
            'number' => (string) $value,
            'text' => (string) $value,
            default => (string) $value,
        };
    }

    private function checkSection2Detailed($section2, $standard, &$violations, array $fieldLabels, int $sectionNum): void
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
                $metadata = $fieldLabels[$field] ?? ['label' => $field, 'section' => $sectionNum, 'type' => 'text'];
                $violations[] = [
                    'fieldName' => $field,
                    'fieldLabel' => $metadata['label'],
                    'section' => $sectionNum,
                    'currentValue' => $section2->{$field},
                    'currentValueFormatted' => $this->formatValue($section2->{$field}, $metadata['type']),
                    'standardValue' => $standard->{$field},
                    'standardValueFormatted' => $this->formatValue($standard->{$field}, $metadata['type']),
                    'type' => $metadata['type'],
                ];
            }
        }
    }

    private function checkSection3Detailed($section3, $standard, &$violations, array $fieldLabels, int $sectionNum): void
    {
        $fields = [
            'renewable_energy_percentage',
            'grid_electricity_percentage',
            'total_energy_consumed',
            'ghg_intensity_value',
        ];

        foreach ($fields as $field) {
            if ($section3->{$field} !== null && !$standard->meetsStandard($field, $section3->{$field})) {
                $metadata = $fieldLabels[$field] ?? ['label' => $field, 'section' => $sectionNum, 'type' => 'text'];
                $violations[] = [
                    'fieldName' => $field,
                    'fieldLabel' => $metadata['label'],
                    'section' => $sectionNum,
                    'currentValue' => $section3->{$field},
                    'currentValueFormatted' => $this->formatValue($section3->{$field}, $metadata['type']),
                    'standardValue' => $standard->{$field},
                    'standardValueFormatted' => $this->formatValue($standard->{$field}, $metadata['type']),
                    'type' => $metadata['type'],
                ];
            }
        }
    }

    private function checkSection4Detailed($section4, $standard, &$violations, array $fieldLabels, int $sectionNum): void
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
                $metadata = $fieldLabels[$field] ?? ['label' => $field, 'section' => $sectionNum, 'type' => 'text'];
                $violations[] = [
                    'fieldName' => $field,
                    'fieldLabel' => $metadata['label'],
                    'section' => $sectionNum,
                    'currentValue' => $section4->{$field},
                    'currentValueFormatted' => $this->formatValue($section4->{$field}, $metadata['type']),
                    'standardValue' => $standard->{$field},
                    'standardValueFormatted' => $this->formatValue($standard->{$field}, $metadata['type']),
                    'type' => $metadata['type'],
                ];
            }
        }
    }

    private function checkSection5Detailed($section5, $standard, &$violations, array $fieldLabels, int $sectionNum): void
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
                $metadata = $fieldLabels[$field] ?? ['label' => $field, 'section' => $sectionNum, 'type' => 'text'];
                $violations[] = [
                    'fieldName' => $field,
                    'fieldLabel' => $metadata['label'],
                    'section' => $sectionNum,
                    'currentValue' => $section5->{$field},
                    'currentValueFormatted' => $this->formatValue($section5->{$field}, $metadata['type']),
                    'standardValue' => $standard->{$field},
                    'standardValueFormatted' => $this->formatValue($standard->{$field}, $metadata['type']),
                    'type' => $metadata['type'],
                ];
            }
        }
    }

    private function checkSection6Detailed($section6, $standard, &$violations, array $fieldLabels, int $sectionNum): void
    {
        $fields = [
            'supplier_code_exists',
            'suppliers_acknowledged_code_percentage',
            'procurement_staff_trained_percentage',
            'third_party_risk_management_exists',
        ];

        foreach ($fields as $field) {
            if ($section6->{$field} !== null && !$standard->meetsStandard($field, $section6->{$field})) {
                $metadata = $fieldLabels[$field] ?? ['label' => $field, 'section' => $sectionNum, 'type' => 'text'];
                $violations[] = [
                    'fieldName' => $field,
                    'fieldLabel' => $metadata['label'],
                    'section' => $sectionNum,
                    'currentValue' => $section6->{$field},
                    'currentValueFormatted' => $this->formatValue($section6->{$field}, $metadata['type']),
                    'standardValue' => $standard->{$field},
                    'standardValueFormatted' => $this->formatValue($standard->{$field}, $metadata['type']),
                    'type' => $metadata['type'],
                ];
            }
        }
    }

    private function checkSection7Detailed($section7, $standard, &$violations, array $fieldLabels, int $sectionNum): void
    {
        $fields = [
            'netzero_target_year',
        ];

        foreach ($fields as $field) {
            if ($section7->{$field} !== null && !$standard->meetsStandard($field, $section7->{$field})) {
                $metadata = $fieldLabels[$field] ?? ['label' => $field, 'section' => $sectionNum, 'type' => 'text'];
                $violations[] = [
                    'fieldName' => $field,
                    'fieldLabel' => $metadata['label'],
                    'section' => $sectionNum,
                    'currentValue' => $section7->{$field},
                    'currentValueFormatted' => $this->formatValue($section7->{$field}, $metadata['type']),
                    'standardValue' => $standard->{$field},
                    'standardValueFormatted' => $this->formatValue($standard->{$field}, $metadata['type']),
                    'type' => $metadata['type'],
                ];
            }
        }
    }
}
