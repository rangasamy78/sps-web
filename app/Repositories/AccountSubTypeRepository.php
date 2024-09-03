<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\LinkedAccount;
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

    public function delete(int $id)
    {
        $subCategories = LinkedAccount::where('account_sub_type', $id)->first();
        if ($subCategories) {
            return response()->json(['status' => 'error', 'msg' => 'Account sub type cannot be deleted because it has Linked Accounts.'], 200);
        } else {
            $this->findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Account sub type deleted successfully.'], 200);
        }
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
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName      = 'created_at';
        $accountSubTypes = $this->getAccountSubTypeList($request);
        $total           = $accountSubTypes->count();

        $totalFilter = $this->getAccountSubTypeList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getAccountSubTypeList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->sub_type_name = $value->sub_type_name ?? '';
            $value->action        = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
