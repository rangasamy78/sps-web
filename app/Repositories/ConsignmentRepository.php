<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Consignment;
use Illuminate\Http\Request;

class ConsignmentRepository
{
    public function findOrFail(int $id)
    {
        return Consignment::where('consignment_location_id', $id)->firstOrFail();
    }

    public function store(array $data)
    {
        return Consignment::query()
            ->create($data);
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getConsignmentList(Request $request, $status)
    {
        $query_consignment = Customer::with('customer_type', 'parent_location', 'sales_person', 'secondary_sales_person', 'price_list_label', 'payment_term', 'sales_tax');
        if ($status == 1) {
            $query_consignment->where('status', $status)
                ->whereIn('id', Consignment::pluck('consignment_location_id'));
        } elseif ($status == 0) {
            $query_consignment->where('status', $status);
        } elseif ($status == 2) {
            $query_consignment->whereIn('id', Consignment::pluck('consignment_location_id'));
        }
        // Apply additional filters from the request
        if (!empty($request->consignmentLocationFilter)) {
            $query_consignment->whereIn('customer_name', (array) $request->consignmentLocationFilter);
        }
        if (!empty($request->codeFilter)) {
            $query_consignment->whereIn('customer_code', (array) $request->codeFilter);
        }
        if (!empty($request->contactNameFilter)) {
            $query_consignment->whereIn('contact_name', (array) $request->contactNameFilter);
        }
        if (!empty($request->parentLocationFilter)) {
            $query_consignment->whereIn('parent_location_id', (array) $request->parentLocationFilter);
        }
        if (!empty($request->dateFilter)) {
            $formattedDate = Carbon::createFromFormat('d-M-Y', $request->dateFilter)->format('Y-m-d');
            $query_consignment->whereDate('updated_at', $formattedDate);
        }
        if (!empty($request->typeFilter)) {
            $query_consignment->whereIn('customer_type_id', (array) $request->typeFilter);
        }
        if (!empty($request->billingAddressFilter)) {
            $query_consignment->whereIn('address', (array) $request->billingAddressFilter);
        }
        if (!empty($request->shippingAddressFilter)) {
            $query_consignment->whereIn('shipping_address', (array) $request->shippingAddressFilter);
        }
        if (!empty($request->phone1Filter)) {
            $query_consignment->whereIn('phone', (array) $request->phone1Filter);
        }
        if (!empty($request->phone2Filter)) {
            $query_consignment->whereIn('phone_2', (array) $request->phone2Filter);
        }
        if (!empty($request->mobileFilter)) {
            $query_consignment->whereIn('mobile', (array) $request->mobileFilter);
        }
        if (!empty($request->saleFilter)) {
            $query_consignment->whereIn('sales_person_id', (array) $request->saleFilter);
        }
        if (!empty($request->priceLevelFilter)) {
            $query_consignment->whereIn('price_list_label_id', (array) $request->priceLevelFilter);
        }
        if (!empty($request->paymentTermFilter)) {
            $query_consignment->whereIn('payment_terms_id', (array) $request->paymentTermFilter);
        }
        if (!empty($request->taxFilter)) {
            $query_consignment->whereIn('sales_tax_id', (array) $request->taxFilter);
        }
        return $query_consignment;
    }

    public function generateLink($id, $text)
    {
        return "<a href='" . route('customers.show', $id) . "' class='text-secondary'>" . $text . "</a>";
    }

    public function dataTable(Request $request, $status)
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
        $Consignment   = $this->getConsignmentList($request, $status);
        $total      = $Consignment->count();

        $totalFilter = $this->getConsignmentList($request, $status);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getConsignmentList($request, $status);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->customer_id = $value->id ?? null;
            $value->customer_name = $this->generateLink($value->id, $value->customer_name ?? '');
            $value->parent_location_id = $this->generateLink($value->id, $value->parent_location->company_name ?? '');
            $value->address = $this->generateLink($value->id, $value->address ?? '');
            $value->shipping_address = $this->generateLink($value->id, $value->shipping_address ?? '');
            $value->phone = $this->generateLink($value->id, $value->phone ?? '');
            $value->mobile = $this->generateLink($value->id, $value->mobile ?? '');
            $value->price_list_label_id = $value->price_list_label ? $value->price_list_label->price_level . ' - ' . $value->price_list_label->price_code : '';
            $value->sales_person_id = $this->generateLink($value->id, '<ul class="list-unstyled mb-0"><li class=""><i class="fi fi-rr-user text-dark"data-bs-toggle="tooltip" title="Primary Sales Person"></i>: ' . htmlspecialchars($value->sales_person->first_name ?? '') . ' ' . htmlspecialchars($value->sales_person->last_name ?? '') . '</li><li class=""><i class="fi fi-rr-user text-danger"data-bs-toggle="tooltip" title="Secondary Sales Person"></i>: ' . htmlspecialchars($value->secondary_sales_person->first_name ?? '') . ' ' . htmlspecialchars($value->secondary_sales_person->last_name ?? '') . '</li><li><i class="fi fi-rr-label text-info" data-bs-toggle="tooltip" title="Price Label"></i>: ' . htmlspecialchars($value->price_list_label_id) . '</li></ul>');
            $value->payment_terms_id = $this->generateLink($value->id, '<ul class="list-unstyled mb-0"><li class=""><i class="fi fi-rr-payment-pos text-dark"data-bs-toggle="tooltip" title="Payment Terms"></i>: ' . htmlspecialchars($value->payment_term->payment_label ?? '' ?? '') . '</li><li class=""><i class="fi fi-rr-calculator-math-tax text-danger"data-bs-toggle="tooltip" title="Secondary Sales Person"></i>: ' . htmlspecialchars($value->sales_tax->account_name ?? '') . '</li></ul>');
            $value->sales_tax_id = $this->generateLink($value->id, $value->sales_tax_id ?? '');
            $value->internal_notes = $this->generateLink($value->id, '<span class="d-inline-block me-2" data-bs-toggle="tooltip" title="Internal Note: ' . htmlspecialchars($customer->internal_notes ?? '') . '"><i class="fi fi-rr-clipboard fs-4 text-warning"></i></span>');
            $value->details = '<i class="fi fi-rr-attention-detail fs-4"></i>';
            $value->consignment_date = $this->generateLink($value->id, $value->updated_at ? Carbon::parse($value->updated_at)->format('d-M-Y') : '');
            $value->consignment_type = $this->generateLink($value->id, $value->customer_type->customer_type_name ?? '');
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getCustomerList(Request $request)
    {
        $query_customer_list = Customer::query();
        if (!empty($request->customer_name)) {
            $query_customer_list->whereIn('customer_name', (array) $request->customer_name);
        }
        if (!empty($request->code)) {
            $query_customer_list->whereIn('customer_code', (array) $request->code);
        }
        if (!empty($request->contact_input)) { // Assuming the input field is named 'phone_contact_name'
            $query_customer_list->where(function ($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->contact_input . '%')
                    ->orWhere('contact_name', 'like', '%' . $request->contact_input . '%');
            });
        }
        return $query_customer_list;
    }

