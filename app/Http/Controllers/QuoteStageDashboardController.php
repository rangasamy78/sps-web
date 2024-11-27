<?php

namespace App\Http\Controllers;
use Exception;

use Illuminate\Http\Request;
use App\Models\OpportunityStage;
use App\Models\Opportunity;
use Illuminate\Support\Facades\DB;


class QuoteStageDashboardController extends Controller
{
    public function index()
    {
        $defaultStages = Opportunity::where('opportunity_stage_id', 0)
                                    ->orWhereNull('opportunity_stage_id')
                                    ->get();
        $opportunityStages = OpportunityStage::withCount('Opportunity')->get();
        return view('quote_stage_dashboard.quote_stages_dashboard', compact('defaultStages', 'opportunityStages'));
    }
}
