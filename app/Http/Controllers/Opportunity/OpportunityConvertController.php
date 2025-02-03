<?php

namespace App\Http\Controllers\Opportunity;

use Exception;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\QuoteRepository;
use App\Repositories\VisitRepository;
use App\Repositories\SampleOrderRepository;
use App\Http\Requests\Quote\CreatequoteRequest;
use App\Http\Requests\Visit\CreateVisitRequest;
use App\Http\Requests\Visit\Convert\CreateConvertSampleOrderRequest;

class OpportunityConvertController extends Controller
{
    private SampleOrderRepository $sampleOrderRepository;
    private VisitRepository $visitRepository;
    private QuoteRepository $quoteRepository;
    public function __construct(VisitRepository $visitRepository, SampleOrderRepository $sampleOrderRepository, QuoteRepository $quoteRepository)
    {
        $this->sampleOrderRepository = $sampleOrderRepository;
        $this->visitRepository = $visitRepository;
        $this->quoteRepository = $quoteRepository;
    }

    public function saveConvertVisit(Request $request, CreateVisitRequest $visitRequest)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $visit = $this->visitRepository->store($visitRequest->validated());
            $productsData = $request->input('visit_products', []);
            if (is_string($productsData)) {
                $productsData = json_decode($productsData, true);
            }
            if (is_array($productsData)) {
                foreach ($productsData as $productData) {
                    $visit->products()->create([
                        'product_id' => $productData['product_id'] ?? null,
                        'is_sold_as' => $productData['is_sold_as'] ?? null,
                        'product_description' => $productData['product_description'] ?? null,
                        'product_quantity' => $productData['product_quantity'] ?? null,
                        'product_unit_price' => $productData['product_unit_price'] ?? null,
                        'product_amount' => $productData['product_amount'] ?? null,
                    ]);
                }
            } else {
                Log::error('Invalid product data format');
            }
            $servicesData = $request->input('visit_services', []);
            if (is_string($servicesData)) {
                $servicesData = json_decode($servicesData, true);
            }
            if (is_array($servicesData)) {
                foreach ($servicesData as $serviceData) {
                    $visit->services()->create([
                        'service_id' => $serviceData['service_id'] ?? null,
                        'service_description' => $serviceData['service_description'] ?? null,
                        'service_quantity' => $serviceData['service_quantity'] ?? null,
                        'service_unit_price' => $serviceData['service_unit_price'] ?? null,
                        'service_amount' => $serviceData['service_amount'] ?? null,
                        'is_tax' => $serviceData['is_tax'] ?? false,
                    ]);
                }
            } else {
                Log::error('Invalid service data format');
            }
            return response()->json([
                'status' => 'success',
                'msg' => 'Visit saved successfully.',
                'visit_id' => $visit->id,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving Visit: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the Visit.',
            ], 500);
        }
    }

    public function saveConvertQuote(Request $request, CreatequoteRequest $quoteRequest)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $quote = $this->quoteRepository->store($quoteRequest->validated());
            $productsData = $request->input('quote_products', []);
            if (is_string($productsData)) {
                $productsData = json_decode($productsData, true);
            }
            if (is_array($productsData)) {
                foreach ($productsData as $productData) {
                    $quote->quote_product()->create([
                        'product_id' => $productData['product_id'] ?? null,
                        'is_sold_as' => $productData['is_sold_as'] ?? null,
                        'description' => $productData['description'] ?? null,
                        'product_quantity' => $productData['product_quantity'] ?? null,
                        'product_unit_price' => $productData['product_unit_price'] ?? null,
                        'product_amount' => $productData['product_amount'] ?? null,
                        'is_tax' => $productData['is_tax'] ?? false,
                        'is_hide_line' => $productData['is_hide_line'] ?? false,
                    ]);
                }
            } else {
                Log::error('Invalid product data format');
            }
            $servicesData = $request->input('quote_services', []);
            if (is_string($servicesData)) {
                $servicesData = json_decode($servicesData, true);
            }
            if (is_array($servicesData)) {
                foreach ($servicesData as $serviceData) {
                    $quote->quote_service()->create([
                        'service_id' => $serviceData['service_id'] ?? null,
                        'is_sold_as' => $serviceData['is_sold_as'] ?? null,
                        'description' => $serviceData['description'] ?? null,
                        'service_quantity' => $serviceData['service_quantity'] ?? null,
                        'service_unit_price' => $serviceData['service_unit_price'] ?? null,
                        'service_amount' => $serviceData['service_amount'] ?? null,
                        'is_tax' => $serviceData['is_tax'] ?? false,
                        'is_hide_line' => $serviceData['is_hide_line'] ?? false,
                    ]);
                }
            } else {
                Log::error('Invalid service data format');
            }
            return response()->json([
                'status' => 'success',
                'msg' => 'Quote saved successfully.',
                'quote_id' => $quote->id,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving quote: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the quote.',
            ], 500);
        }
    }

    public function saveConvertSampleOrder(Request $request, CreateConvertSampleOrderRequest $sampleRequest)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $sampleOrder = $this->sampleOrderRepository->store($sampleRequest->validated());
            $productsData = $request->input('sample_order_products', []);
            if (is_string($productsData)) {
                $productsData = json_decode($productsData, true);
            }
            if (is_array($productsData)) {
                foreach ($productsData as $productData) {
                    $sampleOrder->sample_order_products()->create([
                        'product_id' => $productData['product_id'] ?? null,
                        'is_sold_as' => $productData['is_sold_as'] ?? null,
                        'product_description' => $productData['product_description'] ?? null,
                        'product_quantity' => $productData['product_quantity'] ?? null,
                        'sample_quantity' => $productData['sample_quantity'] ?? null,
                        'product_unit_price' => $productData['product_unit_price'] ?? null,
                        'product_amount' => $productData['product_amount'] ?? null,
                    ]);
                }
            } else {
                Log::error('Invalid product data format');
            }
            $servicesData = $request->input('sample_order_services', []);
            if (is_string($servicesData)) {
                $servicesData = json_decode($servicesData, true);
            }
            if (is_array($servicesData)) {
                foreach ($servicesData as $serviceData) {
                    $sampleOrder->sample_order_services()->create([
                        'service_id' => $serviceData['service_id'] ?? null,
                        'service_description' => $serviceData['service_description'] ?? null,
                        'service_quantity' => $serviceData['service_quantity'] ?? null,
                        'service_unit_price' => $serviceData['service_unit_price'] ?? null,
                        'service_amount' => $serviceData['service_amount'] ?? null,
                        'is_tax' => $serviceData['is_tax'] ?? false,
                    ]);
                }
            } else {
                Log::error('Invalid service data format');
            }
            return response()->json([
                'status' => 'success',
                'msg' => 'Sample order saved successfully.',
                'sample_order_id' => $sampleOrder->id,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving sample order: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the sample order.',
            ], 500);
        }
    }
}
