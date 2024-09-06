<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\AdjustmentType;
use App\Interfaces\CrudRepositoryInterface;
use App\Models\InventoryAdjustmentReasonCode;
use App\Interfaces\DatatableRepositoryInterface;

class InventoryAdjustmentReasonCodeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return InventoryAdjustmentReasonCode::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return InventoryAdjustmentReasonCode::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = InventoryAdjustmentReasonCode::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getInventoryAdjustmentReasonCodeList($request)
    {
        $query = InventoryAdjustmentReasonCode::with('linked_adjustment_type');
        if (!empty($request->reason_search)) {
            $query->where('reason', 'like', '%' . $request->reason_search . '%');
        }
        if (!empty($request->adjustment_type_search)) {
            $adjSearch = !empty($request->adjustment_type_search) ? $request->adjustment_type_search : '';
            $query->whereIn('adjustment_type_id', $adjSearch);
        }
        if (!empty($request->income_expense_account_search)) {
            $incomeSearch = !empty($request->income_expense_account_search) ? $request->income_expense_account_search : '';
            $query->whereIn('income_expense_account_id', $incomeSearch);
        }
    
        return $query;
    }
    public function getAdjustmentTypeListList($id)
    {
        $adjustmentTypes = AdjustmentType::where('id', $id)
            ->pluck('adjustment_type');
        return $adjustmentTypes;
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

        $columnName                     = 'created_at';
        $inventoryAdjustmentReasonCodes = $this->getInventoryAdjustmentReasonCodeList($request);
        $total                          = $inventoryAdjustmentReasonCodes->count();

        $totalFilter = $this->getInventoryAdjustmentReasonCodeList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getInventoryAdjustmentReasonCodeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                    = ++$i;
            $value->reason                 = $value->reason ?? '';
            $value->adjustment_type_id     = $this->getAdjustmentTypeListList($value->adjustment_type_id);
            $value->income_expense_account_id = $value->linked_adjustment_type->account_code. '-' .$value->linked_adjustment_type->account_name;
            $value->action                 = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
