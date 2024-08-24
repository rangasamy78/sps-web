<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\PrintDocDisclaimer;
use App\Models\SelectTypeCategory;
use App\Models\SelectTypeSubCategory;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class SelectTypeSubCategoryRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return SelectTypeSubCategory::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $selectTypeCategoryId = $data['select_type_category_id'];
        foreach ($data['select_type_sub_categories'] as $subcategory) {
            if (!empty($subcategory['select_type_sub_category_name'])) {
                SelectTypeSubCategory::create([
                    'select_type_category_id'       => $selectTypeCategoryId,
                    'select_type_sub_category_name' => $subcategory['select_type_sub_category_name'],
                ]);
            }
        }
    }

    public function edit(int $id)
    {
        return SelectTypeCategory::with(['select_type_sub_category'])->find($id);
    }

    public function update(array $data, int $id)
    {
        $delete = SelectTypeSubCategory::where('select_type_category_id', $id)->delete();
        if ($delete) {
            foreach ($data['select_type_sub_categories'] as $subcategory) {
                if (!empty($subcategory['select_type_sub_category_name'])) {
                    SelectTypeSubCategory::create([
                        'select_type_category_id'       => $id,
                        'select_type_sub_category_name' => $subcategory['select_type_sub_category_name'],
                    ]);
                }
            }
        }
    }

    public function delete(int $id)
    {
        $categories = PrintDocDisclaimer::where('select_type_category_id', $id)->first();
        if ($categories) {
            $subCategories = PrintDocDisclaimer::where('select_type_sub_category_id', $categories->select_type_sub_category_id)->first();
            if ($subCategories) {
                return response()->json(['status' => 'error', 'msg' => 'Sub Category cannot be deleted because it has policies.'], 200);
            } else {
                SelectTypeSubCategory::where('select_type_category_id', $id)->delete();
                return response()->json(['status' => 'success', 'msg' => 'Sub Category deleted successfully.'], 200);
            }
        } else {
            SelectTypeSubCategory::where('select_type_category_id', $id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Sub Category deleted successfully.'], 200);
        }
    }

    public function getSelectTypeCategoryList($request)
    {
        $query = SelectTypeCategory::query()->with('select_type_sub_category');
        if (!empty($request->select_type_category_name_search)) {
            $query->where('select_type_category_name', 'like', '%' . $request->select_type_category_name_search . '%');
        }
        if (!empty($request->select_type_sub_category_search)) {
            $query->whereHas('select_type_sub_category', function ($q) use ($request) {
                $q->where('id', $request->select_type_sub_category_search)
                    ->orWhere('select_type_sub_category_name', 'like', '%' . $request->select_type_sub_category_search . '%');
            });
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

        $query = $this->getSelectTypeCategoryList($request);
        $allData = $query->get();

        $filteredData = $allData->filter(function ($category) {
            return $category->select_type_sub_category->isNotEmpty();
        });

        $paginatedData = $filteredData->slice($start, $rowPerPage);

        $paginatedData = $paginatedData->sortBy(function ($item) use ($columnName, $columnSortOrder) {
            return $columnSortOrder === 'asc' ? $item->$columnName : -$item->$columnName;
        });
        $paginatedData->map(function ($value, $i) {
            $value->sno                        = ++$i;
            $value->select_type_category_names = $value->select_type_category_name;
            $value->select_type_sub_categories = $value->select_type_sub_category->take(4)->pluck('select_type_sub_category_name')->implode(', ');
            $value->action                     = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'>
                              <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;
                              <button type='button' data-id='" . $value->id . "' name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'>
                              <i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;
                              <button type='button' data-id='" . $value->id . "' name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'>
                              <i class='fas fa-trash-alt'></i></button>";
        });

        $response = [
            "draw"            => intval($draw),
            "recordsTotal"    => $allData->count(),
            "recordsFiltered" => $filteredData->count(),
            "data"            => $paginatedData->values(),
        ];
        return response()->json($response);
    }
}
