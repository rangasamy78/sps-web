<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\FileProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductFinish;
use App\Models\ProductGroup;
use App\Models\ProductKind;
use App\Models\ProductPriceRange;
use App\Models\ProductSubCategory;
use App\Models\ProductThickness;
use App\Models\ProductType;
use App\Models\Supplier;
use App\Models\UnitMeasure;
use App\Repositories\DropDownRepository;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\Request;use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository, DropDownRepository $dropDownRepository)
    {
        $this->dropDownRepository = $dropDownRepository;
        $this->productRepository  = $productRepository;
    }

    public function index()
    {

        $linkedAccountRecords = $this->dropDownRepository->dropDownPopulate('linked_account_inventory_gl');
        $inventories          = $linkedAccountRecords->where('type', '=', 'Inventory');
        $sales                = $linkedAccountRecords->where('type', '=', 'Sales');
        $cogs                 = $linkedAccountRecords->where('type', '=', 'Cogs');
        $supplier             = Supplier::query()->get();
        $product_kind         = ProductKind::query()->get();
        $product_type         = ProductType::query()->get();
        $product_color        = ProductColor::query()->get();
        $country              = Country::query()->get();
        $product_category     = ProductCategory::query()->get();
        $country              = Country::query()->get();
        $product_group        = ProductGroup::all();
        $product_thickness    = ProductThickness::all();
        $product_finish       = ProductFinish::all();
        $unit_measure         = UnitMeasure::all();
        $product_price_range  = ProductPriceRange::all();
        return view('product.products', compact('product_kind', 'product_type', 'product_color', 'product_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range', 'inventories', 'sales', 'cogs', 'supplier'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateProductRequest $request)
    {

        try {

            $productData = $request->only([
                'product_name', 'product_sku', 'product_kind_id', 'product_alternate_name',
                'product_type_id', 'product_base_color_id', 'product_origin_id', 'product_category_id',
                'product_sub_category_id', 'product_group_id', 'product_thickness_id', 'product_finish_id',
                'product_series_name', 'unit_of_measure_id', 'product_weight', 'product_size',
                'gl_inventory_link_account_id', 'gl_income_account_id', 'gl_cogs_account_id', 'safety_stock',
                'safety_stock_value', 'reorder_qty', 'reorder_qty_value', 'lead_time', 'assign_bin_id',
                'preferred_supplier_id', 'brand_or_manufacturer_id', 'generic_name', 'generic_sku',
                'purchasing_unit_id', 'purchasing_unit_cost', 'avg_est_cost', 'new_product_flag',
                'hide_on_website_or_guest_book', 'is_featured', 'web_user_name', 'description_on_web',
                'notes', 'special_intstruction', 'disclaimer', 'uom_one_id', 'uom_one_value', 'uom_two_id',
                'uom_two_value', 'uom_three_id', 'uom_three_value', 'uom_four_id', 'uom_four_value',
                'uom_five_id', 'uom_five_value', 'uom_six_id', 'uom_six_value', 'minimum_packing_unit_id',
                'minimum_packing_unit_value',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                $imagePath = $image->store('storage/app/public/', 'public');

            }

            if ($imagePath) {
                $productData['image'] = $imagePath;
            }

            $productData['indivisible']                   = $request->has('indivisible') ? 1 : 0;
            $productData['manufactured']                  = $request->has('manufactured') ? 1 : 0;
            $productData['generic']                       = $request->has('generic') ? 1 : 0;
            $productData['select_slab']                   = $request->has('select_slab') ? 1 : 0;
            $productData['new_product_flag']              = $request->has('new_product_flag') ? 1 : 0;
            $productData['hide_on_website_or_guest_book'] = $request->has('hide_on_website_or_guest_book') ? 1 : 0;
            $productData['is_featured']                   = $request->has('is_featured') ? 1 : 0;

            $priceData = $request->only([
                'homeowner_price', 'bundle_price', 'special_price', 'loose_slab_price', 'bundle_price_sqft',
                'special_price_per_sqft', 'owner_approval_price', 'loose_slab_per_slab', 'bundle_price_per_slab',
                'special_price_per_slab', 'owner_approval_price_per_slab', 'price12', 'price_range_id',
            ]);

            $data = [
                'productData' => $productData,
                'priceData'   => $priceData,
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
        $linkedAccountRecords = $this->dropDownRepository->dropDownPopulate('linked_account_inventory_gl');
        $inventories          = $linkedAccountRecords->where('type', '=', 'Inventory');
        $sales                = $linkedAccountRecords->where('type', '=', 'Sales');
        $cogs                 = $linkedAccountRecords->where('type', '=', 'Cogs');
        $supplier             = Supplier::query()->get();
        $product_kind         = ProductKind::query()->get();
        $product_type         = ProductType::query()->get();
        $product_color        = ProductColor::query()->get();
        $country              = Country::query()->get();
        $product_category     = ProductCategory::query()->get();
        $country              = Country::query()->get();
        $product_group        = ProductGroup::all();
        $product_thickness    = ProductThickness::all();
        $product_finish       = ProductFinish::all();
        $unit_measure         = UnitMeasure::all();
        $product_price_range  = ProductPriceRange::all();
        return view('product.__create', compact('product_type', 'product_kind', 'product_color', 'product_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range', 'inventories', 'sales', 'cogs', 'supplier'));

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $linkedAccountRecords = $this->dropDownRepository->dropDownPopulate('linked_account_inventory_gl');
        $inventories          = $linkedAccountRecords->where('type', '=', 'Inventory');
        $sales                = $linkedAccountRecords->where('type', '=', 'Sales');
        $cogs                 = $linkedAccountRecords->where('type', '=', 'Cogs');
        $supplier             = Supplier::query()->get();
        $product_kind         = ProductKind::query()->get();
        $product              = Product::with('product_price')->findOrFail($id);
        $product_type         = ProductType::query()->get();
        $product_color        = ProductColor::query()->get();
        $country              = Country::query()->get();
        $product_category     = ProductCategory::query()->get();
        $product_sub_category = ProductSubCategory::query()->get();
        $country              = Country::query()->get();
        $product_group        = ProductGroup::all();
        $product_thickness    = ProductThickness::all();
        $product_finish       = ProductFinish::all();
        $unit_measure         = UnitMeasure::all();
        $product_price_range  = ProductPriceRange::all();
        return view('product.__show', compact('product', 'product_kind', 'product_type', 'product_color', 'product_category', 'product_sub_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range', 'inventories', 'sales', 'cogs', 'supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $supplier             = Supplier::query()->get();
        $linkedAccountRecords = $this->dropDownRepository->dropDownPopulate('linked_account_inventory_gl');
        $inventories          = $linkedAccountRecords->where('type', '=', 'Inventory');
        $sales                = $linkedAccountRecords->where('type', '=', 'Sales');
        $cogs                 = $linkedAccountRecords->where('type', '=', 'Cogs');
        $product              = Product::with('product_price')->findOrFail($id);
        $product_kind         = ProductKind::query()->get();
        $product_type         = ProductType::query()->get();
        $product_color        = ProductColor::query()->get();
        $country              = Country::query()->get();
        $product_category     = ProductCategory::query()->get();
        $product_sub_category = ProductSubCategory::query()->get();
        $country              = Country::query()->get();
        $product_group        = ProductGroup::all();
        $product_thickness    = ProductThickness::all();
        $product_finish       = ProductFinish::all();
        $unit_measure         = UnitMeasure::all();
        $product_price_range  = ProductPriceRange::all();
        return view('product.__edit', compact('product', 'product_kind', 'product_type', 'product_color', 'product_category', 'product_sub_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range', 'inventories', 'sales', 'cogs', 'supplier'));

    }

    public function productPriceUpdate($id)
    {
        $product              = Product::with('product_price')->findOrFail($id);
        $product_type         = ProductType::query()->get();
        $product_color        = ProductColor::query()->get();
        $country              = Country::query()->get();
        $product_category     = ProductCategory::query()->get();
        $product_sub_category = ProductSubCategory::query()->get();
        $country              = Country::query()->get();
        $product_group        = ProductGroup::all();
        $product_thickness    = ProductThickness::all();
        $product_finish       = ProductFinish::all();
        $unit_measure         = UnitMeasure::all();
        $product_price_range  = ProductPriceRange::all();
        return view('product.__price_update', compact('product', 'product_type', 'product_color', 'product_category', 'product_sub_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range'));

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
            // Get the product data and price data from the request
            $data = [
                'productData' => $request->only(
                    'product_name', 'product_sku', 'product_kind_id', 'product_alternate_name', 'product_type_id',
                    'product_base_color_id', 'product_origin_id', 'product_category_id', 'product_sub_category_id',
                    'product_group_id', 'product_thickness_id', 'product_finish_id', 'product_series_name',
                    'unit_of_measure_id', 'product_weight', 'product_size',
                    'indivisible', 'manufactured', 'generic', 'select_slab',
                    'gl_inventory_link_account_id', 'gl_income_account_id', 'gl_cogs_account_id',
                    'safety_stock', 'safety_stock_value', 'reorder_qty',
                    'reorder_qty_value', 'lead_time', 'assign_bin_id',
                    'preferred_supplier_id', 'brand_or_manufacturer_id',
                    'generic_name', 'generic_sku', 'purchasing_unit_id',
                    'purchasing_unit_cost', 'avg_est_cost', 'new_product_flag',
                    'hide_on_website_or_guest_book', 'is_featured', 'web_user_name', 'description_on_web',
                    'notes', 'special_intstruction', 'disclaimer',
                    'uom_one_id', 'uom_one_value', 'uom_two_id', 'uom_two_value',
                    'uom_three_id', 'uom_three_value', 'uom_four_id', 'uom_four_value',
                    'uom_five_id', 'uom_five_value', 'uom_six_id', 'uom_six_value',
                    'minimum_packing_unit_id', 'minimum_packing_unit_value'
                ),
                'priceData'   => $request->only(
                    'homeowner_price', 'bundle_price', 'special_price', 'loose_slab_price',
                    'bundle_price_sqft', 'special_price_per_sqft', 'owner_approval_price',
                    'loose_slab_per_slab', 'bundle_price_per_slab', 'special_price_per_slab', 'owner_approval_price_per_slab',
                    'price12', 'price_range_id'
                ),
            ];

            // Update boolean flags
            $data['productData']['indivisible']  = $request->has('indivisible') ? 1 : 0;
            $data['productData']['manufactured'] = $request->has('manufactured') ? 1 : 0;
            $data['productData']['generic']      = $request->has('generic') ? 1 : 0;
            $data['productData']['select_slab']  = $request->has('select_slab') ? 1 : 0;

            $data['productData']['new_product_flag']              = $request->has('new_product_flag') ? 1 : 0;
            $data['productData']['hide_on_website_or_guest_book'] = $request->has('hide_on_website_or_guest_book') ? 1 : 0;
            $data['productData']['is_featured']                   = $request->has('is_featured') ? 1 : 0;

            // Handle the image upload if a file is present
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image     = $request->file('image');
                $imagePath = $image->store('storage/app/public/', 'public'); // Save the image in the 'public' disk
            }

            // If an image was uploaded, add its path to the product data
            if ($imagePath) {
                $data['productData']['image'] = $imagePath;
            }

            // Update the product using the repository
            $this->productRepository->update($data, $product->id);

            // Return success response
            return response()->json(['status' => 'success', 'msg' => 'Product updated successfully.']);
        } catch (Exception $e) {
            // Log the error and return a failure response
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
                if ($product->status == 0) {
                    return response()->json(['status' => 'false', 'msg' => 'Product is already inactive.']);
                }
                $product->status = 0;
                $product->save();

                return response()->json(['status' => 'success', 'msg' => 'Product marked as inactive.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error updating product status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product status.']);
        }
    }
    public function productChangeStatus($id)
    {
        try {
            $product         = $this->productRepository->findOrFail($id);
            $newStatus       = $product->status == 1 ? 0 : 1;
            $product->status = $newStatus;
            $product->save();

            return response()->json([
                'status'     => 'success',
                'new_status' => $newStatus,
                'msg'        => 'Status updated successfully.',
            ]);
        } catch (Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'msg'    => 'Failed to update status.',
            ], 500);
        }
    }

    public function getSubCategory($id)
    {
        try {
            $subcategories = $this->productRepository->getSubCategories($id);
            return response()->json([
                'status'        => 'success',
                'subcategories' => $subcategories,
            ]);

        } catch (\Exception $e) {

            Log::error('Error in controller fetching subcategories: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'msg'    => 'An error occurred while processing your request.',
            ], 500);
        }
    }
    public function getProductDataTableList(Request $request)
    {
        return $this->productRepository->dataTable($request);
    }
    public function getProductStockDataTableList(Request $request)
    {
        return $this->productRepository->dataStockTable($request);
    }
    public function getProductpriceListDataTableList(Request $request)
    {
        return $this->productRepository->dataPriceListTable($request);
    }
    public function getcustomerProductpriceListDataTableList(Request $request)
    {
        return $this->productRepository->dataCustomerPriceListTable($request);
    }

    public function stockProduct()
    {
        $product_type        = ProductType::query()->get();
        $product_color       = ProductColor::query()->get();
        $country             = Country::query()->get();
        $product_category    = ProductCategory::query()->get();
        $country             = Country::query()->get();
        $product_group       = ProductGroup::all();
        $product_thickness   = ProductThickness::all();
        $product_finish      = ProductFinish::all();
        $unit_measure        = UnitMeasure::all();
        $product_price_range = ProductPriceRange::all();
        return view('product.stock', compact('product_type', 'product_color', 'product_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range'));
    }

    public function priceListProduct()
    {
        $product_type        = ProductType::query()->get();
        $product_color       = ProductColor::query()->get();
        $country             = Country::query()->get();
        $product_category    = ProductCategory::query()->get();
        $country             = Country::query()->get();
        $product_group       = ProductGroup::all();
        $product_thickness   = ProductThickness::all();
        $product_finish      = ProductFinish::all();
        $unit_measure        = UnitMeasure::all();
        $product_price_range = ProductPriceRange::all();
        return view('product.price_list', compact('product_type', 'product_color', 'product_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range'));
    }

    public function customerpriceListProduct()
    {
        $product_type        = ProductType::query()->get();
        $product_color       = ProductColor::query()->get();
        $country             = Country::query()->get();
        $product_category    = ProductCategory::query()->get();
        $country             = Country::query()->get();
        $product_group       = ProductGroup::all();
        $product_thickness   = ProductThickness::all();
        $product_finish      = ProductFinish::all();
        $unit_measure        = UnitMeasure::all();
        $product_price_range = ProductPriceRange::all();
        return view('product.customer_price_list', compact('product_type', 'product_color', 'product_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range'));
    }

    public function productSearch()
    {
        $products            = Product::query()->get();
        $product_type        = ProductType::query()->get();
        $product_color       = ProductColor::query()->get();
        $country             = Country::query()->get();
        $product_category    = ProductCategory::query()->get();
        $country             = Country::query()->get();
        $product_group       = ProductGroup::all();
        $product_thickness   = ProductThickness::all();
        $product_finish      = ProductFinish::all();
        $unit_measure        = UnitMeasure::all();
        $product_price_range = ProductPriceRange::all();
        return view('product.product_search', compact('products', 'product_type', 'product_color', 'product_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range'));
    }
    public function getProductImages(Request $request)
    {
        $query = Product::select('id', 'image')->paginate(10); // Customize the select as per your need
        // dd($query);
        return response()->json([
            'data'            => $query->items(), // Get the current page items
            'recordsTotal' => $query->total(),
            'recordsFiltered' => $query->total(),
        ]);
    }

    public function productWebsite($id)
    {

        $product_id          = $id;
        $product_type        = ProductType::query()->get();
        $product_color       = ProductColor::query()->get();
        $country             = Country::query()->get();
        $product_category    = ProductCategory::query()->get();
        $country             = Country::query()->get();
        $product_group       = ProductGroup::all();
        $product_thickness   = ProductThickness::all();
        $product_finish      = ProductFinish::all();
        $unit_measure        = UnitMeasure::all();
        $product_price_range = ProductPriceRange::all();
        return view('product.__website', compact('product_id', 'product_type', 'product_color', 'product_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range'));

    }
    public function productWebsiteUpdate(Request $request)
    {

        try {

            $this->productRepository->updateProductWebData($request->all(), $request->product_id);
            return response()->json(['status' => 'success', 'msg' => 'Product web data updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating product web data: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the product web data.']);
        }
    }
    public function productImage($id)
    {

        $product_id          = $id;
        $product_type        = ProductType::query()->get();
        $product_color       = ProductColor::query()->get();
        $country             = Country::query()->get();
        $product_category    = ProductCategory::query()->get();
        $country             = Country::query()->get();
        $product_group       = ProductGroup::all();
        $product_thickness   = ProductThickness::all();
        $product_finish      = ProductFinish::all();
        $unit_measure        = UnitMeasure::all();
        $product_price_range = ProductPriceRange::all();
        return view('product.__product_image', compact('product_id', 'product_type', 'product_color', 'product_category', 'country', 'product_group', 'product_thickness', 'product_finish', 'unit_measure', 'product_price_range'));

    }
    public function uploadFiles(FileProductRequest $request)
    {

        $productId     = $request->product_id;
        $uploadedFiles = $request->file('file');

        $filePaths = [];
        foreach ($uploadedFiles as $file) {
            $filePath    = $file->store('product_images', 'public');
            $filePaths[] = $filePath;
            $this->productRepository->saveProductImage($productId, $filePath);
        }

        return response()->json(['message' => 'Files uploaded successfully!', 'files' => $filePaths]);
    }

}
