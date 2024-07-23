<?php

namespace App\Http\Requests\OpportunityStage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOpportunityStageRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $opportunityStageId = $this->route('opportunity_stage')->id;
        return [
            'opportunity_stage' => 'required|string|max:255|unique:opportunity_stages,opportunity_stage,' . $opportunityStageId,
        ];
    }
}
