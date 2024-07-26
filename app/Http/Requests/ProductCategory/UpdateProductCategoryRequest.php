<?php
namespace App\Http\Requests\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
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
        $product_category = $this->route('product_category')->id;
        return [
            'product_category_name' => 'required|string|max:255|unique:product_categories,product_category_name,' . $product_category,
        ];
    }


}
