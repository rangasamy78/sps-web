<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\TaxExemptReason;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class TaxExemptReasonRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return TaxExemptReason::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return TaxExemptReason::query()->create($data);
    }

    public function update(array $data, int $id): void
    {
        TaxExemptReason::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function getTaxExemptReasonList()
    {
        $query = TaxExemptReason::query();
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue     = $searchArray['value'];

        $taxExemptReasonList = $this->getTaxExemptReasonList();
        $total               = $taxExemptReasonList->count();

        $totalFilter = $this->getTaxExemptReasonList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('reason', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getTaxExemptReasonList();
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('reason', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->reason = $value->reason ?? '';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
