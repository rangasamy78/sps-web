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

    public function getProductCategoryList($request)
    {
        $query = ProductCategory::query()->with('sub_categories');
        if (!empty($request->product_category_name_search)) {
            $query->where('product_category_name', 'like', '%' . $request->product_category_name_search . '%');
        }
        if (!empty($request->product_sub_category_name_search)) {
            $query->whereHas('sub_categories', function ($q) use ($request) {
                $q->where('id', $request->product_sub_category_name_search)
                    ->orWhere('product_sub_category_name', 'like', '%' . $request->product_sub_category_name_search . '%');
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
        $category        = $this->getProductCategoryList($request);
        $total           = $category->count();

        $totalFilter     = $this->getProductCategoryList($request);
        $totalFilter     = $totalFilter->count();

        $arrData         = $this->getProductCategoryList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                   = ++$i;
            $value->product_category_name = $value->product_category_name ?? '';
            $value->subcategory           = $value->sub_categories->take(4)->pluck('product_sub_category_name')->implode(', ');
            $value->action                = "<button type='button' data-id='" . $value->id . "'  class='p-2 m-0 btn btn-warning btn-sm showbtn' >
            <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit'
             class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;
             <button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
