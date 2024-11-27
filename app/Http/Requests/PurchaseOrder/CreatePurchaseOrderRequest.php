<?php

namespace App\Http\Requests\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseOrderRequest extends FormRequest
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
            'po_number'            => 'required|unique:purchase_orders,po_number',
            'supplier_id'          => 'required',
            'payment_term_id'      => 'required',
            'purchase_location_id' => 'required',
            'conversion_rate'      => 'required|numeric|min:0',
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

            'supplier_id.required'          => 'Please select a supplier.',
            'payment_term_id.required'      => 'Please select payment terms.',
            'purchase_location_id.required' => 'Please select a purchase location.',
            'conversion_rate.required'      => 'The exchange rate is required.',
            'conversion_rate.numeric'       => 'The exchange rate must be a number.',
            'conversion_rate.min'           => 'The exchange rate must be at least 0.',
        ];
    }
}
