<?php

namespace App\Http\Requests\TaxComponent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxComponentRequest extends FormRequest
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
            'component_name' => 'required',
            'sales_tax_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'sales_tax_id.required' => 'Sales Tax is required.',

        ];
    }
}
