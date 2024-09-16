<?php
namespace App\Http\Requests\ProductType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductTypeRequest extends FormRequest
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
        $product_type = $this->route('product_type')->id;
        return [
            'product_type'            => 'required|string|max:255|unique:product_types,product_type,' . $product_type,
            'inventory_gl_account_id' => 'required|integer',
            'sales_gl_account_id'     => 'required|integer',
            'cogs_gl_account_id'      => 'required|integer',
        ];
    }

    public function messages(): array
    {
         return [
            'inventory_gl_account_id.required'  => 'The inventory gl account field is required.',
            'sales_gl_account_id.required'      => 'The sales gl account field is required.',
            'cogs_gl_account_id.required'       => 'The cogs gl account field is required.',
         ];
    }
}
