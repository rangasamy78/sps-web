<?php

namespace App\Http\Requests\Quote\Lines;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteOptionLineProductRequest extends FormRequest
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
            'quote_product_id' => 'required|integer',
            'products' => 'required|array',  // Validate products array
            'products.*.product_id' => 'required|integer',  // Each product must have a product_id
            'products.*.description' => 'nullable|string',  // Optional description
            'products.*.is_sold_as' => 'nullable|boolean',  // Optional is_sold_as flag
            'products.*.quantity' => 'nullable|integer|min:0',  // Optional quantity
            'products.*.unit_price' => 'nullable|numeric|min:0',  // Optional unit_price
            'products.*.amount' => 'nullable|numeric|min:0',  // Optional amount
        ];
    }

    public function messages()
    {
        return [
            'quote_product_id.required' => 'Quote Product ID is required.',
            'quote_product_id.integer' => 'Quote Product ID must be an integer.',
            'products.required' => 'Products field is required.',
            'products.array' => 'Products must be an array.',
            'products.*.product_id.required' => 'Product ID is required for each product.',
            'products.*.product_id.integer' => 'Product ID must be an integer.',
            'products.*.description.string' => 'Description must be a string.',
            'products.*.quantity.integer' => 'Quantity must be an integer.',
            'products.*.quantity.min' => 'Quantity cannot be negative.',
            'products.*.unit_price.numeric' => 'Unit Price must be a valid number.',
            'products.*.unit_price.min' => 'Unit Price cannot be negative.',
            'products.*.amount.numeric' => 'Amount must be a valid number.',
            'products.*.amount.min' => 'Amount cannot be negative.',
        ];
    }
}
