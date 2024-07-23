<?php

namespace App\Http\Requests\ProbabilityToClose;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProbabilityToCloseRequest extends FormRequest
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
        $probabilityToCloseId = $this->route('probability_to_close')->id;
        return [
            'probability_to_close' => 'required|string|max:255|unique:probability_to_closes,probability_to_close,' . $probabilityToCloseId,
        ];
    }
}
