<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
class CreateCustomerRequest extends FormRequest
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
            'customer_name'       => 'required',
            'parent_location_id'  => 'required',
            'price_list_label_id' => 'required',
            'payment_terms_id'    => 'required',
            'is_allow_login'      => 'nullable|boolean',
            'username'            => 'required_if:is_allow_login,1',
            'password'            => 'required_if:is_allow_login,1',
        ];
    }
}
