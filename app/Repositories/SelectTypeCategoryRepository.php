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
        if ($subCategories->isNotEmpty()) {
            return response()->json(['status' => 'error', 'msg' => 'Category cannot be deleted because it has subcategories.'], 200);
        } else {
            $this->findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Select Type Category deleted successfully.'], 200);
        }
    }

    public function getSelectTypeCategoryList($request)
    {
        $query = SelectTypeCategory::query();
        if (!empty($request->select_type_category_search)) {
            $query->where('select_type_category_name', 'like', '%' . $request->select_type_category_search . '%');
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
        $columnIndex     = $orderArray[0]['column']??'0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName  = 'created_at';
        $select_type = $this->getSelectTypeCategoryList($request);
        $total       = $select_type->count();

        $totalFilter = $this->getSelectTypeCategoryList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSelectTypeCategoryList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                       = ++$i;
            $value->select_type_category_name = $value->select_type_category_name ?? '';
            $value->action                    = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
