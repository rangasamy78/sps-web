<?php

namespace App\Http\Requests\VendorPo;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewBillRequest extends FormRequest
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
            'vendor_id'       => 'required',
            'invoice_number'  => 'required',
            'invoice_date'    => 'required',
            'payment_term_id' => 'required',
            'due_date'        => 'required',
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
            'vendor_id.required'       => 'The vendor field is mandatory.',
            'invoice_number.required'  => 'Please provide an invoice number.',
            'invoice_date.required'    => 'The invoice date is necessary.',
            'payment_term_id.required' => 'You must specify the payment term.',
            'due_date.required'        => 'The due date cannot be left blank.',
        ];
    }

}
