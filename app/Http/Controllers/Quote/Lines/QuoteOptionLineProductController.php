<?php

namespace App\Http\Controllers\Quote\Lines;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\QuoteOptionLineProduct;
use App\Repositories\Quote\Lines\QuoteOptionLineProductRepository;
use App\Http\Requests\Quote\Lines\CreateQuoteOptionLineProductRequest;

class QuoteOptionLineProductController extends Controller
{
    private $quoteOptionLineProductRepository;
    public function __construct(QuoteOptionLineProductRepository $quoteOptionLineProductRepository)
    {
        $this->quoteOptionLineProductRepository = $quoteOptionLineProductRepository;
    }

    public function store(CreateQuoteOptionLineProductRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $quoteProductId = $validatedData['quote_product_id'];
            QuoteOptionLineProduct::where('quote_product_id', $quoteProductId)->delete();
            $productsData = array_map(function ($product) use ($validatedData, $quoteProductId) {
                return [
                    'quote_product_id' => $quoteProductId,
                    'product_id' => $product['product_id'],
                    'description' => $product['description'] ?? null,
                    'is_sold_as' => $product['is_sold_as'] ?? null,
                    'quantity' => $product['quantity'] ?? 0,
                    'unit_price' => $product['unit_price'] ?? 0.0,
                    'amount' => $product['amount'] ?? 0.0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $validatedData['products']);
            $this->quoteOptionLineProductRepository->store($productsData);
            return response()->json([
                'status' => 'success',
                'msg' => 'Quote Option Line Product saved successfully.'
            ]);
        } catch (Exception $e) {
            // Log the error message for debugging
            Log::error('Error saving Quote Option Line Product: ' . $e->getMessage());
            return response()->json([
                'status' => 'false',
                'msg' => 'An error occurred while saving the Quote Option Line Product. Please try again later.'
            ]);
        }
    }

    public function show($id)
    {
        $model = QuoteOptionLineProduct::join('products', 'quote_option_line_products.product_id', '=', 'products.id')
            ->where('quote_option_line_products.quote_product_id', $id)
            ->select('quote_option_line_products.*', 'products.product_name')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $model,
        ]);
    }

    public function destroy($id)
    {
        try {
            $optionLineProduct = $this->quoteOptionLineProductRepository->findOrFail($id);
            if ($optionLineProduct) {
                $this->quoteOptionLineProductRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Option Line Product deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'How did you hear option not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Quote Option Line Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Option Line Product.']);
        }
    }
    public function getAllOptionLineProductDataTableList(Request $request)
    {
        return $this->quoteOptionLineProductRepository->dataTableOptionLineProduct($request);
    }
}
