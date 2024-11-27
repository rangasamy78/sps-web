<?php

namespace App\Repositories;

use App\Models\Visit;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CrudRepositoryInterface;

class VisitRepository implements CrudRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Visit::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return Visit::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = Visit::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getVisitList($request, $id)
    {
        if (!$id) {
            throw new \InvalidArgumentException('Visit ID is required');
        }
        $productQuery = DB::table('visit_products')
            ->join('products', 'visit_products.product_id', '=', 'products.id')
            ->where('visit_id', $id)
            ->select('visit_id as id', 'products.product_name as item_name', 'product_quantity as quantity', 'product_unit_price as unit_price', 'product_amount as amount', 'is_tax as tax', 'product_description as description', DB::raw("'product' as type"));

        $serviceQuery = DB::table('visit_services')
            ->join('services', 'visit_services.service_id', '=', 'services.id')
            ->where('visit_id', $id)
            ->select('visit_id as id', 'services.service_name as item_name', 'service_quantity as quantity', 'service_unit_price as unit_price', 'service_amount as amount', 'is_tax as tax', 'service_description as description', DB::raw("'service' as type"));

        $query = $productQuery
            ->unionAll($serviceQuery);
        return $query;
    }





    public function dataTable(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? 0;
        $columnName      = $columnNameArray[$columnIndex]['data'] ?? 'quantity'; 
        $columnSortOrder = $orderArray[0]['dir'] ?? 'asc';
        $query = $this->getVisitList($request, $id);
        $totalRecords = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query) 
            ->count();
        $data = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query) 
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data->map(function ($value) {
            $value->item_name      = $value->item_name ?? ''; 
            $value->current_qty  = 0;
            $value->tax          = $value->tax ?? '';
            $value->slab         = '';
            $value->serialNum    = '';
            $value->location     = '';
            $value->barcode      = '';
            $value->lot          = '';
            $value->bundle       = '';
            $value->supp_ref     = '';
            $value->quantity     = $value->quantity ?? '';
            $value->unit_price   = $value->unit_price ?? '';
            $value->amount       = $value->amount ?? '';
            $value->action       = "<a class='dropdown-item showbtn text-warning' href='" . route('visits.edit_visit_product', $value->id) . "' data-id='{$value->id}'><i class='bx bxs-edit'></i></a>";
        });
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data"            => $data,
        ]);
    }






    public function getProductList($request)
    {
        $name = $request->get('name');
        $type = $request->get('type');
        $category = $request->get('category');
        $supplier = $request->get('supplier');

        $products = Product::with('product_type'); // Assuming `product_type` is a valid relation.

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
        $rowPerPage      = $request->get("length"); // Number of records per page.
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'] ?? 'created_at'; // Default sorting column.
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc'; // Default sorting order.

        $query = $this->getProductList($request);

        // Total records without filtering.
        $totalRecords = $query->count();

        // Apply pagination and sorting.
        $filteredData = $query
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowPerPage)
            ->get();

        // Map data for DataTable response.
        $data = $filteredData->map(function ($product) {
            return [
                'product_name' => $product->product_name ?? '',
                'product_sku'  => $product->product_sku ?? 'N/A',
                'type'         => $product->product_type->product_type ?? 'N/A',
                'icon' => '<img src="' . asset('public/images/icon_detail.gif') . '" class="me-1" alt="image not found" style="width: 20px; height: 20px;cursor: pointer;" onclick="window.location.href=\'' . route('products.show', $product->id) . '\'">',
                'check'        => '<input type="checkbox" class="form-check-input product_checkbox" value="' . $product->id . '" data-id="' . $product->id . '">',
            ];
        });

        // Prepare response.
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $totalRecords, // Adjust if filtered data differs.
            "data"            => $data,
        ]);
    }
}
