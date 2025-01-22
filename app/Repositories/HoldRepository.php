<?php

namespace App\Repositories;

use App\Models\Hold;
use App\Models\TaxComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;

class HoldRepository implements CrudRepositoryInterface
{
    public function findOrFail(int $id): Model
    {
        return Hold::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return Hold::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return Hold::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getProductHoldList($request, $id)
    {
        if (!$id) {
            throw new \InvalidArgumentException('SampleOrder ID is required');
        }
        $productQuery = DB::table('hold_products')
            ->join('products', 'hold_products.product_id', '=', 'products.id')
            ->where('hold_id', $id)
            ->select(
                'hold_id as id',
                'products.product_name as item_name',
                'product_quantity as quantity',
                'product_unit_price as unit_price',
                'product_amount as amount',
                'is_tax as tax',
                'product_description as description',
                DB::raw("'product' as type"),
                DB::raw('NULL as serialNum') // Placeholder for serialNum
            );

        $serviceQuery = DB::table('hold_services')
            ->join('services', 'hold_services.service_id', '=', 'services.id')
            ->where('hold_id', $id)
            ->select(
                'hold_id as id',
                'services.service_name as item_name',
                'service_quantity as quantity',
                'service_unit_price as unit_price',
                'service_amount as amount',
                'is_tax as tax',
                'service_description as description',
                DB::raw("'service' as type"),
                DB::raw('NULL as serialNum') // Placeholder for serialNum
            );
        return $productQuery->unionAll($serviceQuery);
    }

    public function dataTable(Request $request, $id)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex = $orderArray[0]['column'] ?? 0;
        $columnName = $columnNameArray[$columnIndex]['data'] ?? 'quantity'; // Default column
        $columnSortOrder = $orderArray[0]['dir'] ?? 'asc';

        // Ensure column name exists in the result set
        if (!in_array($columnName, ['id', 'item_name', 'quantity', 'unit_price', 'amount', 'tax', 'description', 'type', 'serialNum'])) {
            $columnName = 'quantity'; // Default to a valid column
        }

        $query = $this->getProductHoldList($request, $id);

        $totalRecords = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->count();

        $data = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowPerPage)
            ->get();

        $data->map(function ($value) {
            $value->item_name = $value->item_name ?? '';
            $value->current_qty = 0;
            $value->tax = ($value->tax == 1 ? "<i class='fi fi-rr-circle-y text-dark fw-bold'></i>" : "<i class='fi fi-rr-circle-n text-dark fw-bold'></i>") . "<input type='hidden' readonly class='border-0 text-secondary tax' value='" . ($value->tax ?? '') . "'>";
            $value->slab = '';
            $value->serialNum = ''; // Ensure serialNum exists
            $value->location = '';
            $value->barcode = '';
            $value->lot = '';
            $value->bundle = '';
            $value->supp_ref = '';
            $value->quantity = $value->quantity ?? '';
            $value->unit_price = "<input type='hidden' readonly class='border-0 text-secondary unit-price' value='" . ($value->unit_price ?? '') . "'>" . ($value->unit_price ?? '');
            $value->amount = $value->amount ?? '';
            if ($value->is_released = 0) {
                $value->action = "<a class='dropdown-item showbtn text-warning' href='" . route('hold.edit_product', $value->id) . "' data-id='{$value->id}'><i class='bx bxs-edit'></i></a>";
            } else {
                $value->action = '';
            }
        });

