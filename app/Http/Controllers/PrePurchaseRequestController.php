<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\EventType;
use App\Models\UnitMeasure;
use App\Models\ShipmentTerm;
use Illuminate\Http\Request;
use App\Models\AccountPaymentTerm;
use App\Models\PrePurchaseRequest;
use App\Models\PrintDocDisclaimer;
use App\Models\SpecialInstruction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PrePurchaseRequestRepository;
use App\Http\Requests\InternalNote\CreateInternalNoteRequest;
use App\Services\PrePurchaseRequest\PrePurchaseRequestService;
use App\Http\Requests\PrePurchaseRequest\CreatePrePurchaseRequest;
use App\Http\Requests\PrePurchaseRequest\UpdatePrePurchaseRequest;

class PrePurchaseRequestController extends Controller
{
    public $prePurchaseRequestService;
    public $prePurchaseRequestRepository;

    public function __construct(PrePurchaseRequestRepository $prePurchaseRequestRepository, PrePurchaseRequestService $prePurchaseRequestService)
    {
        $this->prePurchaseRequestService    = $prePurchaseRequestService;
        $this->prePurchaseRequestRepository = $prePurchaseRequestRepository;
    }

    public function index()
    {
        $suppliers = Supplier::query()->pluck('supplier_name', 'id');
        $users     = User::query()->select(DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'id')->get()->pluck('name', 'id');
        return view('pre_purchase_request.pre_purchase_requests', compact('suppliers', 'users'));
    }

    public function create()
    {
        $data = $this->__getDropDownData();
        return view('pre_purchase_request.create', compact('data'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrePurchaseRequest $request)
    {
        try {
            $this->prePurchaseRequestRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Pre Purchase Request saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving state: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the state.']);
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
        $pre_purchase_request = PrePurchaseRequest::query()->with(['supplier', 'user'])->findOrFail($id);
        $data                 = $this->__getDropDownData();
        return view('pre_purchase_request.show', ['pre_purchase_request' => $pre_purchase_request, 'data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data                 = $this->__getDropDownData();
        $pre_purchase_request = $this->prePurchaseRequestRepository->findOrFail($id);

        return view('pre_purchase_request.edit', ['pre_purchase_request' => $pre_purchase_request, 'data' => $data]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrePurchaseRequest $request, PrePurchaseRequest $prePurchaseRequest)
    {
        try {
            $this->prePurchaseRequestRepository->update($request->only('name', 'code'), $prePurchaseRequest->id);
            return response()->json(['status' => 'success', 'msg' => 'Pre Purchase Request updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating pre purchase request: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the pre purchase request.']);
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
            $prePurchaseRequest = $this->prePurchaseRequestRepository->findOrFail($id);
            if ($prePurchaseRequest) {
                $this->prePurchaseRequestRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Pre Purchase Request deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Pre Purchase Request not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting pre purchase request: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the pre purchase request.']);
        }
    }

    public function getPrePurchaseRequestDataTableList(Request $request)
    {
        return $this->prePurchaseRequestRepository->dataTable($request);
    }

    private function __getDropDownData()
    {
        $uoms                = UnitMeasure::query()->pluck('unit_measure_name', 'id');
        $products            = Product::query()
                               ->select(DB::raw("CONCAT(product_name, ' (', product_sku, ')') as product_name_sku"), 'id')
                               ->pluck('product_name_sku', 'id');
        $countries           = Country::query()->pluck('country_name', 'id');
        $users               = User::query()->select(DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'id')->get()->pluck('name', 'id');
        $suppliers           = Supplier::query()->pluck('supplier_name', 'id');
        $shipmentTerms       = ShipmentTerm::query()->pluck('shipment_term_name', 'id');
        $companies           = Company::query()->pluck('company_name', 'id');
        $specialInstructions = SpecialInstruction::query()->pluck('special_instruction_name', 'id');
        $accountPaymentTerms = AccountPaymentTerm::query()->pluck('payment_label', 'id');
        $printDocDisclaimers = PrintDocDisclaimer::with(['select_type_category'])
            ->whereHas('select_type_category', function ($query) {
                $query->where('select_type_category_name', PrintDocDisclaimer::PRE_PURCHASE_TERMS);
            })
            ->pluck('title', 'id');
        $eventTypes         = EventType::query()->pluck('event_type_name', 'id');
        return compact('uoms','products','countries', 'users', 'suppliers', 'printDocDisclaimers', 'shipmentTerms', 'companies', 'specialInstructions', 'accountPaymentTerms','eventTypes');
    }

    public function getSupplierAddress(Request $request)
    {
        $supplierId = $request->query('id');
        $address    = $this->prePurchaseRequestService->getSupplierAddress($supplierId);

        if (isset($address['error'])) {
            return response()->json(['status' => 'false', 'error' => $address['error']]);
        }

        return response()->json(['status' => 'success', 'data' => $address]);
    }

    public function getSupplierPrimaryAddress(Request $request)
    {
        $contactId = $request->query('id');
        $address   = $this->prePurchaseRequestService->getSupplierPrimaryAddress($contactId);

        if (isset($address['error'])) {
            return response()->json(['status' => 'false', 'error' => $address['error']]);
        }

        return response()->json(['status' => 'success', 'data' => $address]);
    }

    public function getPurchaseLocationAddress(Request $request)
    {
        $purchaseId = $request->query('id');
        $address    = $this->prePurchaseRequestService->getPurchaseLocationAddress($purchaseId);

        if (isset($address['error'])) {
            return response()->json(['status' => 'false', 'error' => $address['error']]);
        }

        return response()->json(['status' => 'success', 'data' => $address]);
    }

    public function getShipToLocationAddress(Request $request)
    {
        $shipToLocationId = $request->query('id');
        $address          = $this->prePurchaseRequestService->getShipToLocationAddress($shipToLocationId);

        if (isset($address['error'])) {
            return response()->json(['status' => 'false', 'error' => $address['error']]);
        }

        return response()->json(['status' => 'success', 'data' => $address]);
    }

    public function getPrePurchaseTermPolicy(Request $request)
    {
        $prePurchaseTermId = $request->query('id');
        $policy            = $this->prePurchaseRequestService->getPrePurchaseTermPolicy($prePurchaseTermId);

        if (isset($policy['error'])) {
            return response()->json(['status' => 'false', 'error' => $policy['error']]);
        }

        return response()->json($policy);
    }

    public function internalNoteSave(CreateInternalNoteRequest $request)
    {
        try {
            $this->prePurchaseRequestRepository->internalNoteSave($request->only('internal_notes','pre_purchase_request_id','user_id'));
            return response()->json(['status' => 'success', 'msg' => 'Internal Notes saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving internal notes: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the internal notes.']);
        }
    }

    public function getInternalNotes(Request $request)
    {
        $result = $this->prePurchaseRequestRepository->getInternalNotes($request->id);

        return response()->json(['status' => 'success', 'data' => $result]);
    }

    public function getContactAddress(Request $request)
    {
        $contactId = $request->query('id');
        $address    = $this->prePurchaseRequestService->getContactAddress($contactId);

        if (isset($address['error'])) {
            return response()->json(['status' => 'false', 'error' => $address['error']]);
        }

        return response()->json(['status' => 'success', 'data' => $address]);
    }
}
