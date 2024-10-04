<?php

namespace App\Http\Requests\TaxAuthority;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxAuthorityRequest extends FormRequest
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
            'authority_name' => 'required',
            'print_name' => 'required',
        ];
    }
}
