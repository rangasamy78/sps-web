<?php

namespace App\Http\Controllers;
use Exception;

use Carbon\Carbon;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use App\Models\OpportunityStage;
use Illuminate\Support\Facades\DB;

class QuoteStageDashboardController extends Controller
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

        $defaultStages = Opportunity::where('opportunity_stage_id', 0)
                                    ->orWhereNull('opportunity_stage_id')
                                    ->leftjoin('customers', 'opportunities.billing_customer_id', '=', 'customers.id')
                                    ->leftjoin('users', 'opportunities.primary_sales_person_id', '=', 'users.id')
                                    ->leftjoin('probability_to_closes', 'opportunities.probability_to_close_id', '=', 'probability_to_closes.id')
                                    ->select('opportunities.opportunity_code','opportunities.ship_to_job_name', 'opportunities.created_at', 'customers.customer_name as customer_name', DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"), 'probability_to_closes.probability_to_close')
                                    ->whereBetween('opportunities.opportunity_date', [$startDate, $endDate])
                                    ->get();

        $opportunityStages = OpportunityStage::with(['opportunities' => function($query) use ($startDate, $endDate) {
                                            $query->whereBetween('opportunity_date', [$startDate, $endDate])
                                            ->leftjoin('customers', 'opportunities.billing_customer_id', '=', 'customers.id')
                                            ->leftjoin('users', 'opportunities.primary_sales_person_id', '=', 'users.id')
                                            ->leftjoin('probability_to_closes', 'opportunities.probability_to_close_id', '=', 'probability_to_closes.id')
            ->select('opportunities.*', 'users.first_name', 'users.email', 'customers.customer_name as customer_name', DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"), 'probability_to_closes.probability_to_close');
        }])->get();

        return view('quote_stage_dashboard.quote_stages_dashboard', compact('defaultStages', 'opportunityStages', 'startDate', 'endDate'));
    }
}
