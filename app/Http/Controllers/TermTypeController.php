<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\TermType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\TermTypeRepository;
use App\Http\Requests\TermType\{CreateTermTypeRequest, UpdateTermTypeRequest};

class TermTypeController extends Controller
{
    private TermTypeRepository $termTypeRepository;

    public function __construct(TermTypeRepository $termTypeRepository)
    {
        $this->termTypeRepository = $termTypeRepository;
    }

    public function index()
    {
        return view('term_type.term_types');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTermTypeRequest $request)
    {
        try {
            $this->termTypeRepository->store($request->only('term_type_name','type_id'));
            return response()->json(['status' => 'success', 'msg' => 'Term Type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving account type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the account type.']);
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
        $model = $this->termTypeRepository->findOrFail($id);
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
        $model = $this->termTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermTypeRequest $request, TermType $termType)
    {
        try {
            $this->termTypeRepository->update($request->only('term_type_name','type_id'), $termType->id);
            return response()->json(['status' => 'success', 'msg' => 'Term Type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating account type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the account type.']);
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
            $termType = $this->termTypeRepository->findOrFail($id);
            if ($termType) {
                $response = $this->termTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Term Type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Term Type not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Term type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Term type.']);
        }
        return $response;
    }

    public function getTermTypeDataTable(Request $request)
    {
        return $this->termTypeRepository->dataTable($request);
    }

}
