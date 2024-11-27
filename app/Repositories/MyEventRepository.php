<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\MyEvent;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class MyEventRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return MyEvent::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return MyEvent::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return MyEvent::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getMyEventList($request)
    {
        $query = MyEvent::with(['users', 'assigned', 'search_product']);

        $statusval = $request->status_filter;
        if ($statusval == 0) {
            $query->where('mark_as_complete', 0);
        } elseif ($statusval == 1) {
            $query->where('mark_as_complete', 1);
        } else {
            $query->whereIn('mark_as_complete', [0, 1]);
        }

        if (!empty($request->enteredby_assignedto_search)) {
            $query->where(function($query) use ($request) {
                $query->whereHas('users', function($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->enteredby_assignedto_search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->enteredby_assignedto_search . '%');
                })
                ->orWhereHas('assigned', function($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->enteredby_assignedto_search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->enteredby_assignedto_search . '%');
                });
            });
        }

        if (!empty($request->event_title_search)) {
            $query->where('event_title', 'like', '%' . $request->event_title_search . '%')
                ->orWhere('description', 'like', '%' . $request->event_title_search . '%');
        }

        if (!empty($request->product_search)) {
            $query->whereHas('search_product', function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->product_search . '%');
            });
        }

        if (!empty($request->date_search)) {
            try {
                $formattedSearchDate = Carbon::parse($request->date_search)->format('Y-m-d');
                $query->where('schedule_date', '=', $formattedSearchDate);
            } catch (\Exception $e) {
                // Optionally handle invalid date input here
            }
        }

        if (!empty($request->time_search)) {
            $query->where('schedule_time', 'like', '%' . $request->time_search . '%');
        }

        if (!empty($request->toggleBtnVal)) {
            $query->where('entered_by_id', $request->toggleBtnVal);
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
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName = 'created_at';
        $event    = $this->getMyEventList($request);
        $total      = $event->count();

        $totalFilter = $this->getMyEventList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getMyEventList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                     = ++$i;
            $entered_by = $value->entered_by_id;
            $value->entered_by_id           = '<B>'.($value->users->first_name ?? '').' '.($value->users->last_name ?? '').'</B><br/>'.$value->created_at->diffForHumans() ?? '';
            $followerIds = $value->follower_id;
                $explodedFollowerIds  = explode('~', $followerIds);
                $followersValue = '';

                    foreach ($explodedFollowerIds as $id) {
                        $follower = User::find($id);

                        if ($follower) {
                            $followersValue .= $follower->first_name . ', ';
                        }
                    }
                    $followersValue = rtrim($followersValue, ', ');
            $value->assigned_to_id          = ($value->assigned->first_name ?? '').' '.($value->assigned->last_name ?? '').'<br/>'.($followersValue ?? '') ?? '';
            $value->event_title             = ($value->event_title ?? '').'<br/>'.($value->description ?? '');
            $value->product_type_id         = $value->event_type->event_type_name ?? '';
            $formattedDate = !empty($value->schedule_date) ? Carbon::parse($value->schedule_date)->format('M d, Y') : '';
            $formattedTime = !empty($value->schedule_time) ? Carbon::createFromFormat('H:i:s', $value->schedule_time)->format('g:i A') : '';
            $value->schedule_date           = $formattedDate.'<br/>'.$formattedTime;
            $value->party_name              = $value->party_name ?? '';
                $productIds = $value->product_id;
                $explodedProductIds  = explode('~', $productIds);
                $productsValue = '';

                    foreach ($explodedProductIds as $id) {
                        $product = Product::find($id);

                        if ($product) {
                            $productsValue .= $product->product_name . ', <br/>';
                        }
                    }
                    $productsValue = rtrim($productsValue, ', <br/>');
            $value->product_id              = ($productsValue ?? '').'<br/>'.(!empty($value->price) ? '$'.$value->price : '');
            $value->action = '';
            $value->action = "<div class='dropup'>
                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                        <i class='bx bx-dots-vertical-rounded icon-color'></i>
                    </button>
                    <div class='dropdown-menu'>
                <a class='dropdown-item showbtn text-warning' href='" . route('my_events.show', $value->id) . "' data-id='" . $value->id . "'><i class='bx bx-show me-1 icon-warning'></i> Show</a>";

                if ($entered_by == auth()->user()->id) {
                    $value->action .= "<a class='dropdown-item editbtn text-success' href='" . route('my_events.edit', $value->id) . "' data-id='" . $value->id . "'>
                        <i class='bx bx-edit-alt me-1 icon-success'></i> Edit
                    </a>
                    <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a>";
                }

                $value->action .= "</div></div>";
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
