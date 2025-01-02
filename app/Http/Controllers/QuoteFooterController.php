<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\QuoteFooter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Repositories\QuoteFooterRepository;
use App\Http\Requests\QuoteFooter\{CreateQuoteFooterRequest, UpdateQuoteFooterRequest};

class QuoteFooterController extends Controller
{
    private QuoteFooterRepository $quoteFooterRepository;

    public function __construct(QuoteFooterRepository $quoteFooterRepository)
    {
        $this->quoteFooterRepository = $quoteFooterRepository;
    }
    public function index()
    {
        return view('quote_footer.quote_footers');
    }

    public function store(CreateQuoteFooterRequest $request)
    {
        try {
            $this->quoteFooterRepository->store($request->only('quote_footer_name'));
            return response()->json(['status' => 'success', 'msg' => 'Quote Footer saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Quote Footer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Quote Footer.']);
        }
    }

    public function show($id)
    {
        $model = $this->quoteFooterRepository->findOrFail($id);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = $this->quoteFooterRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateQuoteFooterRequest $request, QuoteFooter $quoteFooter)
    {
        try {
            $this->quoteFooterRepository->update($request->only('quote_footer_name'), $quoteFooter->id);
            return response()->json(['status' => 'success', 'msg' => 'Quote Footer updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote Footer: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Quote Footer.']);
        }
    }

    public function destroy($id)
    {
        try {
            $aboutUsOption = $this->quoteFooterRepository->findOrFail($id);
            if ($aboutUsOption) {
                $this->quoteFooterRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Footer deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Quote Footer not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Quote Footer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Footer.']);
        }
    }

    public function getQuoteFooterDataTableList(Request $request)
    {
        return $this->quoteFooterRepository->dataTable($request);
    }
}
