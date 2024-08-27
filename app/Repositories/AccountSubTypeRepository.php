<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\AccountSubType;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class AccountSubTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return AccountSubType::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return AccountSubType::query()->create($data);
    }

    public function update(array $data, int $id): void
    {
        AccountSubType::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function getAccountSubTypeList($request)
    {
        $query = AccountSubType::query();
        if (!empty($request->sub_type_name_search)) {
            $query->where('sub_type_name', 'like', '%' . $request->sub_type_name_search . '%');
        }
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw                  =         $request->get('draw');
        $start                 =         $request->get("start");
        $rowPerPage            =         $request->get("length");
        $orderArray            =         $request->get('order');
        $columnNameArray       =         $request->get('columns');
        $columnIndex           =         $orderArray[0]['column'];
        $columnName            =         $columnNameArray[$columnIndex]['data'];
        $columnSortOrder       =         $orderArray[0]['dir'];
        $accountSubTypes = $this->getAccountSubTypeList($request);
        $total = $accountSubTypes->count();
        $totalFilter = $this->getAccountSubTypeList($request);
        $totalFilter = $totalFilter->count();
        $arrData = $this->getAccountSubTypeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);      
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->sub_type_name = $value->sub_type_name ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' ><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
