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
        $ExpenseCategory = $this->getExpenseCategoryList($request);
        $total = $ExpenseCategory->count();

        $totalFilter = $this->getExpenseCategoryList($request);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('expense_category_name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData = $this->getExpenseCategoryList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('expense_category_name', 'like', '%' . $searchValue . '%')
                ->orwhere('expense_account', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();
         
        $arrData->map(function ($value) {
            $value->expense_category_name = $value->expense_category_name ?? '';
            $value->linked_account_id = $value->linked_account_details ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
