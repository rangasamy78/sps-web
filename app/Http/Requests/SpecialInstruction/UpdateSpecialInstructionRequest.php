<?php

namespace App\Http\Requests\SpecialInstruction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecialInstructionRequest extends FormRequest
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
            'special_instruction_name' => 'required|string|max:255|unique:special_instructions,special_instruction_name,' .  $this->route('special_instruction')->id,
        ];
    }
}
