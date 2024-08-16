<?php

namespace App\Repositories;

use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Models\LinkedAccount;
use App\Models\AccountSubType;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class LinkedAccountRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id): Model
    {
        return LinkedAccount::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return LinkedAccount::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        LinkedAccount::query()
            ->findOrFail($id)
            ->update($data);
    }
    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }
    public function getLinkedAccountList($request)
    {
        $query = LinkedAccount::query();
        if (!empty($request->account_code_search) ) {
            $query->where('account_code', 'like', '%' . $request->account_code_search . '%');
        }
        if (!empty($request->account_name_search) ) {
            $query->where('account_name', 'like', '%' . $request->account_name_search . '%');
        }
        if (!empty($request->account_type_search) ) {
            $query->where('account_type', $request->account_type_search);
        }
        if (!empty($request->account_sub_type_search) ) {
            $query->where('account_sub_type', $request->account_sub_type_search);
        }
        return $query;
    }
    public function dataTable(Request $request)
    {
        $draw                 =         $request->get('draw');
        $start                =         $request->get("start");
        $rowPerPage           =         $request->get("length");
        $orderArray           =         $request->get('order');
        $columnNameArray      =         $request->get('columns');
        $searchArray          =         $request->get('search');
        $columnIndex          =         $orderArray[0]['column'];
        $columnName           =         $columnNameArray[$columnIndex]['data'];
        $columnSortOrder      =         $orderArray[0]['dir'];
        $searchValue          =         $searchArray['value'];
        $LinkedAccounts = $this->getLinkedAccountList($request);
        $total = $LinkedAccounts->count();

        $totalFilter = $this->getLinkedAccountList($request);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('account_code', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData = $this->getLinkedAccountList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('account_code', 'like', '%' . $searchValue . '%')
                ->orwhere('account_name', 'like', '%' . $searchValue . '%')
                ->orwhere('account_type', 'like', '%' . $searchValue . '%')
                ->orwhere('account_sub_type', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->account_code     = $value->account_code ?? '';
            $value->account_name     = $value->account_name ?? '';
            $value->account_type     = AccountType::getAccountTypeList($value->account_type);
            $value->account_sub_type = AccountSubType::getAccountSubTypeList($value->account_sub_type);
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "' name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "' name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
