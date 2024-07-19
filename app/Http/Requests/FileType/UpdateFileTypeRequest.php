<?php

namespace App\Http\Requests\FileType;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
class UpdateFileTypeRequest extends FormRequest
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
        $fileTypeId = $this->route('file_type');

        return [
            'view_in' => 'required|string|max:255',
            'file_type' => [
                'required',
                'string',
                'max:255',
                Rule::unique('file_types')
                    ->where('view_in', $this->input('view_in'))
                    ->ignore($fileTypeId),
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
            'file_type.unique' => 'The file type has already been taken for the selected view.',
        ];
    }
}
