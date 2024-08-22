<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\SubHeading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\SubHeadingRepository;
use App\Http\Requests\SubHeading\{CreateSubHeadingRequest, UpdateSubHeadingRequest};


class SubHeadingController extends Controller
{
    private SubHeadingRepository $subHeadingRepository;

    public function __construct(SubHeadingRepository $subHeadingRepository)
    {
        $this->subHeadingRepository = $subHeadingRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sub_heading.sub_headings');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubHeadingRequest $request)
    {
        try {
            $this->subHeadingRepository->store($request->only('sub_heading_name'));
            return response()->json(['status' => 'success', 'msg' => 'Sub heading saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving sub heading: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the sub heading.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = $this->subHeadingRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = $this->subHeadingRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubHeadingRequest $request, SubHeading $subHeading)
    {
        try {
            $this->subHeadingRepository->update($request->only('sub_heading_name'), $subHeading->id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Sub heading updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating sub heading: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the sub heading.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $subHeading = $this->subHeadingRepository->findOrFail($id);
            if ($subHeading) {
                $this->subHeadingRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sub heading deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sub heading not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting sub heading: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the sub heading.']);
        }
    }

    public function getSubHeadingDataTableList(Request $request) {
        return $this->subHeadingRepository->dataTable($request);
    }
}
