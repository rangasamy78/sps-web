<?php

namespace App\Http\Controllers\Quote\Lines;

use Exception;
use App\Models\Product;
use App\Models\QuoteProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Quote\Lines\QuoteProductRepository;
use App\Http\Requests\Quote\Lines\CreateQuoteProductRequest;

class QuoteProductController extends Controller
{
    private $quoteProductRepository;
    public function __construct(QuoteProductRepository $quoteProductRepository)
    {
        $this->quoteProductRepository = $quoteProductRepository;
    }

    public function store(CreateQuoteProductRequest $request)
    {
        try {
            $this->quoteProductRepository->store($request->only('quote_id', 'product_id', 'description', 'is_sold_as', 'product_quantity', 'product_unit_price', 'product_amount', 'is_tax', 'is_hide_line', 'notes', 'inventory_restriction'));
            return response()->json(['status' => 'success', 'msg' => 'Quote Product saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Quote Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Quote Product.']);
        }
    }
    public function edit($id)
    {
        $model = $this->quoteProductRepository->findOrFail($id);
        $productName = Product::where('id', $model->product_id)->first()->product_name;
        return response()->json([
            'model' => $model,
            'product_name' => $productName
        ]);
    }


    public function update(CreateQuoteProductRequest $request, QuoteProduct $quoteProduct)
    {
        try {
            $this->quoteProductRepository->update($request->only('quote_id', 'product_id', 'description', 'is_sold_as', 'product_quantity', 'product_unit_price', 'product_amount', 'is_tax', 'is_hide_line', 'notes', 'inventory_restriction'), $quoteProduct->id);
            return response()->json(['status' => 'success', 'msg' => 'Quote Item updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote Item: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Quote Item.']);
        }
    }

    public function destroy($id)
    {
        try {
            $quoteProduct = $this->quoteProductRepository->findOrFail($id);
            if ($quoteProduct) {
                $this->quoteProductRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Product deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Quote Product not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Quote Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Product.']);
        }
    }
    public function getAllProductDataTableList(Request $request)
    {
        return $this->quoteProductRepository->dataTableGetProduct($request);
    }
    public function getAllServiceProductDataTableList(Request $request, $id)
    {
        return $this->quoteProductRepository->dataTable($request, $id);
    }
}
