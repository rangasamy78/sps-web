<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class ExpenseCategoryRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id): Model
    {
        return ExpenseCategory::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return ExpenseCategory::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return ExpenseCategory::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getExpenseCategoryList($request)
    {
        $query = ExpenseCategory::with('linked_account');
        if (!empty($request->expense_category_search) ) {
            $query->where('expense_category_name', 'like', '%' . $request->expense_category_search . '%');
        }
        if (!empty($request->expense_account_search) ) {
            $query->where('expense_account', $request->expense_account_search);
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
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $ExpenseCategory = $this->getExpenseCategoryList($request);

        $total           = $ExpenseCategory->count();
        $totalFilter = $this->getExpenseCategoryList($request);

        $totalFilter = $totalFilter->count();
        $arrData     = $this->getExpenseCategoryList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->expense_category_name = $value->expense_category_name ?? '';
            $value->linked_account_id     = $value->linked_account_details ?? '';
            $value->action                = "<div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
