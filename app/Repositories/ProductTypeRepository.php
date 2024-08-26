<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Services\ProductType\ProductTypeService;

class ProductTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public $productTypeService;
    public function __construct(ProductTypeService $productTypeService)
    {
        $this->productTypeService = $productTypeService;
    }

    public function findOrFail(int $id)
    {
        return ProductType::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return ProductType::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = ProductType::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }
    public function getProductTypeList($request)
    {
        $query = ProductType::query();
        if (!empty($request->product_type_search)) {
            $query->where('product_type', 'like', '%' . $request->product_type_search . '%');
        }
        if (!empty($request->inventory_gl_account_search)) {
            $query->where('inventory_gl_account', 'like', '%' . $request->inventory_gl_account_search . '%');
        }
        if (!empty($request->sales_gl_account_search)) {
            $query->where('sales_gl_account', 'like', '%' . $request->sales_gl_account_search . '%');
        }
        if (!empty($request->cogs_gl_account_search)) {
            $query->where('cogs_gl_account', 'like', '%' . $request->cogs_gl_account_search . '%');
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

        $states = $this->getProductTypeList($request);
        $total  = $states->count();

        $totalFilter = $this->getProductTypeList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getProductTypeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                 = ++$i;
            $value->product_type        = $value->product_type ?? '';
            $value->default_gl_accounts = $this->productTypeService->getDefaultGLAccounts($value->inventory_gl_account, $value->sales_gl_account, $value->cogs_gl_account);
            $value->default_values      = $this->productTypeService->getDefaultValues($value->indivisible, $value->non_serialized, $value->id);
            $value->action              = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function saveDefaultValue(Request $request)
    {
        return $this->productTypeService->saveDefaultValue($request);
    }
}
