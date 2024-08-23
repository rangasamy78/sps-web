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
        $product_type    = $this->getProductTypeList($request);
        $total           = $product_type->count();
        $totalFilter     = $this->getProductTypeList($request);
        $totalFilter     = $totalFilter->count();
        $arrData         = $this->getProductTypeList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno                 = ++$i;
            $value->product_type        = $value->product_type ?? '';
            $value->default_gl_accounts = $this->productTypeService->getDefaultGLAccounts($value->inventory_gl_account, $value->sales_gl_account, $value->cogs_gl_account);
            $value->default_values      = $this->productTypeService->getDefaultValues($value->indivisible, $value->non_serialized, $value->id);
            $value->action              = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' >
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

    public function saveDefaultValue(Request $request)
    {
        return $this->productTypeService->saveDefaultValue($request);
    }
}
