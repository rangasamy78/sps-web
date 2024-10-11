<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\SpecialInstruction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SpecialInstructionRepository;
use App\Http\Requests\SpecialInstruction\{CreateSpecialInstructionRequest, UpdateSpecialInstructionRequest};

class SpecialInstructionController extends Controller
{
    public $specialInstructionRepository;

    public function __construct(SpecialInstructionRepository $specialInstructionRepository)
    {
        $this->specialInstructionRepository = $specialInstructionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('special_instruction.special_instructions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateSpecialInstructionRequest $request)
    {
        try {
            $this->specialInstructionRepository->store($request->only('special_instruction_name'));
            return response()->json(['status' => 'success', 'msg' => 'Special Instruction saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Special Instruction : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Special Instruction .']);
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
        $model = $this->specialInstructionRepository->findOrFail($id);
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
        $model = $this->specialInstructionRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecialInstructionRequest $request, SpecialInstruction $specialInstruction)
    {
        try {
            $this->specialInstructionRepository->update($request->only('special_instruction_name'), $specialInstruction->id);
            return response()->json(['status' => 'success', 'msg' => 'Special Instruction  updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Special Instruction: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Special Instruction.']);
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
            $specialInstruction = $this->specialInstructionRepository->findOrFail($id);
            if ($specialInstruction) {
                $this->specialInstructionRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Special Instruction deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Special Instruction number not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Special Instruction: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Special Instruction.']);
        }
    }

    public function getSpecialInstructionDataTableList(Request $request)
    {
        return $this->specialInstructionRepository->dataTable($request);
    }
}
