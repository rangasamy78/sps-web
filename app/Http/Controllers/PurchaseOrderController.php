<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Account;
use App\Models\Company;
use App\Models\Country;
use App\Models\Product;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\Consignment;
use App\Models\Expenditure;
use App\Models\OtherCharges;
use App\Models\ShipmentTerm;
use App\Models\SupplierPort;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\SupplierInvoice;
use App\Models\AccountPaymentTerm;
use App\Models\PrintDocDisclaimer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseOrderProduct;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PurchaseOrderRepository;
use App\Http\Requests\PurchaseOrder\SupplierInvoiceRequest;
use App\Http\Requests\InternalNote\CreatePoInternalNoteRequest;
use App\Http\Requests\PurchaseOrder\CreatePurchaseOrderRequest;
use App\Http\Requests\PurchaseOrder\UpdatePurchaseOrderRequest;

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
            'quantity'   => 'required|numeric',
            'unit_price' => 'required|numeric',
            'extended'   => 'required|numeric',
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
                'length',
                'width',
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
                    'id'           => $purchasePo->id,
                    'so'           => $purchasePo->so,
                    'product_id'   => $purchasePo->product_id,
                    'product_name' => $purchasePo->product->product_name,
                    'description'  => $purchasePo->description,
                    'quantity'     => $purchasePo->quantity,
                    'unit_price'   => $purchasePo->unit_price,
                    'extended'     => $purchasePo->quantity * $purchasePo->unit_price,
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
            $existingPo = DB::table('purchase_orders')->where('po_number', $request->po_number)->exists();
            if ($existingPo) {
                $lastPo = DB::table('purchase_orders')->orderBy('id', 'desc')->value('po_number');
                $newPo  = $lastPo
                ? str_pad(((int)$lastPo + 1) % 10000, 4, '0', STR_PAD_LEFT)
                : '0001';
                $request->merge(['po_number' => $newPo]);
            }
            $po = $this->purchaseOrderRepository->store($request->only(
                'po_number',
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
                'wiring_instruction_id'
            ));
            return response()->json(['id' => $po->id, 'status' => 'success', 'msg' => 'PO saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving PO: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the PO.']);
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
                'length',
                'width',
                'bundles',
                'slab_bundles',
                'slab',
                'quantity',
                'unit_price',
                'extended'
            );

            if ($request->has('edit_id')) {

                $purchasePo = $this->purchaseOrderRepository->updateProductPo($data, $request->edit_id);

                if (! $purchasePo) {
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
                    'id'           => $purchasePo->id,
                    'so'           => $purchasePo->so,
                    'product_id'   => $purchasePo->product_id,
                    'product_name' => $purchasePo->product->product_name,
                    'description'  => $purchasePo->description,
                    'quantity'     => $purchasePo->quantity,
                    'unit_price'   => $purchasePo->unit_price,
                    'extended'     => $purchasePo->quantity * $purchasePo->unit_price,
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
        $lastPo = DB::table('purchase_orders')
            ->orderBy('id', 'desc')
            ->value('po_number');
        $newPo = $lastPo
        ? str_pad(((int)$lastPo + 1) % 10000, 4, '0', STR_PAD_LEFT)
        : '0001';
        $consignment_location = Consignment::with('customer')->get();
        $shipment_terms       = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $supplier             = Supplier::query()->select('id', 'supplier_name')->get();
        $payment_terms        = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $location             = Company::query()->get();
        $country              = Country::query()->get();
        $discharge            = SupplierPort::query()->get();
        $arrival              = SupplierPort::query()->get();
        $departure            = SupplierPort::query()->get();
        $purchase_order       = PurchaseOrder::findOrFail($id);
        $printdoc             = PrintDocDisclaimer::join('select_type_sub_categories', 'print_doc_disclaimers.select_type_sub_category_id', '=', 'select_type_sub_categories.id')
            ->where('select_type_sub_categories.select_type_sub_category_name', 'P.O. Terms')
            ->select('print_doc_disclaimers.id', 'print_doc_disclaimers.policy', 'print_doc_disclaimers.title')
            ->get();

        $freight = Expenditure::whereHas('vendorType', function ($query) {
            $query->where('vendor_type_name', 'INTRANSIT Freight');
        })->get();

        return view('purchase_order.__edit', compact('consignment_location', 'shipment_terms', 'purchase_order', 'supplier', 'payment_terms', 'location', 'country', 'discharge', 'arrival', 'departure', 'newPo', 'freight', 'printdoc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseOrderRequest $request, $id)
    {
        try {

            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $purchaseOrder->update($request->only(
                'po_number',
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
                'wiring_instruction_id'
            ));

            return response()->json(['id' => $id, 'status' => 'success', 'msg' => 'Purchase Order updated successfully.']);
        } catch (Exception $e) {

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

        $lastPo = DB::table('purchase_orders')
            ->orderBy('id', 'desc')
            ->value('po_number');
        $newPo = $lastPo
        ? str_pad(((int)$lastPo + 1) % 10000, 4, '0', STR_PAD_LEFT)
        : '0001';

        $shipment_terms       = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $supplier             = Supplier::query()->select('id', 'supplier_name')->get();
        $payment_terms        = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $location             = Company::query()->get();
        $country              = Country::query()->get();
        $discharge            = SupplierPort::query()->get();
        $arrival              = SupplierPort::query()->get();
        $departure            = SupplierPort::query()->get();
        $consignment_location = Consignment::with('customer')->get();

        $printdoc = PrintDocDisclaimer::join('select_type_sub_categories', 'print_doc_disclaimers.select_type_sub_category_id', '=', 'select_type_sub_categories.id')
            ->where('select_type_sub_categories.select_type_sub_category_name', 'P.O. Terms')
            ->select('print_doc_disclaimers.id', 'print_doc_disclaimers.policy', 'print_doc_disclaimers.title')
            ->get();

        $freight = Expenditure::whereHas('vendorType', function ($query) {
            $query->where('vendor_type_name', 'INTRANSIT Freight');
        })->get();

        return view('purchase_order.__create', compact('shipment_terms', 'consignment_location', 'supplier', 'payment_terms', 'location', 'country', 'discharge', 'arrival', 'departure', 'newPo', 'freight', 'printdoc'));

    }
    public function getPoDetails($id)
    {

        $product        = Product::query()->get();
        $purchase_order = PurchaseOrder::findOrFail($id);
        $location       = Company::query()->get();
        $payment_terms  = AccountPaymentTerm::query()->get();
        $country        = Country::query()->get();
        $purchasePo     = PurchaseOrderProduct::query()
            ->where('po_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('purchase_order.po_detail.__po_details', compact('product', 'purchasePo', 'purchase_order', 'location', 'payment_terms', 'country'));

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
        $productPo      = PurchaseOrderProduct::where('po_id', $id)
            ->join('products', 'products.id', '=', 'purchase_order_products.product_id')
            ->select('purchase_order_products.*', 'products.*')
            ->get();
        $location      = Company::query()->get();
        $payment_terms = AccountPaymentTerm::query()->get();
        $country       = Country::query()->get();
        $purchasePo    = PurchaseOrderProduct::query()->where('po_id', $id)->get();

        return view('purchase_order.purchase_order_details', compact('product', 'purchasePo', 'purchase_order', 'location', 'payment_terms', 'country', 'productPo'));

    }
    public function SupplierInvoice($id)
    {
        $consignment_location = Consignment::with('customer')->get();
        $shipment_terms       = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $supplier             = Supplier::query()->select('id', 'supplier_name')->get();
        $payment_terms        = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $location             = Company::query()->get();
        $country              = Country::query()->get();
        $po_id                = $id;
        $services             = Service::query()->get();
        $account              = Account::query()->get();
        $products             = Product::query()->get();
        $purchase_order       = PurchaseOrder::findOrFail($id);
        $productPo            = PurchaseOrderProduct::where('po_id', $id)
            ->join('products', 'products.id', '=', 'purchase_order_products.product_id')
            ->select('purchase_order_products.*', 'products.*')
            ->get();

        $purchase_supplier = Supplier::findOrFail($purchase_order->supplier_id);

        return view('purchase_order.supplier_invoice.supplier_invoices', compact('consignment_location', 'account', 'services', 'products', 'po_id', 'shipment_terms', 'supplier', 'payment_terms', 'location', 'country', 'productPo', 'purchase_order', 'purchase_supplier'));

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
                'delivery_method',
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

            DB::table('purchase_order_products')
                ->where('po_id', $supplierInv->po_id)
                ->update(['sipl_created' => 1]);

            $serviceIds = is_array($request->service_id_) ? $request->service_id_ : [];

            $data          = [];
            $totalExtended = 0;

            foreach ($serviceIds as $key => $serviceId) {

                if (empty($serviceId)) {
                    continue;
                }

                if (! empty($request->input('po_id'))) {
                    $data[] = [
                        'po_id'       => $request->input('po_id'),
                        'service_id'  => $serviceId,
                        'account_id'  => $request->freight_forwarder_id_[$key],
                        'description' => $request->description_[$key],
                        'extended'    => $request->extended_[$key],
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];

                    $totalExtended += $request->extended_[$key];
                }
            }

            if (! empty($data)) {
                OtherCharges::insert($data);
            }

            $freightData = [
                'vendor_po_id'        => $request->input('po_id'),
                'transaction_number'  => $request->input('po_id'),
                'invoice_number'      => $request->input('invoice'),
                'invoice_date'        => $request->input('invoice_date'),
                'payments_terms_id'   => $request->input('payment_term_id'),
                'due_date'            => $request->input('due_date'),
                'contact_location_id' => $request->input('purchase_location_id'),
                'hold_payment_check'  => "",
                'hold_payment_reason' => "",
                'extended_total'      => $totalExtended,
            ];
            DB::table('vendor_po_new_bills')->insert($freightData);

            return response()->json(['id' => $supplierInv->id, 'status' => 'success', 'msg' => 'Supplier Invoice saved successfully.']);

        } catch (\Exception $e) {
            Log::error('Error saving Supplier Invoice: ' . $e->getMessage());
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
        $inventory        = Inventory::query()->where('sipl_id', $id)->get();

        $received_date  = null;
        $receive_status = "no";

        if (! $inventory->isEmpty()) {
            $received_date  = date('d-m-Y', strtotime($inventory[0]->received_date));
            $receive_status = "yes";
        }

        return view('purchase_order.supplier_invoice.supplier_invoice_packing_list', compact('receive_status', 'received_date', 'inventory', 'product', 'purchasePo', 'purchase_order', 'location', 'payment_terms', 'country', 'supplier_invoice'));

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
    public function getPoProductPoDataTableList($id)
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

    public function fetchPolicy($id)
    {

        $policy = PrintDocDisclaimer::find($id);

        if ($policy) {
            return response()->json(['policy' => $policy->policy]);
        }

        return response()->json(['policy' => ''], 404);
    }

    public function poInternalNoteSave(CreatePoInternalNoteRequest $request)
    {
        try {
            $this->purchaseOrderRepository->poInternalNoteSave($request->only('po_internal_notes', 'purchase_order_id'));
            return response()->json(['status' => 'success', 'msg' => 'Internal Notes saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving internal notes: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the internal notes.']);
        }
    }
    public function poGetInternalNotes(Request $request)
    {
        $result = $this->purchaseOrderRepository->getPoInternalNotes($request->id);

        return response()->json(['status' => 'success', 'data' => $result]);
    }

    public function poApproveCheck($id)
    {
        $po = $this->purchaseOrderRepository->dataFetchFromProductApprove($id);
        if ($po) {
            return response()->json([
                'success'              => true,
                'data'                 => $po,
                'sub_total'            => $po->sub_total,
                'extended_total'       => $po->extended_total,
                'approval_status'      => $po->approval_status,
                'approval_status_note' => $po->approval_status_note,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Po not found',
            ]);
        }
    }

    public function updatePoStatus(Request $request)
    {
        try {

            $purchaseOrder                       = PurchaseOrder::findOrFail($request->po_id);
            $purchaseOrder->approval_status      = $request->status;
            $purchaseOrder->approval_status_note = $request->notes;
            $purchaseOrder->approval_date        = now();
            $purchaseOrder->approved_state       = 1;
            $purchaseOrder->save();

            return response()->json(['message' => 'Purchase Order updated successfully.'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to update Purchase Order. ' . $e->getMessage()], 500);
        }
    }

    public function closePo($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);

        if (! $purchaseOrder) {
            return response()->json(['message' => 'Purchase order not found'], 404);
        }

        $purchaseOrder->status = 'Closed';
        $purchaseOrder->save();

        return response()->json(['message' => 'Purchase order closed successfully'], 200);
    }
    public function FetchPurchaseData($id)
    {
        $vendor = $this->purchaseOrderRepository->dataFetchFromLocation($id);
        if ($vendor) {
            return response()->json([
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
    }
    public function FetchShipLocationData($id)
    {
        $vendor = $this->purchaseOrderRepository->dataFetchFromLocation($id);
        if ($vendor) {
            return response()->json([
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
    }
}
