<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SupplierReturnStatus;
use App\Repositories\SupplierReturnStatusRepository;
use App\Http\Requests\SupplierReturnStatus\{CreateSupplierReturnStatusRequest, UpdateSupplierReturnStatusRequest};

class SupplierReturnStatusController extends Controller
{
    private SupplierReturnStatusRepository $supplierReturnStatusRepository;

    public function __construct(SupplierReturnStatusRepository $supplierReturnStatusRepository)
    {
        $this->supplierReturnStatusRepository = $supplierReturnStatusRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier_return_status.supplier_return_statuses');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSupplierReturnStatusRequest $request)
    {
        try {
            $this->supplierReturnStatusRepository->store($request->only('return_code_name'));
            return response()->json(['status' => 'success', 'msg' => 'Supplier return status saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving release reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the release reason code.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = $this->supplierReturnStatusRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = $this->supplierReturnStatusRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierReturnStatusRequest $request, SupplierReturnStatus $supplierReturnStatus)
    {
        try {
            $this->supplierReturnStatusRepository->update($request->only('return_code_name'), $supplierReturnStatus->id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Supplier return status Updated Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Supplier return status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Supplier return status.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $supplierReturnStatus = $this->supplierReturnStatusRepository->findOrFail($id);
            if ($supplierReturnStatus) {
                $this->supplierReturnStatusRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier return status deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Supplier return status not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Supplier return status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Supplier return status.']);
        }
    }

    public function getSupplierReturnStatusDataTableList(Request $request) {
        return $this->supplierReturnStatusRepository->dataTable($request);
    }
}
