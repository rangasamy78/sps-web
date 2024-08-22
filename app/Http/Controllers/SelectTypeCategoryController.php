<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\SelectTypeCategory;
use Illuminate\Support\Facades\Log;
use App\Repositories\SelectTypeCategoryRepository;
use App\Http\Requests\SelectTypeCategory\{CreateSelectTypeCategoryRequest, UpdateSelectTypeCategoryRequest};

class SelectTypeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private SelectTypeCategoryRepository $selectTypeCategoryRepository;

    public function __construct(SelectTypeCategoryRepository $selectTypeCategoryRepository)
    {
        $this->selectTypeCategoryRepository = $selectTypeCategoryRepository;
    }

    public function index()
    {
        return view('select_type_category.select_type_categories');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateSelectTypeCategoryRequest $request)
    {
        try {
            $this->selectTypeCategoryRepository->store($request->only('select_type_category_name'));
            return response()->json(['status' => 'success', 'msg' => 'Select type category saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Select type category : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Select type category .']);
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
        $model = $this->selectTypeCategoryRepository->findOrFail($id);
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
        $model = $this->selectTypeCategoryRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSelectTypeCategoryRequest $request, SelectTypeCategory $selectTypeCategory)
    {
        try {
            $this->selectTypeCategoryRepository->update($request->only('select_type_category_name'), $selectTypeCategory->id);
            return response()->json(['status' => 'success', 'msg' => 'Select type category updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Select type category : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Select type category .']);
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
            $selectType = $this->selectTypeCategoryRepository->findOrFail($id);
            if ($selectType) {
                $response = $this->selectTypeCategoryRepository->delete($id);
                $data = $response->getData();
                if ($data->status == 'success') {
                    return response()->json(['status' => $data->status, 'msg' => $data->msg]);
                } else if ($data->status == 'error') {
                    return response()->json(['status' => $data->status, 'msg' => $data->msg]);
                }
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Select type category not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Select type category : ' . $e->getMessage());
            return response()->json(['status' => $data->status, 'msg' => $data->msg], 500);
        }
        return $response;
    }

    public function getSelectTypeCategoryDataTableList(Request $request)
    {
        return $this->selectTypeCategoryRepository->dataTable($request);
    }
}
