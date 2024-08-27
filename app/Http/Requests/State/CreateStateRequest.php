<?php

namespace App\Http\Requests\State;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStateRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('states')->ignore($this->route('state')),
            ],
            'code' => [
                'required',
                Rule::unique('states')->where(function ($query) {
                    return $query->where('code', $this->input('code'));
                })->ignore($this->route('state')),
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
            'name.unique' => 'The state name has already been taken.',
            'code.unique' => 'The combination of Name and Code has already been taken.',
        ];
    }
}