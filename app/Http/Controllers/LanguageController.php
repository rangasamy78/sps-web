<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\LanguageRepository;
use App\Http\Requests\Language\{CreateLanguageRequest, UpdateLanguageRequest};

class LanguageController extends Controller
{
    private LanguageRepository $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function index()
    {
        return view('language.languages');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLanguageRequest $request)
    {
        try {
            $this->languageRepository->store($request->only('language_name'));
            return response()->json(['status' => 'success', 'msg' => 'Language saved successfully.'], 200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving language: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while saving the language.'], 500);
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
        $model = $this->languageRepository->findOrFail($id);
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
        $model = $this->languageRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLanguageRequest $request, Language $language)
    {
        try {
            $this->languageRepository->update($request->only('language_name'), $language->id);
            return response()->json(['status' => 'success', 'msg' => 'Language updated successfully.'],200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating language: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the language.'],500);
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
        $language = $this->languageRepository->findOrFail($id);
        if ($language) {
            $response = $this->languageRepository->delete($id);
            $data     = $response->getData();
            if ($data->status == 'success') {
                return response()->json(['status' => $data->status, 'msg' => $data->msg]);
            } elseif ($data->status == 'error') {
                return response()->json(['status' => $data->status, 'msg' => $data->msg]);
            }
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Language deleted successfully.']);
        }
    } catch (Exception $e) {
        Log::error('Error deleting language : ' . $e->getMessage());
        return response()->json(['status' => $data->status, 'msg' => $data->msg], 500);
    }
    return $response;

    }

    public function getLanguageDataTableList(Request $request)
    {
        return $this->languageRepository->dataTable($request);
    }

}
