<?php

namespace App\Http\Requests\SelectTypeCategory;

use Illuminate\Foundation\Http\FormRequest;

class CreateSelectTypeCategoryRequest extends FormRequest
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
            'select_type_category_name' => 'required|string|max:255|unique:select_type_categories,select_type_category_name',
        ];
    }
}
