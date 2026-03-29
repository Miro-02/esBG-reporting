<?php

namespace Modules\Reports\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Please upload an Excel file',
            'file.file' => 'The uploaded item must be a file',
            'file.mimes' => 'The file must be an Excel file (.xlsx or .xls)',
            'file.max' => 'The file size cannot exceed 10MB',
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
