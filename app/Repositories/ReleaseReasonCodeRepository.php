<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ReleaseReasonCode;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

Class ReleaseReasonCodeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface {

    public function findOrFail(int $id)
    {
        return ReleaseReasonCode::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return ReleaseReasonCode::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = ReleaseReasonCode::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getReleaseReasonCodeList($request)
    {
       $query = ReleaseReasonCode::query();
       if (!empty($request->reason_code_search)) {
            $query->where('release_reason_code', 'like', '%' . $request->reason_code_search . '%');
        }
       return $query;
    }

    public function dataTable(Request $request) {
        $draw 				= 		$request->get('draw');
        $start 				= 		$request->get("start");
        $rowPerPage 		= 		$request->get("length");
        $orderArray 	   = 		$request->get('order');
        $columnNameArray 	= 		$request->get('columns');
        $columnIndex 		= 		$orderArray[0]['column'];
        $columnName 		= 		$columnNameArray[$columnIndex]['data'];
        $columnSortOrder 	= 		$orderArray[0]['dir'];
        $releaseReasonCodes = $this->getReleaseReasonCodeList($request);
        $total = $releaseReasonCodes->count();
        $totalFilter = $this->getReleaseReasonCodeList($request);
        $totalFilter = $totalFilter->count();
        $arrData = $this->getReleaseReasonCodeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->release_reason_code = $value->release_reason_code ?? '';
            $value->action = "<button type='button' data-id='".$value->id."' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='".$value->id."'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='".$value->id."'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
