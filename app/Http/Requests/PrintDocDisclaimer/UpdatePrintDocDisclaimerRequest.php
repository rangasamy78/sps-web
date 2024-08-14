<?php
namespace App\Http\Requests\PrintDocDisclaimer;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrintDocDisclaimerRequest extends FormRequest
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
        $print_doc_disclaimer = $this->route('print_doc_disclaimer')->id;
        return [
            'title' => 'required|string|max:255|unique:print_doc_disclaimers,title,' . $print_doc_disclaimer,
            'select_type_category_id' => 'required|integer',
            'select_type_sub_category_id' => 'required|integer|different:select_type|unique:print_doc_disclaimers,select_type_sub_category_id,' . $print_doc_disclaimer,
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
            'select_type_category_id.integer' => 'The select type must be an integer .',
            'select_type_sub_category_id.required' => 'The select subcategory is required.',
            'select_type_sub_category_id.integer' => 'The select subcategory must be an integer.',
            'select_type_sub_category_id.different' => 'The select subcategory must be different from the select type.',
            'select_type_sub_category_id.unique' => 'The select subcategory has already been taken.',
        ];
    }
}
