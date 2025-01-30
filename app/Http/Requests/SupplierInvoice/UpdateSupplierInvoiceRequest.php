<?php

namespace App\Http\Requests\SupplierInvoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierInvoiceRequest extends FormRequest
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
            'entry_date' => 'nullable|date',
            'invoice' => 'required|string|max:255',
            'ship_date' => 'nullable|date',
            'invoice_date' => 'nullable|date',
            'payment_term_id' => 'nullable|integer',
            'due_date' => 'nullable|date',
            'supplier_id' => 'required|integer',
            'purchase_location_id' => 'nullable|integer',
            'ship_to_location_id' => 'nullable|integer',
            'container_number' => 'nullable|string|max:255',
            'printed_notes' => 'nullable|string|max:2000',
            'internal_notes' => 'nullable|string|max:2000',
            'item_total' => 'nullable|numeric',
            'other_total' => 'nullable|numeric',
            'total' => 'nullable|numeric',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'entry_date.date' => 'The entry date must be a valid date.',
            'invoice.required' => 'The invoice field is required.',
            'invoice.string' => 'The invoice must be a string.',
            'invoice.max' => 'The invoice may not be greater than 255 characters.',
            'ship_date.date' => 'The ship date must be a valid date.',
            'invoice_date.date' => 'The invoice date must be a valid date.',
            'payment_term_id.integer' => 'The payment term ID must be an integer.',
            'due_date.date' => 'The due date must be a valid date.',
            'supplier_id.required' => 'The supplier ID is required.',
            'supplier_id.integer' => 'The supplier ID must be an integer.',
            'purchase_location_id.integer' => 'The purchase location ID must be an integer.',
            'ship_to_location_id.integer' => 'The ship-to location ID must be an integer.',
            'container_number.max' => 'The container number may not be greater than 255 characters.',
            'printed_notes.max' => 'The printed notes may not be greater than 2000 characters.',
            'internal_notes.max' => 'The internal notes may not be greater than 2000 characters.',
            'item_total.numeric' => 'The item total must be a numeric value.',
            'other_total.numeric' => 'The other total must be a numeric value.',
            'total.numeric' => 'The total must be a numeric value.',
        ];
    }
}
