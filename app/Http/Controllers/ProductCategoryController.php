<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategory\CreateProductCategoryRequest;

use App\Http\Requests\ProductCategory\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;
use Exception;
use Illuminate\Http\Request;use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductCategoryRepository $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function index()
    {
        return view('product_category.product_categories');
    }

    
   public function store(CreateProductCategoryRequest $request)
     {
        try {

            $this->productCategoryRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Product Category saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving product category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the product category.']);
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
        $model = $this->productCategoryRepository->edit($id);
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
        $model = $this->productCategoryRepository->edit($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        try {
            $data = $request->only(['product_category_name', 'product_sub_categories']);

            $result = $this->productCategoryRepository->update($data, $productCategory->id);

            return response()->json(['status' => 'success', 'msg' => 'Product Catgory updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating product Category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product category.']);
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
            $this->productCategoryRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Product Category deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting product Category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product Category.']);
        }
    }
    public function getProductCategoryDataTableList(Request $request)
    {
        return $this->productCategoryRepository->dataTable($request);
    }
}
