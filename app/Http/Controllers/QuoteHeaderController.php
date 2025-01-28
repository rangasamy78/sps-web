<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\QuoteHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\QuoteHeaderRepository;
use App\Http\Requests\QuoteHeader\{CreateQuoteHeaderRequest, UpdateQuoteHeaderRequest};

class QuoteHeaderController extends Controller
{
    private QuoteHeaderRepository $quoteHeaderRepository;

    public function __construct(QuoteHeaderRepository $quoteHeaderRepository)
    {
        $this->quoteHeaderRepository = $quoteHeaderRepository;
    }

    public function index()
    {
        return view('quote_header.quote_headers');
    }

    public function store(CreateQuoteHeaderRequest $request)
    {
        try {
            $this->quoteHeaderRepository->store($request->only('quote_header_name'));
            return response()->json(['status' => 'success', 'msg' => 'Quote Header saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Quote Header: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Quote Header.']);
        }
    }

    public function show($id)
    {
        $model = $this->quoteHeaderRepository->findOrFail($id);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = $this->quoteHeaderRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateQuoteHeaderRequest $request, QuoteHeader $quoteHeader)
    {
        try {
            $this->quoteHeaderRepository->update($request->only('quote_header_name'), $quoteHeader->id);
            return response()->json(['status' => 'success', 'msg' => 'Quote Header updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote Header: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Quote Header.']);
        }
    }

    public function destroy($id)
    {
        try {
            $aboutUsOption = $this->quoteHeaderRepository->findOrFail($id);
            if ($aboutUsOption) {
                $this->quoteHeaderRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Header deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Quote Header not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Quote Header: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Header.']);
        }
    }

    public function getQuoteHeaderDataTableList(Request $request)
    {
        return $this->quoteHeaderRepository->dataTable($request);
    }
}
