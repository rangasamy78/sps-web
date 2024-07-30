<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\InventoryAdjustmentReasonCode;
use App\Models\AdjustmentType;
use Illuminate\Http\Request;

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

    public function getInventoryAdjustmentReasonCodeList()
    {
        $query = InventoryAdjustmentReasonCode::query();
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

        $states = $this->getInventoryAdjustmentReasonCodeList();
        $total = $states->count();

        $totalFilter = $this->getInventoryAdjustmentReasonCodeList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('reason', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getInventoryAdjustmentReasonCodeList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('reason', 'like', '%' . $searchValue . '%');

        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->reason = $value->reason ?? '';
            $value->adjustment_type_id =  $this->getAdjustmentTypeListList($value->adjustment_type_id);
            $value->income_expense_account = $value->income_expense_account ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' >
            <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit'
             class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;
             <button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
