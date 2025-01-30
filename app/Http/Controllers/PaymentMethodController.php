<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Account;
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
            'data' => $this->paymentMethodService->getAllData(),
            'linked_accounts' => Account::query()->get()
        ]);
    }

    public function store(CreatePaymentMethodRequest $request)
    {
        try {
            $this->paymentMethodRepository->store($request->only('payment_method_name', 'linked_account_id', 'account_type_id', 'is_transaction_required'));
            return response()->json(['status' => 'success', 'msg' => 'Payment method saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving payment method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the payment method.']);
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
            return response()->json(['status' => 'success', 'msg' => 'Payment method updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating payment method: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the payment method.']);
        }
    }

    public function destroy($id)
    {
        try {
            $paymentMethod = $this->paymentMethodRepository->findOrFail($id);
            if ($paymentMethod) {
                $this->paymentMethodRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Payment method deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Payment method not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting payment method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the payment method.']);
        }
    }

    public function getPaymentMethodDataTableList(Request $request)
    {
        return $this->paymentMethodRepository->dataTable($request);
    }
}
