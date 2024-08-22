<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductGroupRepository;
use App\Http\Requests\ProductGroup\{CreateProductGroupRequest, UpdateProductGroupRequest};

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductGroupRepository $productGroupRepository;

    public function __construct(ProductGroupRepository $productGroupRepository)
    {
        $this->productGroupRepository = $productGroupRepository;
    }

    public function index()
    {
        return view('product_group.product_groups');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateProductGroupRequest $request)
    {
        try {
            $this->productGroupRepository->store($request->only('product_group_name', 'product_group_code'));
            return response()->json(['status' => 'success', 'msg' => 'Product group saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving product group: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the product group.']);
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
        $model = $this->productGroupRepository->findOrFail($id);
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
        $model = $this->productGroupRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductGroupRequest $request, ProductGroup $productGroup)
    {
        try {
            $this->productGroupRepository->update($request->only('product_group_name', 'product_group_code'), $productGroup->id);
            return response()->json(['status' => 'success', 'msg' => 'Product group updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating product Group: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product group.']);
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
            $productGroup = $this->productGroupRepository->findOrFail($id);
            if ($productGroup) {
                $this->productGroupRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Product group deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product group not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting product group: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product group.']);
        }
    }
    public function getProductGroupDataTableList(Request $request)
    {
        return $this->productGroupRepository->dataTable($request);
    }
}
