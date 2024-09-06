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
            $selectTypeNameSearch = !empty($request->select_type_category_name_search) ? $request->select_type_category_name_search : '';
            $query->whereIn('id', $selectTypeNameSearch);
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
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName = 'created_at';
        $query      = $this->getSelectTypeCategoryList($request);
        $allData    = $query->get();

        $filteredData = $allData->filter(function ($category) {
            return $category->select_type_sub_category->isNotEmpty();
        });

        $paginatedData = $filteredData->slice($start, $rowPerPage);

        $paginatedData = $paginatedData->sortBy(function ($item) use ($columnName, $columnSortOrder) {
            return $item ? $item->$columnName : -$item->$columnName;
        });
        $paginatedData->map(function ($value, $i) {
            $value->sno                        = ++$i;
            $value->select_type_category_names = $value->select_type_category_name;
            $value->select_type_sub_categories = $value->select_type_sub_category->take(4)->pluck('select_type_sub_category_name')->filter()->implode(', ');
            $value->action                     = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
