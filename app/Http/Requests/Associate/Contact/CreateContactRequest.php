<?php

namespace App\Http\Requests\Associate\Contact;

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
        ];
    }

    public function messages()
    {
        return [
            'contact_name.required' => 'The contact name is required.',
        ];
    }
}
