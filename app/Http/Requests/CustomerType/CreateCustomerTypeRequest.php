<?php

namespace App\Http\Requests\CustomerType;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerTypeRequest extends FormRequest
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
            'customer_type_name' => 'required|string|max:255|unique:customer_types,customer_type_name',
        ];
    }
}
