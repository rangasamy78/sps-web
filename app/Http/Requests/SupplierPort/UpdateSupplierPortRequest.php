<?php
namespace App\Http\Requests\SupplierPort;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierPortRequest extends FormRequest
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
        $supplier_port = $this->route('supplier_port')->id;
        return [
            'supplier_port_name' => 'required|string|max:255|unique:supplier_ports,supplier_port_name,' . $supplier_port,
            'avg_days'           => 'required',
            'country_id'         => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'Country is required.',

        ];
    }
}
