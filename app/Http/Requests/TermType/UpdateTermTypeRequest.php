<?php

namespace App\Http\Requests\TermType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTermTypeRequest extends FormRequest
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
        $term_type = $this->route('term_type')->id;
        return [
            'term_type_name' => 'required|string|max:255|unique:term_types,term_type_name,' . $term_type,
            'type_id'   =>  'required',
        ];
    }
}
