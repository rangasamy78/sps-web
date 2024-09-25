<?php

namespace App\Http\Requests\Associate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssociateRequest extends FormRequest
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
        $associate = $this->route('associate')->id;
        return [
            'associate_name' => 'required|string|max:255|unique:associates,associate_name,' . $associate,
            'associate_code' => 'nullable|unique:associates,associate_code,' . $associate,
            'primary_phone' => ['nullable', 'numeric', 'digits:10'],
            'secondary_phone' => ['nullable', 'numeric', 'digits:10'],
            'mobile' => ['nullable', 'numeric', 'digits:10'],
            'zip' => ['nullable', 'numeric', 'digits_between:5,10'],
            'website' => ['nullable', 'url'],
            'email' => ['nullable', 'string', 'max:255', 'email', 'unique:associates,email,' . $associate],
            'accounting_email' => ['nullable', 'string', 'max:255', 'email', 'unique:associates,email,' . $associate],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'associate_name.required' => 'The associate name field is required.',
            'associate_name.unique' => 'The associate name has already been taken.',
            'associate_code.unique' => 'The associate code has already been taken.',
            'primary_phone.numeric' => 'The primary phone number must be a number.',
            'primary_phone.digits' => 'The primary phone number must be 10 digits.',
            'secondary_phone.numeric' => 'The secondary phone number must be a number.',
            'secondary_phone.digits' => 'The secondary phone number must be 10 digits.',
            'mobile.numeric' => 'The mobile number must be a number.',
            'mobile.digits' => 'The mobile number must be 10 digits.',
            'zip.numeric' => 'The zip code must be a number.',
            'zip.digits_between' => 'The zip code must be between 5 and 10 digits.',
            'website.url' => 'The website must be a valid URL.',
            'email.email' => 'The email address must be a valid email address.',
            'email.unique' => 'The email address has already been taken.',
            'accounting_email.email' => 'The accounting email address must be a valid email address.',
            'accounting_email.unique' => 'The accounting email address has already been taken.',
        ];
    }
}
