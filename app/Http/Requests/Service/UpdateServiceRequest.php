<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'service_name' => 'required',
            'service_sku'  => 'nullable',
            'unit_of_measure_id' => 'required',
            'gl_sales_account_id' => 'required',
            'gl_cost_of_sales_account_id' => 'required',
            'homeowner_price' => 'required|numeric',
            'bundle_price' => 'nullable|numeric',
            'special_price' => 'nullable|numeric',
            'loose_slab_price' => 'nullable|numeric',
            'bundle_price_sqft' => 'nullable|numeric',
            'special_price_per_sqft' => 'nullable|numeric',
            'owner_approval_price' => 'nullable|numeric',
            'loose_slab_per_slab' => 'nullable|numeric',
            'special_price_per_slab' => 'nullable|numeric',
            'owner_approval_price_per_slab' => 'nullable|numeric',
            'price12' => 'nullable|numeric',
            'purchasing_unit_cost' => 'nullable|numeric',
            'avg_est_cost' => 'nullable|numeric'
        ];
    }



    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'service_name.required' => 'The service name field is required.',
            'service_name.unique'   => 'The service name must be unique.',
            'service_sku.unique'    => 'The service SKU must be unique.',
            'unit_of_measure_id.required' => 'The unit of measure is required.',
            'gl_sales_account_id.required' => 'The GL Sales Account field is required.',
            'gl_cost_of_sales_account_id.required' => 'The GL Cost of Sales Account is required.',
            'homeowner_price.required' => 'The homeowner price is required.',
            'homeowner_price.numeric'  => 'The homeowner price must be a valid number.',
            'bundle_price.numeric'  => 'The bundle price must be a valid number.',
            'loose_slab_price.numeric'  => 'The loose slab price must be a valid number.',
            'bundle_price_sqft.numeric'  => 'The bundle price per SQFT must be a valid number.',
            'special_price_per_sqft.numeric'  => 'The special price per SQFT must be a valid number.',
            'owner_approval_price.numeric'  => 'The owner approval price must be a valid number.',
            'loose_slab_per_slab.numeric'  => 'The loose slab price per slab must be a valid number.',
            'special_price_per_slab.numeric'  => 'The special price per slab must be a valid number.',
            'owner_approval_price_per_slab.numeric'  => 'The owner approval price per slab must be a valid number.',
            'price12.numeric'  => 'The price 12 must be a valid number.',
            'purchasing_unit_cost.numeric'  => 'The purchasing unit cost value must be a valid number.',
            'avg_est_cost.numeric'  => 'The avg est cost must be a valid number.',
        ];
    }
}
