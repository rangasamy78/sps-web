<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\AdjustmentType;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class AdjustmentTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return AdjustmentType::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return AdjustmentType::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = AdjustmentType::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getAdjustmentTypeList($request)
    {
        $query = AdjustmentType::query();
        if (!empty($request->adjustment_type_search)) {
            $query->where('adjustment_type', 'like', '%' . $request->adjustment_type_search . '%');
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
        $adjustment      = $this->getAdjustmentTypeList($request);
        $total           = $adjustment->count();
        $totalFilter     = $this->getAdjustmentTypeList($request);
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getAdjustmentTypeList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno             = ++$i;
            $value->adjustment_type = $value->adjustment_type ?? '';
            $value->action          = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' >
            <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit'
             class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;
             <button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
