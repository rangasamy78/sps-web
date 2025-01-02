<?php

namespace App\Http\Requests\Quote\Lines;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuotePriceCalculatorInventoryDetailRequest extends FormRequest
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
            'products' => 'required|array',
            'products.*.serial_number' => 'nullable|string|max:255',
            'products.*.lot_name' => 'nullable|string|max:255',
            'products.*.bundle' => 'nullable|string|max:255',
            'products.*.length' => 'nullable|numeric|min:0',
            'products.*.width' => 'nullable|numeric|min:0',
            'products.*.slabs' => 'nullable|integer|min:0',
            'products.*.area' => 'nullable|numeric|min:0',
            'products.*.unit_cost' => 'nullable|numeric|min:0',
            'products.*.amount' => 'nullable|numeric|min:0',
            'products.*.notes' => 'nullable|string',
        ];
    }


    /**
     * Customize the validation messages.
     */
    public function messages(): array
    {
        return [
            'quote_product_price_calculator_id.required' => 'The associated price calculator ID is required.',
            'quote_product_price_calculator_id.exists' => 'The selected price calculator ID does not exist.',
            'serial_number.string' => 'The serial number must be a valid string.',
            'lot_name.string' => 'The lot name must be a valid string.',
            'bundle.string' => 'The bundle must be a valid string.',
            'length.numeric' => 'The length must be a valid number.',
            'width.numeric' => 'The width must be a valid number.',
            'slabs.integer' => 'The slabs count must be a valid integer.',
            'area.required' => 'The area is required.',
            'unit_cost.required' => 'The unit cost is required.',
            'amount.required' => 'The amount is required.',
        ];
    }
}
