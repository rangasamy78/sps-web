<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\SupplierType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\SupplierTypeRepository;
use App\Http\Requests\SupplierType\{CreateSupplierTypeRequest, UpdateSupplierTypeRequest};

class SupplierTypeController extends Controller
{
    private SupplierTypeRepository $supplierTypeRepository;

    public function __construct(SupplierTypeRepository $supplierTypeRepository)
    {
        $this->supplierTypeRepository = $supplierTypeRepository;
    }

    public function index()
    {
        return view('supplier_type.supplier_types');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupplierTypeRequest $request)
    {
        try {
            $this->supplierTypeRepository->store($request->only('supplier_type_name'));
            return response()->json(['status' => 'success', 'msg' => 'Supplier type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Supplier type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier type.']);
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
        $model = $this->supplierTypeRepository->findOrFail($id);
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
        $model = $this->supplierTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierTypeRequest $request, SupplierType $supplierType)
    {
        try {
            $supplierType->update($request->only('supplier_type_name')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Supplier type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Supplier type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Supplier type.']);
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
            $supplierType = $this->supplierTypeRepository->findOrFail($id);
            if ($supplierType) {
                $this->supplierTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Supplier type not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Supplier type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the department.']);
        }
    }

    public function getSupplierTypeDataTableList(Request $request) {
        return $this->supplierTypeRepository->dataTable($request);
    }

}
