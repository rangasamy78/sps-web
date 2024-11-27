<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\PrePurchaseRequestProduct;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class PrePurchaseRequestProductRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return PrePurchaseRequestProduct::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return PrePurchaseRequestProduct::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = $this->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getPrePurchaseRequestProductList($request)
    {
        $query = PrePurchaseRequestProduct::query()->where('pre_purchase_request_id', $request->id)->with(['product']);
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
        $counties   = $this->getPrePurchaseRequestProductList($request);
        $total      = $counties->count();

        $totalFilter = $this->getPrePurchaseRequestProductList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPrePurchaseRequestProductList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno             = ++$i;
            $value->product_sku     = $value->product_sku ?? '';
            $value->product_name    = $value->product->product_name ?? '';
            $value->description     = $value->description ?? '';
            $value->picking_qty     = $value->picking_qty ? $value->picking_qty . " Bundles" : '';
            $value->slab            = $value->slab ? $value->slab . " Slabs" : '';
            $value->qty             = $value->qty ?? '';
            $value->purchasing_note = $value->purchasing_note ?? '';
            $value->action          = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deleteProductbtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
