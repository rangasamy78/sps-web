<?php

namespace App\Http\Controllers;
use Exception;

use Carbon\Carbon;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use App\Models\ProbabilityToClose;
use Illuminate\Support\Facades\DB;


class FollowUpController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->input('start_date'))) {
            $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');
        }
        else{
            $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        }

        $probabilityToClose = ProbabilityToClose::with(['Probability' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('opportunity_date', [$startDate, $endDate]);
        }])
        ->get();

        return view('follow_up.follow_ups', compact('probabilityToClose', 'startDate', 'endDate'));
    }
    public function filterData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $probabilityToClose = ProbabilityToClose::with(['Probability' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('opportunity_date', [$startDate, $endDate]);
        }])
        ->get();
        return response()->json($startDate);
    }
}
