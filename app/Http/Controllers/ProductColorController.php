<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductColorRepository;
use App\Http\Requests\ProductColor\{CreateProductColorRequest, UpdateProductColorRequest};

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductColorRepository $productColorRepository;

    public function __construct(ProductColorRepository $productColorRepository)
    {
        $this->productColorRepository = $productColorRepository;
    }

    public function index()
    {
        return view('product_color.product_colors');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateProductColorRequest $request)
    {
        try {
            $this->productColorRepository->store($request->only('product_color'));
            return response()->json(['status' => 'success', 'msg' => 'Product Color saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving product color: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the product color.']);
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
        $model = $this->productColorRepository->findOrFail($id);
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
        $model = $this->productColorRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductColorRequest $request, ProductColor $productColor)
    {
        try {
            $this->productColorRepository->update($request->only('product_color'), $productColor->id);
            return response()->json(['status' => 'success', 'msg' => 'Product Color updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating product color: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product color.']);
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
            $this->productColorRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Product Color deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting product color: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product color.']);
        }
    }
    public function getProductColorDataTableList(Request $request)
    {
        return $this->productColorRepository->dataTable($request);
    }
}