        return response()->json([
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data,
        ]);
    }

    public function getHoldList(Request $request)
    {
        $query = Hold::with('customer', 'location', 'primary_user');
        return $query;
    }
    public function getTaxDetail($id)
    {
        $hold = Hold::findOrFail($id);
        $taxCode = $hold?->sales_tax;

        $taxAmount = null;
        $taxCodeLabel = null;

        if ($taxCode) {
            $taxComponent = TaxComponent::where('tax_code_id', $taxCode->id)->first();
            if ($taxComponent) {
                $taxAmount = $taxComponent->tax_code_total;
            }
            $taxCodeLabel = $taxCode->tax_code_label ?? null;
        }
        return [
            'taxAmount' => $taxAmount,
            'taxCode'   => $taxCodeLabel,
        ];
    }

    public function dataTableHold(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex = $orderArray[0]['column'] ?? '0';
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';
        $columnName = 'created_at';
        $holdList = $this->getHoldList($request);
        $total = $holdList->count();
        $totalFilter = $this->getHoldList($request)->count();

        $arrData = $holdList->skip($start)
            ->take($rowPerPage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();
        $arrData->map(function ($value) {
            $holdDate = !empty($value->hold_date) ? \Carbon\Carbon::parse($value->hold_date)->format('M d, Y') : '';
            $expiryDate = !empty($value->expiry_date) ? \Carbon\Carbon::parse($value->expiry_date)->format('M d, Y') : '';
            $expiryDateCarbon = \Carbon\Carbon::parse($value->expiry_date);
            $currentDate = \Carbon\Carbon::now();
            if ($currentDate->greaterThan($expiryDateCarbon)) {
                $daysExpired = $currentDate->diffInDays($expiryDateCarbon);
                $statusText = "<span class='text-danger' >Expired On $expiryDate</span>";
                $day = "<span class='text-danger' >{$daysExpired} Days Ago</span>";
            } else {
                $daysRemaining = $expiryDateCarbon->diffInDays($currentDate);
                $statusText = "Expires On $expiryDate";
                $day = "<span class='text-success'>In {$daysRemaining} Days To Go</span>";
            }
            $value->add = '<i class="fi fi-ss-multiple fs-4 text-dark fw-bold add_click"  data-hold-id="' . $value->id . '"></i>';

            $value->hold_code = $value->hold_code ?? '';
            $value->hold_date = !empty($value->hold_date) ? \Carbon\Carbon::parse($value->hold_date)->format('M d, Y') : '';
            $value->expiry_date = !empty($value->expiry_date) ? \Carbon\Carbon::parse($value->expiry_date)->format('M d, Y') : '';
            $value->opportunity = '<a href="' . route('opportunities.show', $value->opportunity_id) . '" class="text-secondary open-modal-btn" data-bs-id="' . $value->opportunity_id . '">' . ($value->opportunity_id ?? '') . '</a>';
            $value->customer_name = '<ul style="list-style: none; padding: 0; margin: 0;">' . (!empty(optional($value->customer)->customer_name) ? '<li><i class="fi fi-ss-user-headset text-dark fw-bold"></i> ' . htmlspecialchars(optional($value->customer)->customer_name, ENT_QUOTES, 'UTF-8') . '</li>' : '') . (!empty($value->job_name) ? '<li><i class="fi fi-ss-user text-dark fw-bold"></i> ' . htmlspecialchars($value->job_name, ENT_QUOTES, 'UTF-8') . '</li>' : '') . '</ul>';
            $value->location_name = '<ul style="list-style: none; padding: 0; margin: 0;">' . (!empty(optional($value->location)->company_name) ? '<li><i class="fi fi-ss-land-layer-location text-dark fw-bold"></i> ' . htmlspecialchars(optional($value->location)->company_name, ENT_QUOTES, 'UTF-8') . '</li>' : '') . (!empty(optional($value->primary_user)->first_name) || !empty(optional($value->primary_user)->last_name) ? '<li><i class="fi fi-rr-user text-dark fw-bold"></i> ' . htmlspecialchars(optional($value->primary_user)->first_name, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars(optional($value->primary_user)->last_name, ENT_QUOTES, 'UTF-8') . '</li>' : '') . '</ul>';
            $value->status = '<div class="status-text-top text-center mb-2">' . $day . '</div><div class="progress mb-3">
                <div class="progress-bar shadow-none fw-bold" role="progressbar" style="width: 50%; background-color: rgba(156, 156, 208, 0.71);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar shadow-none fw-bold" role="progressbar" style="width: 50%; background-color: rgba(144, 183, 212, 0.49);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                
                </div><div class="status-text-bottom text-center mb-1 text-dark fw-bold" style="font-size:8pt"> Initiated On ' . $holdDate . '&nbsp;&nbsp;' . $statusText . ' </div>';
            $value->notes = "<a href='javascript:void(0);' class='text-secondary' style='display: block; margin-bottom: 10px;'><div style='display: flex; align-items: center; gap: 10px;'>" . (!empty($value->internal_notes) ? "<i class='fi fi-rr-note-sticky text-dark fw-bold fs-3' data-bs-toggle='tooltip' data-bs-placement='top' title='Internal Notes: " . htmlspecialchars($value->internal_notes, ENT_QUOTES, 'UTF-8') . "'></i>" : "") . (!empty($value->printed_notes) ? "<i class='fi fi-rr-note text-dark fw-bold fs-3' data-bs-toggle='tooltip' data-bs-placement='top' title='Printed Notes: " . htmlspecialchars($value->printed_notes, ENT_QUOTES, 'UTF-8') . "'></i>" : "") . "</div></a>";
            $taxDetails = $this->getTaxDetail($value->id);
            $value->taxAmount = $taxDetails['taxAmount'];
            $value->taxCode = $taxDetails['taxCode'];
            return $value;
        });

        // Response for DataTable
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        ];

        return response()->json($response);
    }
}
