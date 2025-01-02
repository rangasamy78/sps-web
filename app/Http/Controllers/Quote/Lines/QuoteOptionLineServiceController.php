<?php

namespace App\Http\Controllers\Quote\Lines;

use Exception;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\QuoteOptionLineService;
use App\Repositories\Quote\Lines\QuoteOptionLineServiceRepository;
use App\Http\Requests\Quote\Lines\CreateQuoteOptionLineServiceRequest;

class QuoteOptionLineServiceController extends Controller
{
    private $quoteOptionLineServiceRepository;
    public function __construct(QuoteOptionLineServiceRepository $quoteOptionLineServiceRepository)
    {
        $this->quoteOptionLineServiceRepository = $quoteOptionLineServiceRepository;
    }
    public function store(CreateQuoteOptionLineServiceRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $quoteProductId = $validatedData['quote_service_id'];
            QuoteOptionLineService::where('quote_service_id', $quoteProductId)->delete();
            $servicesData = array_map(function ($service) use ($validatedData, $quoteProductId) {
                return [
                    'quote_service_id' => $quoteProductId,
                    'service_id' => $service['service_id'],
                    'description' => $service['description'] ?? null,
                    'is_sold_as' => $service['is_sold_as'] ?? null,
                    'quantity' => $service['quantity'] ?? 0,
                    'unit_price' => $service['unit_price'] ?? 0.0,
                    'amount' => $service['amount'] ?? 0.0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $validatedData['services']);
            $this->quoteOptionLineServiceRepository->store($servicesData);
            return response()->json([
                'status' => 'success',
                'msg' => 'Quote Option Line Service saved successfully.'
            ]);
        } catch (Exception $e) {
            // Log the error message for debugging
            Log::error('Error saving Quote Option Line Service: ' . $e->getMessage());
            return response()->json([
                'status' => 'false',
                'msg' => 'An error occurred while saving the Quote Option Line Service. Please try again later.'
            ]);
        }
    }

    public function show($id)
    {
        $model = QuoteOptionLineService::join('services', 'quote_option_line_services.service_id', '=', 'services.id')
            ->where('quote_option_line_services.quote_service_id', $id)
            ->select('quote_option_line_services.*', 'services.service_name')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $model,
        ]);
    }

    public function destroy($id)
    {
        try {
            $optionLineService = $this->quoteOptionLineServiceRepository->findOrFail($id);
            if ($optionLineService) {
                $this->quoteOptionLineServiceRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Option Line Service deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Service not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Quote Option Line Service: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Option Line Service.']);
        }
    }

    public function getService(Request $request)
    {
        try {
            $id = $request->get('id');
            $service = Service::with('service_price')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $service,
            ]);
        } catch (Exception $e) {
            Log::error('Error in searchProduct: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching products.',
            ], 500);
        }
    }

    public function getAllOptionLineServiceDataTableList(Request $request)
    {
        return $this->quoteOptionLineServiceRepository->dataTableOptionLineService($request);
    }
}
