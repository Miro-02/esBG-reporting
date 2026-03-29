<?php

namespace Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportSection2Request extends FormRequest
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
            'total_board_members' => 'nullable|integer|min:0',
            'female_board_percentage' => 'nullable|numeric|min:0|max:100',
            'esg_committee_exists' => 'nullable|boolean',
            'esg_committee_frequency' => 'nullable|string',
            'esg_executive_role' => 'nullable|string|max:255',
            'code_of_conduct_exists' => 'nullable|boolean',
            'whistleblower_channel_exists' => 'nullable|boolean',
            'whistleblower_reports_filed' => 'nullable|integer|min:0',
            'anti_corruption_training_rate' => 'nullable|numeric|min:0|max:100',
            'esg_awareness_training_rate' => 'nullable|numeric|min:0|max:100',
        ];
    }
}
