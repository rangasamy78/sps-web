<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Expenditure;
use App\Models\Product;
use App\Models\Service;
use App\Models\Account;
use App\Models\Inventory;
use App\Models\SupplierPort;
use App\Models\ShipmentTerm;
use App\Models\Consignment;
use App\Models\OtherCharges;
use App\Models\VendorPoNewBill;
use App\Models\SupplierInvoice;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Repositories\PurchaseOrderRepository;
use App\Repositories\SupplierInvoiceRepository;
use App\Http\Requests\SupplierInvoice\{CreateSupplierInvoiceRequest, UpdateSupplierInvoiceRequest};

class SupplierInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private SupplierInvoiceRepository $supplierInvoiceRepository;

    public function __construct(SupplierInvoiceRepository $supplierInvoiceRepository)
    {
        $this->supplierInvoiceRepository = $supplierInvoiceRepository;
    }

    public function index()
    {
        return view('supplier_invoice_packing_list.supplier_invoices_packing_lists');
    }

    public function create()
    {
        $lastPo = DB::table('purchase_orders')
            ->orderBy('id', 'desc')
            ->value('po_number'); 
        $newPo = $lastPo 
            ? str_pad(((int)$lastPo + 1) % 10000, 4, '0', STR_PAD_LEFT) 
            : '0001';
        $shipment_terms = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $supplier       = Supplier::query()->select('id', 'supplier_name')->get();
        $payment_terms  = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $location       = Company::query()->get();
        $country        = Country::query()->get();
        $freight = Expenditure::whereHas('vendorType', function ($query) {
            $query->where('vendor_type_name', 'INTRANSIT Freight');
        })->get();  
        $discharge        = SupplierPort::query()->get();
        $arrival        = SupplierPort::query()->get();
        $product        = Product::query()->get();
        $service        = Service::query()->get();
        $account        = Account::query()->get();
        $departure        = SupplierPort::query()->get();  
        $consignment_location = Consignment::with('customer')->get();
       
        return view('supplier_invoice_packing_list.__create', compact('consignment_location','account','service','product','discharge','arrival','departure','freight','shipment_terms', 'supplier', 'payment_terms', 'location', 'country','newPo'));

    }

    public function store(CreateSupplierInvoiceRequest $request)
    {

    try {
        $poData = [
            'po_number' => $request->input('sipl_bill'),
            'po_date' => $request->input('entry_date'),
            'supplier_so_number' => $request->input('supplier_so'),
            'required_ship_date' => $request->input('ship_date'),
            'eta_date' => $request->input('eta_date'),
            'po_expiry_date' => $request->input('po_expiry_date'),
            'container_number' => $request->input('container_number'),
            'shipment_term_id' => $request->input('shipment_term_id'),
            'supplier_id' => $request->input('supplier_id'),
            'supplier_address_id' => '',
            'supplier_address' => $request->input('supplier_address'),
            'supplier_suite' => $request->input('supplier_suite'),
            'supplier_city' => $request->input('supplier_city'),
            'supplier_state' => $request->input('supplier_state'),
            'supplier_zip' => $request->input('supplier_zip'),
            'supplier_country_id' => $request->input('supplier_country_id'),
            'payment_term_id' => $request->input('payment_term_id'),
            'purchase_location_id' => $request->input('purchase_location_id'),
            'purchase_location_address' => $request->input('purchase_location_address'),
            'purchase_location_suite' => $request->input('purchase_location_suite'),
            'purchase_location_city' => $request->input('purchase_location_city'),
            'purchase_location_state' => $request->input('purchase_location_state'),
            'purchase_location_zip' => $request->input('purchase_location_zip'),
            'purchase_location_country_id' => $request->input('purchase_location_country_id'),
            'ship_to_location_id' => $request->input('ship_to_location_id'),
            'ship_to_location_attn' => $request->input('ship_to_location_attn'),
            'ship_to_location_address' => $request->input('ship_to_location_address'),
            'ship_to_location_suite' => $request->input('ship_to_location_suite'),
            'ship_to_location_city' => $request->input('ship_to_location_city'),
            'ship_to_location_state' => $request->input('ship_to_location_state'),
            'ship_to_location_zip' => $request->input('ship_to_location_zip'),
            'ship_to_location_country_id' => $request->input('ship_to_location_country_id'),
            'printed_notes' => $request->input('printed_notes'),
            'internal_notes' => $request->input('internal_notes'),
            'special_instruction_id' => '',
            'special_instructions' => '',
            'pre_purchase_term_id' => '',
            'terms' => '',
            'conversion_rate' => $request->input('conversion_rate'),
            'freight_forwarder_id' => $request->input('freight_forwarder_id'),
            'vessel' => $request->input('vessel'),
            'air_bill' => $request->input('air_bill'),
            'planned_ex_factory' => $request->input('planned_ex_factory'),
            'ex_factory_date' => $request->input('ex_factory_date'),
            'departure_port_id' => $request->input('departure_port_id'),
            'arrival_port_id' => $request->input('arrival_port_id'),
            'discharge_port_id' => $request->input('discharge_port_id'),
            'etd_port' => $request->input('etd_port'),
            'eta_port' => $request->input('eta_port'),
            'wiring_instruction_id' => $request->input('wiring_instruction_id')
        ];

        $poId = DB::table('purchase_orders')->insertGetId($poData);

        $invoiceData = $request->only([
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
            'delivery_method',
            'shipment_term_id',
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
            'total'
        ]);
        $invoiceData['po_id'] = $poId;
        $invoiceData['payment_hold'] = $request->has('payment_hold') ? 'on' : 'off';
        $invoice = $this->supplierInvoiceRepository->store($invoiceData);
       
        $products = json_decode($request->input('products', '[]'), true);
    
        foreach ($products as $product) {
            
            if (empty($product['product_id'])) {
                continue; 
            }
  
           
            $productData = [
                'po_id' => $poId,
                'product_id' => $product['product_id'],
                'so' => $product['so'] ?? null,
                'purchased_as' => $product['purchased_as'] ?? null,
                'description' => $product['description'] ?? null,
                'supplier_purchasng_note' => $product['supp_note'] ?? null,
                'length' => $product['length'] ?? null,
                'width' => $product['width'] ?? null,
                'bundles' => $product['bundles'] ?? null,
                'slab_bundles' => $product['slab_bundles'] ?? null,
                'slab' => $product['alt_qty'] ?? null,
                'quantity' => is_numeric($product['qty']) ? $product['qty'] : null,
                'unit_price' => is_numeric($product['unit_price']) ? $product['unit_price'] : 0.00, 
                'extended' => $product['extended'] ?? null,
                'sipl_created' => 1
            ];
        
            DB::table('purchase_order_products')->insert($productData);
        }

        $data = [];
        $totalExtended = 0; 
        foreach ($request->service_id as $key => $serviceId) {
            if (!empty($serviceId)) { 
                $data[] = [
                    'po_id' => $poId,
                    'service_id' => $serviceId,
                    'account_id' => $request->account_id[$key],
                    'description' => $request->service_description[$key],
                    'extended' => $request->service_extended[$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
      
        if (!empty($data)) {
            OtherCharges::insert($data);
        }
        
     
        $totalExtended = array_sum(array_filter($request->service_extended, function ($key) use ($request) {
            return !empty($request->service_id[$key]); 
        }, ARRAY_FILTER_USE_KEY));


        $freightData = [
            'vendor_po_id' => $poId,
            'transaction_number' =>'' ,
            'invoice_number' => $request->input('invoice'),
            'invoice_date' => $request->input('invoice_date'),
            'payments_terms_id' => $request->input('payment_term_id'),
            'due_date' => $request->input('due_date'),
            'contact_location_id' => $request->input('purchase_location_id'),
            'hold_payment_check' => "",
            'hold_payment_reason' => "",
            'extended_total' => $totalExtended, 
            'created_at' => now(),
            'updated_at' => now()
        ];

    
        DB::table('vendor_po_new_bills')->insert($freightData);

        
        return response()->json(['id' => $invoice->id,'status' => 'success', 'msg' => 'Supplier Invoice saved successfully.']);
    } catch (Exception $e) {
        
        Log::error('Error saving Supplier Invoice: ' . $e->getMessage());
        return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Invoice.']);
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
        $model = $this->supplierInvoiceRepository->findOrFail($id);
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
      
        $shipment_terms = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $supplier       = Supplier::query()->select('id', 'supplier_name')->get();
        $payment_terms  = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $location       = Company::query()->get();
        $country        = Country::query()->get();
        $freight = Expenditure::whereHas('vendorType', function ($query) {
            $query->where('vendor_type_name', 'INTRANSIT Freight');
        })->get();  
        $discharge        = SupplierPort::query()->get();
        $arrival        = SupplierPort::query()->get();
        $product        = Product::query()->get();
        $service        = Service::query()->get();
        $account        = Account::query()->get();
        $departure        = SupplierPort::query()->get(); 
        $supplier_invoice = SupplierInvoice::findOrFail($id);
        $po_id=$supplier_invoice->po_id;
       
        $products = PurchaseOrderProduct::where('po_id', $po_id)
        ->leftjoin('products', 'products.id', '=', 'purchase_order_products.product_id')
        ->select('purchase_order_products.*', 'products.*','purchase_order_products.id as pid')
        ->get();
       
        $other_charges = OtherCharges::where('po_id', $po_id)->get();
       
        $consignment_location = Consignment::with('customer')->get();
 
        return view('supplier_invoice_packing_list.__edit', compact('products','consignment_location','supplier_invoice','account','service','product','discharge','arrival','departure','freight','shipment_terms', 'supplier', 'payment_terms', 'location', 'country','other_charges'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierInvoiceRequest $request, SupplierInvoice $supplierInvoice)
    {
        try {
          
            $paymentHold = $request->has('payment_hold') ? 'on' : 'off';
            
            $data = $request->only([
                'sipl_bill', 'entry_date', 'invoice', 'supplier_so', 'ship_date', 'invoice_date',
                'po_expiry_date', 'payment_term_id', 'due_date', 'eta_date', 'container_number',
                'delivery_method', 'shipment_term_id', 'payment_hold_reason', 'supplier_id', 
                'supplier_address', 'supplier_suite', 'supplier_city', 'supplier_state', 
                'supplier_zip', 'supplier_country_id', 'purchase_location_id', 'purchase_location_address', 
                'purchase_location_suite', 'purchase_location_city', 'purchase_location_state', 
                'purchase_location_zip', 'purchase_location_country_id', 'ship_to_location_id', 
                'ship_to_location_attn', 'ship_to_location_address', 'ship_to_location_suite', 
                'ship_to_location_city', 'ship_to_location_state', 'ship_to_location_zip', 
                'ship_to_location_country_id', 'freight_forwarder_id', 'printed_notes', 'internal_notes', 
                'vessel', 'air_bill', 'planned_ex_factory', 'ex_factory_date', 'departure_port_id', 
                'discharge_port_id', 'etd_port', 'arrival_port_id', 'eta_port', 'wiring_instruction_id', 
                'item_total', 'other_total', 'total'
            ]);
    
            $data['payment_hold'] = $paymentHold;
            $this->supplierInvoiceRepository->update($data, $supplierInvoice->id);
    
            $poData = [
                'po_date' => $request->input('entry_date'),
                'supplier_so_number' => $request->input('supplier_so'),
                'required_ship_date' => $request->input('ship_date'),
                'eta_date' => $request->input('eta_date'),
                'po_expiry_date' => $request->input('po_expiry_date'),
                'container_number' => $request->input('container_number'),
                'shipment_term_id' => $request->input('shipment_term_id'),
                'supplier_id' => $request->input('supplier_id'),
                'supplier_address_id' => '',
                'supplier_address' => $request->input('supplier_address'),
                'supplier_suite' => $request->input('supplier_suite'),
                'supplier_city' => $request->input('supplier_city'),
                'supplier_state' => $request->input('supplier_state'),
                'supplier_zip' => $request->input('supplier_zip'),
                'supplier_country_id' => $request->input('supplier_country_id'),
                'payment_term_id' => $request->input('payment_term_id'),
                'purchase_location_id' => $request->input('purchase_location_id'),
                'purchase_location_address' => $request->input('purchase_location_address'),
                'purchase_location_suite' => $request->input('purchase_location_suite'),
                'purchase_location_city' => $request->input('purchase_location_city'),
                'purchase_location_state' => $request->input('purchase_location_state'),
                'purchase_location_zip' => $request->input('purchase_location_zip'),
                'purchase_location_country_id' => $request->input('purchase_location_country_id'),
                'ship_to_location_id' => $request->input('ship_to_location_id'),
                'ship_to_location_attn' => $request->input('ship_to_location_attn'),
                'ship_to_location_address' => $request->input('ship_to_location_address'),
                'ship_to_location_suite' => $request->input('ship_to_location_suite'),
                'ship_to_location_city' => $request->input('ship_to_location_city'),
                'ship_to_location_state' => $request->input('ship_to_location_state'),
                'ship_to_location_zip' => $request->input('ship_to_location_zip'),
                'ship_to_location_country_id' => $request->input('ship_to_location_country_id'),
                'printed_notes' => $request->input('printed_notes'),
                'internal_notes' => $request->input('internal_notes'),
                'special_instruction_id' => '',
                'special_instructions' => '',
                'pre_purchase_term_id' => '',
                'terms' => '',
                'conversion_rate' => $request->input('conversion_rate'),
                'freight_forwarder_id' => $request->input('freight_forwarder_id'),
                'vessel' => $request->input('vessel'),
                'air_bill' => $request->input('air_bill'),
                'planned_ex_factory' => $request->input('planned_ex_factory'),
                'ex_factory_date' => $request->input('ex_factory_date'),
                'departure_port_id' => $request->input('departure_port_id'),
                'arrival_port_id' => $request->input('arrival_port_id'),
                'discharge_port_id' => $request->input('discharge_port_id'),
                'etd_port' => $request->input('etd_port'),
                'eta_port' => $request->input('eta_port'),
                'wiring_instruction_id' => $request->input('wiring_instruction_id')
            ];
    
            DB::table('purchase_orders')
                ->where('po_number', $supplierInvoice->sipl_bill)
                ->update($poData);



                $po_id = $supplierInvoice->po_id;
                $products = $request->input('product');
                
                if (is_array($products) && count($products) > 0) {
                    foreach ($products as $product) {
                        if (!empty($product['id'])) {
                           
                            PurchaseOrderProduct::updateOrCreate(
                                ['id' => $product['id']],
                                [
                                    'po_id' => $po_id, 
                                    'product_id' => $product['product_id'],
                                    'description' => $product['description'],
                                    'supplier_purchasng_note' => $product['supplier_purchasng_note'],
                                    'slab' => $product['slab'],
                                    'quantity' => $product['quantity'],
                                    'unit_price' => $product['unit_price'],
                                    'extended' => $product['quantity'] * $product['unit_price'],
                                ]
                            );
                        } else {
                           
                            $extended = $product['quantity'] * $product['unit_price'];

                       
                        if ($extended != 0) { 
                            PurchaseOrderProduct::create([
                                'po_id' => $po_id,
                                'product_id' => $product['product_id'],
                                'description' => $product['description'],
                                'supplier_purchasng_note' => $product['supplier_purchasng_note'],
                                'slab' => $product['slab'],
                                'quantity' => $product['quantity'],
                                'unit_price' => $product['unit_price'],
                                'extended' => $extended, 
                            ]);
                        }
                        }
                    }
                } else {
                    Log::error('No products provided in the request.');
                }



                $otherCharges = $request->input('other_charges');
           
        
                if (!empty($otherCharges)) {
                 
                    foreach ($otherCharges as $charge) {
                       
                        $chargeId = isset($charge['id']) ? $charge['id'] : null;
    
                        $extended = isset($charge['extended']) ? (float) $charge['extended'] : 0;
    
                       
                        if ($extended > 0 && !empty($charge['service_id']) && !empty($charge['account_id']) && !empty($charge['description'])) {
                            
                            $data = [
                                'po_id' => $po_id, 
                                'service_id' => $charge['service_id'] ?? null, 
                                'account_id' => $charge['account_id'] ?? null, 
                                'description' => $charge['description'] ?? '', 
                                'extended' => $extended,
                            ];
    
                          
                            if ($chargeId) {
                               
                                OtherCharges::where('id', $chargeId)->update($data);
                            } else {
                              
                                OtherCharges::create($data);
                            }
                        }
                    }
                }


                DB::table('vendor_po_new_bills')
                ->where('vendor_po_id', $po_id)
                ->delete();
            
                $extendedTotal = OtherCharges::where('po_id', $po_id)->sum('extended');
                $freightData = [
                    'vendor_po_id' => $po_id,
                    'transaction_number' => '',
                    'invoice_number' => $request->input('invoice'),
                    'invoice_date' => $request->input('invoice_date'),
                    'payments_terms_id' => $request->input('payment_term_id'),
                    'due_date' => $request->input('due_date'),
                    'contact_location_id' => $request->input('purchase_location_id'),
                    'hold_payment_check' => "",
                    'hold_payment_reason' => "",
                    'extended_total' => $extendedTotal,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                DB::table('vendor_po_new_bills')->insert($freightData);
                



                
            return response()->json([
                'id' => $supplierInvoice->id,
                'status' => 'success',
                'msg' => 'Supplier Invoice updated successfully.'
            ]);
        } catch (Exception $e) {
            Log::error('Error updating Supplier Invoice', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while updating the Supplier Invoice. Please try again later.'
            ], 500);
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
            $productColor = $this->supplierInvoiceRepository->findOrFail($id);
            if ($productColor) {
                $this->supplierInvoiceRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier Invoce deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Supplier Invoce not found.']);
            }
        } catch (Exception $e) {
           
            Log::error('Error deleting Supplier Invoce: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Supplier Invoce.']);
        }
    }
    public function getSupplierInvoiceDataTableList(Request $request)
    {
        return $this->supplierInvoiceRepository->dataTable($request);
    }
    public function FetchSupplierProductData($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found',
            ]);
        }

        $productPOs = PurchaseOrder::where('supplier_id', $id)->get();

        if ($productPOs->isEmpty()) {

            return response()->json([
                'success' => true,
                'data' => [
                    'supplier' => $supplier,
                    'products' => []
                ],
            ]);

          
        }

        $purchaseOrderProducts = [];

    
        foreach ($productPOs as $po) {
            $products = PurchaseOrderProduct::where('purchase_order_products.po_id', $po->id)
            ->where('purchase_order_products.sipl_created', 0)
            ->join('products', 'products.id', '=', 'purchase_order_products.product_id')
            ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_products.po_id')
            ->join('companies', 'companies.id', '=', 'purchase_orders.purchase_location_id') // Join with companies
            ->select(
                'purchase_order_products.*', 
                'products.*', 
                'purchase_orders.*', 
                'companies.*'
            )
            ->get();
        
        
            $purchaseOrderProducts = array_merge($purchaseOrderProducts, $products->toArray());
        }

        return response()->json([
            'success' => true,
            'data' => [
                'supplier' => $supplier,
                'products' => $purchaseOrderProducts,
            ],
        ]);
    }

    public function FetchServiceData($id)
    {

       
        $vendor = $this->supplierInvoiceRepository->dataFetchFromService($id);
      
        if ($vendor) {
            return response()->json([
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ]);
        }
    }

    public function FetchProductDetailsData($id)
    {
        
       
        $vendor = $this->supplierInvoiceRepository->dataFetchProductDetails($id);
      
        if ($vendor) {
            return response()->json([
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ]);
        }
    }
    public function FetchOtherDetailsData($id)
    {

       
        $vendor = $this->supplierInvoiceRepository->dataOtherDetails($id);
      
        if ($vendor) {
            return response()->json([
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ]);
        }
    }
    public function FetchFreightBillsData($id)
    {

       
        $freight = $this->supplierInvoiceRepository->dataFreightBillsDetails($id);
 
        if ($freight) {
            return response()->json([
                'success' => true,
                'data'    => $freight,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ]);
        }
    }
    public function receive_inventory($id)
    {
        $supplier_invoice = SupplierInvoice::findOrFail($id);
        return view('supplier_invoice_packing_list.receive_inventories.receive_inventory', compact('supplier_invoice'));

    }

    public function receiveInventoryDetails(Request $request,$id)
    {
       
        $received_date = $request->input('received_date');
        $vendor = $this->supplierInvoiceRepository->dataReceiveInventory($id,$received_date);
      
        if ($vendor) {
            return response()->json([
                'id' => $id,
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ]);
        }
    }
    public function receiveInventoryView($id)
    {
        $supplier_invoice = SupplierInvoice::findOrFail($id);

        $inventory = Inventory::query()->where('sipl_id', $id)->get();
       
        $received_date = null;
        $receive_status = "no";

        if (!$inventory->isEmpty()) { 
            $received_date = date('d-m-Y', strtotime($inventory[0]->received_date));
            $receive_status = "yes";
        }

        return view('supplier_invoice_packing_list.receive_inventories.receive_inventory_view', compact('inventory','received_date','receive_status','supplier_invoice'));

    }

    public function receiveInventoryDetailsUpdate(Request $request,$id)
    {
       
        $received_date = $request->input('received_date');
        $vendor = $this->supplierInvoiceRepository->dataReceiveInventoryUpdate($id,$received_date);
      
        if ($vendor) {
            return response()->json([
                'id' => $id,
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ]);
        }
    }

    public function unreceive_inventory($id)
    {
        $supplier_invoice = SupplierInvoice::findOrFail($id);
        return view('supplier_invoice_packing_list.receive_inventories.unreceive_inventory', compact('supplier_invoice'));

    }
    public function FetchUnreceivedDetails($id)
    {

       
        $vendor = $this->supplierInvoiceRepository->dataFetchUnreceivedDetails($id);
    
        if ($vendor) {
            return response()->json([
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ]);
        }
    } 
    public function unreceiveInventoryDetails(Request $request,$id)
    {
       
        $received_date = $request->input('received_date');
        $vendor = $this->supplierInvoiceRepository->dataunReceiveInventory($id,$received_date);
      
        if ($vendor) {
            return response()->json([
                'id' => $id,
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ]);
        }
    }

}
