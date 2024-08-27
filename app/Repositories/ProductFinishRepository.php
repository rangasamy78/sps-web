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
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue     = $searchArray['value'];

        $states = $this->getProductFinishList($request);
        $total  = $states->count();

        $totalFilter = $this->getProductFinishList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getProductFinishList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('product_finish_code', 'like', '%' . $searchValue . '%');
            $arrData = $arrData->orWhere('finish', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                 = ++$i;
            $value->product_finish_code = $value->product_finish_code ?? '';
            $value->finish              = $value->finish ?? '';
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
}
