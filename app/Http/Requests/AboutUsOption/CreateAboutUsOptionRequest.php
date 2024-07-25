<?php

namespace App\Http\Requests\AboutUsOption;

use Illuminate\Foundation\Http\FormRequest;

class CreateAboutUsOptionRequest extends FormRequest
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
            'how_did_you_hear_option' => 'required|string|max:255|unique:about_us_options,how_did_you_hear_option',
        ];

    }
}
