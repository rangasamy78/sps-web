<?php

namespace App\Http\Requests\VendorPo;

use Illuminate\Foundation\Http\FormRequest;

class CreateVendorPoRequest extends FormRequest
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
        $vendorId = $this->route('vendor_pos');

        return [
            'transaction_number' => 'required|string|unique:vendor_pos,transaction_number,' . $vendorId,  
            'vendor_id' => 'required|integer', 
            'transaction_date' => 'required|date',
            'payment_term_id'  => 'required|integer|exists:account_payment_terms,id',
            'zip'              => 'nullable|string|max:10',
            'phone'            => 'nullable|string|max:15',
            'email'            => 'nullable|email|max:255',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [

            'vendor_id.required'        => 'Vendor Id is required.',
            'vendor_id.integer'         => 'Vendor Id must be an integer.',
            'transaction_date.required' => 'Transaction date is required.',
            'transaction_date.date'     => 'Please provide a valid date for the transaction date.',
            'payment_term_id.required'  => 'Payment term ID is required.',
            'payment_term_id.integer'   => 'Payment term ID must be an integer.',
            'payment_term_id.exists'    => 'The selected payment term ID is invalid.',

        ];
    }
}
