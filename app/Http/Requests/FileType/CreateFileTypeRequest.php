<?php

namespace App\Http\Requests\FileType;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateFileTypeRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'view_in' => [
                'required',
                Rule::unique('file_types')->where(function ($query) {
                    return $query->where('view_in', $this->input('view_in'))
                                 ->where('file_type', $this->input('file_type'));
                })->ignore($this->route('file_type')), // ignore current file_type ID when updating
            ],
            'file_type' => [
                'required',
                Rule::unique('file_types')->where(function ($query) {
                    return $query->where('view_in', $this->input('view_in'))
                                 ->where('file_type', $this->input('file_type'));
                })->ignore($this->route('file_type')), // ignore current file_type ID when updating
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
            'view_in.unique' => 'The combination of View In and File Type has already been taken.',
            'file_type.unique' => 'The combination of View In and File Type has already been taken.',
        ];
    }
}
