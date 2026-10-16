<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AIAnalysisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'evidence_id' => 'sometimes|required|exists:evidence,id',
            'case_id' => 'sometimes|required|exists:cases,id',
        ];
    }
}
