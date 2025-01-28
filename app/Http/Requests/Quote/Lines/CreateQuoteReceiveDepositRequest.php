<?php

namespace App\Http\Requests\Quote\Lines;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteReceiveDepositRequest extends FormRequest
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
            'quote_id' => 'required|integer|exists:quotes,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'cash_account_id' => 'required|integer|exists:accounts,id',
            'receipt_code' => 'nullable|string|max:255',
            'deposit_date' => 'required|date',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'reference' => 'nullable|string|max:255',
            'reference_date' => 'nullable|date',
            'authorization' => 'nullable|string|max:255',
            'check_date' => 'nullable|date',
            'check_code' => 'nullable|string|max:255',
            'receive_amount' => 'required|numeric|min:0',
            'net_amount_due' => 'nullable|numeric|min:0',
            'quote_amount_percentage' => 'nullable|in:20,25,30,40,50,100',
            'address' => 'nullable|string|max:250',
            'suite' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:150',
            'zip' => 'nullable|string|max:100',
            'memo' => 'nullable|string|max:200',
            'account_id' => 'nullable|integer|exists:accounts,id',
            'location_id' => 'nullable|integer|exists:companies,id',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'internal_notes' => 'nullable|string',
        ];

        // Check if payment method is "Check" and make 'check_code' and 'check_date' required
        if ($this->payment_method_id && \App\Models\PaymentMethod::find($this->payment_method_id)->payment_method_name === 'Check') {
            $rules['check_code'] = 'required|string|max:255';
            $rules['check_date'] = 'required|date';
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'quote_id.required' => 'The quote ID is required.',
            'customer_id.required' => 'The customer ID is required.',
            'cash_account_id.required' => 'The cash account ID is required.',
            'receipt_code.required' => 'The receipt code is required.',
            'receipt_code.unique' => 'This receipt code already exists.',
            'deposit_date.required' => 'The deposit date is required.',
            'deposit_date.before_or_equal' => 'The deposit date cannot be in the future.',
            'payment_method_id.required' => 'The payment method is required.',
            'authorization.required' => 'Authorization is required.',
            'receive_amount.numeric' => 'The received amount must be a valid number.',
            'quote_amount_percentage.in' => 'The quote amount percentage must be one of the predefined values.',
        ];
    }
}
