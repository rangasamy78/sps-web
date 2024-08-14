<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;
use App\Repositories\PaymentMethodRepository;
use App\Services\PaymentMethod\PaymentMethodService;
use App\Http\Requests\PaymentMethod\{CreatePaymentMethodRequest, UpdatePaymentMethodRequest};

class PaymentMethodController extends Controller
{
    public  $paymentMethodService;
    public  $paymentMethodRepository;

    public function __construct(PaymentMethodRepository $paymentMethodRepository, PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function index()
    {
        return view('payment_method.payment_methods', [
            'data' => $this->paymentMethodService->getAllData()
        ]);
    }

    public function store(CreatePaymentMethodRequest $request)
    {
        try {
            $this->paymentMethodRepository->store($request->only('payment_method_name', 'linked_account_id', 'account_type_id', 'is_transaction_required'));
            return response()->json(['status' => 'success', 'msg' => 'Payment Method saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Payment Method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Payment Method.']);
        }
    }

    public function show($id)
    {
        $model = $this->paymentMethodRepository->findOrFail($id);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = $this->paymentMethodRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        try {
            $this->paymentMethodRepository->update($request->only('payment_method_name', 'linked_account_id', 'account_type_id', 'is_transaction_required'), $paymentMethod->id);
            return response()->json(['status' => 'success', 'msg' => 'Payment Method updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Payment Method: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Payment Method.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->paymentMethodRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Payment Method deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Payment Method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Payment Method.']);
        }
    }

    public function getPaymentMethodDataTableList(Request $request)
    {
        return $this->paymentMethodRepository->dataTable($request);
    }
}
