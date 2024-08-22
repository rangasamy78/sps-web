<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProductFinish;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductFinishRepository;
use App\Http\Requests\ProductFinish\{CreateProductFinishRequest, UpdateProductFinishRequest};

class ProductFinishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductFinishRepository $productFinishRepository;

    public function __construct(ProductFinishRepository $productFinishRepository)
    {
        $this->productFinishRepository = $productFinishRepository;
    }

    public function index()
    {
        return view('product_finish.product_finishes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateProductFinishRequest $request)
    {
        try {
            $this->productFinishRepository->store($request->only('product_finish_code', 'finish'));
            return response()->json(['status' => 'success', 'msg' => 'Product finish saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving product finish: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the product finish.']);
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
        $model = $this->productFinishRepository->findOrFail($id);
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
        $model = $this->productFinishRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductFinishRequest $request, ProductFinish $productFinish)
    {
        try {
            $this->productFinishRepository->update($request->only('product_finish_code', 'finish'), $productFinish->id);
            return response()->json(['status' => 'success', 'msg' => 'Product finish updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating product finish: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product finish.']);
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
            $productFinish = $this->productFinishRepository->findOrFail($id);
            if ($productFinish) {
                $this->productFinishRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Product finish deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product finish not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting product finish: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product finish.']);
        }
    }
    public function getProductFinishDataTableList(Request $request)
    {
        return $this->productFinishRepository->dataTable($request);
    }
}
