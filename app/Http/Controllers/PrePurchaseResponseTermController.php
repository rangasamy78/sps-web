<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Supplier;
use App\Models\ShipmentTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductSupplier;
use App\Models\PrePurchaseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\PrePurchaseResponseTerm;
use App\Interfaces\EmailServiceInterface;
use App\Mail\SupplierRequestProductTotalMail;
use App\Models\PrePurchaseRequestSupplierRequest;
use App\Http\Requests\PrePurchaseResponseTerm\CreatePrePurchaseResponseTermRequest;

class PrePurchaseResponseTermController extends Controller
{
    protected $emailService;

    public function __construct(EmailServiceInterface $emailService)
    {
        $this->emailService = $emailService;
    }

    public function create($pre_purchase_response_id)
    {
        $data                          = $this->__getDropDownData();
        $pre_purchase_supplier_request = PrePurchaseRequestSupplierRequest::query()->with(['supplier', 'user', 'shipment_term', 'account_payment_term'])->find($pre_purchase_response_id);
        $reqProducts                   = ProductSupplier::query()->where('pre_purchase_request_id', $pre_purchase_supplier_request->pre_purchase_request_id)->where('supplier_id', $pre_purchase_supplier_request->supplier_id)->get();
        return view('pre_purchase_request.partials.pre_purchase_response_term.create', compact('data', 'reqProducts', 'pre_purchase_supplier_request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrePurchaseResponseTermRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $responseTerm = PrePurchaseResponseTerm::create($request->only([
                    'supplier_id',
                    'pre_purchase_request_id',
                    'requested_by_name',
                    'requested_payment_terms',
                    'requested_shipment_terms',
                    'required_ship_date',
                    'response_payment_terms',
                    'response_shipment_term_id',
                    'response_shipment_terms',
                    'response_ship_date',
                ]));

                $products = $request->input('product');
                foreach ($products as $product) {
                    $supplierProduct = $supplierAddress = ProductSupplier::with(['supplier'])->find($product['id']);
                    if ($supplierProduct) {
                        $supplierProduct->update([
                            'requested_product' => $product['requested_product'],
                            'response_qty'      => $product['response_qty'],
                            'unit_price'        => $product['unit_price'],
                            'total_price'       => $product['total_price'],
                            'comments'          => $product['comments'],
                        ]);

                        list($user, $supplier) = $this->getUserAndSupplier($supplierProduct->supplier_id);
                        $details = [
                            'content' => $supplierAddress,
                            'response' => $responseTerm,
                            'products'  => $products,
                        ];
                    Mail::to($user->email)->send(new SupplierRequestProductTotalMail($details));
                    Mail::to($supplier->email)->send(new SupplierRequestProductTotalMail($details));
                    }
                }
            });
            return response()->json(['status' => 'success', 'msg' => 'Product Response saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Product.']);
        }
    }

    private function __getDropDownData()
    {
        $users         = User::query()->select(DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'id')->get()->pluck('name', 'id');
        $suppliers     = Supplier::query()->pluck('supplier_name', 'id');
        $shipmentTerms = ShipmentTerm::query()->pluck('shipment_term_name', 'id');

        return compact('users', 'suppliers', 'shipmentTerms');
    }

    public function createComplete($pre_purchase_request_id, $supplier_request_id)
    {
        $data                 = $this->__getDropDownData();
        $pre_purchase_request = PrePurchaseRequest::query()->with(['supplier', 'user', 'shipment_term', 'account_payment_term'])->findOrFail($pre_purchase_request_id);
        $reqProducts          = ProductSupplier::query()->where('supplier_id', $supplier_request_id)->where('pre_purchase_request_id', $pre_purchase_request_id)->get();
        return view('pre_purchase_request.partials.pre_purchase_complete.create', compact('pre_purchase_request', 'data', 'reqProducts', 'pre_purchase_request_id', 'supplier_request_id'));
    }

    public function completeStore(Request $request)
    {
        try {
            $supplierReqs                     = PrePurchaseRequestSupplierRequest::query()->where('pre_purchase_request_id', $request->pre_purchase_request_id)->where('supplier_id', $request->supplier_request_id)->first();
            $supplierReqs->resend_request     = DB::raw('resend_request + 1');
            $supplierReqs->status             = 1;
            $supplierReqs->response_ship_date = Carbon::today()->toDateString();
            $supplierReqs->update_response    = 1;
            $supplierReqs->save();

            return response()->json(['status' => 'success', 'msg' => 'Response saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Product.']);
        }
    }

    public function sendEmailsIfRequired($supplierProduct, $products, $user, $supplier)
    {
        $details = [
            'subject'  => 'Supplier Request Product Mail',
            'content'  => $supplierProduct,
            'products' => $products,
        ];
        // Send emails
        $this->emailService->sendToUser($user, $details);
        $this->emailService->sendToSupplier($supplier, $details);
    }

    public function getUserAndSupplier($supplier_id)
    {
        $user = User::findOrFail(1);
        $supplier = Supplier::findOrFail($supplier_id);

        return [$user, $supplier];
    }

    public function SupplierResponseView(Request $request) {

        $suppliers = Supplier::query()->find($request->supplier_id);
        $terms    = PrePurchaseResponseTerm::query()->where('supplier_id', $request->supplier_id)->where('pre_purchase_request_id', $request->pre_purchase_request_id)->first();
        $products = ProductSupplier::query()->where('supplier_id', $request->supplier_id)->where('pre_purchase_request_id', $request->pre_purchase_request_id)->get();

        $html = view('pre_purchase_request.partials.pre_purchase_response_term.show', compact('suppliers', 'terms', 'products'))->render();

        return response()->json([
            'status' => true,
            'html' => $html,
        ]);
    }

    public function updateStatus(Request $request)
    {
        try {
            $item = ProductSupplier::find($request->id);
            $item->status = $request->status;
            $item->save();

            return response()->json(['status' => 'success', 'msg' => 'Response saved successfully.']);
        } catch (\Exception $e) {
            \Log::error('Update Status Error: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the status.'], 500);
        }
    }

    public function rejectStatus(Request $request)
    {
        try {
            $item = ProductSupplier::find($request->id);
            $item->reject_status = $request->reject_status;
            $item->save();

            return response()->json(['status' => 'success', 'msg' => 'Reject saved successfully.']);
        } catch (\Exception $e) {
            \Log::error('Update Status Error: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the status.'], 500);
        }
    }
}
