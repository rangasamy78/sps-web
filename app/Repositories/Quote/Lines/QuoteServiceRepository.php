<?php

namespace App\Repositories\Quote\Lines;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\QuoteService;
use Illuminate\Http\Request;

class QuoteServiceRepository
{
    public function findOrFail(int $id)
    {
        return QuoteService::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return QuoteService::create($data);
    }

    public function update(array $data, $id)
    {
        if (!isset($data['is_sold_as'])) {
            $data['is_sold_as'] = 0;
        }

        if (!isset($data['is_tax'])) {
            $data['is_tax'] = 0;
        }

        if (!isset($data['is_hide_line'])) {
            $data['is_hide_line'] = 0;
        }
        $query = QuoteService::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getQuoteServiceList(Request $request, $id)
    {
        $query = QuoteService::with(['user', 'assigned_user', 'QuoteService_type', 'product'])
            ->where('type', 'quote')
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
        $aboutUsOptions = $this->getQuoteServiceList($request, $id);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getQuoteServiceList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getQuoteServiceList($request, $id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->check = '<div class="form-check"><input type="checkbox" class="form-check-input QuoteService_check" id="mark_as_complete" name="mark_as_complete" value="1" ' . ($value->mark_as_complete ? 'checked' : '') . '  data-id="' . htmlspecialchars($value->id) . '"></div>';
            $value->entered_by_id = $value->user->first_name ?? '';
            $value->assigned_to_id = $value->assigned_user->first_name ?? '';
            $value->title_description = '';
            $listItems = '';
            if ($value->description) {
                $listItems .= "<li> <i class='fi fi-rr-circle-d text-dark fw-bold'></i>&nbsp;" . htmlspecialchars($value->description) . "</li>";
            }
            if ($value->QuoteService_title) {
                $listItems .= "<li> <i class='fi fi-rr-circle-t text-dark fw-bold'></i>&nbsp;" . htmlspecialchars($value->QuoteService_title) . "</li>";
            }
            $value->title_description = $listItems ? "<ul style='list-style-type: none; padding: 0; margin: 0;'>$listItems</ul>" : '';
            $value->QuoteService_type_id = $value->QuoteService_type->product_type ?? '';
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

    public function getServiceList(Request $request)
    {
        $query = Service::join('service_price', 'service_price.service_id', '=', 'services.id')
            ->select('services.*', 'service_price.*');
        // $query = Product::with('product_type');
        if (!empty($request->serviceName)) {
            $query->where('service_name', 'like', '%' . $request->ServiceName . '%');
        }
        if (!empty($request->serviceCode)) {
            $query->where('service_sku', 'like', '%' . $request->serviceCode . '%');
        }
        return $query;
    }

    public function dataTableGetService(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName     = 'services.created_at';
        $aboutUsOptions = $this->getServiceList($request);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getServiceList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getServiceList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->id = $value->id ?? '';
            $value->service_name = $value->service_name ?? '';
            $value->service_sku = $value->service_sku ?? '';
            $value->is_taxable_item = $value->is_taxable_item ?? '';
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
