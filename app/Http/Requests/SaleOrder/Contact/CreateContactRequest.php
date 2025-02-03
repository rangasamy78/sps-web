<?php

namespace App\Http\Requests\SaleOrder\Contact;

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
            'sales_order_id' => 'required',
            'contact_id' => 'required|array', // Ensure this is set to required and array
            'contact_id.*' => 'exists:contacts,id', // Each contact ID must exist in the contacts table
        ];
    }
}
