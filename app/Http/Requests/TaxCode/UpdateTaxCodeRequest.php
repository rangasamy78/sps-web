<?php

namespace App\Http\Requests\TaxCode;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxCodeRequest extends FormRequest
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
        $taxCodeId = $this->route('tax_code')->id;
        return [
            'tax_code' => 'required|string|max:255|unique:tax_codes,tax_code,' . $taxCodeId,
            'tax_code_label' => 'required',
            'effective_date' => 'nullable|required',
        ];
    }
}
