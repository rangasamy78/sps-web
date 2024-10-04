<?php

namespace App\Http\Requests\TaxCode;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaxCodeRequest extends FormRequest
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
            'tax_code' => 'required|unique:tax_codes,tax_code',
            'tax_code_label' => 'required',
            'effective_date' => 'required',
            'tax_component_id.0' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tax_component_id.0.required' => 'The tax component is required.',
        ];
    }
}
