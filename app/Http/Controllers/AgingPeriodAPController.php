<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\AgingPeriodAP;
use Illuminate\Support\Facades\Log;
use App\Repositories\AgingPeriodAPRepository;
use App\Http\Requests\AgingPeriodAP\CreateAgingPeriodAPRequest;

class AgingPeriodAPController extends Controller
{
    private AgingPeriodAPRepository $agingPeriodAPRepository;

    public function __construct(AgingPeriodAPRepository $agingPeriodAPRepository)
    {
        $this->agingPeriodAPRepository = $agingPeriodAPRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agingPeriodAPRepositoryDetail = AgingPeriodAP::latest()->first();
        return view('aging_period_ap.aging_period_aps', compact('agingPeriodAPRepositoryDetail'));
    }
    public function save(CreateAgingPeriodAPRequest $request)
    {
        try {
            $lastInsertId = $this->agingPeriodAPRepository->save($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Account payable saved successfully.','lastId' => $lastInsertId ? $lastInsertId : $request->id ]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving account payable: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the account payable.']);
        }
    }
}
