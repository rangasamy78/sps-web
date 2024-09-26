<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplierRequest extends FormRequest
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
            'supplier_name' => 'required|string|max:255|unique:suppliers,supplier_name',
            'print_name' => 'required|string|max:255|unique:suppliers,print_name',
            'code' => 'nullable|string|unique:suppliers,code',
            'contact_name' => 'nullable|string|max:255',
            'supplier_type_id' => 'nullable|integer',
            'parent_location_id' => 'required|integer',
            'multi_location_supplier' => 'nullable|integer',
            'language_id' => 'nullable|integer',
            'parent_supplier_id' => 'nullable|integer',
            'supplier_since' => 'nullable|string|max:255',
            'supplier_port_id' => 'nullable|integer',
            'markup_multiplier' => 'nullable|string',
            'discount' => 'nullable|numeric',
            'primary_phone' => 'nullable|numeric|digits_between:10,15',
            'secondary_phone' => 'nullable|numeric|digits_between:10,15',
            'mobile' => 'nullable|numeric|digits_between:10,15',
            'fax' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'remit_address' => 'nullable|string',
            'remit_suite' => 'nullable|string',
            'remit_city' => 'nullable|string',
            'remit_state' => 'nullable|string',
            'remit_zip' => 'nullable|string',
            'remit_country_id' => 'nullable|integer',
            'ship_address' => 'nullable|string',
            'ship_suite' => 'nullable|string',
            'ship_city' => 'nullable|string',
            'ship_state' => 'nullable|string',
            'ship_zip' => 'nullable|string',
            'ship_country_id' => 'nullable|integer',
            'credit_limit' => 'nullable|string',
            'ein_number' => 'nullable|string',
            'account' => 'nullable|string',
            'currency_id' => 'required|integer',  // Corrected spelling
            'payment_terms_id' => 'required|integer',
            'shipment_terms_id' => 'nullable|integer',
            'purchase_tax_id' => 'nullable|integer',
            'frieght_forwarder_id' => 'nullable|integer',
            'default_payment_method_id' => 'nullable|integer',
            'shipping_instruction' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'allow_access_to_supplier' => 'nullable|integer',
            'supplier_username' => 'nullable|string',
            'supplier_password' => 'nullable|string',
            'form_1099_printed' => 'nullable',
            'status' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'supplier_name.required' => 'The supplier name field is mandatory.',
            'supplier_name.unique' => 'The supplier name must be unique.',
            'print_name.required' => 'The print name field is mandatory.',
            'print_name.unique' => 'The print name must be unique.',
            'code.numeric' => 'The code must be a valid number.',
            'code.unique' => 'The code must be unique.',
            'primary_phone.numeric' => 'The primary phone number must be a valid number.',
            'primary_phone.digits_between' => 'The primary phone number must be between 10 and 15 digits.',
            'secondary_phone.numeric' => 'The secondary phone number must be a valid number.',
            'secondary_phone.digits_between' => 'The secondary phone number must be between 10 and 15 digits.',
            'mobile.numeric' => 'The mobile number must be a valid number.',
            'mobile.digits_between' => 'The mobile number must be between 10 and 15 digits.',
            'currency_id.required' => 'The currency field is required.',
            'currency_id.integer' => 'The currency ID must be a valid integer.',
            'payment_terms_id.required' => 'The payment terms field is required.',
            'payment_terms_id.integer' => 'The payment terms ID must be a valid integer.',
            'email.email' => 'The email address must be valid.',
            'website.url' => 'The website URL must be valid.',
            'remit_country_id.integer' => 'The remit country ID must be a valid integer.',
            'ship_country_id.integer' => 'The ship country ID must be a valid integer.',
            'allow_access_to_supplier.integer' => 'The allow access to supplier field must be a valid integer.',
            // Add more custom messages as needed
        ];
    }
}
