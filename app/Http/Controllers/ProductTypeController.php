<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Account;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\{ProductTypeRepository, DropDownRepository};
use App\Http\Requests\ProductType\{CreateProductTypeRequest, UpdateProductTypeRequest};

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductTypeRepository $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepository,DropDownRepository $dropDownRepository)
    {
        $this->dropDownRepository    = $dropDownRepository;
        $this->productTypeRepository = $productTypeRepository;
    }

    public function index()
    {
        $linkedAccountRecords       = $this->dropDownRepository->dropDownPopulate('linked_account_inventory_gl');
        $inventories                =  Account::query()
                                        ->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')
                                        ->where('account_types.account_type_name', '=', 'Inventory')
                                        ->select('accounts.*') 
                                        ->get();

        $sales                      =  Account::query()
                                        ->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')
                                        ->where('account_types.account_type_name', '=', 'Sales')
                                        ->select('accounts.*') 
                                        ->get();
        $cogs                       = Account::query()
                                        ->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')
                                        ->where('account_types.account_type_name', '=', 'Cogs')
                                        ->select('accounts.*') 
                                        ->get();
        
        return view('product_type.product_types', compact('inventories', 'sales', 'cogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateProductTypeRequest $request)
    {
        try {
            $this->productTypeRepository->store($request->only('product_type', 'indivisible', 'non_serialized', 'inventory_gl_account_id', 'sales_gl_account_id', 'cogs_gl_account_id'));
            return response()->json(['status' => 'success', 'msg' => 'Product type saved successfully.']);
        } catch (Exception $e) {
           
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
                'inventory_gl_account_id',
                'sales_gl_account_id',
                'cogs_gl_account_id',
            ]);
            $this->productTypeRepository->update($data, $productType->id);
            return response()->json(['status' => 'success', 'msg' => 'Product type updated successfully.']);
        } catch (Exception $e) {
           
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
            $productType = $this->productTypeRepository->findOrFail($id);
            if ($productType) {
                $this->productTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Product type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product type not found.']);
            }
        } catch (Exception $e) {
           
            Log::error('Error deleting product type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product type.']);
        }
    }

    public function getProductTypeDataTableList(Request $request)
    {
        return $this->productTypeRepository->dataTable($request);
    }

    public function saveDefaultValue(Request $request)
    {
        return $this->productTypeRepository->saveDefaultValue($request);
    }
}
