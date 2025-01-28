<?php

namespace App\Http\Controllers\Quote\Lines;

use Exception;
use App\Models\Quote;
use App\Models\Service;
use App\Models\QuoteService;
use App\Models\QuoteProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Quote\Lines\QuoteServiceRepository;
use App\Http\Requests\Quote\Lines\CreateQuoteServiceRequest;

class QuoteServiceController extends Controller
{
    private $quoteServiceRepository;
    public function __construct(QuoteServiceRepository $quoteServiceRepository)
    {
        $this->quoteServiceRepository = $quoteServiceRepository;
    }

    public function store(CreateQuoteServiceRequest $request)
    {
        try {
            $this->quoteServiceRepository->store($request->only('quote_id', 'service_id', 'description', 'is_sold_as', 'service_quantity', 'service_unit_price', 'service_amount', 'is_tax', 'is_hide_line'));
            $id = $request->input('quote_id');
            $quote = Quote::findOrFail($id);
            $salesTax = $quote->sales_tax;
            $tax = $salesTax?->tax_code_component->first();
            $taxRate = $tax?->rate ?? 0;
            $quoteItemTax = QuoteProduct::where('quote_id', $id)->where('is_tax', '1')->sum('product_amount');
            $quoteServiceTax = QuoteService::where('quote_id', $id)->where('is_tax', '1')->sum('service_amount');
            $taxAmount = (($quoteItemTax + $quoteServiceTax) * $taxRate) / 100;
            $quoteItemAmount = QuoteProduct::where('quote_id', $id)->sum('product_amount');
            $quoteServiceAmount = QuoteService::where('quote_id', $id)->sum('service_amount');
            $total = round($taxAmount + $quoteItemAmount + $quoteServiceAmount, 2);
            $quote->update([
                'total' => $total,
            ]);
            return response()->json(['status' => 'success', 'msg' => 'Quote Service saved successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error saving Quote Service: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Quote Service.']);
        }
    }

    public function edit($id)
    {
        $model = $this->quoteServiceRepository->findOrFail($id);
        $serviceName = Service::where('id', $model->service_id)->first()->service_name;
        return response()->json([
            'model' => $model,
            'service_name' => $serviceName
        ]);
    }

    public function update(CreateQuoteServiceRequest $request, QuoteService $quoteService)
    {
        try {
            $this->quoteServiceRepository->update($request->only('quote_id', 'service_id', 'description', 'is_sold_as', 'service_quantity', 'service_unit_price', 'service_amount', 'is_tax', 'is_hide_line'), $quoteService->id);
            $id = $request->input('quote_id');
            $quote = Quote::findOrFail($id);
            $salesTax = $quote->sales_tax;
            $tax = $salesTax?->tax_code_component->first();
            $taxRate = $tax?->rate ?? 0;
            $quoteItemTax = QuoteProduct::where('quote_id', $id)->where('is_tax', '1')->sum('product_amount');
            $quoteServiceTax = QuoteService::where('quote_id', $id)->where('is_tax', '1')->sum('service_amount');
            $taxAmount = (($quoteItemTax + $quoteServiceTax) * $taxRate) / 100;
            $quoteItemAmount = QuoteProduct::where('quote_id', $id)->sum('product_amount');
            $quoteServiceAmount = QuoteService::where('quote_id', $id)->sum('service_amount');
            $total = round($taxAmount + $quoteItemAmount + $quoteServiceAmount, 2);
            $quote->update([
                'total' => $total,
            ]);
            return response()->json(['status' => 'success', 'msg' => 'Quote Service updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote Service: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Quote Service.']);
        }
    }

    public function destroy($id)
    {
        try {
            $quoteService = $this->quoteServiceRepository->findOrFail($id);
            if ($quoteService) {
                $this->quoteServiceRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Service deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Quote Service not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Quote Service: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Service.']);
        }
    }

    public function getAllServiceDataTableList(Request $request)
    {
        return $this->quoteServiceRepository->dataTableGetService($request);
    }

    public function getQuoteEventDataTableList(Request $request, $id)
    {
        return $this->quoteServiceRepository->dataTable($request, $id);
    }
}
