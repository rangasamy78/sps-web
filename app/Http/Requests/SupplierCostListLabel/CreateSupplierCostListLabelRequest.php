<?php

namespace App\Http\Requests\SupplierCostListLabel;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplierCostListLabelRequest extends FormRequest
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
            'cost_level' => 'required|string|max:255|unique:supplier_cost_list_labels,cost_level',
            'cost_code' => 'nullable|string|max:255|unique:supplier_cost_list_labels,cost_code',
            'cost_label' => 'required|string|max:255|unique:supplier_cost_list_labels,cost_label',
        ];
    }
}
