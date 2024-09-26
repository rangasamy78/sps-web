<?php

namespace App\Http\Requests\Expenditure;

use Illuminate\Foundation\Http\FormRequest;

class CreateExpenditureRequest extends FormRequest
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
            'expenditure_name'      => 'required|string|max:255|unique:expenditures,expenditure_name',
            'print_name'            => 'required',
            'parent_location_id'   => 'required|integer',
            'primary_phone' => ['nullable', 'numeric', 'digits:10'],
            'secondary_phone' => ['nullable', 'numeric', 'digits:10'],
            'mobile' => ['nullable', 'numeric', 'digits:10'],
            'zip' => ['nullable', 'numeric', 'digits_between:5,10'],
            'shipping_zip' => ['nullable', 'numeric', 'digits_between:5,10'],
            'website' => ['nullable', 'url'],
            'email' => ['nullable', 'string', 'max:255', 'email', 'unique:expenditures,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_location_id.required' => 'The parent location field is required.',
            'primary_phone.numeric' => 'The primary phone number must be a number.',
            'primary_phone.digits' => 'The primary phone number must be 10 digits.',
            'secondary_phone.numeric' => 'The secondary phone number must be a number.',
            'secondary_phone.digits' => 'The secondary phone number must be 10 digits.',
            'mobile.numeric' => 'The mobile number must be a number.',
            'mobile.digits' => 'The mobile number must be 10 digits.',
            'zip.numeric' => 'The zip code must be a number.',
            'zip.digits_between' => 'The zip code must be between 5 and 10 digits.',
            'shipping_zip.numeric' => 'The zip code must be a number.',
            'shipping_zip.digits_between' => 'The zip code must be between 5 and 10 digits.',
            'website.url' => 'The website must be a valid URL.',
            'email.email' => 'The email address must be a valid email address.',
            'email.unique' => 'The email address has already been taken.',
        ];
    }
}
