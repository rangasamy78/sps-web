<?php

namespace App\Repositories;

use App\Models\ProductType;
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
        $subCategories = ProductType::where('inventory_gl_account_id', $id)
            ->orWhere('sales_gl_account_id', $id)
            ->orWhere('cogs_gl_account_id', $id)
            ->first();

        if ($subCategories) {
            return response()->json(['status' => 'error', 'msg' => 'Linked Account cannot be deleted because it has Product Types.'], 200);
        } else {
            $this->findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Linked Account deleted successfully.'], 200);
        }
    }

    public function getLinkedAccountList($request)
    {
        $query = LinkedAccount::query();
        if (!empty($request->account_code_search)) {
            $query->where('account_code', $request->account_code_search);
        }
        if (!empty($request->account_name_search)) {
            $query->where('account_name', 'like', '%' . $request->account_name_search . '%');
        }
        if (!empty($request->account_type_search)) {
            $accountSearch = !empty($request->account_type_search) ? $request->account_type_search : '';
            $query->whereIn('account_type', $accountSearch);
        }
        if (!empty($request->account_sub_type_search)) {
            $accountsubSearch = !empty($request->account_sub_type_search) ? $request->account_sub_type_search : '';
            $query->whereIn('account_sub_type', $accountsubSearch);
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

        $columnName     = 'created_at';
        $LinkedAccounts = $this->getLinkedAccountList($request);
        $total          = $LinkedAccounts->count();

        $totalFilter = $this->getLinkedAccountList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getLinkedAccountList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->account_code     = $value->account_code ?? '';
            $value->account_name     = $value->account_name ?? '';
            $value->account_type     = $value->linked_account_type ? $value->linked_account_type->account_type_name : '';
            $value->account_sub_type = $value->linked_account_sub_type ? $value->linked_account_sub_type->sub_type_name : '';
            $value->action           = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
