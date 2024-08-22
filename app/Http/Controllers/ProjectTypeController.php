<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProjectTypeRepository;
use App\Http\Requests\ProjectType\{CreateProjectTypeRequest, UpdateProjectTypeRequest};

class ProjectTypeController extends Controller
{
    private ProjectTypeRepository $projectTypeRepository;

    public function __construct(ProjectTypeRepository $projectTypeRepository)
    {
        $this->projectTypeRepository = $projectTypeRepository;
    }

    public function index()
    {
        return view('project_type.project_types');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectTypeRequest $request)
    {
        try {
            $this->projectTypeRepository->store($request->only('project_type_name'));
            return response()->json(['status' => 'success', 'msg' => 'Project type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving project type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the project type.']);
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
        $model = $this->projectTypeRepository->findOrFail($id);
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
        $model = $this->projectTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectTypeRequest $request, ProjectType $projectType)
    {
        try {
            $projectType->update($request->only('project_type_name')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Project type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating project type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the product type.']);
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
            $projectType = $this->projectTypeRepository->findOrFail($id);
            if ($projectType) {
                $this->projectTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Project type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product type not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting project type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the product type.']);
        }
    }

    public function getProjectTypeDataTableList(Request $request) {
        return $this->projectTypeRepository->dataTable($request);
    }

}
