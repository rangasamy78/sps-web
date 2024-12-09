<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\SupplierInvoice;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class SupplierInvoiceRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return SupplierInvoice::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SupplierInvoice::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SupplierInvoice::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getSupplierInvoiceList($request)
    {
        $query = SupplierInvoice::query();

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
        $columnName      = 'created_at';
        $supplier   = $this->getSupplierInvoiceList($request);
        $total           = $supplier->count();
        $totalFilter     = $this->getSupplierInvoiceList($request);
        $totalFilter     = $totalFilter->count();
        $arrData         = $this->getSupplierInvoiceList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno           = ++$i;
            $value->id = $value->id ?? '';
            $value->sipl_bill = $value->sipl_bill ?? '';
            $value->po_id = $value->po_id ?? '';
            $value->entry_date = $value->entry_date ?? '';
            $value->invoice = $value->invoice ?? '';
            $value->payment_term_id = $value->payment_term_id ?? '';
            $value->supplier_so = $value->supplier_so ?? '';
            $value->container_number = $value->container_number ?? '';
            $value->sipl_status = $value->sipl_status ?? '';
            $value->ship_to_location_id = $value->ship_to_location_id ?? '';
            $value->ship_date = $value->ship_date ?? '';
            $value->freight_forwarder_id = $value->freight_forwarder_id ?? '';
            $value->item_total = $value->item_total ?? '';
            $value->status = '';
            $value->received_date = '';
            $value->balance_due = '';
            $value->action        = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
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
