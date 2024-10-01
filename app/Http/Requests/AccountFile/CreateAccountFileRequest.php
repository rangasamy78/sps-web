<?php

namespace App\Http\Requests\AccountFile;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountFileRequest extends FormRequest
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
            'file_name' => 'required|array', // Accepts an array of files
            'file_name.*' => 'required|', // Each file can be an image or PDF, max size of 10MB
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|max:250', // Validate each note as a string with a max length of 250 characters
            'account_id' => 'required|array',
            'account_id.*' => 'required', // Validate each account_id as an integer
        ];
    }
}
