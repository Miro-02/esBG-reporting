<?php

namespace Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportSection6Request extends FormRequest
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
            'supplier_code_of_conduct_exists' => 'nullable|boolean',
            'supplier_audit_rate' => 'nullable|numeric|min:0|max:100',
            'ethical_sourcing_percentage' => 'nullable|numeric|min:0|max:100',
            'conflict_minerals_assessment_exists' => 'nullable|boolean',
            'supply_chain_risk_assessment_exists' => 'nullable|boolean',
            'supplier_diversity_percentage' => 'nullable|numeric|min:0|max:100',
        ];
    }
}
