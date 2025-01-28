<?php

namespace App\Http\Requests\Quote\Lines;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteProductPriceCalculatorsRequest extends FormRequest
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
        return [
            'quote_product_id' => 'required|exists:quote_products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'supplier_unit_cost' => 'nullable|numeric',
            'subtotal_area' => 'nullable|numeric|min:0',
            'subtotal_extended' => 'nullable|numeric|min:0',
            'markup_multiplier' => 'nullable|numeric|min:0',
            'total_markup_multiplier' => 'nullable|numeric|min:0',
            'tax_id' => 'nullable',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_tax_amount' => 'nullable|numeric|min:0',
            'additional_charges' => 'nullable|numeric|min:0',
            'delivery_charges' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'product_charges' => 'nullable|numeric|min:0',
            'product_charges_amount' => 'nullable|numeric|min:0',
            'product_charges_total' => 'nullable|numeric|min:0',
            'fab_other' => 'nullable|numeric|min:0',
            'fab_other_amount' => 'nullable|numeric|min:0',
            'fab_other_total' => 'nullable|numeric|min:0',
            'total_quote_slab' => 'nullable|numeric|min:0',
            'total_quote_price' => 'nullable|numeric|min:0',
            'quote_total' => 'nullable|numeric|min:0',
            'wastage_amount' => 'nullable|numeric|min:0',
            'wastage_percentage' => 'nullable|numeric|min:0',
            'internal_notes' => 'nullable|string',
        ];
    }
}
