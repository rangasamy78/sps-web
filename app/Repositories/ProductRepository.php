<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\Product;
use App\Models\ProductKind;
use App\Models\ProductPrice;
use App\Models\ProductSubCategory;
use App\Models\ProductWebsite;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return Product::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $productData = $data['productData'];
        $priceData   = $data['priceData'];

        $product = Product::create($productData);

        $priceData['product_id'] = $product->id;
        ProductPrice::create($priceData);

        return $product;
    }

    public function update(array $data, int $id)
    {
        try {

            \DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->update($data['productData']);
            $priceData = $data['priceData'];
            $price     = $product->price;

            if ($price) {

                $price->update($priceData);
            } else {
                $priceData['product_id'] = $product->id;
                ProductPrice::create($priceData);
            }

            \DB::commit();

            return $product;
        } catch (\Exception $e) {

            \DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }
    public function getSubCategories($typeId)
    {
        try {
            $selectTypeSubCategory = ProductSubCategory::where('product_category_id', $typeId)->get();

            return $selectTypeSubCategory;

        } catch (\Exception $e) {
            Log::error('Error fetching subcategories in repository: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getProductList($request)
    {

        $query = Product::with('product_type', 'product_category', 'product_sub_category', 'product_group', 'country', 'product_price');

        if (!empty($request->price_range_search)) {
            $query->whereHas('product_price', function ($q) use ($request) {
                $q->whereIn('price_range_id', (array)$request->price_range_search);
            });
        }

        $products = $query->get();

        if (!empty($request->product_name_search) || !empty($request->product_sku_search)) {
            $query->where(function ($q) use ($request) {
                if (!empty($request->product_name_search)) {
                    $q->where('product_name', 'like', '%' . $request->product_name_search . '%');
                }
                if (!empty($request->product_name_search)) {
                    $q->orWhere('product_sku', 'like', '%' . $request->product_name_search . '%');
                }
            });
        }

        if (!empty($request->product_type_search)) {
            $query->whereIn('product_type_id', (array)$request->product_type_search);
        }

        if (!empty($request->product_category_search)) {
            $query->whereIn('product_category_id', (array)$request->product_category_search);
        }

        if (!empty($request->product_sub_category_search)) {
            $query->whereIn('product_sub_category_id', (array)$request->product_sub_category_search);
        }

        if (!empty($request->product_group_search)) {
            $query->whereIn('product_group_id', (array)$request->product_group_search);
        }

        if (!empty($request->product_thickness_search)) {
            $query->whereIn('product_thickness_id', (array)$request->product_thickness_search);
        }

        if (!empty($request->price_origin_search)) {
            $query->whereIn('product_origin_id', (array)$request->price_origin_search);
        }

        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName = 'created_at';
        $product    = $this->getProductList($request);
        $total      = $product->count();

        $totalFilter = $this->getProductList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getProductList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                     = ++$i;
            $value->product_name            = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_name ?? '') . "</a>";
            $value->product_sku             = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_sku ?? '') . "</a>";
            $value->product_kind_id         = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_kind->product_kind_name ?? '') . "</a>";
            $value->product_type_id         = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_type->product_type ?? '') . "</a>";
            $value->product_category_id     = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_category->product_category_name ?? '') . "</a>";
            $value->product_sub_category_id = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_sub_category->product_sub_category_name ?? '') . "</a>";
            $value->product_group_id        = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_group->product_group_name ?? '') . "</a>";
            $value->product_origin_id       = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->country->country_name ?? '') . "</a>";
            $value->preferred_supplier_id   = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->preferred_supplier_id ?? '') . "</a>";
            $value->status                  = $value->status == 1
            ? '<button class="btn btn-success btn-sm change_status" data-id="' . $value->id . '">Active</button>'
            : '<button class="btn btn-danger btn-sm change_status" data-id="' . $value->id . '">Inactive</button>';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow'
             data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'>
             <a class='dropdown-item showbtn text-warning' href='" . route('products.show', $value->id) . "' data-id='" . $value->id . "'><i class='bx bx-show me-1 icon-warning'></i> Show</a>
             <a class='dropdown-item editbtn text-success' href='" . route('products.edit', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
             <a class='dropdown-item webbtn text-dark' href='" . route('products.product_website', $value->id) . "' data-id='" . $value->id . "' ><i <i class='bx bx-info-circle'></i></i> Website </a>
             <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function getstockProductList($request)
    {

        $query = Product::with('product_type', 'product_category', 'product_sub_category', 'product_group', 'country', 'product_price', 'product_kind');

        if (!empty($request->price_range_search)) {
            $query->whereHas('product_price', function ($q) use ($request) {
                $q->whereIn('price_range_id', (array)$request->price_range_search);
            });
        }
        $productKindId = ProductKind::query()->where('product_kind_name', 'Stock')->first();

        if ($productKindId) {
            $products = $query->where('product_kind_id', $productKindId->id)->get();
        } else {
            $products = $query->get();
        }

        if (!empty($request->product_name_search) || !empty($request->product_sku_search)) {
            $query->where(function ($q) use ($request) {
                if (!empty($request->product_name_search)) {
                    $q->where('product_name', 'like', '%' . $request->product_name_search . '%');
                }
                if (!empty($request->product_name_search)) {
                    $q->orWhere('product_sku', 'like', '%' . $request->product_name_search . '%');
                }
            });
        }

        if (!empty($request->product_type_search)) {
            $query->whereIn('product_type_id', (array)$request->product_type_search);
        }

        if (!empty($request->product_category_search)) {
            $query->whereIn('product_category_id', (array)$request->product_category_search);
        }

        if (!empty($request->product_sub_category_search)) {
            $query->whereIn('product_sub_category_id', (array)$request->product_sub_category_search);
        }

        if (!empty($request->product_group_search)) {
            $query->whereIn('product_group_id', (array)$request->product_group_search);
        }

        if (!empty($request->product_thickness_search)) {
            $query->whereIn('product_thickness_id', (array)$request->product_thickness_search);
        }

        if (!empty($request->price_origin_search)) {
            $query->whereIn('product_origin_id', (array)$request->price_origin_search);
        }

        return $query;
    }
    public function dataStockTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName = 'created_at';
        $product    = $this->getstockProductList($request);
        $total      = $product->count();

        $totalFilter = $this->getstockProductList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getstockProductList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                     = ++$i;
            $value->product_name            = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_name ?? '') . "</a>";
            $value->product_sku             = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_sku ?? '') . "</a>";
            $value->product_kind_id         = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_kind->product_kind_name ?? '') . "</a>";
            $value->product_type_id         = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_type->product_type ?? '') . "</a>";
            $value->product_category_id     = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_category->product_category_name ?? '') . "</a>";
            $value->product_sub_category_id = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_sub_category->product_sub_category_name ?? '') . "</a>";
            $value->product_group_id        = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_group->product_group_name ?? '') . "</a>";
            $value->product_origin_id       = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->country->country_name ?? '') . "</a>";
            $value->preferred_supplier_id   = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->preferred_supplier_id ?? '') . "</a>";
            $value->status                  = $value->status == 1
            ? '<button class="btn btn-success btn-sm change_status" data-id="' . $value->id . '">Active</button>'
            : '<button class="btn btn-danger btn-sm change_status" data-id="' . $value->id . '">Inactive</button>';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow'
             data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'>
             <a class='dropdown-item showbtn text-warning' href='" . route('products.show', $value->id) . "' data-id='" . $value->id . "'><i class='bx bx-show me-1 icon-warning'></i> Show</a>
             <a class='dropdown-item editbtn text-success' href='" . route('products.edit', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
             <a class='dropdown-item webbtn text-dark' href='" . route('products.product_website', $value->id) . "' data-id='" . $value->id . "' ><i <i class='bx bx-info-circle'></i></i> Website </a>
             <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function getPriceListProductList($request)
    {

        $query = Product::with('product_type', 'product_category', 'product_sub_category', 'product_group', 'country', 'product_price', 'product_kind');

        if (!empty($request->price_range_search)) {
            $query->whereHas('product_price', function ($q) use ($request) {
                $q->whereIn('price_range_id', (array)$request->price_range_search);
            });
        }

        $productKindId = ProductKind::query()->where('product_kind_name', 'Stock')->first();

        if ($productKindId) {
            $products = $query->where('product_kind_id', $productKindId->id)->get();
        } else {
            $products = $query->get();
        }

        if (!empty($request->product_name_search) || !empty($request->product_sku_search)) {
            $query->where(function ($q) use ($request) {
                if (!empty($request->product_name_search)) {
                    $q->where('product_name', 'like', '%' . $request->product_name_search . '%');
                }
                if (!empty($request->product_name_search)) {
                    $q->orWhere('product_sku', 'like', '%' . $request->product_name_search . '%');
                }
            });
        }

        if (!empty($request->product_type_search)) {
            $query->whereIn('product_type_id', (array)$request->product_type_search);
        }

        if (!empty($request->product_category_search)) {
            $query->whereIn('product_category_id', (array)$request->product_category_search);
        }

        if (!empty($request->product_sub_category_search)) {
            $query->whereIn('product_sub_category_id', (array)$request->product_sub_category_search);
        }

        if (!empty($request->product_group_search)) {
            $query->whereIn('product_group_id', (array)$request->product_group_search);
        }

        if (!empty($request->product_thickness_search)) {
            $query->whereIn('product_thickness_id', (array)$request->product_thickness_search);
        }

        if (!empty($request->price_origin_search)) {
            $query->whereIn('product_origin_id', (array)$request->price_origin_search);
        }

        return $query;
    }

    public function dataPriceListTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName = 'created_at';
        $product    = $this->getPriceListProductList($request);
        $total      = $product->count();

        $totalFilter = $this->getPriceListProductList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPriceListProductList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                           = ++$i;
            $value->product_name                  = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_name ?? '') . "</a>";
            $value->product_sku                   = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_sku ?? '') . "</a>";
            $value->product_kind_id               = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_kind->product_kind_name ?? '') . "</a>";
            $value->product_type_id               = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_type->product_type ?? '') . "</a>";
            $value->product_category_id           = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_category->product_category_name ?? '') . "</a>";
            $value->product_sub_category_id       = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_sub_category->product_sub_category_name ?? '') . "</a>";
            $value->product_group_id              = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_group->product_group_name ?? '') . "</a>";
            $value->product_origin_id             = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_origin_id ?? '') . "</a>";
            $value->preferred_supplier_id         = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->preferred_supplier_id ?? '') . "</a>";
            $value->homeowner_price               = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->homeowner_price ?? '') . "</a>";
            $value->bundle_price                  = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->bundle_price ?? '') . "</a>";
            $value->special_price                 = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->special_price ?? '') . "</a>";
            $value->loose_slab_price              = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->loose_slab_price ?? '') . "</a>";
            $value->bundle_price_sqft             = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->bundle_price_sqft ?? '') . "</a>";
            $value->special_price_per_sqft        = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->special_price_per_sqft ?? '') . "</a>";
            $value->owner_approval_price          = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->owner_approval_price ?? '') . "</a>";
            $value->loose_slab_per_slab           = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->loose_slab_per_slab ?? '') . "</a>";
            $value->bundle_price_per_slab         = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->bundle_price_per_slab ?? '') . "</a>";
            $value->special_price_per_slab        = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->special_price_per_slab ?? '') . "</a>";
            $value->owner_approval_price_per_slab = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->owner_approval_price_per_slab ?? '') . "</a>";
            $value->price12                       = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_price->price12 ?? '') . "</a>";
            $value->status                        = $value->status == 1
            ? '<button class="btn btn-success btn-sm change_status" data-id="' . $value->id . '">Active</button>'
            : '<button class="btn btn-danger btn-sm change_status" data-id="' . $value->id . '">Inactive</button>';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow'
             data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'>
             <a class='dropdown-item showbtn text-warning' href='" . route('products.show', $value->id) . "' data-id='" . $value->id . "'><i class='bx bx-show me-1 icon-warning'></i> Show</a>
             <a class='dropdown-item editbtn text-success' href='" . route('products.edit', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
             <a class='dropdown-item webbtn text-dark' href='" . route('products.product_website', $value->id) . "' data-id='" . $value->id . "' ><i <i class='bx bx-info-circle'></i></i> Website </a>
             <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";

        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }
    public function getcustomerPriceListProductList($request)
    {

        $query = Product::with('product_type', 'product_category', 'product_sub_category', 'product_group', 'country', 'product_price', 'product_kind')->where('id', 0);

        if (!empty($request->price_range_search)) {
            $query->whereHas('product_price', function ($q) use ($request) {
                $q->whereIn('price_range_id', (array)$request->price_range_search);
            });
        }

        $productKindId = ProductKind::query()->where('product_kind_name', 'Stock')->first();

        if ($productKindId) {
            $products = $query->where('product_kind_id', $productKindId->id)->get();
        } else {
            $products = $query->get();
        }

        if (!empty($request->product_name_search) || !empty($request->product_sku_search)) {
            $query->where(function ($q) use ($request) {
                if (!empty($request->product_name_search)) {
                    $q->where('product_name', 'like', '%' . $request->product_name_search . '%');
                }
                if (!empty($request->product_name_search)) {
                    $q->orWhere('product_sku', 'like', '%' . $request->product_name_search . '%');
                }
            });
        }

        if (!empty($request->product_type_search)) {
            $query->whereIn('product_type_id', (array)$request->product_type_search);
        }

        if (!empty($request->product_category_search)) {
            $query->whereIn('product_category_id', (array)$request->product_category_search);
        }

        if (!empty($request->product_sub_category_search)) {
            $query->whereIn('product_sub_category_id', (array)$request->product_sub_category_search);
        }

        if (!empty($request->product_group_search)) {
            $query->whereIn('product_group_id', (array)$request->product_group_search);
        }

        if (!empty($request->product_thickness_search)) {
            $query->whereIn('product_thickness_id', (array)$request->product_thickness_search);
        }

        if (!empty($request->price_origin_search)) {
            $query->whereIn('product_origin_id', (array)$request->price_origin_search);
        }

        return $query;
    }

    public function dataCustomerPriceListTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName = 'created_at';
        $product    = $this->getcustomerPriceListProductList($request);
        $total      = $product->count();

        $totalFilter = $this->getcustomerPriceListProductList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getcustomerPriceListProductList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                     = ++$i;
            $value->product_name            = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_name ?? '') . "</a>";
            $value->product_sku             = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_sku ?? '') . "</a>";
            $value->product_kind_id         = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_kind_id ?? '') . "</a>";
            $value->product_type_id         = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_kind->product_kind_name ?? '') . "</a>";
            $value->product_category_id     = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_category_id ?? '') . "</a>";
            $value->product_sub_category_id = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_sub_category_id ?? '') . "</a>";
            $value->product_group_id        = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_group_id ?? '') . "</a>";
            $value->product_origin_id       = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->product_origin_id ?? '') . "</a>";
            $value->preferred_supplier_id   = "<a href='" . route('products.show', $value->id) . "' class='product-link'>" . ($value->preferred_supplier_id ?? '') . "</a>";
            $value->status                  = $value->status == 1
            ? '<button class="btn btn-success btn-sm change_status" data-id="' . $value->id . '">Active</button>'
            : '<button class="btn btn-danger btn-sm change_status" data-id="' . $value->id . '">Inactive</button>';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow'
             data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'>
             <a class='dropdown-item showbtn text-warning' href='" . route('products.show', $value->id) . "' data-id='" . $value->id . "'><i class='bx bx-show me-1 icon-warning'></i> Show</a>
             <a class='dropdown-item editbtn text-success' href='" . route('products.edit', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
             <a class='dropdown-item webbtn text-dark' href='" . route('products.product_website', $value->id) . "' data-id='" . $value->id . "' ><i <i class='bx bx-info-circle'></i></i> Website </a>
             <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }
    public function updateProductWebData(array $data, $productId)
    {
        $filteredData   = array_filter($data, fn($value) => !is_null($value) && $value !== '');
        $product        = Product::findOrFail($productId);
        $productWebsite = ProductWebsite::firstOrNew(['product_id' => $productId]);
        $productWebsite->fill($filteredData);
        $productWebsite->save();
        return $productWebsite;
    }

    public function saveProductImage($productId, $filePath)
    {
       
        return ProductImage::create([
            'product_id' => $productId,
            'product_image' => $filePath,
        ]);
    }

}
