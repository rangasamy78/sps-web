<?php

namespace App\Repositories\SaleOrder;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Service;
use App\Models\UnitMeasure;
use Illuminate\Http\Request;
use App\Models\SaleOrderLine;
use App\Models\SupplierInvoicePackingItem;
use App\Interfaces\CrudRepositoryInterface;

class LineRepository implements CrudRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return SaleOrderLine::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SaleOrderLine::create($data);
    }

    public function update(array $data, int $id)
    {
        if (!isset($data['mark_as_complete'])) {
            $data['mark_as_complete'] = 0;
        }
        $query = SaleOrderLine::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getSlabList($request)
    {
        // dd($request);
        $product = Product::where('product_name', $request)->first();
// dd($product_id->id);
        $query = SupplierInvoicePackingItem::where('product_id', $product->id);
        // return $query;
        return $query->get();
    }


    public function getLineList(Request $request, $id)
    {
        $query = SaleOrderLine::with(['service', 'unit_measures_so'])
                            ->where('sales_order_id', $id);
        return $query;
        // return $query->get();
    }

    public function dataTable(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName     = 'created_at';
        $aboutUsOptions = $this->getLineList($request, $id);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getLineList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getLineList($request, $id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->so_line_no          = $value->so_line_no ?? '';
            $value->item                = $value->service->service_name ?? '';
            $value->sku                 = $value->service->service_sku ?? '';
            $value->item_description    = $value->item_description ?? '';
            $value->quantity            = number_format($value->quantity, 2).' '.$value->unit_measures_so->unit_measure_name ?? '';
            $value->unit_price          = '$'.number_format($value->unit_price, 2) ?? '';
            $value->extended_amount     = '$'.number_format($value->extended_amount, 2) ?? '';
            $value->is_taxable          = $value->is_taxable == 1 ? '<i class="fas fa-check-circle fa-lg" style="color: green;font-weight: normal;"></i>' : '<i class="fas fa-times-circle fa-lg" style="color: red;font-weight: normal;"></i>';
            $value->is_hideon_print     = $value->is_hideon_print == 1 ? "<i class='bx bxs-low-vision'></i>" : '';
            $value->action                  = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getProductList(Request $request)
    {
        $query = Product::with('product_type');
        if (!empty($request->productName)) {
            $query->where('product_name', 'like', '%' . $request->productName . '%');
        }
        if (!empty($request->productCode)) {
            $query->where('product_sku', 'like', '%' . $request->productCode . '%');
        }
        return $query;
    }

    public function dataTableGetProduct(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName     = 'created_at';
        $aboutUsOptions = $this->getProductList($request);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getProductList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getProductList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->id = $value->id ?? '';
            $value->product_name = $value->product_name ?? '';
            $value->product_sku = $value->product_sku ?? '';
            $value->type = $value->product_type->product_type ?? '';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }
}
