<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\EndUseSegment;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class EndUseSegmentRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return EndUseSegment::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return EndUseSegment::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return EndUseSegment::query()
        ->findOrFail($id)
        ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getEndUseSegmentsList($request)
    {
        $query = EndUseSegment::query();
        if (!empty($request->end_use_segment_search)) {
            $query->where('end_use_segment', 'like', '%' . $request->end_use_segment_search . '%');
        }
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw                 =         $request->get('draw');
        $start                =         $request->get("start");
        $rowPerPage           =         $request->get("length");
        $orderArray           =         $request->get('order');
        $columnNameArray      =         $request->get('columns');
        $columnIndex          =         $orderArray[0]['column'];
        $columnName           =         $columnNameArray[$columnIndex]['data'];
        $columnSortOrder      =         $orderArray[0]['dir'];
        $endUseSegment = $this->getEndUseSegmentsList($request);
        $total = $endUseSegment->count();
        $totalFilter = $this->getEndUseSegmentsList($request);
        $totalFilter = $totalFilter->count();
        $arrData = $this->getEndUseSegmentsList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->end_use_segment = $value->end_use_segment ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
