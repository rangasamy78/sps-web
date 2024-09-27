<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class UserRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return User::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return User::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = User::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getUserList($request)
    {
        $query = User::with(['department', 'designation']);
        if (!empty($request->name_search)) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name_search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->name_search . '%');
            });
        }
        
        if (!empty($request->code_search)) {
            $query->where('code', 'like', '%' . $request->code_search . '%');
        }
        if (!empty($request->email_search)) {
            $query->where('email', 'like', '%' . $request->email_search . '%');
        }
        if (!empty($request->department_search)) {
            $deptSearch = !empty($request->department_search) ? $request->department_search : '';
            $query->whereIn('department_id', $deptSearch);
        }
        if (!empty($request->designation_search)) {
            $desgSearch = !empty($request->designation_search) ? $request->designation_search : '';
            $query->whereIn('designation_id', $desgSearch);
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
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName = 'created_at';
        $name       = $this->getUserList($request);
        $total      = $name->count();

        $totalFilter = $this->getUserList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getUserList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno          = ++$i;
            $value->name = ($value->first_name ?? '') . ' ' . ($value->last_name ?? '');
            $value->code         = $value->code ?? '';
            $value->email        = $value->email ?? '';
            $value->departments  = $value->department->department_name ?? '';
            $value->designations = $value->designation->designation_name ?? '';
            $value->action       = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
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
