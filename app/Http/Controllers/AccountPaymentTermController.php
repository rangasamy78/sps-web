<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\Log;
use App\Repositories\{ AccountPaymentTermRepository, DropDownRepository };
use App\Http\Requests\AccountPaymentTerm\{ CreateAccountPaymentTermRequest, UpdateAccountPaymentTermRequest };

class AccountPaymentTermController extends Controller
{
    public DropDownRepository $dropDownRepository;
    private AccountPaymentTermRepository $accountPaymentTermRepository;

    public function __construct(AccountPaymentTermRepository $accountPaymentTermRepository, DropDownRepository $dropDownRepository)
    {
        $this->dropDownRepository = $dropDownRepository;
        $this->accountPaymentTermRepository = $accountPaymentTermRepository;
    }

    public function index()
    {
        $account_types = $this->dropDownRepository->dropDownPopulate('account_types');
        return view('account_payment_term.account_payment_terms', compact('account_types'));
    }

    public function store(CreateAccountPaymentTermRequest $request)
    {
        try {
            $this->accountPaymentTermRepository->store($request->only('payment_standard_date_driven','payment_code','payment_label','payment_type','payment_net_due_day','payment_not_used_sales','payment_not_used_purchases','payment_discount_percent','payment_threshold_days'));
            return response()->json(['status' => 'success', 'msg' => 'Payment Term saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Payment Term: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Payment Term.']);
        }
    }

    public function show($id)
    {
        $model = $this->accountPaymentTermRepository->findOrFail($id);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = $this->accountPaymentTermRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateAccountPaymentTermRequest $request, AccountPaymentTerm $accountPaymentTerm)
    {
        try {
            $this->accountPaymentTermRepository->update($request->only('payment_standard_date_driven','payment_code','payment_label','payment_type','payment_net_due_day','payment_not_used_sales','payment_not_used_purchases','payment_discount_percent','payment_threshold_days'), $accountPaymentTerm->id);
            return response()->json(['status' => 'success', 'msg' => 'Payment Term updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Payment Term: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Payment Term.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->accountPaymentTermRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Payment Term deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Payment Term: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Payment Term.']);
        }
    }

    public function getAccountPaymentTermDataTableList(Request $request)
    {
        return $this->accountPaymentTermRepository->dataTable($request);
    }
}