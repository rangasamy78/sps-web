<?php

namespace App\Repositories;

use App\Models\ProductType;
use Illuminate\Http\Request;
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
        $query = ProductType::with('linked_account_inventory_gl', 'linked_account_sales_gl', 'linked_account_cogs_gl');
        if (!empty($request->product_type_search)) {
            $query->where('product_type', 'like', '%' . $request->product_type_search . '%');
        }
        if (!empty($request->inventory_gl_account_search)) {
            $inventorySearch = !empty($request->inventory_gl_account_search) ? $request->inventory_gl_account_search : '';
            $query->whereIn('inventory_gl_account_id', $inventorySearch);
        }
        if (!empty($request->sales_gl_account_search)) {
            $salesSearch = !empty($request->sales_gl_account_search) ? $request->sales_gl_account_search : '';
            $query->whereIn('sales_gl_account_id', $salesSearch);
        }
        if (!empty($request->cogs_gl_account_search)) {
            $cogsSearch = !empty($request->cogs_gl_account_search) ? $request->cogs_gl_account_search : '';
            $query->whereIn('cogs_gl_account_id', $cogsSearch);
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

        $columnName   = 'created_at';
        $productTypes = $this->getProductTypeList($request);
        $total        = $productTypes->count();

        $totalFilter = $this->getProductTypeList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getProductTypeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                 = ++$i;
            $value->product_type        = $value->product_type ?? '';
            $inventory_gl               = $value->linked_account_inventory_gl->account_number . '-' . $value->linked_account_inventory_gl->account_name;
            $sales_gl                   = $value->linked_account_sales_gl->account_number . '-' . $value->linked_account_sales_gl->account_name;
            $cogs_gl                    = $value->linked_account_cogs_gl->account_number . '-' . $value->linked_account_cogs_gl->account_name;
            $value->default_gl_accounts = $this->productTypeService->getDefaultGLAccounts($inventory_gl, $sales_gl, $cogs_gl);
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
