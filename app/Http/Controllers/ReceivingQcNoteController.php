<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\ReceivingQcNote;
use Illuminate\Support\Facades\Log;
use App\Repositories\ReceivingQcNoteRepository;
use App\Http\Requests\ReceivingQcNote\{CreateReceivingQcNoteRequest, UpdateReceivingQcNoteRequest};

class ReceivingQcNoteController extends Controller
{
    private ReceivingQcNoteRepository $receivingQcNoteRepository;

    public function __construct(ReceivingQcNoteRepository $receivingQcNoteRepository)
    {
        $this->receivingQcNoteRepository = $receivingQcNoteRepository;
    }

    public function index()
    {
        return view('receiving_qc_note.receiving_qc_notes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReceivingQcNoteRequest $request)
    {
        try {
            $this->receivingQcNoteRepository->store($request->only('code','notes'));
            return response()->json(['status' => 'success', 'msg' => 'Receiving qc note saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Receiving qc note: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Receiving qc note.']);
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
        $model = $this->receivingQcNoteRepository->findOrFail($id);
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
        $model = $this->receivingQcNoteRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceivingQcNoteRequest $request, ReceivingQcNote $receivingQcNote)
    {
        try {
            $this->receivingQcNoteRepository->update($request->only('code','notes'), $receivingQcNote->id);
            return response()->json(['status' => 'success', 'msg' => 'Receiving qc note updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Receiving qc note: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Receiving qc note.']);
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
            $receivingQcNote = $this->receivingQcNoteRepository->findOrFail($id);
            if ($receivingQcNote) {
                $this->receivingQcNoteRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Receiving qc note deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Receiving qc note not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Receiving qc note: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Receiving qc note.']);
        }
    }

    public function getReceivingQcNoteDataTableList(Request $request) {
        return $this->receivingQcNoteRepository->dataTable($request);
    }

}
