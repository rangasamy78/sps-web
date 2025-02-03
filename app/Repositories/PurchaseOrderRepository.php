<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\SupplierInvoice;
use App\Models\PoInternalNote;
use App\Models\PurchaseOrderProduct;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class PurchaseOrderRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return PurchaseOrder::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return PurchaseOrder::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = PurchaseOrder::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        \DB::table('purchase_order_products')->where('po_id', $id)->delete();
        \DB::table('supplier_invoices')->where('po_id', $id)->delete();
        $query = $this->findOrFail($id)->delete();
     
        return $query;
    }

    public function getPurchaseOrderList($request)
    {
        $query = PurchaseOrder::query();
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
        $purchase   = $this->getPurchaseOrderList($request);
        $total      = $purchase->count();

        $totalFilter = $this->getPurchaseOrderList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPurchaseOrderList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                     = ++$i;
            $value->sno                = ++$i;
            $value->po_number            = "<a href='" . route('purchase_orders.po_details', $value->id) . "' class='text-secondary'>" . ($value->po_number ?? '') . "</a>";
            $value->po_date            = "<a href='" . route('purchase_orders.po_details', $value->id) . "' class='text-secondary'>" . ($value->po_date ?? '') . "</a>";
            $value->required_ship_date = "<a href='" . route('purchase_orders.po_details', $value->id) . "' class='text-secondary'>" . ($value->required_ship_date ?? '') . "</a>";

            $value->supplier_so_number = $value->supplier_so_number ?? '';
            $value->supplier_id        = $value->supplier->supplier_name ?? '';
            $value->age                 ='';
            $value->supplier_so_number        ='';
            $value->inventory_supplier = "<a href='" . route('suppliers.show', $value->supplier->id) . "' class='text-secondary'>" . ($value->supplier->supplier_name ?? '') . "</a>";

            $value->supplier_type = "<a href='" . route('suppliers.show', $value->supplier->id) . "' class='text-secondary'></a>";
            $value->container = "<a href='" . route('suppliers.show', $value->supplier->id) . "' class='text-secondary'>" . ($value->container_number ?? '') . "</a>";


            
            $value->supplier_type        ='';
            $value->container        =$value->container_number ?? '';
            $value->payment_terms        =$value->payment_terms->payment_label ?? '';
            $value->status        =$value->status ?? '';
           
            $value->purchase_location        =$value->purchase_locations->company_name ?? '';
            $value->ship_location        =$value->ship_locations->company_name ?? '';
            $value->total        =$value->extended_total ?? '';
            $value->approval_status        =$value->status ?? '';
            $value->no_inv        ='';
            $value->internal_note        ='';
            $value->special_note        ='';
           
           
            $value->payment_term_id    = $value->payment_terms->payment_label ?? '';
            $value->action = "<div class='dropup'>
            <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i>
            </button>";
            $value->action .= "<div class='dropdown-menu'>
            <a class='dropdown-item showbtn text-warning' href='" . route('purchase_orders.po_details', $value->id) . "' data-id='" . $value->id . "'>
                <i class='bx bx-show me-1 icon-warning'></i> Show
            </a>
            <a class='dropdown-item editbtn text-success' href='" . route('purchase_orders.edit', $value->id) . "' data-id='" . $value->id . "'>
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
    public function dataFetchFromSupplier($id)
    {
        
        $supplier = Supplier::where('id', $id)->first();
        return $supplier;
    }

    public function storeProductPo(array $data)
    {
        return PurchaseOrderProduct::query()
            ->create($data);
    }

    public function updateProductPo(array $data, int $id)
    {
        $purchasePo = PurchaseOrderProduct::findOrFail($id);
        $purchasePo->update($data);
        return $purchasePo;
    }
    
    public function getPurchasePoOrderList($request)
    {
        $query = PurchaseOrderProduct::query();
        return $query;
    }

    public function dataTablePo(Request $request)
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
        $purchase   = $this->getPurchasePoOrderList($request);
        $total      = $purchase->count();

        $totalFilter = $this->getPurchasePoOrderList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPurchasePoOrderList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno         = ++$i;
            $value->so  = $value->so ?? '';
            $value->product_id  = $value->product_id ?? '';
            $value->description = $value->description ?? '';
            $value->quantity    = $value->quantity ?? '';
            $value->unit_price  = $value->unit_price ?? '';
            $value->extended    = $value->extended ?? '';

            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function FetchPoData($id)
    {
        $po = PurchaseOrderProduct::where('po_id', $id)->first();
        return $po;
    }
    public function calculateSubtotal($po_id)
    {
        try {         
            $items = PurchaseOrderProduct::where('po_id', $po_id)->get();
            $subtotal = $items->sum('extended_price');

            return $subtotal;
        } catch (\Exception $e) {
            \Log::error("Error calculating subtotal for PO ID $po_id: " . $e->getMessage());
            throw $e;
        }
    }
    public function storeSupplier(array $data)
    {
        return SupplierInvoice::query()
            ->create($data);
    }
    public function dataFetchFromProduct($id)
    {
        $prd = PurchaseOrderProduct::with('product')
            ->where('id', $id)
            ->orderBy('id', 'asc') 
            ->first();
        return $prd;
    }
    
    public function poInternalNoteSave(array $data)
    {
        return PoInternalNote::query()
            ->create($data);
    }

    public function getPoInternalNotes($id){
        $results = PoInternalNote::query()->where('purchase_order_id',$id)->get();
        $output = '';
        if(!empty($results)){
            foreach($results as $result){
                $output .= '<div>' . e($result['po_internal_notes']) . '</div>';
            }
        }
        return $output;
    }
    public function dataFetchFromProductApprove($id)
    {
        $totalExtended = PurchaseOrderProduct::where('po_id', $id)->sum('extended');
        
        $purchaseOrder = PurchaseOrder::find($id);
        if ($purchaseOrder) {
            $purchaseOrder->sub_total = $totalExtended;
            $purchaseOrder->extended_total = $totalExtended;
          
            if ($totalExtended > 5000) {
                $purchaseOrder->approval_status = 'Disapprove';
                $purchaseOrder->approved_state = 0;
            }
    
            $purchaseOrder->save();
            return $purchaseOrder;
        }
    }
    public function dataFetchFromLocation($id)
    {
        $location = Customer::where('id', $id)->first();
        return $location;
    }


   
    
    
    
    

}