<?php

namespace App\Http\Requests\InventoryAdjustmentReasonCode;

use Illuminate\Foundation\Http\FormRequest;

class CreateInventoryAdjustmentReasonCodeRequest extends FormRequest
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
            'reason' => 'required|string|max:255|unique:inventory_adjustment_reason_codes,reason',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

}