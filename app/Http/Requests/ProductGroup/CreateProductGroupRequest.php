<?php

namespace App\Http\Requests\ProductGroup;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductGroupRequest extends FormRequest
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
            'product_group_name' => 'required|string|max:255|unique:product_groups,product_group_name',
        ];

    }
}
