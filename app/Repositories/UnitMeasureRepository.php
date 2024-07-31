<?php

namespace App\Repositories;

use App\Models\UnitMeasure;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class UnitMeasureRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return UnitMeasure::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return UnitMeasure::query()
        ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = UnitMeasure::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getUnitMeasuresList()
    {
        $query = UnitMeasure::query();
        return $query;
    }
 
    public function dataTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue = $searchArray['value'];
        $unitMeasures = $this->getUnitMeasuresList();
        $total = $unitMeasures->count();
        $totalFilter = $this->getUnitMeasuresList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('unit_measure_entity', 'like', '%' . $searchValue . '%')
                ->orWhere('unit_measure_name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData = $this->getUnitMeasuresList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('unit_measure_entity', 'like', '%' . $searchValue . '%')
                ->orWhere('unit_measure_name', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->unit_measure_entity = UnitMeasure::getUnitMeasureOptions($value->unit_measure_entity);
            $value->unit_measure_name = $value->unit_measure_name ?? '';
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
