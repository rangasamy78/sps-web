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
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue     = $searchArray['value'];

        $projectTypes = $this->getEventTypeList();
        $total        = $projectTypes->count();

        $totalFilter = $this->getEventTypeList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('event_type_name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getEventTypeList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('event_type_name', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno               = ++$i;
            $value->event_type_name   = $value->event_type_name ?? '';
            $value->event_type_code   = $value->event_type_code ?? '';
            $value->event_category_id = get_event_category_list($value->event_category_id);
            $value->action            = "<div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
