<?php

namespace App\Http\Requests\SupplierReturnStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierReturnStatusRequest extends FormRequest
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
        $supplier_return_status = $this->route('supplier_return_status')->id;
        return [
            'return_code_name' => 'required|string|max:255|unique:supplier_return_statuses,return_code_name,' . $supplier_return_status,
        ];
    }
}
