<?php

namespace App\Http\Requests\ProductThickness;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductThicknessRequest extends FormRequest
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
            'product_thickness_name' => [
                'required',
                Rule::unique('product_thicknesses')->where(function ($query) {
                    return $query->where('product_thickness_name', $this->input('product_thickness_name'))
                                 ->where('product_thickness_unit', $this->input('product_thickness_unit'));
                })->ignore($this->route('product_thicknesses')), 
            ],
            'product_thickness_unit' => [
                'required',
                Rule::unique('product_thicknesses')->where(function ($query) {
                    return $query->where('product_thickness_name', $this->input('product_thickness_name'))
                                 ->where('product_thickness_unit', $this->input('product_thickness_unit'));
                })->ignore($this->route('product_thicknesses')), 
            ],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'product_thickness_name.unique' => 'The combination of Product Thickness and Unit has already been taken.',
            'product_thickness_unit.unique' => 'The combination of Product Thickness and Unit has already been taken.',
        ];
    }
}
