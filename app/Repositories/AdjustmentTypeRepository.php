<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\AdjustmentType;
use App\Interfaces\CrudRepositoryInterface;
use App\Models\InventoryAdjustmentReasonCode;
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
        $subCategories = InventoryAdjustmentReasonCode::where('adjustment_type_id', $id)->first();
        if ($subCategories) {
            return response()->json(['status' => 'error', 'msg' => 'Adjustment Type cannot be deleted because it has Inventory Adjustment reason code.'], 200);
        } else {
            $this->findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Adjustment Type deleted successfully.'], 200);
        }
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
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName      = 'created_at';
        $adjustment      = $this->getAdjustmentTypeList($request);
        $total           = $adjustment->count();

        $totalFilter = $this->getAdjustmentTypeList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getAdjustmentTypeList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno             = ++$i;
            $value->adjustment_type = $value->adjustment_type ?? '';
            $value->action          = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
