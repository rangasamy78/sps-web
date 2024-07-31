<?php

namespace App\Http\Requests\PriceListLabel;

use Illuminate\Foundation\Http\FormRequest;

class CreatePriceListLabelRequest extends FormRequest
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
            'price_level' => 'required|string|unique:price_list_labels,price_level',
            'price_label' => 'required|string|max:255|unique:price_list_labels,price_label',
            'price_code' => 'required|string|max:255|unique:price_list_labels,price_code',
            'price_notes' => 'required|string|max:255|unique:price_list_labels,price_notes',
            'default_discount' => 'nullable|integer',
            'default_margin' => 'nullable|integer',
            'default_markup' => 'nullable|integer',
            'sales_person_commission' => 'nullable|integer',
        ];
    }
}
