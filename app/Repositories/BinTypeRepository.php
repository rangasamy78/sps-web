<?php

namespace App\Repositories;

use App\Models\BinType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class BinTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return BinType::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return BinType::query()->create($data);
    }

    public function update(array $data, int $id): void
    {
        BinType::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function getBinTypeList()
    {
        $query = BinType::query();

        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw                 =         $request->get('draw');
        $start                 =         $request->get("start");
        $rowPerPage         =         $request->get("length");
        $orderArray         =         $request->get('order');
        $columnNameArray     =         $request->get('columns');
        $searchArray         =         $request->get('search');
        $columnIndex         =         $orderArray[0]['column'];
        $columnName         =         $columnNameArray[$columnIndex]['data'];
        $columnSortOrder     =         $orderArray[0]['dir'];
        $searchValue         =         $searchArray['value'];

        $bin = $this->getBinTypeList();
        $total = $bin->count();

        $totalFilter = $this->getBinTypeList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('bin_type', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData = $this->getBinTypeList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('bin_type', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) use ($start) {
            $value->bin_type = $value->bin_type ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' data-bs-target='#show_state-modal'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
        });

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );
        return response()->json($response);
    }
}