<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SupplierInvoicePackingItem;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class InventoryIntransitRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return SupplierInvoicePackingItem::query()
            ->findOrFail($id);
    }
    public function store(array $data)
    {
        return SupplierInvoicePackingItem::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SupplierInvoicePackingItem::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getIntransitInventoryList($request)
    {
        $query = SupplierInvoicePackingItem::where('inventory_travel_status', 'Intransit')
            ->select('*')
            ->groupBy('product_id')
            ->with('product');
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
        $intransit   = $this->getIntransitInventoryList($request);
        $total           = $intransit->count();

        $totalFilter     = $this->getIntransitInventoryList($request);
        $totalFilter     = $totalFilter->count();

        $arrData         = $this->getIntransitInventoryList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();
      
        $arrData->map(function ($value, $i) {
            $value->sno           = ++$i;
            $value->product_name = $value->product->product_name ?? '';
            $value->product_sku = $value->product->product_sku ?? '';
            $value->po_number = $value->purchase_order->po_number ?? '';
            $value->po_date = $value->purchase_order->po_date ?? '';
            $value->eta_date = $value->purchase_order->eta_date ?? '';
            $value->supplier_so = $value->purchase_order->supplier_so_number ?? '';
            $value->slabs = '';
            $value->quantity = '';
            $value->units = '';
            $value->ship_to_location= $value->purchase_order->ship_to_location_id ?? '';
            $value->supplier= $value->purchase_order->supplier_id ?? '';
            $value->freight= $value->purchase_order->freight_forwarder_id ?? '';
            $value->eta_date= $value->purchase_order->eta_date ?? '';
            $value->ship_date= $value->purchase_order->required_ship_date ?? '';
            $value->container_number= $value->purchase_order->container_number ?? '';
            $value->vessel= $value->purchase_order->vessel ?? '';
            $value->customer_loc= '';
            $value->status= $value->inventory_travel_status ?? '';
            $value->sidemark=  '';
            $value->supp_pu_note=  '';
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
