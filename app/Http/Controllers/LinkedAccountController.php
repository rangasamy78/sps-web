<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Models\LinkedAccount;
use App\Models\AccountSubType;
use Illuminate\Support\Facades\Log;
use App\Repositories\LinkedAccountRepository;
use App\Http\Requests\LinkedAccount\{CreateLinkedAccountRequest, UpdateLinkedAccountRequest};

class LinkedAccountController extends Controller
{
    private LinkedAccountRepository $linkedAccountRepository;

    public function __construct(LinkedAccountRepository $linkedAccountRepository)
    {
        $this->linkedAccountRepository = $linkedAccountRepository;
    }
    
    public function index()
    {
        $accountTypes = AccountType::query()->select('id', 'account_type_name')->get();
        $accountSubTypes = AccountSubType::query()->select('id', 'sub_type_name')->get();
        return view('linked_account.linked_accounts', compact('accountTypes', 'accountSubTypes'));
    }

    public function store(CreateLinkedAccountRequest $request)
    {
        try {
            $this->linkedAccountRepository->store($request->only('account_code', 'account_name', 'account_type', 'account_sub_type'));
            return response()->json(['status' => 'success', 'msg' => 'Linked Account saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Linked Account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Linked Account.']);
        }
    }

    public function show($id)
    {
        $model = $this->linkedAccountRepository->findOrFail($id);
        return response()->json($model);
    }
    
    public function edit($id)
    {
        $model = $this->linkedAccountRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateLinkedAccountRequest $request, LinkedAccount $linkedAccount)
    {
        try {
            $this->linkedAccountRepository->update($request->only('account_code', 'account_name', 'account_type', 'account_sub_type'), $linkedAccount->id);
            return response()->json(['status' => 'success', 'msg' => 'Linked Account updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Linked Account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Linked Account.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->linkedAccountRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Linked Account deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Linked Account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Linked Account.']);
        }
    }
    
    public function getLinkedAccountDataTableList(Request $request)
    {
        return $this->linkedAccountRepository->dataTable($request);
    }
}
