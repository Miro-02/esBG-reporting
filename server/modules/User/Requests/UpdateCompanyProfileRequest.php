<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // User can only update their own profile
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId = auth()->id();
        
        return [
            'company_name' => 'nullable|string|max:255',
            'legal_form_id' => 'nullable|integer|exists:legal_forms,id',
            'country_id' => 'nullable|integer|exists:countries,id',
            'sector_id' => 'nullable|integer|exists:sectors,id',
            'annual_revenue' => 'nullable|numeric|min:0',
            'number_of_employees' => 'nullable|integer|min:0',
            'number_of_locations' => 'nullable|integer|min:0',
            'reporting_period' => 'nullable|string|max:50',
            'parent_company_id' => 'nullable|integer|exists:users,id|different:user_id',
            'is_subsidiary' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'legal_form_id.exists' => 'The selected legal form does not exist.',
            'country_id.exists' => 'The selected country does not exist.',
            'sector_id.exists' => 'The selected sector does not exist.',
            'parent_company_id.exists' => 'The selected parent company does not exist.',
            'parent_company_id.different' => 'A company cannot be its own parent company.',
            'annual_revenue.numeric' => 'Annual revenue must be a valid number.',
            'number_of_employees.integer' => 'Number of employees must be a whole number.',
            'number_of_locations.integer' => 'Number of locations must be a whole number.',
        ];
    }
}
