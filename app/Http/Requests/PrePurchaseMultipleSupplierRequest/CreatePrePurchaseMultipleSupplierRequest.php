<?php

namespace App\Http\Requests\PrePurchaseMultipleSupplierRequest;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrePurchaseMultipleSupplierRequest extends FormRequest
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
            'requested_by_id' => 'required',
            'supplier_id'     => 'required|array',
            'supplier_id.*'   => 'required|integer|exists:suppliers,id',
            'product.*.description' => 'required',
            'product.*.purchasing_note' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'The supplier field is required.',
            'supplier_id.array' => 'The supplier field must be an array.',
            'supplier_id.*.exists' => 'One or more selected suppliers do not exist.',
            'requested_by_id.required' => 'The Requested by is required.',
            'product.*.description.required' => 'Product description is required.',
            'product.*.purchasing_note.required' => 'Purchasing note is required.',
        ];
    }
}
