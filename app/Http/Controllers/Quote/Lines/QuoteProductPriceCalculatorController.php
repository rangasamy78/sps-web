<?php

namespace App\Http\Controllers\Quote\Lines;

use Exception;
use App\Models\Supplier;
use App\Models\TaxComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\QuoteProductPriceCalculator;
use App\Models\QuotePriceCalculatorInventoryDetail;
use App\Repositories\Quote\Lines\{QuoteProductPriceCalculatorRepository, QuotePriceCalculatorInventoryDetailRepository};
use App\Http\Requests\Quote\Lines\{CreateQuoteProductPriceCalculatorsRequest, CreateQuotePriceCalculatorInventoryDetailRequest};

class QuoteProductPriceCalculatorController extends Controller
{

    private $quoteProductPriceCalculatorRepository;
    private $quotePriceCalculatorInventoryDetailRepository;
    public function __construct(QuoteProductPriceCalculatorRepository $quoteProductPriceCalculatorRepository, QuotePriceCalculatorInventoryDetailRepository $quotePriceCalculatorInventoryDetailRepository)
    {
        $this->quoteProductPriceCalculatorRepository = $quoteProductPriceCalculatorRepository;
        $this->quotePriceCalculatorInventoryDetailRepository = $quotePriceCalculatorInventoryDetailRepository;
    }

   
    public function getSupplierDetail($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            return response()->json([
                'data' => $supplier,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Supplier not found.',
            ], 404);
        }
    }
    public function getTaxAmount($id)
    {
        try {
            $taxComponents = TaxComponent::where('tax_code_id', $id)->get();

            if ($taxComponents->isEmpty()) {
                return response()->json([
                    'error' => 'Tax not found.',
                ], 404);
            }
            $taxCodeTotal = $taxComponents->sum('tax_code_total');

            return response()->json([
                'data' => $taxCodeTotal,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while retrieving the tax.',
            ], 500);
        }
    }

    public function store(CreateQuoteProductPriceCalculatorsRequest $request, CreateQuotePriceCalculatorInventoryDetailRequest $inventoryRequest)
    {
        try {
            $data = $request->validated();
            $quoteProductId = $data['quote_product_id'];
            $existingPriceCalculator = $this->quoteProductPriceCalculatorRepository->findByQuoteProductId($quoteProductId);
            if ($existingPriceCalculator) {
                QuotePriceCalculatorInventoryDetail::where('quote_product_price_calculator_id', $existingPriceCalculator->id)->delete();
                $this->quoteProductPriceCalculatorRepository->delete($existingPriceCalculator->id);
            }
            $priceCalculator = $this->quoteProductPriceCalculatorRepository->store($data);
            $products = $inventoryRequest->validated()['products'];
            $productsData = array_map(function ($product) use ($priceCalculator) {
                return [
                    'quote_product_price_calculator_id' => $priceCalculator->id,
                    'serial_number' => $product['serial_number'] ?? null,
                    'lot_name' => $product['lot_name'] ?? null,
                    'bundle' => $product['bundle'] ?? null,
                    'length' => $product['length'] ?? 0,
                    'width' => $product['width'] ?? 0,
                    'slabs' => $product['slabs'] ?? 0,
                    'area' => $product['area'] ?? 0,
                    'unit_cost' => $product['unit_cost'] ?? 0,
                    'amount' => $product['amount'] ?? 0,
                    'notes' => $product['notes'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $products);
            $this->quotePriceCalculatorInventoryDetailRepository->store($productsData);
            return response()->json([
                'status' => 'success',
                'msg' => 'Quote Product Price Calculator saved successfully.',
            ]);
        } catch (Exception $e) {
            Log::error('Error saving Quote Product Price Calculator: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the Quote Product Price Calculator. Please try again later.',
            ]);
        }
    }

    public function show($id)
    {
        $priceCalculator = QuoteProductPriceCalculator::where('quote_product_id', $id)
            ->first();
        if (!$priceCalculator) {
            return response()->json([
                'status' => 'error',
                'message' => 'Price calculator not found.',
            ], 404);
        }
        $inventory = QuotePriceCalculatorInventoryDetail::where('quote_product_price_calculator_id', $priceCalculator->id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => [
                'price_calculator' => $priceCalculator,
                'inventory' => $inventory,
            ],
        ]);
    }

    public function destroy($id)
    {
        try {
            $priceInventory = $this->quotePriceCalculatorInventoryDetailRepository->findOrFail($id);
            if ($priceInventory) {
                $this->quotePriceCalculatorInventoryDetailRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Price Calculator Inventory deleted successfully.'], 200);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Quote Price Calculator Inventory not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Quote Price Calculator Inventory: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Price Calculator Inventory.']);
        }
    }
}
