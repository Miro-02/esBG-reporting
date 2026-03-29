<?php

namespace Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportSection4Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'gender_pay_gap_percentage' => 'nullable|numeric|min:-100|max:100',
            'female_employees_percentage' => 'nullable|numeric|min:0|max:100',
            'female_management_percentage' => 'nullable|numeric|min:0|max:100',
            'health_safety_incidents' => 'nullable|integer|min:0',
            'employee_turnover_rate' => 'nullable|numeric|min:0|max:100',
            'employee_satisfaction_score' => 'nullable|numeric|min:0|max:100',
            'diversity_policy_exists' => 'nullable|boolean',
        ];
    }
}
