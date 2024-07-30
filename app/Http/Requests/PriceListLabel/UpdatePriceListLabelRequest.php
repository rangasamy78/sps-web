<?php

namespace App\Http\Requests\PriceListLabel;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceListLabelRequest extends FormRequest
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
            'price_level' => 'required|string|unique:price_list_labels,price_level,' . $this->route('price_list_label')->id,
            'price_label' => 'required|string|max:255|unique:price_list_labels,price_label,' . $this->route('price_list_label')->id,
            'price_code' => 'required|string|max:255|unique:price_list_labels,price_code,' . $this->route('price_list_label')->id,
            'price_notes' => 'required|string|max:255|unique:price_list_labels,price_notes,' . $this->route('price_list_label')->id,
            'default_discount' => 'nullable|integer|',
            'default_margin' => 'nullable|integer|',
            'default_markup' => 'nullable|integer|',
            'sales_person_commission' => 'nullable|integer|',
        ];
    }
}
