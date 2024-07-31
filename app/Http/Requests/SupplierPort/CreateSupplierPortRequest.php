<?php

namespace App\Http\Requests\SupplierPort;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplierPortRequest extends FormRequest
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
            'supplier_port_name' => 'required|string|max:255|unique:supplier_ports,supplier_port_name',
            'avg_days' => 'required',
            'country_id' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

}
