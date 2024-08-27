<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ProductPriceRange;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class ProductPriceRangeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return ProductPriceRange::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return ProductPriceRange::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = ProductPriceRange::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getProductPriceRangeList($request)
    {
        $query = ProductPriceRange::query();
        if (!empty($request->product_price_range_search)) {
            $query->where('product_price_range', 'like', '%' . $request->product_price_range_search . '%');
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
        $price_range = $this->getProductPriceRangeList($request);
        $total       = $price_range->count();
        $totalFilter = $this->getProductPriceRangeList($request);
        $totalFilter = $totalFilter->count();
        $arrData = $this->getProductPriceRangeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno                 = ++$i;
            $value->product_price_range = $value->product_price_range ?? '';
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
}
