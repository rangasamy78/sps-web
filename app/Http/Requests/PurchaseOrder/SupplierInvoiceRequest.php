<?php

namespace App\Http\Requests\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class SupplierInvoiceRequest extends FormRequest
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
            'sipl_bill'               => 'required',
            'entry_date'              => 'required|date',
            'invoice'                 => 'required|string',
            'ship_date'               => 'required|date',
            'invoice_date'            => 'required|date',
            'payment_term_id'         => 'required|numeric|min:1',
            'due_date'                => 'required|date',
         
            'purchase_location_id'    => 'required|numeric|min:1',
            'ship_to_location_id'     => 'required|numeric|min:1',
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
            'sipl_bill.required'               => 'The bill number is required.',
            
            'entry_date.required'              => 'The entry date is required.',
            'entry_date.date'                  => 'The entry date must be a valid date.',
            'invoice.required'                 => 'The invoice is required.',
            'ship_date.required'               => 'The ship date is required.',
            'ship_date.date'                   => 'The ship date must be a valid date.',
            'invoice_date.required'            => 'The invoice date is required.',
            'invoice_date.date'                => 'The invoice date must be a valid date.',
            'payment_term_id.required'         => 'Please select payment terms.',
            'payment_term_id.numeric'          => 'Payment terms must be a valid numeric value.',
            'payment_term_id.min'              => 'Payment terms must be greater than zero.',
            'due_date.required'                => 'The due date is required.',
            'due_date.date'                    => 'The due date must be a valid date.',
            
            'supplier_id.min'                  => 'The supplier must be greater than zero.',
            'purchase_location_id.required'    => 'Please select a purchase location.',
            'purchase_location_id.numeric'     => 'The purchase location must be a valid numeric value.',
            'purchase_location_id.min'         => 'The purchase location must be greater than zero.',
            'ship_to_location_id.required'     => 'Please select a shipping location.',
            'ship_to_location_id.numeric'      => 'The shipping location must be a valid numeric value.',
            'ship_to_location_id.min'          => 'The shipping location must be greater than zero.',
        ];
    }
}

