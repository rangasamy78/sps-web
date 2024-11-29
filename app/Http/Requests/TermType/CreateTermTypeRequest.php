<?php

namespace App\Http\Requests\TermType;

use Illuminate\Foundation\Http\FormRequest;

class CreateTermTypeRequest extends FormRequest
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
            'term_type_name' => 'required|string|max:255|unique:term_types,term_type_name',
            'type_id'   =>  'required',
        ];
    }
}
