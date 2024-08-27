<?php

namespace App\Repositories;

use App\Models\VendorType;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class VendorTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return VendorType::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return VendorType::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = VendorType::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getVendorTypeList($request)
    {
        $query = VendorType::query();
        if (!empty($request->vendor_type_search)) {
            $query->where('vendor_type_name', 'like', '%' . $request->vendor_type_search . '%');
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
        $vendorTypes = $this->getVendorTypeList($request);
        $total = $vendorTypes->count();
        $totalFilter = $this->getVendorTypeList($request);
        $totalFilter = $totalFilter->count();
        $arrData = $this->getVendorTypeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->vendor_type_name = $value->vendor_type_name ?? '';
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
