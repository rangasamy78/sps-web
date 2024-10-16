<?php

namespace App\Http\Requests\PrePurchaseTerm;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrePurchaseTermRequest extends FormRequest
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
        $prePurchaseTermId = $this->route('pre_purchase_term')->id;
        return [
            'pre_purchase_term_name' => 'required|string|max:255|unique:pre_purchase_terms,pre_purchase_term_name,' . $prePurchaseTermId,
        ];
    }
}
