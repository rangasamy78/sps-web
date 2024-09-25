<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ProductKind;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\ProductKindRepository;
use App\Http\Requests\ProductKind\{CreateProductKindRequest, UpdateProductKindRequest};

class ProductKindController extends Controller
{
    private ProductKindRepository $productKindRepository;

    public function __construct(ProductKindRepository $productKindRepository)
    {
        $this->productKindRepository = $productKindRepository;
    }

    public function index()
    {
        return view('product_kind.product_kinds');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductKindRequest $request)
    {
        try {
            $this->productKindRepository->store($request->only('product_kind_name'));
            return response()->json(['status' => 'success', 'msg' => 'Product Kind saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Product Kind : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Product Kind .']);
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
        $model = $this->productKindRepository->findOrFail($id);
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
        $model = $this->productKindRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductKindRequest $request, ProductKind $productKind)
    {
        try {
            $this->productKindRepository->update($request->only('product_kind_name'), $productKind->id);
            return response()->json(['status' => 'success', 'msg' => 'Product Kind  updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Product Kind: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Product Kind.']);
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
            $productKind = $this->productKindRepository->findOrFail($id);
            if ($productKind) {
                $this->productKindRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Product Kind deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product Kind number not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Product Kind: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Product Kind.']);
        }
    }

    public function getProductKindDataTableList(Request $request)
    {
        return $this->productKindRepository->dataTable($request);
    }
}
