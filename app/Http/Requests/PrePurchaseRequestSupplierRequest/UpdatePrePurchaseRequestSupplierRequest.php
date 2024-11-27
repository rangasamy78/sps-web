<?php

namespace App\Http\Requests\PrePurchaseRequestSupplierRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePrePurchaseRequestSupplierRequest extends FormRequest
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
            'required_ship_date' => 'required|date',
            'requested_by_id'    => 'required',
            'supplier_id' => 'required',
            'product.*.description' => 'required',
            'product.*.purchasing_note' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required'        => 'The Supplier name is required.',
            'requested_by_id.required'    => 'The Requested by is required.',
            'product.*.description.required' => 'Product description is required.',
            'product.*.purchasing_note.required' => 'Purchasing note is required.',
        ];
    }
}
