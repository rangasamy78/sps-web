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
                $query->whereBetween('opportunities.opportunity_date', [$startDate, $endDate])
                    ->leftjoin('customers', 'opportunities.billing_customer_id', '=', 'customers.id')
                    ->leftjoin('users', 'opportunities.primary_sales_person_id', '=', 'users.id')
                    ->leftjoin('companies', 'opportunities.location_id', '=', 'companies.id')
                    ->select('opportunities.*', 'customers.customer_name as customer_name', 'customers.phone as phone', 'customers.accounting_email as accounting_email', DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"), 'companies.company_name');
        }])
        ->get();

        return view('follow_up.follow_ups', compact('probabilityToClose', 'startDate', 'endDate'));
    }
}
