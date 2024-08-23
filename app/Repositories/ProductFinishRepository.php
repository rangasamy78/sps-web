<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ProductFinish;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class ProductFinishRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return ProductFinish::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return ProductFinish::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = ProductFinish::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getProductFinishList($request)
    {
        $query = ProductFinish::query();
        if (!empty($request->product_finish_code_search)) {
            $query->where('product_finish_code', 'like', '%' . $request->product_finish_code_search . '%');
        }
        if (!empty($request->finish_search)) {
            $query->where('finish', 'like', '%' . $request->finish_search . '%');
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
        $product_finish  = $this->getProductFinishList($request);
        $total           = $product_finish->count();
        $totalFilter     = $this->getProductFinishList($request);
        $totalFilter     = $totalFilter->count();
        $arrData         = $this->getProductFinishList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno                 = ++$i;
            $value->product_finish_code = $value->product_finish_code ?? '';
            $value->finish              = $value->finish ?? '';
            $value->action              = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' >
            <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit'
            class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button
            type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
