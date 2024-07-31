<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Repositories\CurrencyRepository;
use App\Http\Requests\Currency\{CreateCurrencyRequest, UpdateCurrencyRequest};

class CurrencyController extends Controller
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }
    public function index()
    {
        return view('currency.currencies');
    }
    public function store(CreateCurrencyRequest $request)
    {
        try {
            $this->currencyRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Currency saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Currency: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Currency.']);
        }
    }

    public function show($id)
    {
        $model = $this->currencyRepository->findOrFail($id);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = $this->currencyRepository->findOrFail($id);
        return response()->json($model);
    }
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        try {
            $this->currencyRepository->update($request->all(), $currency->id);
            return response()->json(['status' => 'success', 'msg' => 'Currency updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Currency: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Currency.']);
        }
    }
    public function destroy($id)
    {
        try {
            $this->currencyRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Currency deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Currency: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Currency.']);
        }
    }
    public function getCurrencyDataTable(Request $request)
    {
        return $this->currencyRepository->dataTable($request);
    }
}
