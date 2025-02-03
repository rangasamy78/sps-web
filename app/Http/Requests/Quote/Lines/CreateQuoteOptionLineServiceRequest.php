<?php

namespace App\Http\Requests\Quote\Lines;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteOptionLineServiceRequest extends FormRequest
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
            'quote_service_id' => 'required|integer',
            'services' => 'required|array',  // Validate products array
            'services.*.service_id' => 'required|integer',  // Each product must have a product_id
            'services.*.description' => 'nullable|string',  // Optional description
            'services.*.is_sold_as' => 'nullable|boolean',  // Optional is_sold_as flag
            'services.*.quantity' => 'nullable|integer|min:0',  // Optional quantity
            'services.*.unit_price' => 'nullable|numeric|min:0',  // Optional unit_price
            'services.*.amount' => 'nullable|numeric|min:0',  // Optional amount
        ];
    }

    public function messages()
    {
        return [
            'quote_service_id.required' => 'Quote Service ID is required.',
            'quote_service_id.integer' => 'Quote Service ID must be an integer.',
            'services.required' => 'Services field is required.',
            'services.array' => 'Services must be an array.',
            'services.*.product_id.required' => 'Service ID is required for each Service.',
            'services.*.product_id.integer' => 'Service ID must be an integer.',
            'services.*.description.string' => 'Description must be a string.',
            'services.*.quantity.integer' => 'Quantity must be an integer.',
            'services.*.quantity.min' => 'Quantity cannot be negative.',
            'services.*.unit_price.numeric' => 'Unit Price must be a valid number.',
            'services.*.unit_price.min' => 'Unit Price cannot be negative.',
            'services.*.amount.numeric' => 'Amount must be a valid number.',
            'services.*.amount.min' => 'Amount cannot be negative.',
        ];
    }
}
