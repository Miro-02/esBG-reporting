<?php

namespace Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportSection7Request extends FormRequest
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
            'emission_reduction_target' => 'nullable|numeric|min:0|max:100',
            'emission_reduction_target_year' => 'nullable|integer|min:2024',
            'renewable_energy_target' => 'nullable|numeric|min:0|max:100',
            'renewable_energy_target_year' => 'nullable|integer|min:2024',
            'diversity_target_female_management' => 'nullable|numeric|min:0|max:100',
            'diversity_target_year' => 'nullable|integer|min:2024',
            'other_targets' => 'nullable|string',
        ];
    }
}
