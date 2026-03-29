<?php

namespace Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportSection1Request extends FormRequest
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
            'company_name' => 'nullable|string|max:255',
            'legal_form_id' => 'nullable|integer|exists:legal_forms,id',
            'country_id' => 'nullable|integer|exists:countries,id',
            'sector_id' => 'nullable|integer|exists:sectors,id',
            'annual_revenue' => 'nullable|numeric|min:0',
            'number_of_employees' => 'nullable|integer|min:0',
            'number_of_locations' => 'nullable|integer|min:0',
            'parent_company_id' => 'nullable|integer|exists:report_section1_company_profiles,id',
            'is_subsidiary' => 'nullable|boolean',
        ];
    }

    /**
     * Get the validated data.
     */
    public function validated($key = null, $default = null)
    {
        return parent::validated($key, $default);
    }
}
