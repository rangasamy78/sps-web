<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\ShipmentTerm;
use Illuminate\Http\Request;
use App\Models\ProductSupplier;
use App\Models\PrePurchaseRequest;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PrePurchaseRequestProduct;
use App\Services\PrePurchaseRequest\PrePurchaseRequestService;
use App\Repositories\PrePurchaseRequestSupplierRequestRepository;
use App\Http\Requests\PrePurchaseRequestSupplierRequest\CreatePrePurchaseRequestSupplierRequest;
use App\Http\Requests\PrePurchaseRequestSupplierRequest\UpdatePrePurchaseRequestSupplierRequest;
use App\Http\Requests\PrePurchaseMultipleSupplierRequest\CreatePrePurchaseMultipleSupplierRequest;

class PrePurchaseRequestSupplierRequestController extends Controller
{
    public $prePurchaseRequestService;
    public $prePurchaseRequestSupplierRequestRepository;

    public function __construct(PrePurchaseRequestSupplierRequestRepository $prePurchaseRequestSupplierRequestRepository, PrePurchaseRequestService $prePurchaseRequestService)
    {
        $this->prePurchaseRequestService                   = $prePurchaseRequestService;
        $this->prePurchaseRequestSupplierRequestRepository = $prePurchaseRequestSupplierRequestRepository;
    }

    public function create(Request $request)
    {
        $pre_purchase_request_id   = $request->query('id');
        $data = $this->__getDropDownData();
        $reqProducts = PrePurchaseRequestProduct::query()->with(['product'])->where('pre_purchase_request_id', $pre_purchase_request_id)->get();
        $pre_purchase_supplier_request = PrePurchaseRequest::query()->with(['supplier', 'user','shipment_term','account_payment_term'])->find($pre_purchase_request_id);
        return view('pre_purchase_request.partials.supplier_request.create', compact('data', 'pre_purchase_request_id', 'reqProducts','pre_purchase_supplier_request'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrePurchaseRequestSupplierRequest $request)
    {
        try {
            $this->prePurchaseRequestSupplierRequestRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Supplier Requests saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Supplier Requests: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Requests.']);
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
        $model = $this->prePurchaseRequestSupplierRequestRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $pre_purchase_request_id       = $request->query('id');
        $data                          = $this->__getDropDownData();
        $pre_purchase_supplier_request = $this->prePurchaseRequestSupplierRequestRepository->findOrFail($id);
        $reqProducts = PrePurchaseRequestProduct::query()->with(['product'])->where('pre_purchase_request_id', $pre_purchase_request_id)->get();
        return view('pre_purchase_request.partials.supplier_request.edit', compact('pre_purchase_supplier_request', 'data', 'id', 'reqProducts','pre_purchase_request_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrePurchaseRequestSupplierRequest $request, $id)
    {
        try {
            $this->prePurchaseRequestSupplierRequestRepository->update($request->all(), $id);
            return response()->json(['status' => 'success', 'msg' => 'Supplier Requests updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Supplier Requests : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Supplier Requests .']);
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
            $vendorType = $this->prePurchaseRequestSupplierRequestRepository->findOrFail($id);
            if ($vendorType) {
                $this->prePurchaseRequestSupplierRequestRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier Requests deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Supplier Requests not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Supplier Requests : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Supplier Requests .']);
        }
    }

    public function getPrePurchaseRequestSupplierRequestDataTableList(Request $request)
    {
        return $this->prePurchaseRequestSupplierRequestRepository->dataTable($request);
    }

    private function __getDropDownData()
    {
        $countries           = Country::query()->pluck('country_name', 'id');
        $users               = User::query()->select(DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'id')->get()->pluck('name', 'id');
        $suppliers           = Supplier::query()->pluck('supplier_name', 'id');
        $accountPaymentTerms = AccountPaymentTerm::query()->pluck('payment_label', 'id');
        $shipmentTerms       = ShipmentTerm::query()->pluck('shipment_term_name', 'id');
        return compact('countries', 'users', 'suppliers', 'accountPaymentTerms', 'shipmentTerms');
    }

    public function multipleCreate(Request $request)
    {
        $id   = $request->query('id');
        $data = $this->__getDropDownData();
        $selectedSuppliers = ProductSupplier::query()->select('supplier_id')->where('pre_purchase_request_id', $id)->groupBy('supplier_id')->get()->pluck('supplier_id')->toArray();
        $reqProducts = PrePurchaseRequestProduct::query()->where('pre_purchase_request_id', $id)->get();
        return view('pre_purchase_request.partials.supplier_request.multiple_create', compact('data', 'id','reqProducts','selectedSuppliers'));
    }


    public function getSupplierDetails(Request $request)
    {
        $supplierIds = (array)$request->query('id');
        $suppliers    = Supplier::query()->whereIn('id', $supplierIds)->with(['remit_country','shipment_term'])->get();
        return response()->json($suppliers);
    }

    public function multipleStore(CreatePrePurchaseMultipleSupplierRequest $request)
    {
        try {
            $this->prePurchaseRequestSupplierRequestRepository->multipleStore($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Multiple Supplier Requests saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Supplier Requests: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Requests.']);
        }
    }

    public function getSupplierCompareDetails(Request $request)
    {
        $supplierIds = explode(',', $request->ids);
        $suppliers = DB::table('pre_purchase_request_supplier_requests as pprsr')
                ->join('product_suppliers as ps', 'pprsr.pre_purchase_request_id', '=', 'ps.pre_purchase_request_id')
                ->join('suppliers as s', 'pprsr.supplier_id', '=', 's.id')
                ->join('products as p', 'ps.product_id', '=', 'p.id')
                ->join('shipment_terms as st', 'pprsr.shipment_term_id', '=', 'st.id')
                ->join('account_payment_terms as apt', 'pprsr.payment_term_id', '=', 'apt.id')
                ->where('ps.pre_purchase_request_id', $request->pre_purchase_request_id)
                ->where('ps.supplier_id', $supplierIds)
                ->select(
                    'pprsr.*',
                    's.id as supplier_id',
                    'p.id as product_id',
                    'pprsr.pre_purchase_request_id as pre_purchase_request_id',
                    's.supplier_name',
                    'st.shipment_term_name',
                    'apt.payment_label',
                    'ps.qty',
                    'ps.unit_price',
                    'ps.total_price',
                    'ps.product_name',
                    'ps.product_sku',
                    'ps.generic_name',
                    'ps.generic_sku',
                    'ps.reject_status',
                )
                ->get();
        return response()->json($suppliers);
    }
}
