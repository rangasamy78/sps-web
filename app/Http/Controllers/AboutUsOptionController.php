<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\AboutUsOption;
use Illuminate\Support\Facades\Log;
use App\Repositories\AboutUsOptionRepository;
use App\Http\Requests\AboutUsOption\{CreateAboutUsOptionRequest, UpdateAboutUsOptionRequest};


class AboutUsOptionController extends Controller
{
    private AboutUsOptionRepository $aboutUsOptionRepository;
    public function __construct(AboutUsOptionRepository $aboutUsOptionRepository)
    {
        $this->aboutUsOptionRepository = $aboutUsOptionRepository;
    }
    public function index()
    {
        return view('about_us_option.about_us_options');
    }
    public function store(CreateAboutUsOptionRequest $request)
    {
        try {
            $this->aboutUsOptionRepository->store($request->only('how_did_you_hear_option'));
            return response()->json(['status' => 'success', 'msg' => 'How did you hear Option saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving How did you hear Option: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the How did you hear Option.']);
        }
    }
    public function show($id)
    {
        $model = $this->aboutUsOptionRepository->findOrFail($id);
        return response()->json($model);
    }
    public function edit($id)
    {
        $model = $this->aboutUsOptionRepository->findOrFail($id);
        return response()->json($model);
    }
    public function update(UpdateAboutUsOptionRequest $request, AboutUsOption $aboutUsOption)
    {
        try {
            $this->aboutUsOptionRepository->update($request->only('how_did_you_hear_option'), $aboutUsOption->id);
            return response()->json(['status' => 'success', 'msg' => 'How did yopu hear Option updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating How did you hear Option: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the How did you hear Option.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->aboutUsOptionRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'How did you hear Option deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting How did you hear Option: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the How did you hear Option.']);
        }
    }
    public function getAboutUsOptionDataTableList(Request $request)
    {
        return $this->aboutUsOptionRepository->dataTable($request);
    }
}
