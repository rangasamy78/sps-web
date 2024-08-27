<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\AccountReceivableAgingPeriod;
use App\Repositories\AccountReceivableAgingPeriodRepository;

class AccountReceivableAgingPeriodController extends Controller
{
    private $accountReceivableAgingPeriodRepository;
    public function __construct(AccountReceivableAgingPeriodRepository $accountReceivableAgingPeriodRepository)
    {
        $this->accountReceivableAgingPeriodRepository = $accountReceivableAgingPeriodRepository;
    }

    public function index()
    {
        $accountReceivableAgingPeriod = AccountReceivableAgingPeriod::latest()->first();
        return view('account_receivable_aging_period.account_receivable_aging_periods', compact('accountReceivableAgingPeriod'));
    }

    public function save(Request $request)
    {
        try {
            $accountReceivableAgingPeriod=$this->accountReceivableAgingPeriodRepository->save($request->only('account_receivable_aging_period_id','ar_invoice_date_start_1','ar_invoice_date_end_1','ar_invoice_date_start_2','ar_invoice_date_end_2','ar_invoice_date_start_3','ar_invoice_date_end_3','ar_invoice_date_start_4','ar_invoice_date_end_4','ar_due_date_start_2','ar_due_date_end_2','ar_due_date_start_3','ar_due_date_end_3','ar_due_date_start_4','ar_due_date_end_4','ar_due_date_start_5','ar_due_date_end_5','do_not_show_on_report'));
            return response()->json(['status' => 'success', 'msg' => 'Account Receivable Aging Period saved successfully.', 'lastId' => $accountReceivableAgingPeriod ? $accountReceivableAgingPeriod : $request->id]);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error saving account receivable aging period: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the account receivable aging period.']);
        }
    }
}
