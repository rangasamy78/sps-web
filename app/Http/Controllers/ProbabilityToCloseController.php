<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProbabilityToClose;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProbabilityToCloseRepository;
use App\Http\Requests\ProbabilityToClose\{CreateProbabilityToCloseRequest, UpdateProbabilityToCloseRequest};

class ProbabilityToCloseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProbabilityToCloseRepository $probabilityToCloseRepository;

    public function __construct(ProbabilityToCloseRepository $probabilityToCloseRepository)
    {
        $this->probabilityToCloseRepository = $probabilityToCloseRepository;
    }

    public function index()
    {
        return view('probability_to_close.probability_to_closes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateProbabilityToCloseRequest $request)
    {
        try {
            $this->probabilityToCloseRepository->store($request->only('probability_to_close'));
            return response()->json(['status' => 'success', 'msg' => 'Probability to close saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving probability to close: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the probability to close.']);
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
        $model = $this->probabilityToCloseRepository->findOrFail($id);
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
        $model = $this->probabilityToCloseRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProbabilityToCloseRequest $request, ProbabilityToClose $probabilityToClose)
    {
        try {
            $this->probabilityToCloseRepository->update($request->only('probability_to_close'), $probabilityToClose->id);
            return response()->json(['status' => 'success', 'msg' => 'Probability to close updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating probability to close: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the probability to close.']);
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
            $probabilityToClose = $this->probabilityToCloseRepository->findOrFail($id);
            if ($probabilityToClose) {
                $this->probabilityToCloseRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Probability to close deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Probability to close not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting probability to close: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the probability to close.']);
        }
    }
    public function getProbabilityToCloseDataTableList(Request $request)
    {
        return $this->probabilityToCloseRepository->dataTable($request);
    }
}
