<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ShipmentTerm;
use App\Models\PurchaseOrder;
use App\Models\SupplierInvoice;
use App\Models\AccountPaymentTerm;
use App\Models\PurchaseOrderProduct;
use App\Repositories\PurchaseOrderRepository;
use Illuminate\Support\Facades\Log;use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Product\{SupplierInvoiceRequest, CreatePurchaseOrderRequest,UpdatePurchaseOrderRequest};

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private PurchaseOrderRepository $purchaseOrderRepository;

    public function __construct(PurchaseOrderRepository $purchaseOrderRepository)
    {
        $this->purchaseOrderRepository = $purchaseOrderRepository;
    }

    public function index()
    {
        return view('purchase_order.purchase_orders');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function PurchaseOrderPo(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1', 
            'unit_price' => 'required|numeric|min:0.01',
            'extended' => 'required|numeric|min:0.01', 
        ], [
            'quantity.required'   => 'The quantity field is required.',
            'quantity.numeric'    => 'The quantity must be a valid number.',
            'quantity.min'        => 'The quantity must be at least 1.',

            'unit_price.required' => 'The unit price field is required.',
            'unit_price.numeric'  => 'The unit price must be a valid number.',
            'unit_price.min'      => 'The unit price must be at least 0.01.',

            'extended.required'   => 'The extended price field is required.',
            'extended.numeric'    => 'The extended price must be a valid number.',
            'extended.min'        => 'The extended price must be at least 0.01.',
        ]);

       
        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'msg'    => 'Validation failed.',
                'errors' => $validator->errors(),
            ]);
        }

        try {
           
            $purchasePo = $this->purchaseOrderRepository->storeProductPo($request->only(
                'po_id',
                'product_id',
                'so',
                'purchased_as',
                'description',
                'supplier_purchasng_note',
                'min_l_w',
                'min_l_w_value',
                'bundles',
                'slab_bundles',
                'slab',
                'quantity',
                'unit_price',
                'extended',
            ));

            
            $subtotal = $this->purchaseOrderRepository->calculateSubtotal($request->po_id); 
            $total    = $this->purchaseOrderRepository->calculateSubtotal($request->po_id); 
          
            return response()->json([
                'status'   => 'success',
                'msg'      => 'Purchase Order saved successfully.',
                'product'  => [
                    'id'          => $purchasePo->id,
                    'so'          => $purchasePo->so,
                    'product_id'  => $purchasePo->product_id,
                    'description' => $purchasePo->description,
                    'quantity'    => $purchasePo->quantity,
                    'unit_price'  => $purchasePo->unit_price,
                    'extended'    => $purchasePo->quantity * $purchasePo->unit_price,
                ],
                'subtotal' => $subtotal,
                'total'    => $total,
            ]);
        } catch (Exception $e) {
            
            Log::error('Error saving Purchase Order: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Purchase Order.']);
        }
    }

    public function store(CreatePurchaseOrderRequest $request)
    {
        try {
            $po=$this->purchaseOrderRepository->store($request->only('po_number',
                'po_date',
                'supplier_so_number',
                'required_ship_date',
                'eta_date',
                'po_expiry_date',
                'container_number',
                'shipment_term_id',
                'supplier_id',
                'supplier_address_id',
                'supplier_address',
                'supplier_suite',
                'supplier_city',
                'supplier_state',
                'supplier_zip',
                'supplier_country_id',
                'payment_term_id',
                'purchase_location_id',
                'purchase_location_address',
                'purchase_location_suite',
                'purchase_location_city',
                'purchase_location_state',
                'purchase_location_zip',
                'purchase_location_country_id',
                'ship_to_location_id',
                'ship_to_location_attn',
                'ship_to_location_address',
                'ship_to_location_suite',
                'ship_to_location_city',
                'ship_to_location_state',
                'ship_to_location_zip',
                'ship_to_location_country_id',
                'printed_notes',
                'internal_notes',
                'special_instruction_id',
                'special_instructions',
                'pre_purchase_term_id',
                'terms',
                'conversion_rate',
                'freight_forwarder_id',
                'vessel',
                'air_bill',
                'planned_ex_factory',
                'ex_factory_date',
                'departure_port_id',
                'arrival_port_id',
                'discharge_port_id',
                'etd_port',
                'eta_port',
                'wiring_instruction_id'));
            return response()->json(['id' => $po->id,'status' => 'success', 'msg' => 'Po saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving po: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the po.']);
        }
    }

    public function PurchaseOrderPoUpdate(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'edit_id'    => 'nullable|integer|exists:purchase_order_products,id',
            'quantity'   => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0.01',
            'extended'   => 'required|numeric|min:0.01',
        ], [
            'edit_id.exists'      => 'The selected item to edit does not exist.',
            'quantity.required'   => 'The quantity field is required.',
            'quantity.numeric'    => 'The quantity must be a valid number.',
            'quantity.min'        => 'The quantity must be at least 1.',
            'unit_price.required' => 'The unit price field is required.',
            'unit_price.numeric'  => 'The unit price must be a valid number.',
            'unit_price.min'      => 'The unit price must be at least 0.01.',
            'extended.required'   => 'The extended price field is required.',
            'extended.numeric'    => 'The extended price must be a valid number.',
            'extended.min'        => 'The extended price must be at least 0.01.',
        ]);
       
        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'msg'    => 'Validation failed.',
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $data = $request->only(
                'po_id',
                'product_id',
                'so',
                'purchased_as',
                'description',
                'supplier_purchasng_note',
                'min_l_w',
                'min_l_w_value',
                'bundles',
                'slab_bundles',
                'slab',
                'quantity',
                'unit_price',
                'extended'
            );

            if ($request->has('edit_id')) {
                
                $purchasePo = $this->purchaseOrderRepository->updateProductPo($data, $request->edit_id);

                if (!$purchasePo) {
                    return response()->json([
                        'status' => 'false',
                        'msg'    => 'Failed to update Purchase Order.',
                    ]);
                }

                $message = 'Purchase Order updated successfully.';
            }
          
            $subtotal = $this->purchaseOrderRepository->calculateSubtotal($request->po_id);
            $total    = $this->purchaseOrderRepository->calculateSubtotal($request->po_id);          
            return response()->json([
                'status'   => 'success',
                'msg'      => $message,
                'product'  => [
                    'id'          => $purchasePo->id,
                    'so'          => $purchasePo->so,
                    'product_id'  => $purchasePo->product_id,
                    'description' => $purchasePo->description,
                    'quantity'    => $purchasePo->quantity,
                    'unit_price'  => $purchasePo->unit_price,
                    'extended'    => $purchasePo->quantity * $purchasePo->unit_price,
                ],
                'subtotal' => $subtotal,
                'total'    => $total,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving/updating Purchase Order: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while processing the Purchase Order.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->purchaseOrderRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->purchaseOrderRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        try {
            $this->purchaseOrderRepository->update($request->only(''), $purchaseOrder->id);
            return response()->json(['status' => 'success', 'msg' => 'Purchase Order updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Purchase Order: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Purchase Order.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $purchaseOrder = $this->purchaseOrderRepository->findOrFail($id);
            if ($purchaseOrder) {
                $this->purchaseOrderRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Purchase Order deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Purchase Order not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Purchase Order: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Purchase Order.']);
        }
    }
    public function getPurchaseOrderDataTableList(Request $request)
    {
        return $this->purchaseOrderRepository->dataTable($request);
    }

    public function create()
    {

        $shipment_terms = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $supplier       = Supplier::query()->select('id', 'supplier_name')->get();
        $payment_terms  = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $location       = Company::query()->get();
        $country        = Country::query()->get();
        return view('purchase_order.__create', compact('shipment_terms', 'supplier', 'payment_terms', 'location', 'country'));

    }
    public function getPoDetails($id)
    {

        $product        = Product::query()->get();
        $purchase_order = PurchaseOrder::findOrFail($id);
        $location       = Company::query()->get();
        $payment_terms  = AccountPaymentTerm::query()->get();
        $country        = Country::query()->get();
        $purchasePo     = PurchaseOrderProduct::query()->where('po_id', $id)->get();
        return view('purchase_order.__po_details', compact('product', 'purchasePo', 'purchase_order', 'location', 'payment_terms', 'country'));

    }

    public function FetchSupplierData($id)
    {

        $vendor = $this->purchaseOrderRepository->dataFetchFromSupplier($id);
        if ($vendor) {
            return response()->json([
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found',
            ]);
        }
    }

    public function getPurchaseProductDataTableList(Request $request)
    {
        return $this->purchaseOrderRepository->dataTablePo($request);
    }
    public function FetchPoData($id)
    {

        $po = $this->purchaseOrderRepository->FetchPoData($id);
        if ($po) {
            return response()->json([
                'success' => true,
                'data'    => $po,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found',
            ]);
        }
    }
    public function FetchPoDetails($id)
    {
        $product        = Product::query()->get();
        $purchase_order = PurchaseOrder::findOrFail($id);
        $location       = Company::query()->get();
        $payment_terms  = AccountPaymentTerm::query()->get();
        $country        = Country::query()->get();
        $purchasePo     = PurchaseOrderProduct::query()->where('po_id', $id)->get();
        return view('purchase_order.purchase_order_details', compact('product', 'purchasePo', 'purchase_order', 'location', 'payment_terms', 'country'));

    }
    public function SupplierInvoice($id)
    {
        $shipment_terms = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $supplier       = Supplier::query()->select('id', 'supplier_name')->get();
        $payment_terms  = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $location       = Company::query()->get();
        $country        = Country::query()->get();
        $po_id          = $id;

        return view('supplier_invoice.supplier_invoices', compact('po_id', 'shipment_terms', 'supplier', 'payment_terms', 'location', 'country'));

    }

    public function SupplierInvoiceSave(SupplierInvoiceRequest $request)
    {
        try {
            $supplierInv = $this->purchaseOrderRepository->storeSupplier($request->only('po_id',
                'sipl_bill',
                'entry_date',
                'invoice',
                'supplier_so',
                'ship_date',
                'invoice_date',
                'po_expiry_date',
                'payment_term_id',
                'due_date',
                'eta_date',
                'container_number',
                'delivery_method_id',
                'shipment_term_id',
                'payment_hold',
                'payment_hold_reason',
                'supplier_id',
                'supplier_address',
                'supplier_suite',
                'supplier_city',
                'supplier_state',
                'supplier_zip',
                'supplier_country_id',
                'purchase_location_id',
                'purchase_location_address',
                'purchase_location_suite',
                'purchase_location_city',
                'purchase_location_state',
                'purchase_location_zip',
                'purchase_location_country_id',
                'ship_to_location_id',
                'ship_to_location_attn',
                'ship_to_location_address',
                'ship_to_location_suite',
                'ship_to_location_city',
                'ship_to_location_state',
                'ship_to_location_zip',
                'ship_to_location_country_id',
                'freight_forwarder_id',
                'printed_notes',
                'internal_notes',
                'vessel',
                'air_bill',
                'planned_ex_factory',
                'ex_factory_date',
                'departure_port_id',
                'discharge_port_id',
                'etd_port',
                'arrival_port_id',
                'eta_port',
                'wiring_instruction_id',
                'item_total',
                'other_total',
                'total'));
            return response()->json(['id' => $supplierInv->id, 'status' => 'success', 'msg' => 'Supplier Invoice saved successfully.']);
        } catch (Exception $e) {
            
            Log::error('Error saving Supplier Invoice: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Invoice.']);
        }
    }
    public function SupplierInvoicePackingList($id)
    {

        $product          = Product::query()->get();
        $purchase_order   = PurchaseOrder::query()->get();
        $supplier_invoice = SupplierInvoice::findOrFail($id);
        $location         = Company::query()->get();
        $payment_terms    = AccountPaymentTerm::query()->get();
        $country          = Country::query()->get();
        $purchasePo       = PurchaseOrderProduct::query()->where('po_id', $id)->get();
        return view('supplier_invoice.supplier_invoice_packing_list', compact('product', 'purchasePo', 'purchase_order', 'location', 'payment_terms', 'country', 'supplier_invoice'));

    }

    public function deletePoDetails($id)
    {
        try {
            $po = PurchaseOrderProduct::find($id);
            if ($po) {
                $po->delete();
                return response()->json(['status' => 'success', 'msg' => 'Product deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting product color: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product.']);
        }
    }

    public function FetchProductPoData($id)
    {

        $po = $this->purchaseOrderRepository->dataFetchFromProduct($id);
        if ($po) {
            return response()->json([
                'success' => true,
                'data'    => $po,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Po not found',
            ]);
        }
    }
    public function FetchPoproductDetails($id)
    {

        $po = $this->purchaseOrderRepository->dataFetchFromProduct($id);
        if ($po) {
            return response()->json([
                'success' => true,
                'data'    => $po,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Po not found',
            ]);
        }
    }

 

}