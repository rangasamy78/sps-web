<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Http\Request;
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
            $value->sno             = ++$i;
            $value->department_name = $value->department_name ?? '';
            $value->action          = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
