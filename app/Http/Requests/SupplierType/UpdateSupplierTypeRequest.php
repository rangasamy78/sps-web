<?php
namespace App\Http\Requests\SupplierType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierTypeRequest extends FormRequest
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
        $supplier_type = $this->route('supplier_type')->id;
        return [
            'supplier_type_name' => 'required|string|max:255|unique:supplier_types,supplier_type_name,' . $supplier_type,
        ];
    }
}
