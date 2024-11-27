<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use App\Models\Country;
use App\Models\VendorPo;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Models\LinkedAccount;
use App\Models\PaymentMethod;
use App\Models\VendorPoDetails;
use App\Models\VendorPoNewBill;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\VendorPoRepository;
use App\Http\Requests\Product\{CreateNewBillRequest, CreatePrepaymentRequest,CreateVendorPoRequest};

class VendorPoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private VendorPoRepository $vendorPoRepository;

    public function __construct(VendorPoRepository $vendorPoRepository)
    {
        $this->vendorPoRepository = $vendorPoRepository;
    }

    public function index()
    {

        return view('vendor_po.vendor_pos');

    }
    public function create()
    {
        $expendure     = Expenditure::query()->get();
        $location      = Company::query()->get();
        $payment_terms = AccountPaymentTerm::query()->get();
        $country       = Country::query()->get();
        return view('vendor_po.__create', compact('expendure', 'location', 'payment_terms', 'country'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateVendorPoRequest $request)
    {
        DB::beginTransaction(); 
        try {
            $vendorPo = $this->vendorPoRepository->store($request->only(
                'transaction_number', 'vendor_id', 'location_id', 'transaction_date',
                'eta_date', 'payment_term_id', 'address', 'address2', 'city', 'state',
                'zip', 'country_id', 'phone', 'fax', 'email', 'extended_total', 'printed_notes', 'internal_notes', 'vendor_po_terms_id'
            ));
                      
            $items = $request->input('items', []);
            foreach ($items as $item) {
                if (!empty($item['service'])) { 
                    VendorPoDetails::create([
                        'vendor_po_id'   => $vendorPo->id,
                        'service'        => $item['service_id'],
                        'purchase_check' => isset($item['purchase_check']) ? (int)$item['purchase_check'] : 0,
                        'purchase'       => $item['purchase'] ?? null,
                        'description'    => $item['description'] ?? null,
                        'alt_qty'        => $item['alt_qty'] ?? null,
                        'alt_uom'        => $item['alt_uom'] ?? null,
                        'alt_ucost'      => $item['alt_ucost'] ?? null,
                        'quantity'       => $item['quantity'] ?? null,
                        'uom'            => $item['uom'] ?? null,
                        'unit_cost'      => $item['unit_cost'] ?? null,
                        'extended'       => $item['extended'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['id' => $vendorPo->id, 'status' => 'success', 'msg' => 'Vendor PO saved successfully.']);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error saving vendor PO: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the vendor PO.']);
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
        $vendor_po         = VendorPo::with(['vendor', 'location', 'vendor_po_details.service'])->findOrFail($id);
        $payment_methods   = PaymentMethod::query()->pluck('payment_method_name', 'id');
        $vendor_po_details = VendorPoDetails::with('service')->where('vendor_po_id', $id)->get();
        $expendure         = Expenditure::query()->get();
        $location          = Company::query()->get();
        $payment_terms     = AccountPaymentTerm::query()->get();
        $country           = Country::query()->get();
        return view('vendor_po.__show', compact('vendor_po', 'payment_methods', 'vendor_po_details', 'expendure', 'location', 'payment_terms', 'country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor_po = VendorPo::with(['vendor_po_details.service'])->findOrFail($id);

        $expendure     = Expenditure::query()->get();
        $location      = Company::query()->get();
        $payment_terms = AccountPaymentTerm::query()->get();
        $country       = Country::query()->get();
        return view('vendor_po.__edit', compact('vendor_po', 'expendure', 'location', 'payment_terms', 'country'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorPo $vendorPo)
    {      
        DB::beginTransaction();

        try {
            $this->vendorPoRepository->update($request->only(
                'transaction_number', 'vendor_id', 'location_id', 'transaction_date',
                'eta_date', 'payment_term_id', 'address', 'address2', 'city', 'state',
                'zip', 'country_id', 'phone', 'fax', 'email', 'extended_total',
                'printed_notes', 'internal_notes', 'vendor_po_terms_id'
            ), $vendorPo->id);

            $vendorPoDetail = DB::table('vendor_po_details')->where('vendor_po_id', $vendorPo->id)->first();
          
            if ($vendorPoDetail) {
                $deleted = DB::table('vendor_po_details')->where('vendor_po_id', $vendorPo->id)->delete();
            }

            $items = $request->input('items', []);
            foreach ($items as $item) {
                if (!empty($item['service'])) {
                    VendorPoDetails::create([
                        'vendor_po_id'   => $vendorPo->id,
                        'service'        => $item['service_id'],
                        'purchase_check' => isset($item['purchase_check']) ? (int)$item['purchase_check'] : 0,
                        'purchase'       => $item['purchase'] ?? null,
                        'description'    => $item['description'] ?? null,
                        'alt_qty'        => $item['alt_qty'] ?? null,
                        'alt_uom'        => $item['alt_uom'] ?? null,
                        'alt_ucost'      => $item['alt_ucost'] ?? null,
                        'quantity'       => $item['quantity'] ?? null,
                        'uom'            => $item['uom'] ?? null,
                        'unit_cost'      => $item['unit_cost'] ?? null,
                        'extended'       => $item['extended'] ?? null,
                    ]);
                }
            }

            DB::commit(); 
            return response()->json(['id' => $vendorPo->id, 'status' => 'success', 'msg' => 'Vendor PO updated successfully.']);

        } catch (Exception $e) {
            DB::rollBack(); 
            Log::error('Error updating vendor PO: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the vendor PO.']);
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
            $vendor = $this->vendorPoRepository->findOrFail($id);
            if ($vendor) {

                if ($vendor->status == 0) {
                    return response()->json(['status' => 'false', 'msg' => 'Vendor is already inactive.']);
                }
                $vendor->status = 0;
                $vendor->save();

                return response()->json(['status' => 'success', 'msg' => 'Vendor marked as inactive.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Vendor not found.']);
            }
        } catch (Exception $e) {

            Log::error('Error updating vendor status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the vendor status.']);
        }
    }

    public function getVendorPoDataTableList(Request $request)
    {
        return $this->vendorPoRepository->dataTable($request);
    }

    public function FetchServiceData(Request $request)
    {
        return $this->vendorPoRepository->dataFetchFromservice($request);
    }
    public function FetchVendorData($id)
    {
        $vendor = $this->vendorPoRepository->dataFetchFromVendor($id);
        if ($vendor) {
            return response()->json([
                'success' => true,
                'data'    => $vendor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found',
            ]);
        }
    }
    public function getVendorPoDetails($id)
    {
        $vendor_po = VendorPo::with(['vendor', 'location', 'vendor_po_details.service'])->findOrFail($id);
        $payment_methods   = PaymentMethod::query()->pluck('payment_method_name', 'id');
        $expendure     = Expenditure::query()->get();
        $location      = Company::query()->get();
        $payment_terms = AccountPaymentTerm::query()->get();
        $country       = Country::query()->get();
        return view('vendor_po.__details', compact('vendor_po', 'payment_methods','expendure', 'location', 'payment_terms', 'country'));
    }
    public function FetchVendorPoDetails($request)
    {
        return $this->vendorPoRepository->dataTablePoDetails($request);
    }

    public function prePayment($id)
    {
        $vendor_po       = VendorPo::with(['vendor', 'location', 'vendor_po_details.service'])->findOrFail($id);
        $linked_accounts = LinkedAccount::query()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->account_code . ' - ' . $item->account_name];
            });

        $payment_methods = PaymentMethod::query()->pluck('payment_method_name', 'id');

        return view('vendor_po.pre_payment.pre_payment', compact('linked_accounts', 'payment_methods', 'vendor_po'));

    }
    public function prepaymentSave(CreatePrepaymentRequest $request)
    {
        try {
            $data = $request->only([
                'vendor_po_id',
                'cash_account_id',
                'payment_date',
                'date_on_check',
                'check',
                'payment_method_id',
                'memo',
                'account_id',
                'description',
                'amount',
                'internal_notes',
                'vendor_po_total',
                'misc_amount',
                'net_amount_due',
                'po_percentage',
                'updated_at',
            ]);

            $this->vendorPoRepository->storePayment($data);
            return response()->json(['status' => 'success', 'msg' => 'Payment saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving tax code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Payment.']);
        }
    }
    public function Vpayment($id)
    {
        $vendor_po         = VendorPo::with(['vendor', 'location', 'vendor_po_details.service'])->findOrFail($id);
        $payment_methods   = PaymentMethod::query()->pluck('payment_method_name', 'id');
        $vendor_po_details = VendorPoDetails::with('service')->where('vendor_po_id', $id)->get();
        $expendure         = Expenditure::query()->get();
        $location          = Company::query()->get();
        $payment_terms     = AccountPaymentTerm::query()->get();
        $country           = Country::query()->get();
        return view('vendor_po.pre_payment.__vpayment', compact('vendor_po', 'payment_methods', 'vendor_po_details', 'expendure', 'location', 'payment_terms', 'country'));
    }
    public function newBill($id)
    {
        $vendor_po       = VendorPo::with(['vendor', 'location', 'vendor_po_details.service'])->findOrFail($id);
        $expendure       = Expenditure::query()->get();
        $location        = Company::query()->get();
        $payment_terms   = AccountPaymentTerm::query()->get();
        $country         = Country::query()->get();
        $linked_accounts = LinkedAccount::query()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->account_code . ' - ' . $item->account_name];
            });

        $payment_methods = PaymentMethod::query()->pluck('payment_method_name', 'id');
        $vendor_po       = VendorPo::with(['vendor_po_details.service'])->findOrFail($id);

        return view('vendor_po.bills.new_bill', compact('payment_terms', 'country', 'linked_accounts', 'expendure', 'location', 'payment_methods', 'vendor_po'));
    }

    public function newBillSave(CreateNewBillRequest $request)
    {
        try {
            $data = $request->only([
                'vendor_po_id',
                'transaction_number',
                'invoice_number',
                'invoice_date',
                'payments_terms_id',
                'due_date',
                'contact_location_id',
                'hold_payment_check',
                'hold_payment_reason',
                'created_at',
                'updated_at',
            ]);
            $bill = $this->vendorPoRepository->storenewBill($data);
            $billDetails = $request->input('bill_details'); 

            if ($billDetails && is_array($billDetails)) {
                foreach ($billDetails as $detail) {
                    $detailData = [
                        'bill_check'        => $detail['bill_check'] ?? null,
                        'vendor_po_id'      => $detail['vendor_po_id'] ?? null,
                        'vendor_po_bill_id' => $bill->id, 
                        'account_id' => $detail['account_id'] ?? null,
                        'location_id'       => $detail['location_id'] ?? null,
                        'service'           => $detail['service'] ?? null,
                        'purchase_check'    => $detail['purchase_check'] ?? null,
                        'purchase'          => $detail['purchase'] ?? null,
                        'description'       => $detail['description'] ?? null,
                        'quantity'          => $detail['quantity'] ?? null,
                        'uom'               => $detail['uom'] ?? null,
                        'unit_cost'         => $detail['unit_cost'] ?? null,
                        'extended'          => $detail['extended'] ?? null,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                    $this->vendorPoRepository->storenewBillDetail($detailData);
                }
            }

            return response()->json(['status' => 'success', 'msg' => 'New Bill and details saved successfully.', 'id' => $bill->id]);
        } catch (Exception $e) {
            Log::error('Error saving new bill: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the New Bill.']);
        }
    }

    public function newBillDetails($id)
    {
        $vendor_bills = VendorPoNewBill::with(['vendorPo.expenditure'])->findOrFail($id);
        return view('vendor_po.bills.__new_bill_details', compact('vendor_bills'));
    }
}