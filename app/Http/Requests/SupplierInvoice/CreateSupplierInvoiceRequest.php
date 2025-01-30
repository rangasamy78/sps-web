<?php

namespace App\Http\Requests\SupplierInvoice;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplierInvoiceRequest extends FormRequest
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
            'entry_date' => 'required|date',
            'invoice' => 'required',
            'ship_date' => 'required|date',
            'invoice_date' => 'required|date',
            'payment_term_id' => 'required',
            'due_date' => 'required|date',
            'supplier_id' => 'required',
            'purchase_location_id' => 'required',
            'ship_to_location_id' => 'required',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'entry_date.required' => 'The entry date is required.',
            'invoice.required' => 'The Invoice is required.',
            'entry_date.date' => 'The entry date must be a valid date.',
            'ship_date.required' => 'The ship date is required.',
            'ship_date.date' => 'The ship date must be a valid date.',
            'invoice_date.required' => 'The invoice date is required.',
            'invoice_date.date' => 'The invoice date must be a valid date.',
            'payment_term_id.required' => 'The payment term is required.',
            'due_date.required' => 'The due date is required.',
            'due_date.date' => 'The due date must be a valid date.',
            'supplier_id.required' => 'The supplier is required.',
            'purchase_location_id.required' => 'The purchase location ID is required.',
            'ship_to_location_id.required' => 'The ship-to location is required.',
            
        ];
    }
}
