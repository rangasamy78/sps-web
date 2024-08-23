<?php

namespace App\Repositories;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class EventTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return EventType::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return EventType::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = EventType::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getEventTypeList($request)
    {
        $query = EventType::query();
        if (!empty($request->event_type_name_search)) {
            $query->where('event_type_name', 'like', '%' . $request->event_type_name_search . '%');
        }
        if (!empty($request->event_type_code_search)) {
            $query->where('event_type_code', 'like', '%' . $request->event_type_code_search . '%');
        }
        if (!empty($request->event_category_search)) {
            $query->where('event_category_id', $request->event_category_search);
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
        $projectTypes    = $this->getEventTypeList($request);
        $total           = $projectTypes->count();
        $totalFilter     = $this->getEventTypeList($request);
        $totalFilter     = $totalFilter->count();
        $arrData         = $this->getEventTypeList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno               = ++$i;
            $value->event_type_name   = $value->event_type_name ?? '';
            $value->event_type_code   = $value->event_type_code ?? '';
            $value->event_category_id = get_event_category_list($value->event_category_id);
            $value->action            = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
