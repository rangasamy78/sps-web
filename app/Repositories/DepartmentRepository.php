<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

Class DepartmentRepository implements CrudRepositoryInterface, DatatableRepositoryInterface {

    public function findOrFail(int $id)
    {
        return Department::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return Department::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = Department::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getDepartmentList($request)
    {
        $query = Department::query();
        if (!empty($request->department_search)) {
            $query->where('department_name', 'like', '%' . $request->department_search . '%');
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
        $departments = $this->getDepartmentList($request);
        $total = $departments->count();
        $totalFilter = $this->getDepartmentList($request);
        $totalFilter = $totalFilter->count();
        $arrData = $this->getDepartmentList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->department_name = $value->department_name ?? '';
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
