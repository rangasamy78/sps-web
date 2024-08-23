<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class ProductCategoryRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return ProductCategory::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $productCategory = ProductCategory::create([
            'product_category_name' => $data['product_category_name'],
        ]);

        if (isset($data['product_sub_categories']) && is_array($data['product_sub_categories'])) {
            $subCategoriesData = $data['product_sub_categories'];
            $productCategory->sub_categories()->createMany($subCategoriesData);
        }
        return $productCategory;
    }

    public function edit(int $id)
    {
        return ProductCategory::with('sub_categories')->find($id);
    }

    public function update(array $data, int $id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        $productCategory->update(['product_category_name' => $data['product_category_name']]);
        if (isset($data['product_sub_categories']) && is_array($data['product_sub_categories'])) {
            $productCategory->sub_categories()->delete();
            $productCategory->sub_categories()->createMany($data['product_sub_categories']);
        }
        return $productCategory;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        if ($query) {
            ProductSubCategory::where('product_category_id', $id)->delete();
        }
        return $query;
    }

    public function getProductCategoryList()
    {
        $query = ProductCategory::query();
        return $query;
    }

    public function getProductSubCategoryNameList($id)
    {
        $productSubCategorys = ProductSubCategory::where('product_category_id', $id)
            ->take(4)
            ->pluck('product_sub_category_name')
            ->toArray();
        $subCategoryNames = implode(',', $productSubCategorys);
        return $subCategoryNames ?? '';
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

        $category = $this->getProductCategoryList();
        $total    = $category->count();

        $totalFilter = $this->getProductCategoryList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('product_category_name', 'like', '%' . $searchValue . '%');

        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getProductCategoryList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('product_category_name', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                   = ++$i;
            $value->product_category_name = $value->product_category_name ?? '';
            $value->subcategory           = $this->getProductSubCategoryNameList($value->id);
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
