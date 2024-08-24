<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\SupplierCostListLabel;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class SupplierCostListLabelRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return SupplierCostListLabel::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SupplierCostListLabel::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SupplierCostListLabel::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getSupplierCostListLabelList($request)
    {
        $query = SupplierCostListLabel::query();
        if (!empty($request->cost_level_search)) {
            $query->where('cost_level', 'like', '%' . $request->cost_level_search . '%');
        }
        if (!empty($request->cost_code_search)) {
            $query->where('cost_code', 'like', '%' . $request->cost_code_search . '%');
        }
        if (!empty($request->cost_label_search)) {
            $query->where('cost_label', 'like', '%' . $request->cost_label_search . '%');
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

        $supplierCostListLabels = $this->getSupplierCostListLabelList($request);
        $total                  = $supplierCostListLabels->count();

        $totalFilter = $this->getSupplierCostListLabelList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSupplierCostListLabelList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->cost_level = $value->cost_level ?? '';
            $value->cost_code  = $value->cost_code ?? '';
            $value->cost_label = $value->cost_label ?? '';
            $value->action     = "<div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
