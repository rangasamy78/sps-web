<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\AccountTypeRepository;
use App\Http\Requests\AccountType\{CreateAccountTypeRequest, UpdateAccountTypeRequest};

class AccountTypeController extends Controller
{
    private AccountTypeRepository $accountTypeRepository;

    public function __construct(AccountTypeRepository $accountTypeRepository)
    {
        $this->accountTypeRepository = $accountTypeRepository;
    }

    public function index()
    {
        return view('account_type.account_types');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAccountTypeRequest $request)
    {
        try {
            $this->accountTypeRepository->store($request->only('account_type_name'));
            return response()->json(['status' => 'success', 'msg' => 'Account Type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Account Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Account Type.']);
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
        $model = $this->accountTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->accountTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountTypeRequest $request, AccountType $accountType)
    {
        try {
            $this->accountTypeRepository->update($request->only('account_type_name'), $accountType->id);
            return response()->json(['status' => 'success', 'msg' => 'Account Type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Account Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Account Type.']);
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
            $this->accountTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Account Type deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Account Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Account Type.']);
        }
    }

    public function getAccountTypeDataTableList(Request $request) {
        return $this->accountTypeRepository->dataTable($request);
    }

}
