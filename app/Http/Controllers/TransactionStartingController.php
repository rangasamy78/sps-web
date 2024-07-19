<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\TransactionStarting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\TransactionStartingRepository;
use App\Http\Requests\TransactionStarting\{CreateTransactionStartingRequest, UpdateTransactionStartingRequest};

class TransactionStartingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private TransactionStartingRepository $transactionStartingRepository;

    public function __construct(TransactionStartingRepository $transactionStartingRepository)
    {
        $this->transactionStartingRepository = $transactionStartingRepository;
    }

    public function index()
    {
        return view('transaction_starting.transaction_startings');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateTransactionStartingRequest $request)
    {
        try {
            $this->transactionStartingRepository->store($request->only('type', 'starting_number'));
            return response()->json(['status' => 'success', 'msg' => 'Transaction Starting Number saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Transaction Starting Number: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Transaction Starting Number.']);
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
        $model = $this->transactionStartingRepository->findOrFail($id);
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
        $model = $this->transactionStartingRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionStartingRequest $request, TransactionStarting $transactionStarting)
    {
        try {
            $this->transactionStartingRepository->update($request->only('type', 'starting_number'), $transactionStarting->id);
            return response()->json(['status' => 'success', 'msg' => 'Transaction Starting Number updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Transaction Starting Number: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Transaction Starting Number.']);
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
            $this->transactionStartingRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Transaction Starting Number deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Transaction Starting Number: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Transaction Starting Number.']);
        }
    }
    public function getTransactionStartingDataTableList(Request $request)
    {
        return $this->transactionStartingRepository->dataTable($request);
    }
}
