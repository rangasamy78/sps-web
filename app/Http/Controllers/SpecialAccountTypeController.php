<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\SpecialAccountType;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SpecialAccountTypeRepository;
use App\Http\Requests\SpecialAccountType\{CreateSpecialAccountTypeRequest, UpdateSpecialAccountTypeRequest};

class SpecialAccountTypeController extends Controller
{
    private SpecialAccountTypeRepository $specialAccountTypeRepository;

    public function __construct(SpecialAccountTypeRepository $specialAccountTypeRepository)
    {
        $this->specialAccountTypeRepository = $specialAccountTypeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('special_account_type.special_account_types');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateSpecialAccountTypeRequest $request)
    {
        try {
            $this->specialAccountTypeRepository->store($request->only('special_account_type_name'));
            return response()->json(['status' => 'success', 'msg' => 'Special account type saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Special account type : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Special account type .']);
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
        $model = $this->specialAccountTypeRepository->findOrFail($id);
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
        $model = $this->specialAccountTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecialAccountTypeRequest $request, SpecialAccountType $specialAccountType)
    {
        try {
            $this->specialAccountTypeRepository->update($request->only('special_account_type_name'), $specialAccountType->id);
            return response()->json(['status' => 'success', 'msg' => 'Special account type  updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Special account type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Special account type.']);
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
            $specialAccountType = $this->specialAccountTypeRepository->findOrFail($id);
            if ($specialAccountType) {
                $this->specialAccountTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Special account type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Special account type number not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Special account type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Special account type.']);
        }
    }
    public function getSpecialAccounttypeDataTableList(Request $request)
    {
        return $this->specialAccountTypeRepository->dataTable($request);
    }
}
