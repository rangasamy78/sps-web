<?php

namespace App\Http\Requests\PrePurchaseTerm;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrePurchaseTermRequest extends FormRequest
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
            'pre_purchase_term_name' => 'required|string|max:255|unique:pre_purchase_terms,pre_purchase_term_name',
        ];
    }
}
