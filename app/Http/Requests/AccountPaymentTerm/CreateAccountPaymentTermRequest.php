<?php

namespace App\Http\Requests\AccountPaymentTerm;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountPaymentTermRequest extends FormRequest
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
            'payment_label'            => 'required|string',
            'payment_type'             => 'required',
            'payment_net_due_day'      => 'required|string',
            'payment_discount_percent' => 'nullable|numeric',
            'payment_threshold_days'   => 'nullable|numeric',
        ];
    }
}
