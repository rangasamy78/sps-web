<?php

namespace App\Http\Requests\SelectTypeSubCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSelectTypeSubCategoryRequest extends FormRequest
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
             'select_type_category_id' => [
                 'required',
                 'integer',
                 Rule::unique('select_type_sub_categories', 'select_type_category_id')
                     ->ignore($this->route('select_type_sub_category')), 
             ],
             'select_type_sub_categories.0.select_type_sub_category_name' => 'required|string',
             'select_type_sub_categories.*.select_type_sub_category_name' => 'nullable|string',
         ];
     }
     
     public function messages(): array
     {
         return [
             'select_type_category_id.required' => 'The Select Type Category Name is required.',
             'select_type_category_id.integer' => 'The Select Type Category Name must be an integer.',
             'select_type_category_id.unique' => 'The Select Type Category Name has already been taken.',
             'select_type_sub_categories.0.select_type_sub_category_name.required' => 'The first Sub Category Name is required.',
             
         ];
     }
     
}
