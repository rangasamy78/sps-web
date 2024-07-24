<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\ProductThickness;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductThicknessRepository;
use App\Http\Requests\ProductThickness\{CreateProductThicknessRequest, UpdateProductThicknessRequest};


class ProductThicknessController extends Controller
{
    private ProductThicknessRepository $productThicknessRepository;

    public function __construct(ProductThicknessRepository $productThicknessRepository)
    {
        $this->productThicknessRepository = $productThicknessRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product_thickness.product_thicknesses');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductThicknessRequest $request)
    {
        try {
            $this->productThicknessRepository->store($request->only('product_thickness_name','product_thickness_unit'));
            return response()->json(['status' => 'success', 'msg' => 'Product Thickness saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving product thickness: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the product thickness.']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = $this->productThicknessRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = $this->productThicknessRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductThicknessRequest $request, ProductThickness $productThickness)
    {
        try {
            $this->productThicknessRepository->update($request->only('product_thickness_name','product_thickness_unit'), $productThickness->id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Product Thickness Updated Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating product thickness: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Product Thickness.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->productThicknessRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Product Thickness deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting product thickness: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Product Thickness.']);
        }
    }

    public function getProductThicknessDataTableList(Request $request) {
        return $this->productThicknessRepository->dataTable($request);
    }
}
