<?php

namespace App\Repositories\Opportunity;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Product;
use Illuminate\Http\Request;

class EventRepository
{
    public function findOrFail(int $id)
    {
        return Event::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return Event::create($data);
    }

    public function update(array $data, int $id)
    {
        if (!isset($data['mark_as_complete'])) {
            $data['mark_as_complete'] = 0;
        }
        $query = Event::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getEventList(Request $request, $id)
    {
        $query = Event::with(['user', 'assigned_user', 'event_type', 'product'])
            ->where('type', 'opportunity')
            ->where('type_id', $id);
        return $query;
    }

    public function dataTable(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName     = 'created_at';
        $aboutUsOptions = $this->getEventList($request, $id);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getEventList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getEventList($request, $id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->check = '<div class="form-check"><input type="checkbox" class="form-check-input event_check" id="mark_as_complete" name="mark_as_complete" value="1" ' . ($value->mark_as_complete ? 'checked' : '') . '  data-id="' . htmlspecialchars($value->id) . '"></div>';
            $value->entered_by_id = $value->user->first_name ?? '';
            $value->assigned_to_id = $value->assigned_user->first_name ?? '';
            $value->title_description = '';
            $listItems = '';
            if ($value->description) {
                $listItems .= "<li> <i class='fi fi-rr-circle-d text-dark fw-bold'></i>&nbsp;" . htmlspecialchars($value->description) . "</li>";
            }
            if ($value->event_title) {
                $listItems .= "<li> <i class='fi fi-rr-circle-t text-dark fw-bold'></i>&nbsp;" . htmlspecialchars($value->event_title) . "</li>";
            }
            $value->title_description = $listItems ? "<ul style='list-style-type: none; padding: 0; margin: 0;'>$listItems</ul>" : '';
            $value->event_type_id = $value->event_type->product_type ?? '';
            $scheduleDateTime = Carbon::parse($value->schedule_date . ' ' . ($value->schedule_time ?? ''))->format('Y-m-d H:i:s');
            $value->time_date = $scheduleDateTime;
            $value->product_name_price = $value->product->product_name ?? '';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getProductList(Request $request)
    {
        $query = Product::with('product_type');
        if (!empty($request->productName)) {
            $query->where('product_name', 'like', '%' . $request->productName . '%');
        }
        if (!empty($request->productCode)) {
            $query->where('product_sku', 'like', '%' . $request->productCode . '%');
        }
        return $query;
    }

    public function dataTableGetProduct(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName     = 'products.created_at';
        $aboutUsOptions = $this->getProductList($request);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getProductList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getProductList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->id = $value->id ?? '';
            $value->product_name = $value->product_name ?? '';
            $value->product_sku = $value->product_sku ?? '';
            $value->type = $value->product_type->product_type ?? '';
            $value->homeowner_price = $value->homeowner_price ?? '';
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
