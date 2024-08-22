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
            return response()->json(['status' => 'success', 'msg' => 'Linked account saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving linked account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the linked account.']);
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
            return response()->json(['status' => 'success', 'msg' => 'Linked account updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating linked account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the linked account.']);
        }
    }

    public function destroy($id)
    {
        try {
            $linkedAccount = $this->linkedAccountRepository->findOrFail($id);
            if ($linkedAccount) {
                $this->linkedAccountRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Linked account deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Linked account not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting linked account: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the linked account.']);
        }
    }
    
    public function getLinkedAccountDataTableList(Request $request)
    {
        return $this->linkedAccountRepository->dataTable($request);
    }
}
