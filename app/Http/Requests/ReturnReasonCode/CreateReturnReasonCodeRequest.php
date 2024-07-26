<?php

namespace App\Http\Requests\ReturnReasonCode;

use Illuminate\Foundation\Http\FormRequest;

class CreateReturnReasonCodeRequest extends FormRequest
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
            'return_code' => 'required|string|max:255|unique:return_reason_codes,return_code,',
        ];
    }
}
