<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\SupplierType;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class SupplierTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return SupplierType::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SupplierType::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SupplierType::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getSupplierTypeList($request)
    {
        $query = SupplierType::query();
        if (!empty($request->supplier_type_name_search)) {
            $query->where('supplier_type_name', 'like', '%' . $request->supplier_type_name_search . '%');
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
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $supplierTypes   = $this->getSupplierTypeList($request);
        $total           = $supplierTypes->count();

        $totalFilter     = $this->getSupplierTypeList($request);
        $totalFilter     = $totalFilter->count();

        $arrData         = $this->getSupplierTypeList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                = ++$i;
            $value->supplier_type_name = $value->supplier_type_name ?? '';
            $value->action             = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
