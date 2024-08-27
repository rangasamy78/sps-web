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
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
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
            $value->shipment_method_name = $value->shipment_method_name ?? '';
            $value->shipment_method_description = $value->shipment_method_description ? Str::limit($value->shipment_method_description, 150, '...') : '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
        });

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }
}
