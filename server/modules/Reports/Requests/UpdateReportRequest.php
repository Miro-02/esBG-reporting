<?php

namespace Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && $this->report->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Report metadata
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',

            // Section 1: Company Profile
            'section1.company_name' => 'nullable|string|max:255',
            'section1.legal_form_id' => 'nullable|integer|exists:legal_forms,id',
            'section1.country_id' => 'nullable|integer|exists:countries,id',
            'section1.sector_id' => 'nullable|integer|exists:sectors,id',
            'section1.annual_revenue' => 'nullable|numeric|min:0',
            'section1.number_of_employees' => 'nullable|integer|min:0',
            'section1.number_of_locations' => 'nullable|integer|min:0',
            'section1.parent_company_id' => 'nullable|integer|exists:report_section1_company_profiles,id',
            'section1.is_subsidiary' => 'nullable|boolean',

            // Section 2: Governance
            'section2.total_board_members' => 'nullable|integer|min:0',
            'section2.female_board_percentage' => 'nullable|numeric|min:0|max:100',
            'section2.esg_committee_exists' => 'nullable|boolean',
            'section2.esg_committee_frequency' => 'nullable|string',
            'section2.esg_executive_role' => 'nullable|string|max:255',
            'section2.code_of_conduct_exists' => 'nullable|boolean',
            'section2.whistleblower_channel_exists' => 'nullable|boolean',
            'section2.whistleblower_reports_filed' => 'nullable|integer|min:0',
            'section2.anti_corruption_training_rate' => 'nullable|numeric|min:0|max:100',
            'section2.esg_awareness_training_rate' => 'nullable|numeric|min:0|max:100',

            // Section 3: Environment
            'section3.scope1_current_year' => 'nullable|numeric|min:0',
            'section3.scope1_previous_year1' => 'nullable|numeric|min:0',
            'section3.scope1_previous_year2' => 'nullable|numeric|min:0',
            'section3.scope2_market_based' => 'nullable|numeric|min:0',
            'section3.scope2_location_based' => 'nullable|numeric|min:0',
            'section3.scope3_category1' => 'nullable|numeric|min:0',
            'section3.scope3_category4' => 'nullable|numeric|min:0',
            'section3.scope3_category6' => 'nullable|numeric|min:0',
            'section3.scope3_category7' => 'nullable|numeric|min:0',
            'section3.scope3_category11' => 'nullable|numeric|min:0',
            'section3.scope3_other_categories' => 'nullable|json',
            'section3.total_energy_consumed' => 'nullable|numeric|min:0',
            'section3.grid_electricity_percentage' => 'nullable|numeric|min:0|max:100',
            'section3.renewable_energy_percentage' => 'nullable|numeric|min:0|max:100',
            'section3.netzero_target_year' => 'nullable|integer|min:2000',
            'section3.ghg_intensity_metric' => 'nullable|string|max:255',
            'section3.ghg_intensity_value' => 'nullable|numeric|min:0',

            // Section 4: Social
            'section4.total_employees' => 'nullable|integer|min:0',
            'section4.male_percentage' => 'nullable|numeric|min:0|max:100',
            'section4.female_percentage' => 'nullable|numeric|min:0|max:100',
            'section4.other_percentage' => 'nullable|numeric|min:0|max:100',
            'section4.female_leadership_percentage' => 'nullable|numeric|min:0|max:100',
            'section4.employees_under_30_percentage' => 'nullable|numeric|min:0|max:100',
            'section4.employees_30_to_50_percentage' => 'nullable|numeric|min:0|max:100',
            'section4.employees_over_50_percentage' => 'nullable|numeric|min:0|max:100',
            'section4.survey_participation_rate' => 'nullable|numeric|min:0|max:100',
            'section4.respect_satisfaction' => 'nullable|numeric|min:0|max:100',
            'section4.flexibility_satisfaction' => 'nullable|numeric|min:0|max:100',
            'section4.work_life_balance_satisfaction' => 'nullable|numeric|min:0|max:100',
            'section4.sickness_rate' => 'nullable|numeric|min:0|max:100',
            'section4.lost_time_incident_rate' => 'nullable|numeric|min:0',
            'section4.occupational_fatalities' => 'nullable|integer|min:0',
            'section4.employees_in_training_percentage' => 'nullable|numeric|min:0|max:100',
            'section4.average_training_spend_per_fte' => 'nullable|numeric|min:0',
            'section4.employee_assistance_program_exists' => 'nullable|boolean',
            'section4.volunteer_days_per_employee' => 'nullable|numeric|min:0',
            'section4.total_volunteer_days' => 'nullable|integer|min:0',
            'section4.employees_covered_by_collective_bargaining' => 'nullable|numeric|min:0|max:100',

            // Section 5: Cybersecurity
            'section5.number_of_breaches' => 'nullable|integer|min:0',
            'section5.customers_affected_by_breaches' => 'nullable|integer|min:0',
            'section5.law_enforcement_requests' => 'nullable|integer|min:0',
            'section5.iso27001_certified' => 'nullable|boolean',
            'section5.cybersecurity_training_completion_rate' => 'nullable|numeric|min:0|max:100',

            // Section 6: Supply Chain
            'section6.supplier_code_exists' => 'nullable|boolean',
            'section6.suppliers_acknowledged_code_percentage' => 'nullable|numeric|min:0|max:100',
            'section6.procurement_staff_trained_percentage' => 'nullable|numeric|min:0|max:100',
            'section6.third_party_risk_management_exists' => 'nullable|boolean',

            // Section 7: Targets
            'section7.netzero_scope1_scope2_target_year' => 'nullable|integer|min:2000',
            'section7.science_based_targets_submitted' => 'nullable|boolean',
            'section7.science_based_targets_validated' => 'nullable|boolean',
            'section7.cdp_level_id' => 'nullable|integer|exists:cdp_levels,id',
            'section7.ecoVadis_rating_id' => 'nullable|integer|exists:ecoVadis_ratings,id',

            // Frameworks and Certifications
            'frameworks' => 'nullable|array',
            'frameworks.*' => 'integer|exists:frameworks,id',
            'certifications' => 'nullable|array',
            'certifications.*' => 'integer|exists:certifications,id',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Report name is required.',
            'name.string' => 'Report name must be a string.',
            'name.max' => 'Report name cannot exceed 255 characters.',
            '*.exists' => 'The selected value does not exist.',
            '*.numeric' => 'The field must be a valid number.',
            '*.integer' => 'The field must be a whole number.',
            '*.min' => 'The field must be at least :min.',
            '*.max' => 'The field cannot exceed :max.',
            '*.boolean' => 'The field must be true or false.',
            'frameworks.array' => 'Frameworks must be an array.',
            'certifications.array' => 'Certifications must be an array.',
        ];
    }
}
