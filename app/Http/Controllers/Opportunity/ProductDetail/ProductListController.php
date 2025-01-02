<?php

namespace App\Http\Controllers\Opportunity\ProductDetail;

use Exception;
use App\Models\Service;
use App\Models\Product;
use App\Models\ServicePrice;
use Illuminate\Http\Request;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Opportunity\ProductDetail\ProductListRepository;


class ProductListController extends Controller
{
    private ProductListRepository $productListRepository;
    public function __construct(ProductListRepository $productListRepository)
    {
        $this->productListRepository = $productListRepository;
    }

    public function searchProduct(Request $request)
    {
        return $this->productListRepository->searchProductDataTable($request);
    }

    public function getProduct(Request $request)
    {
        try {
            $id = $request->get('id');
            $product = Product::with('price')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $product,
            ]);
        } catch (Exception $e) {
            Log::error('Error in searchProduct: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching products.',
            ], 500);
        }
    }

    public function getProductPrice(Request $request)
    {
        try {
            $id = $request->get('id');
            $product = Product::findOrFail($id);
            $price = ProductPrice::where('product_id', $product->id)->firstOrFail();
            return response()->json([
                'status' => 'success',
                'data' => $price
            ]);
        } catch (Exception $e) {
            Log::error('Error in searchProduct: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching products.',
            ], 500);
        }
    }

    public function getServicePrice(Request $request)
    {
        try {
            $id = $request->get('id');
            $service = Service::findOrFail($id);
            $price = ServicePrice::where('service_id', $service->id)->firstOrFail();
            return response()->json([
                'status' => 'success',
                'data' => [
                    'unit_price' => $price->homeowner_price, // Return only the unit price
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Error in searchProduct: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching products.',
            ], 500);
        }
    }
}
