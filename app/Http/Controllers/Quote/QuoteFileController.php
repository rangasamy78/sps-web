<?php

namespace App\Http\Controllers\Quote;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Quote\QuoteFileRepository;

class QuoteFileController extends Controller
{
    private QuoteFileRepository $quoteFileRepository;
    public function __construct(QuoteFileRepository $quoteFileRepository)
    {
        $this->quoteFileRepository = $quoteFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->quoteFileRepository->store($request->only('file_name', 'file_type_id', 'notes', 'quote_id'));
            return response()->json(['status' => 'success', 'msg' => 'Quote File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Quote File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Quote File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->quoteFileRepository->update($request->only('file_type_id', 'notes'), $id);
            return response()->json(['status' => 'success', 'msg' => 'Quote File updated successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error updating Quote File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Quote File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $accountFile = $this->quoteFileRepository->findOrFail($id);
            if ($accountFile) {
                $this->quoteFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Quote File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Quote File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Quote File.']);
        }
    }

    public function getQuoteFileDataTableList(Request $request, $id)
    {
        return $this->quoteFileRepository->dataTable($request, $id);
    }
}
