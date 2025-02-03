<?php

namespace App\Http\Requests\Hold\HoldProduct;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHoldProductRequest extends FormRequest
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
            'product_id.*' => 'nullable|integer|exists:products,id',
            'product_quantity.*' => 'required_with:product_id|numeric|min:1',
            'sample_quantity.*' => 'nullable|numeric',
            'product_unit_price.*' => 'required_with:product_id|numeric|min:0',
            'product_amount.*' => 'required_with:product_id|numeric',
            'is_sold_as.*' => 'nullable|boolean',
            'product_description.*' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
}
