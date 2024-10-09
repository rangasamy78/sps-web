<?php

namespace App\Http\Requests\Supplier\Contact;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
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
            'contact_name' => 'required|string|max:255|unique:contacts,contact_name',
            'type' => 'required|string|max:255',
            'type_id' => 'required|integer',
            'address' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'county_id' => 'nullable|integer',
            'lot' => 'nullable|string|max:50',
            'sub_division' => 'nullable|string|max:100',
            'country_id' => 'nullable|integer',
            'primary_phone' => 'nullable|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_ship_to_address' => 'nullable|boolean',
            'tax_code_id' => 'nullable|integer',
            'internal_notes' => 'nullable|string',
        ];
    }
    public function messages()
    {
        return [
            'contact_name.required' => 'The contact name is required.',
            'type.required' => 'The type is required.',
        ];
    }
}
