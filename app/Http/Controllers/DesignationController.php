<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\DesignationRepository;
use App\Http\Requests\Designation\{CreateDesignationRequest, UpdateDesignationRequest};

class DesignationController extends Controller
{
    private DesignationRepository $designationRepository;
    public function __construct(DesignationRepository $designationRepository)
    {
        $this->designationRepository = $designationRepository;
    }
    public function index()
    {
        $departments = Department::query()->get();
        return view('designation.designations', compact('departments'));
    }
    public function store(CreateDesignationRequest $request)
{
    try {
        $designations = $this->designationRepository->store($request->all());
        return response()->json(['status' => 'success', 'msg' => 'Designation saved successfully.', 'data' => $designations]);
    } catch (Exception $e) {
        Log::error('Error saving Designation: ' . $e->getMessage());
        return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Designation.']);
    }
}

    public function show($id)
    {
        $model = $this->designationRepository->findOrFail($id);
        return response()->json($model);
    }
    public function edit($id)
    {
        $model = $this->designationRepository->findOrFail($id);
        return response()->json($model);
    }
    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        try {
            $this->designationRepository->update($request->only('designation_name', 'department_id'), $designation->id);
            return response()->json(['status' => 'success', 'msg' => 'Designation updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Designation: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Designation.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->designationRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Designation deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Designation: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Designation.']);
        }
    }
    public function getDesignationDataTable(Request $request)
    {
        return $this->designationRepository->dataTable($request);
    }
}
