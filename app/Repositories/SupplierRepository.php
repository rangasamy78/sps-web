<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Supplier::with('supplier_type', 'currency', 'location', 'language', 'payment_term', 'shipment_term')
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        if (!isset($data['form_1099_printed'])) {
            $data['form_1099_printed'] = 0;
        }
        if (!isset($data['multi_location_supplier'])) {
            $data['multi_location_supplier'] = 0;
        }
        return Supplier::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        if (!isset($data['form_1099_printed'])) {
            $data['form_1099_printed'] = 0;
        }
        if (!isset($data['multi_location_supplier'])) {
            $data['multi_location_supplier'] = 0;
        }
        $query = Supplier::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getSupplierList($request)
    {
        $query = Supplier::with(['supplier_type', 'currency', 'location', 'language', 'payment_term', 'supplier_port']);
        if (!empty($request->supplier_name_search)) {
            $query->where('supplier_name', 'like', '%' . $request->supplier_name_search . '%');
        }
        if (!empty($request->currency_search)) {
            $query->whereIn('currency_id', (array) $request->currency_search);
        }
        if (!empty($request->supplier_type_search)) {
            $query->whereIn('supplier_type_id', (array) $request->supplier_type_search);
        }
        if (!empty($request->address_search)) {
            $query->where('remit_address', 'like', '%' . $request->address_search . '%');
        }
        if (!empty($request->phone_search)) {
            $query->where('mobile', $request->phone_search);
        }
        if (!empty($request->location_search)) {
            $query->whereIn('parent_location_id', (array) $request->location_search);
        }
        if (!empty($request->payment_term_search)) {
            $query->whereIn('payment_terms_id', (array) $request->payment_term_search);
        }
        if (!empty($request->language_search)) {
            $query->whereIn('language_id', (array) $request->language_search);
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

        $columnName = 'created_at';
        $Supplier   = $this->getSupplierList($request);
        $total      = $Supplier->count();

        $totalFilter = $this->getSupplierList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSupplierList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->supplier_name = "<a href='" . route('suppliers.show', $value->id) . "' class='text-secondary    '>" . ($value->supplier_name ?? '') . "</a>";
            $value->currency_id        = "<a href='" . route('suppliers.show', $value->id) . "' class='text-secondary    '>" . ($value->currency ? $value->currency->currency_name : '') . "</a>";
            $value->supplier_type_id   = "<a href='" . route('suppliers.show', $value->id) . "' class='text-secondary    '>" . ($value->supplier_type ? $value->supplier_type->supplier_type_name : '') . "</a>";
            $value->remit_address      = "<a href='" . route('suppliers.show', $value->id) . "' class='text-secondary    '>" . ($value->remit_address ?? '') . "</a>";
            $value->mobile             = "<a href='" . route('suppliers.show', $value->id) . "' class='text-secondary    '>" . ($value->mobile ?? '') . "</a>";
            $value->parent_location_id = "<a href='" . route('suppliers.show', $value->id) . "' class='text-secondary    '>" . ($value->location ? $value->location->company_name : '') . "</a>";
            $value->payment_terms_id   = "<a href='" . route('suppliers.show', $value->id) . "' class='text-secondary    '>" . ($value->payment_term ? $value->payment_term->payment_label : '') . "</a>";
            $value->language_id        = "<a href='" . route('suppliers.show', $value->id) . "' class='text-secondary    '>" . ($value->language ? $value->language->language_name : '') . "</a>";
            $value->combined_notes = "<div class='d-flex align-items-center'>" . (!empty($value->shipping_instruction) ? "<span class='avatar-initial rounded bg-label-secondary me-2' data-bs-toggle='tooltip' data-bs-placement='top'    title='" . htmlspecialchars($value->shipping_instruction ? $value->shipping_instruction : 'Shipping Instruction', ENT_QUOTES, 'UTF-8') . "'><i class='bx bx-package bx-sm'></i></span>" : '') . "" . (!empty($value->internal_notes) ? "<span class='avatar-initial rounded bg-label-secondary me-2' data-bs-toggle='tooltip' data-bs-placement='top'   title='" . htmlspecialchars($value->internal_notes ? $value->internal_notes : 'Internal Notes', ENT_QUOTES, 'UTF-8') . "'><i class='bx bx-note bx-sm'></i></span>" : '') . "</div>";
            $value->status = $value->status === 0 ? 'Inactive' : 'Active';
            $value->action             = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success'  href='" . route('suppliers.edit', $value->id) . "' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a></div> </div>";
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
