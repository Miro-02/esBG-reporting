<?php

namespace Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportSection3Request extends FormRequest
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
            'ghg_scope1_emissions' => 'nullable|numeric|min:0',
            'ghg_scope2_emissions' => 'nullable|numeric|min:0',
            'ghg_scope3_emissions' => 'nullable|numeric|min:0',
            'renewable_energy_percentage' => 'nullable|numeric|min:0|max:100',
            'waste_reduction_rate' => 'nullable|numeric|min:0|max:100',
            'water_consumption' => 'nullable|numeric|min:0',
            'environmental_certification_exists' => 'nullable|boolean',
        ];
    }
}
