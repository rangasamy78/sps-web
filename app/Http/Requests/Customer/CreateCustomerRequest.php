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
            'customer_name'        => 'required',
            'parent_location_id'   => 'required',
            'price_list_label_id'  => 'required',
            'payment_terms_id'     => 'required',
            'is_allow_login'       => 'nullable|boolean',
            'username'             => 'required_if:is_allow_login,1',
            'password'             => 'required_if:is_allow_login,1',
            'is_tax_exempt'        => 'nullable|boolean',
            'tax_exempt_reason_id' => 'required_if:is_tax_exempt,1',
            'exempt_expiry_date'   => 'required_if:is_tax_exempt,1',
            'hold_days'            => 'nullable|numeric',
            'credit_limit'         => 'nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required'           => 'The customer name is required.',
            'parent_location_id.required'      => 'The parent location is required.',
            'price_list_label_id.required'     => 'The price list label is required.',
            'payment_terms_id.required'        => 'The payment terms are required.',
            'is_allow_login.boolean'           => 'The allow login option must be true or false.',
            'username.required_if'             => 'The username is required when login is allowed.',
            'password.required_if'             => 'The password is required when login is allowed.',
            'is_tax_exempt.boolean'            => 'The tax exemption option must be true or false.',
            'tax_exempt_reason_id.required_if' => 'The tax exempt reason is required when the customer is tax exempt.',
            'exempt_expiry_date.required_if'   => 'The exemption expiry date is required when the customer is tax exempt.',
            'hold_days.numeric'                => 'The hold days must be a valid number.',
            'credit_limit.numeric'             => 'The credit limit must be a valid number.',
        ];
    }
}
