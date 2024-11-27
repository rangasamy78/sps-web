<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrePurchaseRequestEventRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Event::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $data = $this->handleFollowerId($data);
        // $data = $this->handleEventType($data);
        return Event::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $data  = $this->handleFollowerId($data);
        // $data  = $this->handleEventType($data);
        $query = $this->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getEventList($request)
    {
        $query = Event::query()
                ->where('type_id', $request->id)
                ->where('type', Event::PREPURREQUEST)
                ->with(['product', 'user', 'assigned_user', 'event_type']);
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

        $columnName = 'created_at';
        $counties   = $this->getEventList($request);
        $total      = $counties->count();

        $totalFilter = $this->getEventList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getEventList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $combined_datetime     = $value->schedule_date . ' ' . $value->schedule_time;
            $value->sno            = ++$i;
            $value->entered_by_id  = $value->user->full_name;
            $value->assigned_to_id = $value->assigned_user->full_name;
            $value->description    = $value->description;
            $value->event_type_id  = $value->event_type->event_type_name;
            $value->time_date      = Carbon::parse($combined_datetime)->format('M d, Y h:i A');;
            $value->price          = $value->price;
            $value->action         = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item editEventbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deleteEventbtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    protected function handleFollowerId($data)
    {
        if (!empty($data['follower_id']) && is_array($data['follower_id'])) {
            $data['follower_id'] = implode("~", $data['follower_id']);
        }
        if (!empty($data['pre_purchase_request_id'])) {
            $data['type_id'] = $data['pre_purchase_request_id'];
        }
        return $data;
    }
}
