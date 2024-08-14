<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentMethodRequest extends FormRequest
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
            'payment_method_name' => 'required|string|unique:payment_methods,payment_method_name,',
            'linked_account_id' => 'nullable',
            'account_type_id' => 'nullable',
            'is_transaction_required' => 'nullable',
        ];
    }
}
