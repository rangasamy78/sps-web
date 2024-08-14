<?php

namespace App\Http\Requests\PrintDocDisclaimer;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrintDocDisclaimerRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:print_doc_disclaimers,title',
            'select_type_category_id' => 'required|integer',
            'select_type_sub_category_id' => 'required|integer|different:select_type|unique:print_doc_disclaimers,select_type_sub_category_id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not exceed 255 characters.',
            'title.unique' => 'The title has already been taken.',
            'select_type_category_id.required' => 'The select type is required.',
            'select_type_category_id.integer' => 'The select type must be an integer.',
            'select_type_sub_category_id.required' => 'The select type subcategory is required.',
            'select_type_sub_category_id.integer' => 'The select type subcategory must be an integer.',
            'select_type_sub_category_id.different' => 'The select type subcategory must be different from the select type.',
            'select_type_sub_category_id.unique' => 'The select type subcategory has already been taken.',
        ];
    }
}
