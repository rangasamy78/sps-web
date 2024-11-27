<?php

namespace App\Http\Requests\PrePurchaseRequestSupplierRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePrePurchaseRequestSupplierRequest extends FormRequest
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
            'supplier_id' => [
                'required',
                Rule::unique('pre_purchase_request_supplier_requests')->where(function ($query) {
                    return $query->where('pre_purchase_request_id', $this->input('pre_purchase_request_id'));
                })
            ],
            'pre_purchase_request_id' => 'required|exists:pre_purchase_requests,id',
            'product.*.description' => 'required',
            'product.*.purchasing_note' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required'        => 'The Supplier name is required.',
            'supplier_id.exists'          => 'This supplier has already been added to the current request.',
            'requested_by_id.required'    => 'The Requested by is required.',
            'product.*.description.required' => 'Product description is required.',
            'product.*.purchasing_note.required' => 'Purchasing note is required.',

        ];
    }
}
