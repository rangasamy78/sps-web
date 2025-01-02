<?php

namespace App\Http\Requests\Quote\Lines;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteProductRequest extends FormRequest
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
            'quote_id'               => 'required|integer',
            'product_id'             => 'required|integer',
            'description'            => 'nullable|string',
            'is_sold_as'             => 'nullable|boolean',
            'product_quantity'       => 'required|integer',
            'product_unit_price'     => 'required|numeric', // Validate as a number (supports decimals)
            'product_amount'         => 'required|numeric', // Validate as a number (supports decimals)
            'is_tax'                 => 'nullable|boolean',
            'is_hide_line'           => 'nullable|boolean',
            'notes'                  => 'nullable|string',
            'inventory_restriction'  => 'nullable|string|in:exact_slab,within_lot,within_product', // Ensure it matches allowed enum values
        ];
    }
}
