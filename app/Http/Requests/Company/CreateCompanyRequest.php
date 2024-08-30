<?php

namespace App\Http\Requests\Company;

use App\Rules\CompanyLimit;
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
            'company_name' => ['required', 'string', 'max:255', 'unique:companies,company_name' , new CompanyLimit],
            'email' => ['required', 'string', 'max:255', 'unique:companies,email'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'max:255'],
            'zip' => ['required', 'numeric', 'digits_between:5,10'],
            'phone_1' => ['required', 'numeric', 'digits:10'],
            'phone_2' => ['nullable', 'numeric', 'digits:10'],
            'website' => ['nullable', 'url'],
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_bin_pre_defined' => ['required', 'boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'address_line_1' => 'address line',
            'phone_1' => 'phone',
            'phone_2' => 'phone',
        ];
    }
}
