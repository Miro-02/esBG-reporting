<?php

namespace Modules\Country\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CountryStandard extends Model
{
    use HasFactory;

    protected $table = 'country_standards';

    protected $fillable = [
        'country_id',
        // Section 2: Governance
        'female_board_percentage',
        'code_of_conduct_exists',
        'esg_committee_exists',
        'whistleblower_channel_exists',
        'anti_corruption_training_rate',
        'esg_awareness_training_rate',
        // Section 3: Environment
        'renewable_energy_percentage',
        'grid_electricity_percentage',
        'total_energy_consumed',
        'ghg_intensity_value',
        // Section 4: Social
        'female_percentage',
        'female_leadership_percentage',
        'employees_under_30_percentage',
        'employees_in_training_percentage',
        'sickness_rate',
        'employee_assistance_program_exists',
        'survey_participation_rate',
        // Section 5: Cybersecurity
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
        // Section 6: Supply Chain
        'supplier_code_exists',
        'suppliers_acknowledged_code_percentage',
        'procurement_staff_trained_percentage',
        'third_party_risk_management_exists',
        // Section 7: Targets
        'netzero_target_year',
    ];

    protected function casts(): array
    {
        return [
            'code_of_conduct_exists' => 'boolean',
            'esg_committee_exists' => 'boolean',
            'whistleblower_channel_exists' => 'boolean',
            'female_board_percentage' => 'decimal:2',
            'anti_corruption_training_rate' => 'decimal:2',
            'esg_awareness_training_rate' => 'decimal:2',
            'renewable_energy_percentage' => 'decimal:2',
            'grid_electricity_percentage' => 'decimal:2',
            'total_energy_consumed' => 'decimal:2',
            'ghg_intensity_value' => 'decimal:2',
            'female_percentage' => 'decimal:2',
            'female_leadership_percentage' => 'decimal:2',
            'employees_under_30_percentage' => 'decimal:2',
            'employees_in_training_percentage' => 'decimal:2',
            'sickness_rate' => 'decimal:2',
            'employee_assistance_program_exists' => 'boolean',
            'survey_participation_rate' => 'decimal:2',
            'cybersecurity_framework_exists' => 'boolean',
            'cybersecurity_training_rate' => 'decimal:2',
            'data_breach_incidents' => 'integer',
            'gdpr_compliant' => 'boolean',
            'iso27001_certified' => 'boolean',
            'security_audit_frequency' => 'string',
            'incident_response_plan_exists' => 'boolean',
            'cybersecurity_training_completion_rate' => 'decimal:2',
            'number_of_breaches' => 'integer',
            'customers_affected_by_breaches' => 'integer',
            'supplier_code_exists' => 'boolean',
            'suppliers_acknowledged_code_percentage' => 'decimal:2',
            'procurement_staff_trained_percentage' => 'decimal:2',
            'third_party_risk_management_exists' => 'boolean',
        ];
    }

    /**
     * Get the country this standard applies to.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Check if a field value meets the standard.
     * For numeric fields: value must be >= standard (or <= for fields like sickness_rate)
     * For boolean fields: value must be true if standard is true
     *
     * @param string $fieldName
     * @param mixed $reportValue
     * @return bool True if meets standard, false if violates
     */
    public function meetsStandard(string $fieldName, $reportValue): bool
    {
        $standard = $this->{$fieldName};

        // If no standard is set for this field, assume it meets the requirement
        if ($standard === null) {
            return true;
        }

        // Handle boolean fields
        if ($fieldName === 'code_of_conduct_exists' ||
            $fieldName === 'esg_committee_exists' ||
            $fieldName === 'whistleblower_channel_exists' ||
            $fieldName === 'employee_assistance_program_exists' ||
            $fieldName === 'cybersecurity_framework_exists' ||
            $fieldName === 'gdpr_compliant' ||
            $fieldName === 'iso27001_certified' ||
            $fieldName === 'incident_response_plan_exists' ||
            $fieldName === 'supplier_code_exists' ||
            $fieldName === 'third_party_risk_management_exists') {
            // Boolean: if standard is true, report value must be true
            if ($standard) {
                return (bool) $reportValue === true;
            }
            return true;
        }

        // Handle numeric fields - most require minimum
        if (is_numeric($reportValue) && is_numeric($standard)) {
            $reportNum = (float) $reportValue;
            $standardNum = (float) $standard;

            // Fields where LOWER is better (sickness_rate, grid_electricity_percentage, data_breach_incidents, number_of_breaches)
            if ($fieldName === 'sickness_rate' || 
                $fieldName === 'grid_electricity_percentage' || 
                $fieldName === 'data_breach_incidents' ||
                $fieldName === 'number_of_breaches' ||
                $fieldName === 'customers_affected_by_breaches') {
                return $reportNum <= $standardNum;
            }

            // Fields where HIGHER is better (percentage fields, training rates, etc.)
            return $reportNum >= $standardNum;
        }

        // Handle string fields (security_audit_frequency, etc.)
        if (is_string($reportValue) && is_string($standard)) {
            // For audit frequency: ensure it's at least as frequent as required
            // e.g., "Quarterly" >= "Annually" or "Monthly" >= "Quarterly"
            return true; // Accept any non-empty value for now
        }

        return true;
    }
}
