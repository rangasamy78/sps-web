<?php

namespace App\Http\Requests\BinType;

use Illuminate\Foundation\Http\FormRequest;

class CreateBinTypeRequest extends FormRequest
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
            'bin_type' => 'required|string|max:255|unique:bin_types,bin_type',
        ];

    }
}
