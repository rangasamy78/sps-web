<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ProbabilityToClose;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class ProbabilityToCloseRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return ProbabilityToClose::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return ProbabilityToClose::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = ProbabilityToClose::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getProbabilityToCloseList()
    {
        $query = ProbabilityToClose::query();
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

        $probabilityToCloses = $this->getProbabilityToCloseList();
        $total = $probabilityToCloses->count();

        $totalFilter = $this->getProbabilityToCloseList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('probability_to_close', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getProbabilityToCloseList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('probability_to_close', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->probability_to_close = $value->probability_to_close ?? '';
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
