<?php

namespace App\Repositories;

use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Models\LinkedAccount;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class AccountTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return AccountType::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return AccountType::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = AccountType::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $subCategories = LinkedAccount::where('account_type', $id)->first();
        if ($subCategories) {
            return response()->json(['status' => 'error', 'msg' => 'Account Type cannot be deleted because it has Linked Accounts.'], 200);
        } else {
            $this->findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Account Type deleted successfully.'], 200);
        }
    }

    public function getAccountTypeList($request)
    {
        $query = AccountType::query();
        if (!empty($request->account_type_name_search)) {
            $query->where('account_type_name', 'like', '%' . $request->account_type_name_search . '%');
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

        $columnName      = 'created_at';
        $accountTypes    = $this->getAccountTypeList($request);
        $total           = $accountTypes->count();

        $totalFilter = $this->getAccountTypeList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getAccountTypeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno               = ++$i;
            $value->account_type_name = $value->account_type_name ?? '';
            $value->action            = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
