<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\SelectTypeCategory;
use App\Models\SelectTypeSubCategory;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
class SelectTypeCategoryRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return SelectTypeCategory::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SelectTypeCategory::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SelectTypeCategory::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $subCategories = SelectTypeSubCategory::where('select_type_category_id', $id)->get();
        if ($subCategories->isNotEmpty())  {
            return response()->json(['status' => 'error', 'msg' => 'Category cannot be deleted because it has subcategories.'], 200);
        }
        else { 
            $this->findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Select Type Category deleted successfully.'], 200);
        }
    }

    public function getSelectTypeCategoryList()
    {
        $query = SelectTypeCategory::query();
        return $query;
    }
    
    public function dataTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue = $searchArray['value'];
        $select_type = $this->getSelectTypeCategoryList();
        $total = $select_type->count();
        $totalFilter = $this->getSelectTypeCategoryList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('select_type_category_name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSelectTypeCategoryList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('select_type_category_name', 'like', '%' . $searchValue . '%');

        }
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->select_type_category_name = $value->select_type_category_name ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' >
            <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit'
             class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;
             <button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
