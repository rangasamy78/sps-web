<?php

namespace App\Http\Requests\TaxExemptReason;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxExemptReasonRequest extends FormRequest
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
            'reason' => 'required|string|max:255|unique:tax_exempt_reasons,reason,' .  $this->route('tax_exempt_reason')->id,
        ];
    }
}
