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
            return response()->json(['status' => 'success', 'msg' => 'How did you hear option saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving how did you hear option: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the how did you hear option.']);
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
            return response()->json(['status' => 'success', 'msg' => 'How did you hear option updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating how did you hear option: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the how did you hear option.']);
        }
    }

    public function destroy($id)
    {
        try {
            $aboutUsOption = $this->aboutUsOptionRepository->findOrFail($id);
            if ($aboutUsOption) {
                $this->aboutUsOptionRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'How did you hear option deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'How did you hear option not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting How did you hear option: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the how did you hear option.']);
        }
    }

    public function getAboutUsOptionDataTableList(Request $request)
    {
        return $this->aboutUsOptionRepository->dataTable($request);
    }
}
