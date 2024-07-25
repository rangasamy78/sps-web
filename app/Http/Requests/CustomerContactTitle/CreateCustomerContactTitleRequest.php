<?php

namespace App\Http\Requests\CustomerContactTitle;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerContactTitleRequest extends FormRequest
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
            'customer_title' => 'required|string|max:255|unique:customer_contact_titles,customer_title',
        ];

    }
}
