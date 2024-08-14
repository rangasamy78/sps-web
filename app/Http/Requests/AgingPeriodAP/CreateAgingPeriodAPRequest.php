<?php

namespace App\Http\Requests\AgingPeriodAP;

use Illuminate\Foundation\Http\FormRequest;

class CreateAgingPeriodAPRequest extends FormRequest
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
        return [
            'invoice_aging_period_ap_1_end' => 'required',
            'invoice_aging_period_ap_2_end' => 'required',
            'invoice_aging_period_ap_3_end' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'invoice_aging_period_ap_1_end.required' => 'This field required.',
            'invoice_aging_period_ap_2_end.required' => 'This field required.',
            'invoice_aging_period_ap_3_end.required' => 'This field required.',
        ];
    }
}
