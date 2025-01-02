<?php

namespace App\Http\Controllers\Quote\Lines;

use Exception;
use App\Models\Quote;
use App\Models\Account;
use App\Models\Company;
use App\Models\Customer;
use App\Models\QuoteProduct;
use App\Models\QuoteService;
use App\Models\PaymentMethod;
use App\Models\QuoteReceiveDeposit;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Quote\Lines\QuoteReceiveDepositRepository;
use App\Http\Requests\Quote\Lines\CreateQuoteReceiveDepositRequest;

class QuoteReceiveDepositController extends Controller
{
    private $quoteReceiveDepositRepository;
    public function __construct(QuoteReceiveDepositRepository $quoteReceiveDepositRepository)
    {
        $this->quoteReceiveDepositRepository = $quoteReceiveDepositRepository;
    }
    public function index($id)
    {
        $data = $this->getDropDownData();
        $quote = Quote::findOrFail($id);
        $salesTax = $quote->sales_tax;
        $tax = $salesTax?->tax_code_component->first();
        $taxRate = $tax?->rate ?? 0;
        $quoteItemTax = QuoteProduct::where('quote_id', $id)->where('is_tax', '1')->sum('product_amount');
        $quoteServiceTax = QuoteService::where('quote_id', $id)->where('is_tax', '1')->sum('service_amount');
        $taxAmount = (($quoteItemTax + $quoteServiceTax) * $taxRate) / 100;
        $quoteItemAmount = QuoteProduct::where('quote_id', $id)->sum('product_amount');
        $quoteServiceAmount = QuoteService::where('quote_id', $id)->sum('service_amount');
        $total = round($taxAmount + $quoteItemAmount + $quoteServiceAmount, 2);
        $opportunity = $quote->opportunities;
        $customer = $opportunity?->customer;
        $location = $opportunity?->location;
        $receiveAmount = QuoteReceiveDeposit::where('quote_id', $id)->sum('receive_amount');
        $currentBalanceDue = round($total - $receiveAmount, 2);
        return view('quote.line.receive_deposits', compact(
            'data',
            'quote',
            'opportunity',
            'customer',
            'location',
            'total',
            'currentBalanceDue'
        ));
    }

    public function store(CreateQuoteReceiveDepositRequest $request)
    {
        try {
            $quoteId = $request->input('quote_id');
            $this->quoteReceiveDepositRepository->store($request->only('quote_id', 'customer_id', 'cash_account_id', 'receipt_code', 'deposit_date', 'payment_method_id', 'reference', 'reference_date', 'authorization', 'check_date', 'check_code', 'receive_amount', 'net_amount_due', 'quote_amount_percentage', 'address', 'suite', 'city', 'state', 'zip', 'memo', 'account_id', 'location_id', 'description', 'amount', 'internal_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Quote Recieve Deposit saved successfully.', 'quote_id' => $quoteId]);
        } catch (Exception $e) {
            Log::error('Error saving Quote Recieve Deposit: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Quote Recieve Deposit.']);
        }
    }

    public function getDropDownData()
    {
        $companies = Company::query()->select('id', 'company_name')->get();
        $customers = Customer::query()->select('id', 'customer_name', 'customer_code', 'mobile', 'address')->get();
        $accounts = Account::query()->select('id', 'account_name')->get();
        $paymentMethods = PaymentMethod::query()->pluck('payment_method_name', 'id');
        return compact('companies', 'customers', 'accounts', 'paymentMethods');
    }
}
