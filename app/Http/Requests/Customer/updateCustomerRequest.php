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
            'customer_name' => 'required',
            'parent_location_id' => 'required',
            'price_list_label_id' => 'required',
            'payment_terms_id' => 'required',
            'is_allow_login' => 'nullable|boolean',
        ];

        // Add rules for `username` and `password` only if `is_allow_login` is checked
        if ($this->input('is_allow_login')) {
            $rules['username'] = 'required';
            $rules['password'] = 'required';
        }

        //If you're updating, make sure `username` and `password` are not required if `is_allow_login` is not checked
        // if ($this->isMethod('put') || $this->isMethod('patch')) {
        //      $rules['username'] = 'nullable';
        //     $rules['password'] = 'nullable';
        // }

        return $rules;
    }
}