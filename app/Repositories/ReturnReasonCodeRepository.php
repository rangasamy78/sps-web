<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ReturnReasonCode;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

Class ReturnReasonCodeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface {

    public function findOrFail(int $id)
    {
        return ReturnReasonCode::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return ReturnReasonCode::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = ReturnReasonCode::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getReturnReasonCodeList()
    {
       $query = ReturnReasonCode::query();
       return $query;
    }

    public function dataTable(Request $request) {
        $draw 				= 		$request->get('draw');
        $start 				= 		$request->get("start");
        $rowPerPage 		= 		$request->get("length");
        $orderArray 	   = 		$request->get('order');
        $columnNameArray 	= 		$request->get('columns');
        $searchArray 		= 		$request->get('search');
        $columnIndex 		= 		$orderArray[0]['column'];
        $columnName 		= 		$columnNameArray[$columnIndex]['data'];
        $columnSortOrder 	= 		$orderArray[0]['dir'];
        $searchValue 		= 		$searchArray['value'];

        $returnReasonCodes = $this->getReturnReasonCodeList();
        $total = $returnReasonCodes->count();

        $totalFilter = $this->getReturnReasonCodeList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('return_code','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getReturnReasonCodeList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('return_code','like','%'.$searchValue.'%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->return_code = $value->return_code ?? '';
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