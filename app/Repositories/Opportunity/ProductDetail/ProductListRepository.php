<?php

namespace App\Repositories\Opportunity\ProductDetail;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductListRepository
{
    public function getProductList($request)
    {
        $name = $request->get('name');
        $type = $request->get('type');
        $category = $request->get('category');
        $supplier = $request->get('supplier');
        $products = Product::with('product_type');
        if (!empty($name)) {
            $products->where('product_name', 'LIKE', "%{$name}%");
        }
        if (!empty($type)) {
            $products->where('product_type_id', $type);
        }
        if (!empty($category)) {
            $products->where('product_category_id', $category);
        }
        if (!empty($supplier)) {
            $products->where('preferred_supplier_id', $supplier);
        }
        return $products;
    }

    public function searchProductDataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'] ?? 'created_at';
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $query = $this->getProductList($request);
        $totalRecords = $query->count();
        $filteredData = $query
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data = $filteredData->map(function ($product) {
            return [
                'product_name' => $product->product_name ?? '',
                'product_sku'  => $product->product_sku ?? 'N/A',
                'type'         => $product->product_type->product_type ?? 'N/A',
                'icon' => '<img src="' . asset('public/images/icon_detail.gif') . '" class="me-1" alt="image not found" style="width: 20px; height: 20px;cursor: pointer;" onclick="window.location.href=\'' . route('products.show', $product->id) . '\'">',
                'check'        => '<input type="checkbox" class="form-check-input product_checkbox" value="' . $product->id . '" data-id="' . $product->id . '">',
            ];
        });
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data"            => $data,
        ]);
    }
    
}
