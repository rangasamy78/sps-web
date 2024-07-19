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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $model = new Subheading();
        return view('sub_heading.form', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubHeadingRequest $request)
    {
        try {
            $this->subHeadingRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Sub Heading saved successfully.']);
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
        //dd($subHeading);
        try {
            $subHeading->update($request->only('sub_heading_name')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Sub Heading updated successfully.']);
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
            $this->subHeadingRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Sub Heading deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting sub heading: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the sub heading.']);
        }
    }

    public function getSubheadingDataTableList(Request $request) {
        return $this->subHeadingRepository->dataTable($request);
    }
}
