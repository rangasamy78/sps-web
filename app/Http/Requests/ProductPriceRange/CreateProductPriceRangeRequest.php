<?php

namespace App\Http\Requests\ProductPriceRange;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductPriceRangeRequest extends FormRequest
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
            'product_price_range' => 'required|string|max:255|unique:product_price_ranges,product_price_range',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

}
