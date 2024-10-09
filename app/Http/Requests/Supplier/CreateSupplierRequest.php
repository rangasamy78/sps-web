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
            'supplier_type_id' => 'nullable|numeric',
            'parent_location_id' => 'required|numeric',
            'multi_location_supplier' => 'nullable|numeric',
            'language_id' => 'nullable|numeric',
            'parent_supplier_id' => 'nullable|numeric',
            'supplier_since' => 'nullable|string|max:255',
            'supplier_port_id' => 'nullable|numeric',
            'markup_multiplier' => 'nullable|string',
            'discount' => 'nullable|numeric',
            'primary_phone' => 'nullable|numeric|digits:10',
            'secondary_phone' =>  'nullable|numeric|digits:10',
            'mobile' => 'nullable|numeric|numeric|digits:10',
            'fax' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'remit_address' => 'nullable|string',
            'remit_suite' => 'nullable|string',
            'remit_city' => 'nullable|string',
            'remit_state' => 'nullable|string',
            'remit_zip' => 'nullable|digits_between:5,10',
            'remit_country_id' => 'nullable|numeric',
            'ship_address' => 'nullable|string',
            'ship_suite' => 'nullable|string',
            'ship_city' => 'nullable|string',
            'ship_state' => 'nullable|string',
            'ship_zip' => 'nullable|digits_between:5,10',
            'ship_country_id' => 'nullable|numeric',
            'credit_limit' => 'nullable|string',
            'ein_number' => 'nullable|string',
            'account' => 'nullable|string',
            'currency_id' => 'required|numeric',  // Corrected spelling
            'payment_terms_id' => 'required|numeric',
            'shipment_terms_id' => 'nullable|numeric',
            'purchase_tax_id' => 'nullable|numeric',
            'frieght_forwarder_id' => 'nullable|numeric',
            'default_payment_method_id' => 'nullable|numeric',
            'shipping_instruction' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'allow_access_to_supplier' => 'nullable|numeric',
            'supplier_username' => 'nullable|string',
            'supplier_password' => 'nullable|string',
            'form_1099_printed' => 'nullable',
            'status' => 'required|numeric',
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
            'currency_id.numeric' => 'The currency ID must be a valid numeric.',
            'payment_terms_id.required' => 'The payment terms field is required.',
            'payment_terms_id.numeric' => 'The payment terms ID must be a valid numeric.',
            'email.email' => 'The email address must be valid.',
            'website.url' => 'The website URL must be valid.',
            'remit_country_id.numeric' => 'The remit country ID must be a valid numeric.',
            'ship_country_id.numeric' => 'The ship country ID must be a valid numeric.',
            'allow_access_to_supplier.numeric' => 'The allow access to supplier field must be a valid numeric.',
            // Add more custom messages as needed
        ];
    }
}
