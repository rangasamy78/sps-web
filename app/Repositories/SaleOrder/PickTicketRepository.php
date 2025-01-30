<?php

namespace App\Repositories\SaleOrder;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Service;
use App\Models\UnitMeasure;
use Illuminate\Http\Request;
use App\Models\SaleOrderLine;
use App\Interfaces\CrudRepositoryInterface;

class PickTicketRepository implements CrudRepositoryInterface
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

    public function getLineList(Request $request, $id)
    {
        $query = SaleOrderLine::with(['service', 'unit_measures'])
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
            $value->check_item = "<input type='checkbox' name='item_ids[]' id='{$value->id}_item_id' class='form-check-input' value='$value->id' checked>";
            $value->so_line_no = $value->so_line_no ?? '';
            $value->item =($value->service->service_name ?? '') . (($value->service->service_sku ?? '') ? ' (' . $value->service->service_sku . ')' : '');
            $value->description = "<input type='checkbox' name='is_sold_as_ids[]' value='$value->id'" . ($value->is_sold_as == 1 ? ' checked' : '') . ">".'<span style="font-style: italic;font-size: small;"> Sold As </span>'."<input type='text' name='description' class='form-control form-control-sm' value='".$value->description."' >";
            $value->quantity_val = number_format($value->quantity, 2).' '.$value->unit_measures->unit_measure_name ?? '';
            $value->un_invoiced_qty = "<span id='{$value->id}_un_invoiced_qty'>" . (number_format($value->quantity, 2) ?? '') . "</span>";
            $check_unit = '';
            if ($value->unit_measures->unit_measure_name != 'IN') {
                $check_unit = 'readonly';
            }
            $value->pick_qty = "<input $check_unit type='number' name='{$value->id}_pick_qty' id='{$value->id}_pick_qty' class='form-control form-control-sm' value='" . number_format($value->quantity, 2) . "'  max='" . $value->quantity . "'>";
            $value->unit_price = "<input type='number' name='{$value->id}_unit_price' id='{$value->id}_unit_price' class='form-control form-control-sm'   value='" . number_format($value->unit_price, 2) . "' >";
            $value->extended_amount = "<input type='number' name='{$value->id}_extended_amount' id='{$value->id}_extended_amount' class='form-control form-control-sm' value='" . number_format($value->extended_amount, 2) . "' readonly>";
            $value->is_taxable = "<input type='checkbox' name='is_taxable_ids[]' class='checkbox' value='$value->id'" . ($value->is_taxable == 1 ? ' checked' : '') . ">";
            $value->is_hideon_print = "<input type='checkbox' name='is_hideon_print_ids[]' class='checkbox' value='$value->id'" . ($value->is_hideon_print == 1 ? ' checked' : '') . ">";
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

