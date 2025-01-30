<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Inventory;
use App\Models\OtherCharges;
use App\Models\Product;
use App\Models\VendorPoNewBill;
use App\Models\SupplierInvoice;
use App\Models\PoInternalNote;
use App\Models\SupplierInvoicePackingItem;
use App\Models\PurchaseOrderProduct;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use Illuminate\Support\Facades\DB;

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
            $value->sipl_bill = "<a href='" . route('supplier_invoice.supplier_invoice_packing', $value->id) . "' class='text-secondary'>" . ($value->sipl_bill ?? '') . "</a>";
            $value->po_id = "<a href='" . route('purchase_orders.po_details', $value->po_id) . "' class='text-secondary'>" . ($value->purchase_order->po_number ?? '') . "</a>";
            $value->entry_date = "<a href='" . route('supplier_invoice.supplier_invoice_packing', $value->id) . "' class='text-secondary'>" . ($value->entry_date ?? '') . "</a>";
            $value->payment_term_id = "<a href='" . route('supplier_invoice.supplier_invoice_packing', $value->id) . "' class='text-secondary'>" . ($value->payment_terms->payment_label ?? '') . "</a>";
            $value->invoice = "<a href='" . route('supplier_invoice.supplier_invoice_packing', $value->id) . "' class='text-secondary'>" . ($value->invoice ?? '') . "</a>";

            $value->supplier_so = $value->supplier_so ?? '';
            $value->container_number = $value->container_number ?? '';
            if ($value->supplier) {
                $value->supplier_id = "<a href='" . route('suppliers.show', $value->supplier->id) . "' class='text-secondary'>" . ($value->supplier->supplier_name ?? '') . "</a>";
            } else {
                $value->supplier_id = "Supplier not available";
            }
            
          
            $value->sipl_status = $value->sipl_status ?? '';
            $value->ship_to_location_id = $value->ship_locations->company_name ?? '';
            $value->ship_date = $value->ship_date ?? '';
            $value->freight_forwarder_id = $value->freight_forwarder_id ?? '';
            $value->item_total = $value->item_total ?? '';
            $value->status = '';
            $value->received_date = '';
            $value->balance_due = '';
            $value->action = "<div class='dropup'>
            <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i>
            </button>";
            $value->action .= "<div class='dropdown-menu'>
          
            <a class='dropdown-item editbtn text-success' href='" . route('supplier_invoices.edit', $value->id) . "' data-id='" . $value->id . "'>
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

    public function dataFetchFromSupplierProduct($id)
    {
       
        $supplier = Supplier::find($id);
    
        if (!$supplier) {
            return null; 
        }
        $productPOs = PurchaseOrder::where('supplier_id', $id)->get();
        $purchaseOrderProducts = PurchaseOrderProduct::whereIn('po_id', $productPOs->pluck('id'))
            ->with('product')  
            ->get();
           
    
        return [
            'supplier' => $supplier,
            'productPOs' => $productPOs,
            'purchaseOrderProducts' => $purchaseOrderProducts,  
        ];
    }

   
    public function dataFetchFromService($id)
    { 
       
        
        $supplier = Service::where('id', $id)->first();
       
        return $supplier;
    }
    public function dataFetchProductDetails($id)
    { 
     
        
        $suppliers = PurchaseOrderProduct::where('po_id', $id)
                    ->with('product') 
                    ->get();

                return $suppliers;
  

       
        return $supplier;
    }
    public function dataFetchUnreceivedDetails($id)
    { 
   
        
        $suppliers = SupplierInvoice::where('id', $id)
                    ->with('purchase_order') 
                    ->get();

                return $suppliers;
  

       
        return $supplier;
    }
    public function dataOtherDetails($id)
    { 
       
        
        $supplier = OtherCharges::where('po_id', $id)
                    ->with('service')
                    ->with('account')
                    ->get();
       
        return $supplier;
    }
    public function dataFreightBillsDetails($id)
    { 
       
        

        $freight = DB::table('vendor_po_new_bills')
            ->where('vendor_po_new_bills.vendor_po_id', $id)
            ->join('purchase_orders', 'vendor_po_new_bills.vendor_po_id', '=', 'purchase_orders.id') 
            ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id') // Join with suppliers
            ->select(
                'vendor_po_new_bills.*', 
                'purchase_orders.supplier_id', 
                'suppliers.supplier_name as supplier_name'
            )
            ->get();
        
      
        
    return $freight;
    }


    public function dataReceiveInventory($id, $received_date)
    {
      
       
        $invoice = SupplierInvoicePackingItem::where('sipl_id', $id)->get();
      
        if ($invoice->isNotEmpty()) { 
            $groupedByProductId = $invoice->groupBy('product_id');
            
            foreach ($groupedByProductId as $productId => $records) {
                $inventory_in_stock = $records->count();
        
                $currentInventoryInStock = Product::where('id', $productId)->value('inventory_in_stock');
               
                $existingRecord = Inventory::where('sipl_id', $id)
                                           ->where('product_id', $productId)
                                           ->exists();
        
                if (!$existingRecord) { 
                    $newRecord = [
                        'sipl_id' => $id,
                        'product_id' => $productId,
                        'inventory_in_stock' => $inventory_in_stock,
                        'inventory_committed' => 0,
                        'inventory_available' => $inventory_in_stock,
                        'received_date' => $received_date,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
        
                    Inventory::create($newRecord);


                    
                    
                    $updatedInventoryInStock = $currentInventoryInStock + $inventory_in_stock;

                    Product::where('id', $productId)->update([
                        'inventory_in_stock' => $updatedInventoryInStock,
                        'inventory_committed' => 0,
                        'inventory_available' => $updatedInventoryInStock,
                        'received_date' => $received_date,
                    ]);
                }
            }
        }
       

        

        SupplierInvoicePackingItem::where('sipl_id', $id)
        ->update([
            'inventory_status' => 'Received',
            'inventory_travel_status' => 'Intransit'
        ]);

    return $invoice;
}


public function dataReceiveInventoryUpdate($id, $received_date)
{
   
    $invoice = SupplierInvoicePackingItem::where('sipl_id', $id)->get();

    if ($invoice->isNotEmpty()) { 
        $groupedByProductId = $invoice->groupBy('product_id');
        foreach ($groupedByProductId as $productId => $records) {
            $inventory_in_stock = $records->count();
            $existingRecord = Inventory::where('sipl_id', $id)
                                       ->where('product_id', $productId)
                                       ->first(); 
            if ($existingRecord) { 
                $existingRecord->update([
                    'inventory_in_stock' => $inventory_in_stock,
                    'inventory_available' => $inventory_in_stock,
                    'received_date' => $received_date,
                    'updated_at' => now(),
                ]);
            }
        }
    }

    return $invoice; 
}



public function dataunReceiveInventory($id, $received_date)
{
   
    $inventories = Inventory::where('sipl_id', $id)->get();

    foreach ($inventories as $inventory) {
        $product = Product::where('id', $inventory->product_id)->first();

        if ($product) {
            $newInventoryInStock = max(0, $product->inventory_in_stock - $inventory->inventory_in_stock);

            Product::where('id', $inventory->product_id)->update([
                'inventory_in_stock'   => $newInventoryInStock,
                'inventory_committed'  => 0,
                'inventory_available'  => $newInventoryInStock,
                'received_date'        => $received_date,
            ]);
        }
    }

    Inventory::where('sipl_id', $id)->delete();
    return $id;
}






    
}
