<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\{ SelectTypeSubCategoryRepository, DropDownRepository };
use App\Http\Requests\SelectTypeSubCategory\{CreateSelectTypeSubCategoryRequest};

class SelectTypeSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $selectTypeSubCategoryRepository;
    public $dropDownRepository;

    public function __construct(SelectTypeSubCategoryRepository $selectTypeSubCategoryRepository, DropDownRepository $dropDownRepository)
    {
        $this->selectTypeSubCategoryRepository = $selectTypeSubCategoryRepository;
        $this->dropDownRepository = $dropDownRepository;
    }

    public function index()
    {
        $select_type_categories = $this->dropDownRepository->dropDownPopulate('select_type_categories');
        return view('select_type_sub_category.select_type_sub_categories', compact('select_type_categories'));
    }

    public function store(CreateSelectTypeSubCategoryRequest $request)
    {
        try {
            $this->selectTypeSubCategoryRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Select Type Sub category saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Select Type Sub category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Select Type Sub category.']);
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
        $model = $this->selectTypeSubCategoryRepository->edit($id);
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
        $model = $this->selectTypeSubCategoryRepository->edit($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            $this->selectTypeSubCategoryRepository->update($request->all(), $id);
            return response()->json(['status' => 'success', 'msg' => 'Select Type Sub category updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Select Type Sub category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Select Type Sub category.']);
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
            $response = $this->selectTypeSubCategoryRepository->delete($id);
            $data = $response->getData();
            if ($data->status == 'success') {
                return response()->json(['status' => $data->status, 'msg' => $data->msg]);
            } else if ($data->status == 'error') {
                return response()->json(['status' => $data->status, 'msg' => $data->msg]);
            }
        } catch (Exception $e) {
            Log::error('Error deleting select type category: ' . $e->getMessage());
            return response()->json(['status' => $data->status, 'msg' => $data->msg], 500);
        }
        return $response;
    }
    
    public function getSelectTypeSubCategoryDataTableList(Request $request)
    {
        return $this->selectTypeSubCategoryRepository->dataTable($request);
    }

}
