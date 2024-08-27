<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PurchaseShipmentMethod;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class PurchaseShipmentMethodRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return PurchaseShipmentMethod::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return PurchaseShipmentMethod::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = PurchaseShipmentMethod::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getPurchaseShipmentMethodList($request)
    {
        $query = PurchaseShipmentMethod::query();
        if (!empty($request->shipment_method_name_search)) {
            $query->where('shipment_method_name', 'like', '%' . $request->shipment_method_name_search . '%');
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
        $columnIndex = $orderArray[0]['column'];
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $purchaseShipmentMethods = $this->getPurchaseShipmentMethodList($request);
        $total = $purchaseShipmentMethods->count();

        $totalFilter = $this->getPurchaseShipmentMethodList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPurchaseShipmentMethodList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        
        $arrData->map(function ($value) {
            $value->shipment_method_name        = $value->shipment_method_name ?? '';
            $value->shipment_method_description = $value->shipment_method_description ? Str::limit($value->shipment_method_description, 50, '...') : '';
            $value->action                      = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