    public function dataTableCustomerList(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName      = 'created_at';
        $countries       = $this->getCustomerList($request);
        $total           = $countries->count();

        $totalFilter     = $this->getCustomerList($request);
        $totalFilter     = $totalFilter->count();

        $arrData         = $this->getCustomerList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->customer_name          = $value->customer_name ?? '';
            $value->address = $value->address ?? '';
            $value->phone = $value->phone ?? '';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    // create consignment customer list
    public function getCreateConsignmentList(Request $request, $status)
    {
        $query = Customer::query();
        // Filter by status and consignment location ID
        if ($status == 1) {
            $query->where('status', $status)
                ->whereIn('id', Consignment::pluck('consignment_location_id'));
        } elseif ($status == 0) {
            $query->where('status', $status);
        } elseif ($status == 2) {
            $query->whereIn('id', Consignment::pluck('consignment_location_id'));
        }
        // Apply additional filters from the request
        if (!empty($request->customer_name)) {
            $query->whereIn('customer_name', (array) $request->customer_name);
        }
        if (!empty($request->contact_name)) {
            $query->whereIn('contact_name', (array) $request->contact_name);
        }
        if (!empty($request->address)) {
            $query->whereIn('address', (array) $request->address);
        }
        if (!empty($request->phone)) {
            $query->where(function ($q) use ($request) {
                $q->whereIn('phone', (array) $request->phone)
                    ->orWhereIn('phone_2', (array) $request->phone);
            });
        }
        // Return DataTable JSON response
        return $query;
    }

    public function dataTableCreateCustomerList(Request $request, $status)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex = $orderArray[0]['column'] ?? 0;
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';
        $query = $this->getCreateConsignmentList($request, $status);
        $total = $query->count();
        $totalFilter = $query->count(); // Count after filtering (if any)
        $arrData = $query->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        // Map data for response
        $arrData = $arrData->map(function ($value) {
            return [
                'customer_name' => '<a href="' . route('customers.show', $value->id) . '" class="text-secondary">' . ($value->customer_name ?? '') . '</a>',
                'address' => '<a href="' . route('customers.show', $value->id) . '" class="text-secondary">' . ($value->address ?? '') . '</a>',
                'contact_name' => '<a href="' . route('customers.show', $value->id) . '" class="text-secondary">' . ($value->contact_name ?? '') . '</a>',
                'phone' => '<ul class="list-unstyled mb-0">' .
                    (!empty($value->phone) ? '<li><strong>P1:</strong> ' . $value->phone . '</li>' : '') .
                    (!empty($value->phone_2) ? '<li><strong>P2:</strong> ' . $value->phone_2 . '</li>' : '') .
                    '</ul>',
                'qty' => 0,
                'action' => "<a class='dropdown-item showbtn text-danger' href='" . route('customers.show', $value->id) . "' data-id='" . $value->id . "'><i class='fi fi-rr-cross-circle fs-3'></i></a>",
            ];
        });
        // Prepare the response
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        ];
        return response()->json($response);
    }
}
