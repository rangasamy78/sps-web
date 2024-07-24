<?php

namespace App\Http\Requests\ProductThickness;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductThicknessRequest extends FormRequest
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
        $productThicknessId = $this->route('product_thickness');
        return [
            'product_thickness_name' => 'required|string|max:255',
            'product_thickness_unit' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_thicknesses')
                    ->where('product_thickness_name', $this->input('product_thickness_name'))
                    ->ignore($productThicknessId),
            ],
        ];
    }
}
