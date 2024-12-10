<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class BatchCloseQuoteRepository implements DatatableRepositoryInterface
{
    public function getOpportunitysList($request)
    {
        $query = Opportunity::query()->where('close_quote', 0);
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('opportunity_date', [$request->start_date, $request->end_date]);
        }
        else{
            $startDate  = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate    = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
            $query->whereBetween('opportunity_date', [$startDate, $endDate]);
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

        $columnName   = 'created_at';
        $opportunities = $this->getOpportunitysList($request);
        $total        = $opportunities->count();

        $totalFilter = $this->getOpportunitysList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getOpportunitysList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->opportunity_code    = $value->opportunity_code ?? '';
            $value->opportunity_date    = \Carbon\Carbon::parse($value->opportunity_date)->format('M j, Y') ;
            $value->ship_to_type        = $value->ship_to_type ?? '';
            $value->close_quote         = "<input type='checkbox' name='opportunity_ids[]' class='form-check-input' value='$value->id'>";
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
