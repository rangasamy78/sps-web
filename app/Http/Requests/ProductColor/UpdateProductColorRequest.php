<?php
namespace App\Http\Requests\ProductColor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductColorRequest extends FormRequest
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
        $product_color = $this->route('product_color')->id;
        return [
            'product_color' => 'required|string|max:255|unique:product_colors,product_color,' . $product_color,
        ];
    }


}
