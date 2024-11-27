<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductSupplier;
use App\Interfaces\EmailServiceInterface;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\PrePurchaseRequestSupplierRequest;

class PrePurchaseRequestSupplierRequestRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    protected $emailService;

    public function __construct(EmailServiceInterface $emailService)
    {
        $this->emailService = $emailService;
    }

    public function findOrFail(int $id)
    {
        return PrePurchaseRequestSupplierRequest::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $products        = $data['product'];
        $supplierRequest = PrePurchaseRequestSupplierRequest::create($data);
        if (!empty($products)) {
            $this->bulkProductUpdateOrCreate($products, $data['supplier_id']);
        }
        if (!empty($data['is_check_email'])) {
            list($user, $supplier) = $this->getUserAndSupplier($data['supplier_id']);
            $this->sendEmailsIfRequired($supplierRequest, $products, $user, $supplier);
        }
        return $supplierRequest;
    }

    public function update(array $data, int $id)
    {
        $supplierRequest        = $this->findOrFail($id);
        $data['resend_request'] = $supplierRequest->resend_request + 1;
        $query                  = $supplierRequest->update($data);
        $products               = $data['product'];
        if (!empty($data['is_check_email'])) {
            list($user, $supplier) = $this->getUserAndSupplier($data['supplier_id']);
            $this->sendEmailsIfRequired($supplierRequest, $products, $user, $supplier);
        }
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function buildBaseQuery($request)
    {
        return PrePurchaseRequestSupplierRequest::query()->where('pre_purchase_request_id', $request->id)->with(['supplier']);
    }

    public function getPrePurchaseRequestSupplierRequestList(Request $request)
    {
        $query = $this->buildBaseQuery($request);
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
        $countries  = $this->getPrePurchaseRequestSupplierRequestList($request);
        $total      = $countries->count();

        $totalFilter = $this->getPrePurchaseRequestSupplierRequestList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPrePurchaseRequestSupplierRequestList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {

            $status                = $value->status == 1 ? "checked" : "";
            $value->sno            = ++$i;
            $value->requested_date = toDbDateDisplay($value->created_at);
            $value->requested_sent = $value->resend_request ?? 0;
            $value->supplier_name  = $this->getSupplierDetails($value->supplier);
            $value->response_date  = $value->update_response == 1 ? toDbDateDisplay($value->response_ship_date) : 'No Response';
            $value->status         = $status == "checked" ? 'Response Obtained' : 'N/A';
            $value->compare        = "<input type='checkbox' name='compare[]' class='supplierCompare' id='compare_{$i}' data-id='{$value->pre_purchase_request_id}' data-status='{$value->status}' value='{$value->supplier_id}' " . ($status ?: 'disabled') . "   />";
            $value->request        = $status != "checked" ? "<a class='btn btn-warning' href='" . route('pre_purchase_supplier_requests.edit', $value->id) . "?id=" . $value->pre_purchase_request_id . "'>Request</a>" : '';
            $value->response       = "<a class='btn-warning btn' href='" . route('pre_purchase_response.create', ['pre_purchase_response_id' => $value->id]) . "'>Response</a>";
            $value->action         = "<div class='dropup'>
            <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i>
            </button>
            <div class='dropdown-menu'>
                <a class='dropdown-item showbtn text-warning' href='" . route('pre_purchase_requests.show', $value->id) . "'>
                    <i class='bx bx-show me-1 icon-warning'></i> Show
                </a>
                <a class='dropdown-item editbtn text-success' href='" . route('pre_purchase_requests.edit', $value->id) . "'>
                    <i class='bx bx-edit-alt me-1 icon-success'></i> Edit
                </a>
                <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "'>
                    <i class='bx bx-trash me-1 icon-danger'></i> Delete
                </a>
            </div>
        </div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function getSupplierDetails($value)
    {
        $result = !empty($value) ? $value['supplier_name'] . " ( " . $value['code'] . " )" : '';
        return $result;
    }

    public function getUserDetails($user)
    {
        $result = !empty($user) ? $user['full_name'] : '';
        return $result;
    }

    public function multipleStore(array $data)
    {
        $requested_by_id         = $data['requested_by_id'];
        $email_body              = $data['email_body'];
        $pre_purchase_request_id = $data['pre_purchase_request_id'];
        $multipleRecords         = $data['multiple_request'];
        $products                = $data['product'];
        if (!empty($multipleRecords)) {
            foreach ($multipleRecords as $record) {
                $data['supplier_id']             = $record['supplier_id'];
                $data['supplier_address']        = $record['supplier_address'];
                $data['supplier_suite']          = $record['supplier_suite'];
                $data['supplier_city']           = $record['supplier_city'];
                $data['supplier_state']          = $record['supplier_state'];
                $data['supplier_zip']            = $record['supplier_zip'];
                $data['supplier_country_id']     = $record['supplier_country_id'];
                $data['payment_term_id']         = $record['payment_term_id'];
                $data['shipment_term_id']        = $record['shipment_term_id'];
                $data['pre_purchase_request_id'] = $pre_purchase_request_id;
                $data['email']                   = $record['email'];
                $data['email_body']              = $email_body;
                $data['required_ship_date']      = Carbon::today()->toDateString();
                $data['requested_by_id']         = $requested_by_id;
                $data['resend_request']          = 1;
                $supplierRequest                 = PrePurchaseRequestSupplierRequest::create($data);
                $this->bulkProductUpdateOrCreate($products, $record['supplier_id']);
                list($user, $supplier) = $this->getUserAndSupplier($record['supplier_id']);
                $this->sendEmailsIfRequired($supplierRequest, $products, $user, $supplier);

            }
        }
        return $supplierRequest;
    }

    public function bulkProductUpdateOrCreate(array $data, $supplier_id)
    {
        $records = [];
        foreach ($data as $key => $item) {
            $item['supplier_id'] = $supplier_id;
            $records[]           = ProductSupplier::create($item);
        }
        return $records;
    }

    public function sendEmailsIfRequired($supplierRequest, $products, $user, $supplier)
    {
        $records = PrePurchaseRequestSupplierRequest::query()
            ->with(['supplier', 'user', 'shipment_term', 'account_payment_term', 'country'])
            ->findOrFail($supplierRequest->id);

        $details = [
            'subject'  => 'Supplier Request Product Mail',
            'content'  => $records,
            'products' => $products,
        ];
        // Send emails
        $this->emailService->sendToUser($user, $details);
        $this->emailService->sendToSupplier($supplier, $details);
    }

    public function getUserAndSupplier($supplier_id)
    {
        $user = auth()->user();
        $supplier = Supplier::findOrFail($supplier_id);

        return [$user, $supplier];
    }
}
