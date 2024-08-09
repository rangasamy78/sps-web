<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\AccountSubType;
use Illuminate\Support\Facades\Log;
use App\Repositories\AccountSubTypeRepository;
use App\Http\Requests\AccountSubType\{CreateAccountSubTypeRequest, UpdateAccountSubTypeRequest};

class AccountSubTypeController extends Controller
{
    private AccountSubTypeRepository $accountSubTypeRepository;

    public function __construct(AccountSubTypeRepository $accountSubTypeRepository)
    {
        $this->accountSubTypeRepository = $accountSubTypeRepository;
    }
    public function index()
    {
        return view('account_sub_type.account_sub_types');
    }
    public function store(CreateAccountSubTypeRequest $request)
    {
        try {
            $this->accountSubTypeRepository->store($request->only('sub_type_name'));
            return response()->json(['status' => 'success', 'msg' => 'Account Sub Type saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Account Sub Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Account Sub Type.']);
        }
    }

    public function show($id)
    {
        $model = $this->accountSubTypeRepository->findOrFail($id);
        return response()->json($model);
    }
    public function edit($id)
    {
        $model = $this->accountSubTypeRepository->findOrFail($id);
        return response()->json($model);
    }


    public function update(UpdateAccountSubTypeRequest $request, AccountSubType $accountSubType)
    {
        try {
            $this->accountSubTypeRepository->update($request->only('sub_type_name'), $accountSubType->id);
            return response()->json(['status' => 'success', 'msg' => 'Account Sub Type updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Account Sub Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Account Sub Type.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->accountSubTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Account Sub Type deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Account Sub Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Account Sub Type.']);
        }
    }
    public function getAccountSubTypeDataTableList(Request $request)
    {
        return $this->accountSubTypeRepository->dataTable($request);
    }
}
