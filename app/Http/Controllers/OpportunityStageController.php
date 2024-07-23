<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\OpportunityStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\OpportunityStageRepository;
use App\Http\Requests\OpportunityStage\{CreateOpportunityStageRequest, UpdateOpportunityStageRequest};

class OpportunityStageController extends Controller
{
    private OpportunityStageRepository $opportunityStageRepository;

    public function __construct(OpportunityStageRepository $opportunityStageRepository)
    {
        $this->opportunityStageRepository = $opportunityStageRepository;
    }

    public function index()
    {
        return view('opportunity_stage.opportunity_stages');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOpportunityStageRequest $request)
    {
        try {
            $this->opportunityStageRepository->store($request->only('opportunity_stage'));
            return response()->json(['status' => 'success', 'msg' => 'Opportunity Stage saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving department: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the department.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->opportunityStageRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->opportunityStageRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOpportunityStageRequest $request, OpportunityStage $opportunityStage)
    {
        try {
            $opportunityStage->update($request->only('opportunity_stage')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Opportunity Stage updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating opportunity stage: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the opportunity stage.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->opportunityStageRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Opportunity Stage deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting opportunity stage: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the opportunity stage.']);
        }
    }

    public function getOpportunityStageDataTableList(Request $request) {
        return $this->opportunityStageRepository->dataTable($request);
    }

}
