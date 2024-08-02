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

    public function getSupplierCostListLabelList()
    {
        $query = SupplierCostListLabel::query();
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

        $supplierCostListLabels = $this->getSupplierCostListLabelList();
        $total = $supplierCostListLabels->count();

        $totalFilter = $this->getSupplierCostListLabelList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('cost_level', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSupplierCostListLabelList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('cost_level', 'like', '%' . $searchValue . '%')
                ->orwhere('cost_code', 'like', '%' . $searchValue . '%')
                ->orwhere('cost_label', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->cost_level = $value->cost_level ?? '';
            $value->cost_code = $value->cost_code ?? ''; 
            $value->cost_label = $value->cost_label ?? ''; 
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' ><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
