<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class updateCustomerRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'customer_name'       => 'required',
            'parent_location_id'  => 'required',
            'price_list_label_id' => 'required',
            'payment_terms_id'    => 'required',
            'is_allow_login'      => 'nullable|boolean',
            'hold_days'           => 'nullable|numeric',
            'credit_limit'        => 'nullable|numeric',
        ];

        // Add rules for `username` and `password` only if `is_allow_login` is checked
        if ($this->input('is_allow_login')) {
            $rules['username'] = 'nullable|required';
            $rules['password'] = 'nullable|required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'customer_name.required'       => 'The customer name is required.',
            'parent_location_id.required'  => 'The parent location is required.',
            'price_list_label_id.required' => 'The price list label is required.',
            'payment_terms_id.required'    => 'The payment terms are required.',
            'is_allow_login.boolean'       => 'The allow login option must be true or false.',
            'username.required'            => 'The username is required when login is allowed.',
            'password.required'            => 'The password is required when login is allowed.',
            'hold_days.numeric'            => 'The hold days must be a valid number.',
            'credit_limit.numeric'         => 'The credit limit must be a valid number.',
        ];
    }
}
