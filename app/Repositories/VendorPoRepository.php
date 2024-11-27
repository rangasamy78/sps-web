<?php

namespace App\Repositories;

use App\Models\Service;
use App\Models\VendorPo;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Models\VendorPoNewBill;
use App\Models\VendorPoDetails;
use App\Models\VendorPoPrepayment;
use App\Models\VendorPoNewBillDetail;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class VendorPoRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return VendorPo::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return VendorPo::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = VendorPo::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function dataFetchFromservice($request)
    {
        return Service::with('unit_measure')
            ->where('service_name', 'LIKE', '%' . $request->search . '%')
            ->get()
            ->map(function ($service) {
                return [
                    'id'                 => $service->id,
                    'service_name'       => $service->service_name,
                    'unit_of_measure_id' => $service->unit_measure->id ?? null,
                    'unit_measure_name'  => $service->unit_measure->unit_measure_name ?? null,
                ];
            });
    }
    public function getVendorPoList($request)
    {
        $query = VendorPo::with('vendor_po_details');
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
        $associate  = $this->getVendorPoList($request);
        $total      = $associate->count();

        $totalFilter = $this->getVendorPoList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getVendorPoList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                = ++$i;
            $value->transaction_number = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . ($value->transaction_number ?? '') . "</a>";
            $formattedDate             = $value->transaction_date ? \Carbon\Carbon::parse($value->transaction_date)->format('d-m-Y') : '';
            $value->transaction_date   = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . $formattedDate . "</a>";
            $value->vendor_id          = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . ($value->vendor->expenditure_name ?? '') . "</a>";
            $value->cust_ref           = "";
            $formattedEtaDate          = $value->eta_date ? \Carbon\Carbon::parse($value->eta_date)->format('d-m-Y') : '';
            $value->eta_date           = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . $formattedEtaDate . "</a>"; $value->payment_term_id           = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->payment_terms->payment_label ?? '') . "</a>";
            $value->phone_combined     = trim(
                (isset($value->phone) && !empty($value->phone) ?
                    "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>P:" . $value->phone . "</a><br>" : '') .
                (isset($value->fax) && !empty($value->fax) ?
                    "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>F:" . $value->fax . "</a><br>" : '') .
                (isset($value->email) && !empty($value->email) ?
                    "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>E:" . $value->email . "</a><br>" : '')
            );

            $value->extended_total = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . ($value->extended_total ?? '') . "</a>";
            $value->internal_notes = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . ($value->internal_notes ?? '') . "</a>";

            $value->status = $value->status == 'Pending'
            ? '<button class="btn btn-warning btn-sm change_status" data-id="' . $value->id . '">' . $value->status . '</button>'
            : '<button class="btn btn-' . ($value->status == 'Fullfilled' ? 'success' : 'danger') . ' btn-sm change_status" data-id="' . $value->id . '">' . $value->status . '</button>';

            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i></button>
                <div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='" . route('vendor_pos.details', $value->id) . "' data-id='" . $value->id . "' >
                <i class='bx bx-show me-1 icon-warning'></i> Show</a>
                <a class='dropdown-item editbtn text-success' href='" . route('vendor_pos.edit', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
                <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }
    public function dataFetchFromVendor($id)
    {
        $expenditure = Expenditure::where('id', $id)->first();
        return $expenditure;
    }

    public function getVendorPoDetailsList($request)
    {
        $query = VendorPoDetails::with('service');
        return $query;
    }

    public function dataTablePoDetails(Request $request)
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
        $associate  = $this->getVendorPoDetailsList($request);
        $total      = $associate->count();

        $totalFilter = $this->getVendorPoDetailsList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getVendorPoDetailsList($request);

        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                = ++$i;
            $value->transaction_number = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . ($value->transaction_number ?? '') . "</a>";
            $formattedDate             = $value->transaction_date ? \Carbon\Carbon::parse($value->transaction_date)->format('d-m-Y') : '';
            $value->transaction_date   = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . $formattedDate . "</a>";
            $value->vendor_id          = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . ($value->vendor->expenditure_name ?? '') . "</a>";
            $value->cust_ref           = "";
            $formattedEtaDate          = $value->eta_date ? \Carbon\Carbon::parse($value->eta_date)->format('d-m-Y') : '';
            $value->eta_date           = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . $formattedEtaDate . "</a>"; $value->payment_term_id           = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->payment_terms->payment_label ?? '') . "</a>";
            $value->phone_combined     = trim(
                (isset($value->phone) && !empty($value->phone) ?
                    "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>P:" . $value->phone . "</a><br>" : '') .
                (isset($value->fax) && !empty($value->fax) ?
                    "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>F:" . $value->fax . "</a><br>" : '') .
                (isset($value->email) && !empty($value->email) ?
                    "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>E:" . $value->email . "</a><br>" : '')
            );

            $value->extended_total = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . ($value->extended_total ?? '') . "</a>";
            $value->internal_notes = "<a href='" . route('vendor_pos.details', $value->id) . "' class='text-secondary'>" . ($value->internal_notes ?? '') . "</a>";

            $value->status = $value->status == 'Pending'
            ? '<button class="btn btn-warning btn-sm change_status" data-id="' . $value->id . '">' . $value->status . '</button>'
            : '<button class="btn btn-' . ($value->status == 'Fullfilled' ? 'success' : 'danger') . ' btn-sm change_status" data-id="' . $value->id . '">' . $value->status . '</button>';

            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i></button>
                <div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='" . route('vendor_pos.details', $value->id) . "' data-id='" . $value->id . "' >
                <i class='bx bx-show me-1 icon-warning'></i> Show</a>
                <a class='dropdown-item editbtn text-success' href='" . route('vendor_pos.edit', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
                <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function storePayment(array $data)
    {
        return VendorPoPrepayment::query()
            ->create($data);
    }

    public function storenewBill(array $data)
    {
        return VendorPoNewBill::query()
            ->create($data);
    }

    public function storenewBillDetail(array $detailData)
    {
        return VendorPoNewBillDetail::query()
            ->create($detailData);
    }

}