<?php

namespace App\Http\Controllers\SaleOrder;

use Exception;
use Illuminate\Http\Request;
use App\Models\SaleOrderFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SaleOrder\SaleOrderFileRepository;

class SaleOrderFileController extends Controller
{
    private SaleOrderFileRepository $saleOrderFileRepository;
    public function __construct(SaleOrderFileRepository $saleOrderFileRepository)
    {
        $this->saleOrderFileRepository = $saleOrderFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->saleOrderFileRepository->store($request->only('file_name', 'file_type_id', 'notes', 'sales_order_id'));
            return response()->json(['status' => 'success', 'msg' => 'Sales Order File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Sales Order File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Sales Order File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->saleOrderFileRepository->update($request->only('file_type_id', 'notes'), $id);
            return response()->json(['status' => 'success', 'msg' => 'Sales Order File updated successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error updating Sales Order File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Sales Order File.']);
        }
    }
    
    public function destroy(string $id)
    {
        try {
            $accountFile = $this->saleOrderFileRepository->findOrFail($id);
            if ($accountFile) {
                $this->saleOrderFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sales Order File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sales Order File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Sales Order File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Sales Order File.']);
        }
    }

    public function getSaleOrderFileDataTableList(Request $request, $id)
    {
        return $this->saleOrderFileRepository->dataTable($request, $id);
    }
}
