<?php

namespace App\Http\Requests\AdjustmentType;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdjustmentTypeRequest extends FormRequest
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
            'adjustment_type' => 'required|string|max:255|unique:adjustment_types,adjustment_type',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

}
