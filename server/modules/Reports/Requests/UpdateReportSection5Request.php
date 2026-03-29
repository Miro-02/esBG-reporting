<?php

namespace Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportSection5Request extends FormRequest
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
            'cybersecurity_framework_exists' => 'nullable|boolean',
            'cybersecurity_training_rate' => 'nullable|numeric|min:0|max:100',
            'data_breach_incidents' => 'nullable|integer|min:0',
            'gdpr_compliant' => 'nullable|boolean',
            'iso27001_certified' => 'nullable|boolean',
            'security_audit_frequency' => 'nullable|string',
            'incident_response_plan_exists' => 'nullable|boolean',
        ];
    }
}
