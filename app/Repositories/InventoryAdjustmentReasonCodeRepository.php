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
        $query = InventoryAdjustmentReasonCode::query();
        if (!empty($request->reason_search)) {
            $query->where('reason', 'like', '%' . $request->reason_search . '%');
        }
        if (!empty($request->adjustment_type_search)) {
            $query->where('adjustment_type_id', 'like', '%' . $request->adjustment_type_search . '%');
        }
        if (!empty($request->income_expense_account_search)) {
            $query->where('income_expense_account', $request->income_expense_account_search);
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
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $inventory       = $this->getInventoryAdjustmentReasonCodeList($request);
        $total           = $inventory->count();
        $totalFilter     = $this->getInventoryAdjustmentReasonCodeList($request);
        $totalFilter     = $totalFilter->count();
        $arrData         = $this->getInventoryAdjustmentReasonCodeList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);

        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                    = ++$i;
            $value->reason                 = $value->reason ?? '';
            $value->adjustment_type_id     = $this->getAdjustmentTypeListList($value->adjustment_type_id);
            $value->income_expense_account = $value->income_expense_account ?? '';
            $value->action                 = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' >
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
