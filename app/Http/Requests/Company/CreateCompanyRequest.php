<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'company_name' => 'required|string|max:255|unique:companies,company_name',
            'email' => 'required|string|max:255|unique:companies,email',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'phone_1' => 'required|string|max:15',
            'website' => 'nullable|url',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_bin_pre_defined' => 'required|boolean'
        ];
    }
}
