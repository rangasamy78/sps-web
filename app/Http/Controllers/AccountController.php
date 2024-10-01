<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Account;
use App\Models\Company;
use App\Models\Currency;
use App\Models\AccountType;
use App\Models\AccountFile;
use Illuminate\Http\Request;
use App\Models\AccountSubType;
use App\Models\SpecialAccountType;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;
use App\Http\Requests\Account\{CreateAccountRequest, UpdateAccountRequest};


class AccountController extends Controller
{
    private AccountRepository $accountRepository;
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        $accounts = Account::query()->select('id', 'account_name', 'account_number')->get();
        $accountTypes = AccountType::query()->select('id', 'account_type_name')->get();
        $accountSubTypes = AccountSubType::query()->select('id', 'sub_type_name')->get();
        $specialAccountTypes = SpecialAccountType::query()->select('id', 'special_account_type_name')->get();
        return view('account.accounts', compact('accounts', 'accountTypes', 'accountSubTypes', 'specialAccountTypes'));
    }

    public function create()
    {
        $accountTypes = AccountType::query()->select('id', 'account_type_name')->get();
        $accountSubTypes = AccountSubType::query()->select('id', 'sub_type_name')->get();
        $specialAccountTypes = SpecialAccountType::query()->select('id', 'special_account_type_name')->get();
        $currencies = Currency::query()->select('id', 'currency_name', 'currency_code')->get();
        $companies = Company::query()->select('id', 'company_name')->get();
        return view('account.__create', compact('accountTypes', 'accountSubTypes', 'specialAccountTypes', 'currencies', 'companies'));
    }

    public function getIsSubAccountOf($id)
    {
        $type = AccountType::where('id', $id)
            ->where(function ($query) {
                $query->where('account_type_name', 'like', '%Bank%')
                    ->orWhere('account_type_name', 'like', '%Asset-Bank%');
            })
            ->first();
        $accounts = Account::where('account_type_id', $id)->get();
        return response()->json([
            'isSubAccountOf' => $accounts->isNotEmpty(),
            'data' => $accounts,
            'type' => $type
        ]);
    }

    public function store(CreateAccountRequest $request)
    {
        try {
            $this->accountRepository->store($request->only('account_name', 'account_number', 'account_type_id', 'account_sub_type_id', 'special_account_type_id', 'account_operating_location_id', 'alternate_number', 'alternate_name', 'is_sub_account_of_id', 'currency_id', 'statement_end_day', 'is_default_account', 'is_budgeted_account', 'is_tax_account', 'is_reconciled_account', 'is_allow_bank_reconciliation', 'bank_name', 'branch_name', 'manager_name', 'phone', 'fax', 'website', 'swift_code', 'routing_number', 'bank_account_number', 'is_allow_printing_checks', 'internal_notes', 'status'));
            return response()->json(['status' => 'success', 'msg' => 'Account saved successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error saving Account : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Account.']);
        }
    }

    public function show($id)
    {
        $account = $this->accountRepository->findOrFail($id);
        $accountFiles = AccountFile::where('account_id', $id)->get();
        $parentAccount = null;
        if (!empty($accounts->is_sub_account_of_id)) {
            $parentAccount = Account::find($account->is_sub_account_of_id);
        }
        return view('account.__show', compact('account', 'parentAccount', 'accountFiles'));
    }

    public function edit($id)
    {
        $accountTypes = AccountType::select('id', 'account_type_name')->get();
        $accountSubTypes = AccountSubType::select('id', 'sub_type_name')->get();
        $specialAccountTypes = SpecialAccountType::select('id', 'special_account_type_name')->get();
        $currencies = Currency::select('id', 'currency_name', 'currency_code')->get();
        $companies = Company::select('id', 'company_name')->get();
        $account = $this->accountRepository->findOrFail($id);
        $isSubAccountTypes = Account::where('account_type_id', $account->account_type_id)
            ->where('id', '!=', $account->id)
            ->get();
        $type = AccountType::where('id', $account->account_type_id)
            ->where(function ($query) {
                $query->where('account_type_name', 'like', '%Bank%')
                    ->orWhere('account_type_name', 'like', '%Asset-Bank%');
            })
            ->first();
        $display = $type ? 'display:block;' : 'display:none;';
        return view('account.__edit', compact('account', 'accountTypes', 'accountSubTypes', 'specialAccountTypes', 'currencies',  'companies', 'isSubAccountTypes', 'display'));
    }

    public function update(UpdateAccountRequest $request, Account $account)
    {
        try {
            $this->accountRepository->update($request->only('account_name', 'account_number', 'account_type_id', 'account_sub_type_id', 'special_account_type_id', 'account_operating_location_id', 'alternate_number', 'alternate_name', 'is_sub_account_of_id', 'currency_id', 'statement_end_day', 'is_default_account', 'is_budgeted_account', 'is_tax_account', 'is_reconciled_account', 'is_allow_bank_reconciliation', 'bank_name', 'branch_name', 'manager_name', 'phone', 'fax', 'website', 'swift_code', 'routing_number', 'bank_account_number', 'is_allow_printing_checks', 'internal_notes', 'status'), $account->id);
            return response()->json(['status' => 'success', 'msg' => 'Account updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Account.']);
        }
    }

    public function updateStatus($id)
    {
        try {
            $account = $this->accountRepository->findOrFail($id);
            $account->status = $account->status === 1 ? 0 : 1;
            $account->save();
            return response()->json(['status' => 'success', 'msg' => 'Account Status updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating  status of Account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Status of Account.']);
        }
    }

    public function destroy($id)
    {
        try {
            $account = $this->accountRepository->findOrFail($id);
            if ($account) {
                $this->accountRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Account deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Account not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Account.']);
        }
    }
    public function getAccountDataTableList(Request $request)
    {
        return $this->accountRepository->dataTable($request);
    }

    public function getInAccountDataTableList(Request $request)
    {
        return $this->accountRepository->inAccountDataTable($request);
    }
}
