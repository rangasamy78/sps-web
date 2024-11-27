<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\VendorPoNewBill;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class FreightBillRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return VendorPoNewBill::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return VendorPoNewBill::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = VendorPoNewBill::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getFreightBillList($request)
    {
        $query = VendorPoNewBill::query();
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
        $freight    = $this->getFreightBillList($request);
        $total      = $freight->count();

        $totalFilter = $this->getFreightBillList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getFreightBillList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                 = ++$i;
            $value->vendor_po_id        = $value->vendor_po_id ?? '';
            $value->transaction_number  = $value->transaction_number ?? '';
            $value->invoice_date        = $value->invoice_date ?? '';
            $value->due_date            = $value->due_date ?? '';
            $value->invoice_number      = $value->invoice_number ?? '';
            $value->payments_terms_id   = $value->payments_terms_id ?? '';
            $value->contact_location_id = $value->contact_location_id ?? '';
            $value->hold_payment_check  = $value->hold_payment_check ?? '';
            $value->hold_payment_reason = $value->hold_payment_reason ?? '';
            $value->extended_total      = $value->extended_total ?? '';
            $value->bill_inv            = '';
            $value->purchse_order       = '';
            $value->location            = '';
            $value->supplier            = '';
            $value->balance             = '';
            $value->sipl_inv            = '';
            $value->sipl_inv_dt         = '';
            $value->sipl_ship_dt        = '';
            $value->container           = '';
            $value->sipl_amount         = 0;
            $value->action              = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
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