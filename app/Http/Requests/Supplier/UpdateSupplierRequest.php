<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'supplier_name' => 'required|string|max:255|unique:suppliers,supplier_name,' .  $this->route('supplier')->id,
            'print_name' => 'required|string|max:255|unique:suppliers,print_name,' .  $this->route('supplier')->id,
            'code' => 'nullable|string|unique:suppliers,code,' .  $this->route('supplier')->id,
            'contact_name' => 'nullable|string|max:255',
            'supplier_type_id' => 'nullable|numeric',
            'parent_location_id' => 'nullable|numeric',
            'multi_location_supplier' => 'nullable|numeric',
            'language_id' => 'nullable|numeric',
            'parent_supplier_id' => 'nullable|numeric',
            'supplier_since' => 'nullable|string|max:255',
            'supplier_port_id' => 'nullable|numeric',
            'markup_multiplier' => 'nullable|string',
            'discount' => 'nullable|numeric',
            'primary_phone' => 'nullable|string|min:10',
            'secondary_phone' => 'nullable|string|min:10',
            'mobile' => 'nullable|string|min:10',
            'fax' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'remit_address' => 'nullable|string',
            'remit_suite' => 'nullable|string',
            'remit_city' => 'nullable|string',
            'remit_state' => 'nullable|string',
            'remit_zip' => 'nullable|string',
            'remit_country_id' => 'nullable|numeric',
            'ship_address' => 'nullable|string',
            'ship_suite' => 'nullable|string',
            'ship_city' => 'nullable|string',
            'ship_state' => 'nullable|string',
            'ship_zip' => 'nullable|string',
            'ship_country_id' => 'nullable|numeric',
            'credit_limit' => 'nullable|string',
            'ein_number' => 'nullable|string',
            'account' => 'nullable|string',
            'currency_id' => 'required|numeric', // Corrected from 'currecny_id'
            'payment_terms_id' => 'required|numeric',
            'shipment_terms_id' => 'nullable|numeric',
            'purchase_tax_id' => 'nullable|numeric',
            'freight_forwarder_id' => 'nullable|numeric', // Fixed typo from 'frieght_forwarder_id'
            'default_payment_method_id' => 'nullable|numeric',
            'shipping_instruction' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'allow_access_to_supplier' => 'nullable|numeric',
            'supplier_username' => 'nullable|string',
            'supplier_password' => 'nullable|string',
            'form_1099_printed' => 'nullable|numeric',
            'status' => 'required|string',
        ];
    }
}
