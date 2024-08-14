<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\DefaultLinkAccountRepository;
use App\Services\DefaultLinkAccount\DefaultLinkAccountService;

class DefaultLinkAccountController extends Controller
{
    public DefaultLinkAccountService $defaultLinkAccountService;
    public DefaultLinkAccountRepository $defaultLinkAccountRepository;

    public function __construct(DefaultLinkAccountRepository $defaultLinkAccountRepository, DefaultLinkAccountService $defaultLinkAccountService)
    {
        $this->defaultLinkAccountService = $defaultLinkAccountService;
        $this->defaultLinkAccountRepository = $defaultLinkAccountRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('default_link_account.default_link_accounts', [
            'data' => $this->defaultLinkAccountService->getAllData()
        ]);
    }

    public function inventoryAssetSave(Request $request)
    {
        try {
            $this->defaultLinkAccountRepository->inventoryAssetSave($request->only('id','account_for_new_product_id'));
            return response()->json(['status' => 'success', 'msg' => 'Inventory Asset saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error Inventory Asset: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving inventory asset.']);
        }
    }

    public function inventoryInTransitOnTransferSave(Request $request)
    {
        try {
            $this->defaultLinkAccountRepository->inventoryInTransitOnTransferSave($request->only('id','inventory_in_transit_id'));
            return response()->json(['status' => 'success', 'msg' => 'Inventory In Transit On Transfer Saved Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error inventory in transit on transfer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving inventory in transit on transfer.']);
        }
    }

    public function inventoryAdjustmentSave(Request $request)
    {
        try {
            $this->defaultLinkAccountRepository->inventoryAdjustmentSave($request->only('id','positive_adjustment_id','inventory_write_off_id','reclassify_renumbering_split_id','revaluation_adjustment_id'));
            return response()->json(['status' => 'success', 'msg' => 'Inventory Adjustment Saved Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error inventory adjustment: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving inventory adjustment.']);
        }
    }

    public function bankingPaymentSave(Request $request)
    {
        try {
            $this->defaultLinkAccountRepository->bankingPaymentSave($request->only('id','supplier_payment_cash_account_id','vendor_payment_cash_account_id','customer_payment_cash_account_id','miscellaneous_expense_id'));
            return response()->json(['status' => 'success', 'msg' => 'Banking Payment Saved Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error banking payment: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving banking payment.']);
        }
    }

    public function otherChargesDiscountsVarianceSave(Request $request)
    {
        try {
            $this->defaultLinkAccountRepository->otherChargesDiscountsVarianceSave($request->only('id','other_charges_in_po_sipl_id','payments_discount_id','restocking_fees_on_pur_return_id','freight_account_on_purchase_id','supplier_invoice_variance_id','supp_credit_memos_variance_id'));
            return response()->json(['status' => 'success', 'msg' => 'Other Charges Discounts Variance Saved Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error other charges discounts variance: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving other charges discounts variance.']);
        }
    }

    public function saleSave(Request $request)
    {
        try {
            $this->defaultLinkAccountRepository->saleSave($request->only('id','customer_ar_id','sales_income_product_id','sales_income_service_id','cogs_account_id','restocking_fee_income_account_id','sales_tax_liability_account_id','sales_discount_id'));
            return response()->json(['status' => 'success', 'msg' => 'Sale Saved Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error sale: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving sale.']);
        }
    }

    public function accountingSave(Request $request)
    {
        try {
            $this->defaultLinkAccountRepository->accountingSave($request->only('id','retained_earning_id'));
            return response()->json(['status' => 'success', 'msg' => 'Accounting Saved Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error accounting: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving accounting.']);
        }
    }

    public function bankingReceiptSave(Request $request)
    {
        try {
            $this->defaultLinkAccountRepository->bankingReceiptSave($request->only('id','receipt_cash_account_id','miscellaneous_income_id'));
            return response()->json(['status' => 'success', 'msg' => 'Banking Receipt Saved Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error banking receipt: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving banking receipt.']);
        }
    }
}
