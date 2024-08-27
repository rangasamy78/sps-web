<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\TransactionStarting;
use Illuminate\Support\Facades\Log;
use App\Repositories\TransactionStartingRepository;

class TransactionStartingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $transactionStartingRepository;

    public function __construct(TransactionStartingRepository $transactionStartingRepository)
    {
        $this->transactionStartingRepository = $transactionStartingRepository;
    }

    public function index()
    {
        $transactionStartings = TransactionStarting::latest()->first();
        return view('transaction_starting.transaction_startings', compact('transactionStartings'));
    }

    public function save(Request $request)
    {
        try {
            $lastInsertId = $this->transactionStartingRepository->save($request->only('transaction_starting_number_id', 'po_starting_number', 'supplier_invoice_starting_number', 'pre_sale_starting_number', 'sale_order_starting_number', 'delivery_starting_number', 'invoice_starting_number', 'finance_charge_invoice_starting_number'));
            return response()->json(['status' => 'success', 'msg' => 'Transaction Starting Number saved successfully.', 'lastId' => $lastInsertId ?? $request->id]);
        } catch (Exception $e) {
            Log::error('Error saving Transaction Starting Number: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Transaction Starting Number.']);
        }
    }
}
