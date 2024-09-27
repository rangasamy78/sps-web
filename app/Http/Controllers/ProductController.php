<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;

use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductColor;
use App\Models\Country;
use App\Models\UnitMeasure;
use App\Models\ProductGroup;
use App\Models\ProductFinish;
use App\Models\ProductCategory;
use App\Models\ProductThickness;
use App\Models\ProductPriceRange;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\Request;use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        return view('product.products');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateProductRequest $request)
    {
        try {
        $data = [
            'productData' => $request->only(
                'product_name', 'product_sku','product_kind_id', 'product_alternate_name', 'product_type_id',
                'product_base_color_id', 'product_origin_id', 'product_category_id', 'product_sub_category_id',
                'product_group_id', 'product_thickness_id', 'product_finish_id', 'product_series_name',
                'unit_of_measure_id', 'product_weight', 'product_size', 'indivisible', 'manufactured', 'generic',
                'select_slab', 'gl_inventory_link_account_id', 'gl_income_account_id', 'gl_cogs_account_id',
                'safety_stock', 'safety_stock_value', 'reorder_qty', 'reorder_qty_value', 'lead_time', 'assign_bin_id',
                'preferred_supplier_id', 'brand_or_manufacturer_id', 'generic_name', 'generic_sku', 'purchasing_unit_id',
                'purchasing_unit_cost', 'avg_est_cost', 'new_product_flag', 'guest_book', 'is_featured',
                'web_user_name', 'description_on_web', 'notes', 'special_intstruction', 'disclaimer',
                'uom_one_id', 'uom_one_value', 'uom_two_id', 'uom_two_value', 'uom_three_id', 'uom_three_value',
                'uom_four_id', 'uom_four_value', 'uom_five_id', 'uom_five_value', 'uom_six_id', 'uom_six_value',
                'minimum_packing_unit_id', 'minimum_packing_unit_value'
            ),
            'priceData' => $request->only(
                'homeowner_price', 'bundle_price', 'special_price', 'loose_slab_price', 'bundle_price_sqft',
                'special_price_per_sqft', 'owner_approval_price', 'loose_slab_per_slab', 'special_price_per_slab',
                'owner_approval_price_per_slab', 'price12', 'price_range'
            )
            ];
          
            $this->productRepository->store($data);
    
            return response()->json(['status' => 'success', 'msg' => 'Product saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the product.']);
        }
    }
    

    public function create()
    {
       
        $product_type        = ProductType::query()->get();
        $product_color        = ProductColor::query()->get();
        $country = Country::query()->get();
        $product_category        = ProductCategory::query()->get();
        $country = Country::query()->get();
        $product_group= ProductGroup::all(); 
        $product_thickness= ProductThickness::all();
        $product_finish= ProductFinish::all();
        $unit_measure= UnitMeasure::all();
        $product_price_range= ProductPriceRange::all();
        return view('product.__create', compact('product_type', 'product_color', 'product_category', 'country', 'product_group','product_thickness','product_finish','unit_measure','product_price_range'));


    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->productRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->productRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->productRepository->update($request->only('product_name'), $product->id);
            return response()->json(['status' => 'success', 'msg' => 'Product updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = $this->productRepository->findOrFail($id);
            if ($product) {
                $this->productRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Product deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product.']);
        }
    }
    public function getProductDataTableList(Request $request)
    {
        return $this->productRepository->dataTable($request);
    }
}
