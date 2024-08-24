<?php

namespace App\Http\Requests\Company;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
        $companyId = $this->route('id');
        return [
            'company_name' => [
                'required', 'string', 'max:255', Rule::unique('companies', 'company_name')->ignore($companyId),
            ],
            'email' => [
                'required', 'string', 'max:255', Rule::unique('companies', 'email')->ignore($companyId),
            ],
            'address_line_1' => [
                'required', 'string', 'max:255',
            ],
            'city' => [
                'required', 'string', 'max:255',
            ],
            'state' => [
                'required', 'string', 'max:255',
            ],
            'zip' => [
                 'required', 'numeric', 'digits_between:5,10',
            ],
            'phone_1' => [
                'required', 'numeric', 'max:10',
            ],
            'website' => [
                'nullable', 'url',
            ],
            'logo' => [
                'nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048',
            ],
            'is_bin_pre_defined' => [
                'required', 'boolean',
            ],
        ];
    }
}
