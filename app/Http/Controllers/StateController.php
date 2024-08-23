<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\State;
use Illuminate\Http\Request;
use App\Imports\StatesImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StateTemplateExport;
use App\Repositories\StateRepository;
use App\Http\Requests\State\{CreateStateRequest, UpdateStateRequest, ImportStateRequest};

class StateController extends Controller
{
    private StateRepository $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function index()
    {
        return view('state.states');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStateRequest $request)
    {
        try {
            $this->stateRepository->store($request->only('name', 'code'));
            return response()->json(['status' => 'success', 'msg' => 'State saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving state: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the state.']);
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
        $model = $this->stateRepository->findOrFail($id);
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
        $model = $this->stateRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStateRequest $request, State $state)
    {
        try {
            $this->stateRepository->update($request->only('name', 'code'), $state->id);
            return response()->json(['status' => 'success', 'msg' => 'State updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating state: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the state.']);
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
            $state = $this->stateRepository->findOrFail($id);
            if ($state) {
                $this->stateRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'State deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'State not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting state: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the state.']);
        }
    }

    public function getStateDataTableList(Request $request)
    {
        return $this->stateRepository->dataTable($request);
    }

   
    public function importStates(ImportStateRequest $request)
    {
    try {
        $file   = $request->file('file');
        $import = new StatesImport();
        Excel::import($import, $file);

        if (!empty($import->errors)) {
            return response()->json([
                'status' => 'warning',
                'msg'    => 'File processed with some issues',
                'errors' => $import->errors,
            ], 200);
        }

        return response()->json(['status' => 'success', 'msg' => 'File uploaded and processed successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'msg' => 'An error occurred during the file upload. ' . $e->getMessage()], 500);
    }
}
public function stateTemplateDownload()
{
    return Excel::download(new StateTemplateExport, 'state_template.xlsx');
}
    

}
