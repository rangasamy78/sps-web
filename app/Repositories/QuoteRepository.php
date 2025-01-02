<?php

namespace App\Repositories;

use App\Models\Quote;
use App\Models\Opportunity;
use App\Models\QuoteProduct;
use App\Models\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;

class QuoteRepository implements CrudRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return Quote::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return Quote::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return Quote::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getQuoteList(Request $request)
    {
        $query = Opportunity::query()
            ->join('quotes', 'quotes.opportunity_id', '=', 'opportunities.id')
            ->with(['customer', 'location', 'primary_user', 'secondary_user'])
            ->select('opportunities.id as opportunity_id', 'opportunities.created_at as date', 'quotes.id as quote_id', 'opportunities.*')
            ->groupBy('opportunities.id')
            ->orderBy('opportunities.created_at', 'asc');
        return $query;
    }

    public function dataTableQuote(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName  = 'date';
        $vendorTypes = $this->getQuoteList($request);
        $total       = $vendorTypes->count();

        $totalFilter = $this->getQuoteList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getQuoteList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->DT_RowAttr = [
                'data-id' => $value->opportunity_id
            ];
            $value->date_time = "<a href='javascript:void(0);' class='text-secondary open-modal-btn' style='font-size:8pt;' data-bs-toggle='modal'data-bs-target='#searchListQuoteModel' data-bs-id=" . $value->opportunity_id . ">" . ($value->opportunity_code ?? '') . " " . \Carbon\Carbon::parse($value->date)->format('M d, Y, h:i A') . "</a>";
            $value->opportunity = $value->opportunity_id ?? '';
            $value->job_name = "<div style='font-size:8pt;'><span>" . ($value->ship_to_job_name ?? '') . "</span><span>" . ($value->ship_to_address ?? '') . "</span><span>" . ($value->ship_to_zip ?? '') . "</span><span>P: " . ($value->ship_to_phone ?? '') . "</span></div>";
            $value->bill_customer = $value->customer->customer_name ?? '';
            $value->company = $value->location->company_name ?? 'N/A';
            $value->sales_person = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary'><ul style='list-style-type: none; padding: 0; margin: 0;'>" .
                (!empty($value->primary_user?->first_name) ? "<li><img src='" . asset('public/images/PrimSales.png') . "' alt='primary person'> " . e($value->primary_user->first_name) . "</li>" : "") .
                (!empty($value->secondary_user?->first_name) ? "<li><img src='" . asset('public/images/SecSales.png') . "' alt='secondary person'> " . e($value->secondary_user->first_name) . "</li>" : "") . "</ul></a>";
            $value->notes = "<a href='javascript:void(0);' class='text-secondary' style='display: block; margin-bottom: 10px;'><div style='display: flex; align-items: center; gap: 10px;'>" . (!empty($value->internal_notes) ? "<i class='fi fi-rr-note-sticky text-dark fw-bold fs-3' data-bs-toggle='tooltip' data-bs-placement='top' title='Internal Notes: " . htmlspecialchars($value->internal_notes, ENT_QUOTES, 'UTF-8') . "'></i>" : "") . "</div></a>";
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getQuoteAllList(Request $request, $id)
    {
        return Quote::with('project_type', 'probability_close')->where('opportunity_id', $id);
    }

    public function getQuoteTotal($id)
    {
        $totals = [
            'product' => QuoteProduct::where('quote_id', $id)->sum('product_amount'),
            'service' => QuoteService::where('quote_id', $id)->sum('service_amount'),
        ];
        return array_sum($totals);
    }

    public function dataTableQuoteAll(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName  = 'created_at';
        $vendorTypes = $this->getQuoteAllList($request, $id);
        $total       = $vendorTypes->count();

        $totalFilter = $this->getQuoteAllList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getQuoteAllList($request, $id);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->skip($start)->take($rowPerPage)->get();
        // Add position for each visit
        $offset = $start + 1;
        $arrData->map(function ($value, $index) use ($offset) {
            $value->position = $offset + $index;
            $value->date_time = "<a href='" . route('quote.quotes.show', $value->id) . "' class='text-secondary' style='font-size:8pt;'>" . \Carbon\Carbon::parse($value->created_at)->format('M d, Y, h:i A') . "</a>";
            $value->quote = $value->opportunity_id . '-' . $value->position ?? '';
            $value->quote_label = $value->quote_label ?? '';
            $value->customer_po = $value->customer_po ?? '';
            $value->quoteStatus = $value->status;
            if ($value->probability_close && $value->probability_close->probability_to_close) {
                $probability = '<div class="text-center">Probability to Close - ' . $value->probability_close->probability_to_close . '%</div>';
            } else {
                $probability = '';
            }
            if ($value->status == 'close') {
                $value->status = '<div class="progress mb-3">
                    <div class="progress-bar bg-success shadow-none" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100">&nbsp;&nbsp;&nbsp;&nbsp;Quoted&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="progress-bar bg-danger shadow-none" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100">Closed</div>
                </div>' . $probability;
            } else {
                $value->status = '<div class="progress mb-3">
                    <div class="progress-bar bg-success shadow-none" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100">Quoted&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </div>' . $probability;
            }
            $value->projectType = $value->project_type->project_type_name ?? '';
            $createdAt = \Carbon\Carbon::parse($value->created_at);
            $value->day = $createdAt->diffInDays(\Carbon\Carbon::now());
            $value->expiry_date = $value->expiry_date ? \Carbon\Carbon::parse($value->expiry_date)->format('M d, Y') : '';
            $quotetotal = $this->getQuoteTotal($value->id);
            $value->total = '$' . $quotetotal ?? '';
            $value->printed_notes = "<a href='" . route('quote.quotes.show', $value->id) . "' class='text-secondary' style='display: block; margin-bottom: 10px;'>" . "<div style='display: flex; align-items: center; gap: 10px;'>" . (!empty($value->quote_printed_note) ? "<i class='fi fi-rr-note-sticky text-dark fw-bold fs-3' data-bs-toggle='tooltip' data-bs-placement='top' title='Printed Notes: " . htmlspecialchars($value->quote_internal_note, ENT_QUOTES, 'UTF-8') . "'></i>" : "") . "</div></a>";
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item editbtn text-success' href='" . route('quote.quotes.edit', $value->id) . "' data-id='" . $value->id . "'><i class='bx bx-edit-alt me-1 icon-success'></i> Edit</a></div></div>";
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
