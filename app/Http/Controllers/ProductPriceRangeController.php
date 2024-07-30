<?php

    namespace App\Http\Controllers;
    
    use Exception;
    use App\Models\ProductPriceRange;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use App\Repositories\ProductPriceRangeRepository;
    use App\Http\Requests\ProductPriceRange\{CreateProductPriceRangeRequest, UpdateProductPriceRangeRequest};
    
    class ProductPriceRangeController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        private ProductPriceRangeRepository $productPriceRangeRepository;
    
        public function __construct(ProductPriceRangeRepository $productPriceRangeRepository)
        {
            $this->productPriceRangeRepository = $productPriceRangeRepository;
        }
    
        public function index()
        {
            return view('product_price_range.product_price_ranges');
        }
    
        /**
         * Show the form for creating a new resource.
         */
        public function store(CreateProductPriceRangeRequest $request)
        {
            try {
                $this->productPriceRangeRepository->store($request->only('product_price_range'));
                return response()->json(['status' => 'success', 'msg' => 'Product Price Range saved successfully.']);
            } catch (Exception $e) {
                // Log the exception for debugging purposes
                Log::error('Error saving product price range: ' . $e->getMessage());
                return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the product price range.']);
            }
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $model = $this->productPriceRangeRepository->findOrFail($id);
            return response()->json($model);
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $model = $this->productPriceRangeRepository->findOrFail($id);
            return response()->json($model);
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateProductPriceRangeRequest $request, ProductPriceRange $productPriceRange)
        {
            try {
                $this->productPriceRangeRepository->update($request->only('product_price_range'), $productPriceRange->id);
                return response()->json(['status' => 'success', 'msg' => 'Product Price Range updated successfully.']);
            } catch (Exception $e) {
                // Log the exception for debugging purposes
                Log::error('Error updating product price range: ' . $e->getMessage());
                return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product price range.']);
            }
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            try {
                $this->productPriceRangeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Product Price Range lor deleted successfully.']);
            } catch (Exception $e) {
                // Log the exception for debugging purposes
                Log::error('Error deleting product price range: ' . $e->getMessage());
                return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product price range.']);
            }
        }
        public function getProductPriceRangeDataTableList(Request $request)
        {
            return $this->productPriceRangeRepository->dataTable($request);
        }
    }
    