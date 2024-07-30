<?php

namespace App\Repositories;

use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Services\ProductType\ProductTypeService;
use App\Interfaces\DatatableRepositoryInterface;

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

    public function getProductTypeList()
    {
        $query = ProductType::query();
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

        $states = $this->getProductTypeList();
        $total = $states->count();

        $totalFilter = $this->getProductTypeList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('product_type', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getProductTypeList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('product_type', 'like', '%' . $searchValue . '%');

        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->product_type = $value->product_type ?? '';
            $value->default_gl_accounts = $this->productTypeService->getDefaultGLAccounts($value->inventory_gl_account, $value->sales_gl_account, $value->cogs_gl_account);
            $value->default_values = $this->productTypeService->getDefaultValues($value->indivisible, $value->non_serialized, $value->id);
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
    
    public function updateDefaultvalues(Request $request)
    {
        return $this->productTypeService->updateDefaultvalues($request);        
    }
}
