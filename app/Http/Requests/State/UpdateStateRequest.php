<?php

namespace App\Http\Requests\State;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStateRequest extends FormRequest
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
                'string',
                'max:255',
                Rule::unique('states')->where(function ($query) {
                    return $query->where('name', $this->input('name'))
                        ->where('code', $this->input('code'));
                })->ignore($this->state->id),
            ],
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('states')->where(function ($query) {
                    return $query->where('name', $this->input('name'))
                        ->where('code', $this->input('code'));
                })->ignore($this->state->id),
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
            'name.unique' => 'The combination of Name and Code has already been taken.',
            'code.unique' => 'The combination of Name and Code has already been taken.',
        ];
    }
}
