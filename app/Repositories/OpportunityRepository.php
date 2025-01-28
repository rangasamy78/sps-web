<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Hold;
use App\Models\Visit;
use App\Models\Quote;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Associate;
use App\Models\SampleOrder;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class OpportunityRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Opportunity::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        if (!isset($data['pick_is_do_not_send_email'])) {
            $data['pick_is_do_not_send_email'] = 0;
        }
        if (!isset($data['delivery_is_do_not_send_email'])) {
            $data['delivery_is_do_not_send_email'] = 0;
        }
        if (!isset($data['contact_mode'])) {
            $data['contact_mode'] = 0;
        }
        return Opportunity::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = Opportunity::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getOpportunityList($request)
    {
        $query = Opportunity::with(['primary_user', 'secondary_user', 'customer', 'end_use_segment', 'project_type']);
        return $query;
    }

    function getAssociate($id)
    {
        $associate = Associate::find($id);
        return $id ? "$associate->associate_name" : 'N/A'; // E
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
        $Opportunity   = $this->getOpportunityList($request);
        $total      = $Opportunity->count();

        $totalFilter = $this->getOpportunityList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getOpportunityList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->opportunity_code           = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary'>" . ($value->opportunity_code ?? '') . "</a>";
            $value->opportunity_date           = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary'>" . ($value->opportunity_date ?? '') . "</a>";
            $value->delivery_ship_to_name      = sprintf("<a href='%s' class='text-secondary'><ul style='list-style-type: none; padding: 0; margin: 0;'><li>%s</li><li>%s</li></ul></a>", route('opportunities.show', $value->id), e($value->delivery_ship_to_name ?? ''), e($value->delivery_mobile ?? ''));
            $value->delivery                   = $value->delivery_method;
            $value->customer_1                 = "<a href='" . route('opportunities.show', $value->id) . "'class='text-secondary'>" . ($value->customer->customer_name ?? '') . "</a>";
            $value->location                   = "<a href='" . route('opportunities.show', $value->id) . "'class='text-secondary'>" . (Company::find($value->customer->parent_location_id)->company_name ?? '') . "</a>";
            $value->endUseSegment              = "<a href='" . route('opportunities.show', $value->id) . "'class='text-secondary'>" . ($value->end_use_segment->end_use_segment ?? '') . "</a>";
            $value->projectTypeName            = "<a href='" . route('opportunities.show', $value->id) . "'class='text-secondary'>" . ($value->project_type->project_type_name ?? '') . "</a>";
            $value->sales_person = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary'><ul style='list-style-type: none; padding: 0; margin: 0;'><li><i class='fi fi-rr-user'></i> " . e($value->primary_user?->first_name ?? '') . "</li><li><i class='fi fi-rr-user'></i> " . e($value->secondary_user?->first_name ?? '') . "</li></ul></a>";
            $value->associates = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary'><ul style='list-style-type: none; padding: 0; margin: 0;font-size:8pt'><li><i class='fi fi-rr-user'></i> " . e($this->getAssociate($value->fabricator_id)) . "</li><li><i class='fi fi-rr-user'></i> " . e($this->getAssociate($value->designer_id)) . "</li><li><i class='fi fi-rr-user'></i> " . e($this->getAssociate($value->builder_id)) . "</li></ul></a>";
            $value->days = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary'>" . ($value->opportunity_code ?? '') . " (" . Carbon::parse($value->created_at)->diffInDays(Carbon::now()) . " days)</a>";
            $value->sub_transaction = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary' style='display: block; margin-bottom: 10px;'><div style='display: flex; align-items: center; gap: 10px;'><span>" . e($value->primary_user?->first_name ?? '') . "</span><img src='" . asset('public/images/get-quotes.png') . "' alt='Image 1' style='width: 30px; height: 30px;'><img src='" . asset('public/images/location.png') . "' alt='Image 2' style='width: 30px; height: 30px;'><img src='" . asset('public/images/privacy.png') . "' alt='Image 3' style='width: 30px; height: 30px;'><img src='" . asset('public/images/get-quotes.png') . "' alt='Image 4' style='width: 30px; height: 30px;'></div></a>";
            $value->internal_notes             = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary'>" . ($value->internal_notes ?? '') . "</a>";
            $value->action                     = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='" . route('opportunities.show', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success'  href='" . route('opportunities.edit', $value->id) . "' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a></div> </div>";
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function getCustomerList($request)
    {
        $query = Customer::query();
        if (!empty($request->customerName)) {
            $query->where('customer_name', 'like', '%' . $request->customerName . '%');
        }
        if (!empty($request->customerCode)) {
            $query->where('customer_code', 'like', '%' . $request->customerCode . '%');
        }
        if (!empty($request->contact)) {
            $query->where('phone', 'like', '%' . $request->contact . '%');
        }
        return $query;
    }

    public function dataTableAllCustomer(Request $request)
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
        $Opportunity   = $this->getCustomerList($request);
        $total      = $Opportunity->count();
        $totalFilter = $this->getCustomerList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getCustomerList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->id        = $value->id ?? '';
            $value->customer_name                = $value->customer_name ?? '';
            $value->customer_code                = $value->customer_code ?? '';
            $value->address                      = $value->address ?? '';
            $value->address_2                    = $value->address_2 ?? '';
            $value->city                         = $value->city ?? '';
            $value->zip                          = $value->zip ?? '';
            $value->country_id                   = $value->country_id ?? '';
            $value->fax                          = $value->fax ?? '';
            $value->phone                        = $value->phone ?? '';
            $value->mobile                       = $value->mobile ?? '';
            $value->email                        = $value->email ?? '';
            $value->price_list_label_id          = $value->price_list_label_id ?? '';
            $value->sales_person_id              = $value->sales_person_id ?? '';
            $value->secondary_sales_person_id    = $value->secondary_sales_person_id ?? '';
            $value->sales_tax_id                 = $value->sales_tax_id ?? '';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getAssociateList($request)
    {
        $query = Associate::query();
        if (!empty($request->associateName)) {
            $query->where('associate_name', 'like', '%' . $request->associateName . '%');
        }
        if (!empty($request->associateCode)) {
            $query->where('associate_code', 'like', '%' . $request->associateCode . '%');
        }
        if (!empty($request->contact)) {
            $query->where('primary_phone', 'like', '%' . $request->contact . '%');
        }
        return $query;
    }

    public function dataTableAllAssociate(Request $request)
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
        $Opportunity   = $this->getAssociateList($request);
        $total      = $Opportunity->count();
        $totalFilter = $this->getAssociateList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getAssociateList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->id                    = $value->id ?? '';
            $value->associate_name        = $value->associate_name ?? '';
            $value->associate_code        = $value->associate_code ?? '';
            $value->primary_phone                 = $value->phone ?? '';
            $value->address               = $value->address ?? '';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    //pop up ship to 
    public function getShipToList(Request $request, $id)
    {
        $query = Contact::join('customers', 'contacts.type_id', '=', 'customers.id')
            ->where('customers.id', $id)
            ->where('contacts.type', 'customer')
            ->where('contacts.is_ship_to_address', '=', 1)
            ->select(
                'customers.id',
                'customers.customer_name',
                'customers.customer_code',
                'customers.address',
                'contacts.contact_name',
                'contacts.id as contact_id',
                'contacts.tax_code_id'
            );

        if (!empty($request->name)) {
            $query->where('contacts.contact_name', 'like', '%' . $request->name . '%');
        }
        if (!empty($request->code)) {
            $query->where('customers.customer_code', 'like', '%' . $request->code . '%');
        }
        return $query->get();
    }


    public function dataTableAllShipTo(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'] ?? 'created_at';
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';
        $opportunity = $this->getShipToList($request, $id);
        $total       = $opportunity->count();
        $filteredData = $opportunity->skip($start)->take($rowPerPage)->sortBy($columnName, SORT_REGULAR, $columnSortOrder === 'desc');
        $arrData = $filteredData->map(function ($value) {
            $value->id = $value->contact_id ?? '';
            $value->tax_code_id = $value->tax_code_id ?? '';
            $value->customer_name = ($value->customer_name ?? '') . ' ' . ($value->contact_name ?? '');
            $value->customer_name_1 = ($value->customer_name ?? '');
            $value->customer_code = $value->customer_code ?? '';
            $value->address = $value->address ?? '';
            return $value;
        });
        $response = [
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $arrData->values(),
        ];

        return response()->json($response);
    }

    //subtransactions 
    public function getSubtransactionList($id)
    {
        if (!$id) {
            throw new \InvalidArgumentException('Opportunity ID is required');
        }

        $currentDate = Carbon::now();

        // Fetch data from all models and map
        $visits = Visit::with('project_type', 'end_use_segments')->where('opportunity_id', $id)->get()->map(function ($visit, $index) use ($currentDate) {
            $visitDate = Carbon::parse($visit->visit_date);
            $visitTime = Carbon::parse($visit->visit_time);
            $checkoutStatus = ($visit->checkout == 1)
                ? '<span class="text-danger fw-bold">(Closed)</span>'
                : '';
            return [
                'date' => $visitDate->format('M d, Y'),
                'time' => $visitTime->format('g:i a'),
                'days' => $visitDate->diffInDays($currentDate),
                'expiryDate' => null,
                'transaction' => "<a class='dropdown-item showbtn text-dark fw-bold' href='" . route('visits.show', $visit->id) . "' data-id='{$visit->id}'>Visit {$checkoutStatus}: {$visit->id}-" . ($index + 1) . "</a>",
                'projectType' => $visit->project_type->project_type_name ?? null,
                'endUseSegment' => $visit->end_use_segment_id->end_use_segment ?? null,
                'label' => $visit->visit_label,
                'total' => $visit->total,
                'salesOrder' => null,
                'name' => 'visit',
                'action' => "<a class='dropdown-item showbtn text-dark' href='" . route('visits.edit', $visit->id) . "' data-id='{$visit->id}'><i class='fi fi-rr-pen-circle fs-3'></i></a>",
            ];
        });

        $sampleOrders = SampleOrder::with('project_type', 'end_use_segments')->where('opportunity_id', $id)->get()->map(function ($sampleOrder, $index) use ($currentDate) {
            $orderDate = Carbon::parse($sampleOrder->sample_order_date);
            $orderTime = Carbon::parse($sampleOrder->sample_order_time);
            return [

                'date' => $orderDate->format('M d, Y'),
                'time' => $orderTime->format('g:i a'),
                'days' => $orderDate->diffInDays($currentDate),
                'expiryDate' => null,
                'transaction' => "<a class='dropdown-item showbtn text-dark fw-bold' href='" . route('create.sample_orders.show', $sampleOrder->id) . "' data-id='{$sampleOrder->id}'>Sample Order: " . ($sampleOrder->id) . '-' . ($index + 1) . "</a>",
                'projectType' => $sampleOrder->project_type->project_type_name ?? null,
                'endUseSegment' => $sampleOrder->end_use_segment_id->end_use_segment ?? null,
                'label' => $sampleOrder->sample_order_label,
                'total' => $sampleOrder->total,
                'salesOrder' => null,
                'name' => 'sampleOrder',
                'action' => "<a class='dropdown-item showbtn text-dark' href='" . route('create.sample_orders.edit', $sampleOrder->id) . "' data-id='{$sampleOrder->id}'><i class='fi fi-rr-pen-circle fs-3'></i></a>",
            ];
        });

        $quotes = Quote::with('project_type', 'end_use_segments')->where('opportunity_id', $id)->get()->map(function ($quote, $index) use ($currentDate) {
            $quoteDate = Carbon::parse($quote->quote_date);
            $quoteTime = Carbon::parse($quote->quote_time);
            return [
                'date' => $quoteDate->format('M d, Y'),
                'time' => $quoteTime->format('g:i a'),
                'days' => $quoteDate->diffInDays($currentDate),
                'expiryDate' => $quote->expiry_date ? Carbon::parse($quote->expiry_date)->format('M d, Y') : null,
                'transaction' => "<a class='dropdown-item showbtn text-dark fw-bold' href='" . route('quote.quotes.show', $quote->id) . "' data-id='{$quote->id}'>Quote: " . ($quote->id) . '-' . ($index + 1) . "</a>",
                'projectType' => $quote->project_type->project_type_name ?? null,
                'endUseSegment' => $quote->end_use_segments->end_use_segment ?? null,
                'label' => $quote->quote_label,
                'total' => $quote->total,
                'salesOrder' => null,
                'name' => 'quote',
                'action' => "<a class='dropdown-item showbtn text-dark' href='" . route('quote.quotes.edit', $quote->id) . "' data-id='{$quote->id}'><i class='fi fi-rr-pen-circle fs-3'></i></a>",
            ];
        });

        $holds = Hold::with('project_type')->where('opportunity_id', $id)->get()->map(function ($hold, $index) use ($currentDate) {
            $holdDate = Carbon::parse($hold->hold_date);
            $holdTime = Carbon::parse($hold->hold_time);
            $expiryDate = $hold->expiry_date ? Carbon::parse($hold->expiry_date) : null;
            $releasedStatus = ($hold->is_released == 1)
                ? '<span class="text-danger fw-bold">Released:</span>'
                : '';
            $expiredStatus = ($expiryDate && $expiryDate->lt($currentDate))
                ? '<span class="text-danger">Hold Expired</span>'
                : '';
            $action = ($hold->is_released == 1)
                ? ''
                : "<a class='dropdown-item showbtn text-dark' href='" . route('hold.holds.edit', $hold->id) . "' data-id='{$hold->id}'><i class='fi fi-rr-pen-circle fs-3'></i></a>";
            return [
                'date' => $holdDate->format('M d, Y'),
                'time' => $holdTime->format('g:i a'),
                'days' => $holdDate->diffInDays($currentDate),
                'expiryDate' => $expiryDate ? $expiryDate->format('M d, Y') : null,
                'transaction' => "<a class='dropdown-item showbtn text-dark fw-bold' href='" . route('hold.holds.show', $hold->id) . "' data-id='{$hold->id}'>hold: " . ($hold->id) . '-' . ($index + 1) . " {$releasedStatus} {$expiredStatus}</a>",
                'projectType' => $hold->project_type->project_type_name ?? null,
                'endUseSegment' => null,
                'label' => $hold->hold_label,
                'total' => $hold->total,
                'salesOrder' => null,
                'name' => 'hold',
                'action' => $action,
            ];
        });
        return $visits->merge($sampleOrders)->merge($quotes)->merge($holds);
    }

    public function dataTableAllSubtransaction(Request $request, $id)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");

        $subtransactions = $this->getSubtransactionList($id);
        $totalRecords = $subtransactions->count();

        $filteredData = $subtransactions->slice($start, $rowPerPage)->values();

        return response()->json([
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $filteredData,
        ]);
    }
}
