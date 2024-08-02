<?php

namespace App\Http\Requests\SupplierCostListLabel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierCostListLabelRequest extends FormRequest
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
        $supplierCostListLabel = $this->route('supplier_cost_list_label')->id;
        return [
            'cost_level' => 'required|string|max:255|unique:supplier_cost_list_labels,cost_level,' . $supplierCostListLabel,
            'cost_code' => 'nullable|string|max:255|unique:supplier_cost_list_labels,cost_code,' . $supplierCostListLabel,
            'cost_label' => 'required|string|max:255|unique:supplier_cost_list_labels,cost_label,' . $supplierCostListLabel,
        ];
    }
}
