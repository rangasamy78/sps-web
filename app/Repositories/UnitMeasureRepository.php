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

    public function getUnitMeasuresList($request)
    {
        $query = UnitMeasure::query();
        if (!empty($request->unit_measure_name_search)) {
            $query->where('unit_measure_name', 'like', '%' . $request->unit_measure_name_search . '%');
        }
        if (!empty($request->unit_measure_entity_search)) {
            $unitSearch = !empty($request->unit_measure_entity_search) ? $request->unit_measure_entity_search : '';
            $query->whereIn('unit_measure_entity', $unitSearch);
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
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName   = 'created_at';
        $unitMeasures = $this->getUnitMeasuresList($request);
        $total        = $unitMeasures->count();

        $totalFilter = $this->getUnitMeasuresList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getUnitMeasuresList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->unit_measure_entity = UnitMeasure::getUnitMeasureOptions($value->unit_measure_entity);
            $value->unit_measure_name   = $value->unit_measure_name ?? '';
            $value->action              = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
