<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ShipmentTerm;
use App\Models\SupplierInvoice;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseOrderProduct;
use App\Repositories\SupplierInvoiceRepository;
use App\Http\Requests\ProductColor\{CreateSupplierInvoiceRequest, UpdateSupplierInvoiceRequest};

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
        return view('supplier_invoice_packing_list.__create', compact('shipment_terms', 'supplier', 'payment_terms', 'location', 'country','newPo'));

    }

    public function store(CreateSupplierInvoiceRequest $request)
    {
        try {
            $this->supplierInvoiceRepository->store($request->only('po_id',
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
            return response()->json(['status' => 'success', 'msg' => 'Supplier Invoce saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Supplier Invoce: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Invoce.']);
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
        $model = $this->supplierInvoiceRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierInvoiceRequest $request, ProductColor $productColor)
    {
        try {
            $this->supplierInvoiceRepository->update($request->only('po_id',
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
                    'total'), $productColor->id);
            return response()->json(['status' => 'success', 'msg' => 'Supplier Invoce updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Supplier Invoce: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Supplier Invoce.']);
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
            // Log the exception for debugging purposes
            Log::error('Error deleting Supplier Invoce: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Supplier Invoce.']);
        }
    }
    public function getSupplierInvoiceDataTableList(Request $request)
    {
        return $this->supplierInvoiceRepository->dataTable($request);
    }
}
