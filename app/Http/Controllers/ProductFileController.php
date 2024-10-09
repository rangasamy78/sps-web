<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductFile;
use App\Repositories\ProductFileRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductFileController extends Controller
{
    private ProductFileRepository $productFileRepository;
    public function __construct(ProductFileRepository $productFileRepository)
    {
        $this->productFileRepository = $productFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->productFileRepository->store($request->only('file_name', 'notes', 'product_id'));
            return response()->json(['status' => 'success', 'msg' => 'Product File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Product File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Product File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, ProductFile $productFile)
    {
        try {
            $this->productFileRepository->update($request->only('notes', ), $productFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Product File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Product File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Product File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $productFile = $this->productFileRepository->findOrFail($id);
            if ($productFile) {
                $this->productFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Product File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Product File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Product File.']);
        }
    }

    public function getProductFileDataTableList(Request $request)
    {
        return $this->productFileRepository->dataTable($request);
    }
}
