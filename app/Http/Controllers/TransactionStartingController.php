<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\TransactionStarting;
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
            return response()->json(['status' => 'success', 'msg' => 'Transaction starting number saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving transaction starting number: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the transaction starting number.']);
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
            return response()->json(['status' => 'success', 'msg' => 'Transaction starting number updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating transaction starting number: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the transaction starting number.']);
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
            $transactionStarting = $this->transactionStartingRepository->findOrFail($id);
            if ($transactionStarting) {
                $this->transactionStartingRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Transaction starting number deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Transaction starting number not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting transaction starting number: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the transaction starting number.']);
        }
    }
    public function getTransactionStartingDataTableList(Request $request)
    {
        return $this->transactionStartingRepository->dataTable($request);
    }
}
