<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\BatchCloseQuoteRepository;

class BatchCloseQuoteController extends Controller
{
    private BatchCloseQuoteRepository $batchCloseQuoteRepository;

    public function __construct(BatchCloseQuoteRepository $batchCloseQuoteRepository)
    {
        $this->batchCloseQuoteRepository = $batchCloseQuoteRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        return view('batch_close_quote.batch_close_quotes', compact('startDate', 'endDate'));
    }

    public function updatestatus(Request $request)
    {
        $opportunityIds = $request->input('opportunity_ids', []); // Get selected quote ids
        Opportunity::whereIn('id', $opportunityIds)->update(['close_quote' => true]); // Update selected quotes
        $search_url = $request->headers->all('referer');
        return response()->json(['status' => 'success', 'msg' => 'Quotes Closed Successfully!', 'search_url' => $search_url['0']]);
    }

    public function getBatchCloseQuoteDataTableList(Request $request)
    {
        return $this->batchCloseQuoteRepository->dataTable($request);
    }
}
