<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('product')->id;

        return [
            'product_name'                  => 'required|string|max:255|unique:products,product_name,' . $productId,
            'product_sku'                   => 'nullable|unique:products,product_sku,' . $productId,
            'product_kind_id'               => 'required',
            'product_type_id'               => 'required',
            'unit_of_measure_id'            => 'required',
            'gl_inventory_link_account_id'  => 'required',
            'gl_income_account_id'          => 'required',
            'gl_cogs_account_id'            => 'required',
            'homeowner_price'               => 'required|numeric',
            'bundle_price'                  => 'nullable|numeric',
            'special_price'                 => 'nullable|numeric',
            'loose_slab_price'              => 'nullable|numeric',
            'bundle_price_sqft'             => 'nullable|numeric',
            'special_price_per_sqft'        => 'nullable|numeric',
            'owner_approval_price'          => 'nullable|numeric',
            'loose_slab_per_slab'           => 'nullable|numeric',
            'special_price_per_slab'        => 'nullable|numeric',
            'owner_approval_price_per_slab' => 'nullable|numeric',
            'price12'                       => 'nullable|numeric',
            'purchasing_unit_cost'          => 'nullable|numeric',
            'avg_est_cost'                  => 'nullable|numeric',
            'minimum_packing_unit_value'    => 'nullable|numeric',
            'product_weight'                => 'nullable|numeric',
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
            'product_name.required'                 => 'The product name field is required.',
            'product_name.unique'                   => 'The product name must be unique.',
            'product_sku.unique'                    => 'The product SKU must be unique.',
            'product_kind_id.required'              => 'The product kind field is required.',
            'product_type_id.required'              => 'The product type field is required.',
            'unit_of_measure_id.required'           => 'The unit of measure is required.',
            'gl_inventory_link_account_id.required' => 'The GL Inventory Link Account field is required.',
            'gl_income_account_id.required'         => 'The GL Income Account is required.',
            'gl_cogs_account_id.required'           => 'The GL Cost Of Goods Sold Account is required.',
            'homeowner_price.required'              => 'The homeowner price is required.',
            'homeowner_price.numeric'               => 'The homeowner price must be a valid number.',
            'bundle_price.numeric'                  => 'The bundle price must be a valid number.',
            'loose_slab_price.numeric'              => 'The loose slab price must be a valid number.',
            'bundle_price_sqft.numeric'             => 'The bundle price per SQFT must be a valid number.',
            'special_price_per_sqft.numeric'        => 'The special price per SQFT must be a valid number.',
            'owner_approval_price.numeric'          => 'The owner approval price must be a valid number.',
            'loose_slab_per_slab.numeric'           => 'The loose slab price per slab must be a valid number.',
            'special_price_per_slab.numeric'        => 'The special price per slab must be a valid number.',
            'owner_approval_price_per_slab.numeric' => 'The owner approval price per slab must be a valid number.',
            'price12.numeric'                       => 'The price 12 must be a valid number.',
            'purchasing_unit_cost.numeric'          => 'The purchasing unit cost value must be a valid number.',
            'avg_est_cost.numeric'                  => 'The avg est cost must be a valid number.',
            'minimum_packing_unit_value.numeric'    => 'The minimum packing unit value be a valid number.',
            'product_weight.numeric'                => 'The Product Weight must be a valid number.',
        ];
    }
}
