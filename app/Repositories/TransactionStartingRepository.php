<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\TransactionStarting;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class TransactionStartingRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return TransactionStarting::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return TransactionStarting::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = TransactionStarting::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getTransactionStartingList($request)
    {
        $query = TransactionStarting::query();
        if (!empty($request->type_search)) {
            $query->where('type', 'like', '%' . $request->type_search . '%');
        }
        if (!empty($request->starting_number_search)) {
            $query->where('starting_number', 'like', '%' . $request->starting_number_search . '%');
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
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue     = $searchArray['value'];

        $transaction = $this->getTransactionStartingList($request);
        $total       = $transaction->count();

        $totalFilter = $this->getTransactionStartingList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getTransactionStartingList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno             = ++$i;
            $value->type            = $value->type ?? '';
            $value->starting_number = $value->starting_number ?? '';
            $value->action          = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' >
            <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit'
            class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button
            type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
