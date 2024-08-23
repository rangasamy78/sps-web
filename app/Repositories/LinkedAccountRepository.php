<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\LinkedAccount;
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
    public function getLinkedAccountList()
    {
        $query = LinkedAccount::with('linked_account_type', 'linked_account_sub_type');
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
        $LinkedAccounts  = $this->getLinkedAccountList();
        $total           = $LinkedAccounts->count();

        $totalFilter = $this->getLinkedAccountList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('account_code', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getLinkedAccountList();
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
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
            $value->account_type     = $value->linked_account_type ? $value->linked_account_type->account_type_name : '';
            $value->account_sub_type = $value->linked_account_sub_type ? $value->linked_account_sub_type->sub_type_name : '';
            $value->action           = "<div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
