<?php

namespace App\Http\Requests\ReleaseReasonCode;

use Illuminate\Foundation\Http\FormRequest;

class CreateReleaseReasonCodeRequest extends FormRequest
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
            'release_reason_code' => 'required|string|max:255|unique:release_reason_codes,release_reason_code,',
        ];
    }
}
