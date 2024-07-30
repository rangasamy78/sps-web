<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ProductType;
use App\Http\Requests\ProductType\CreateProductTypeRequest;
use App\Http\Requests\ProductType\UpdateProductTypeRequest;
use App\Repositories\ProductTypeRepository;
use Illuminate\Http\Request;use Illuminate\Support\Facades\Log;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductTypeRepository $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepository)
    {
        $this->productTypeRepository = $productTypeRepository;
    }

    public function index()
    {
        return view('product_type.product_types');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateProductTypeRequest $request)
    {
        try {
            $this->productTypeRepository->store($request->only('product_type', 'indivisible', 'non_serialized', 'inventory_gl_account', 'sales_gl_account', 'cogs_gl_account'));
            return response()->json(['status' => 'success', 'msg' => 'Product Type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving product type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the product type.']);
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
        $model = $this->productTypeRepository->findOrFail($id);
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
        $model = $this->productTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductTypeRequest $request, ProductType $productType)
    {
        try {
            $data = $request->only([
                'product_type',
                'indivisible',
                'non_serialized',
                'inventory_gl_account',
                'sales_gl_account',
                'cogs_gl_account',
            ]);
            $this->productTypeRepository->update($data, $productType->id);
            return response()->json(['status' => 'success', 'msg' => 'Product Type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating product type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product type.']);
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
            $this->productTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Product Type deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting product type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product type.']);
        }
    }
    public function getProductTypeDataTableList(Request $request)
    {
        return $this->productTypeRepository->dataTable($request);
    }
    public function updateDefaultvalue(Request $request)
    {

        return $this->productTypeRepository->updateDefaultvalues($request);
        
    }
}
