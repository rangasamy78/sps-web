<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\QuotePrintedNote;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\QuotePrintedNoteRepository;
use App\Http\Requests\QuotePrintedNote\{CreateQuotePrintedNoteRequest, UpdateQuotePrintedNoteRequest};

class QuotePrintedNoteController extends Controller
{
    private QuotePrintedNoteRepository $quotePrintedNoteRepository;

    public function __construct(QuotePrintedNoteRepository $quotePrintedNoteRepository)
    {
        $this->quotePrintedNoteRepository = $quotePrintedNoteRepository;
    }

    public function index()
    {
        return view('quote_printed_note.quote_printed_notes');
    }

    public function store(CreateQuotePrintedNoteRequest $request)
    {
        try {
            $this->quotePrintedNoteRepository->store($request->only('quote_printed_notes_name'));
            return response()->json(['status' => 'success', 'msg' => 'Quote Printed Note saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Quote Printed Note: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Quote Printed Note.']);
        }
    }

    public function show($id)
    {
        $model = $this->quotePrintedNoteRepository->findOrFail($id);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = $this->quotePrintedNoteRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateQuotePrintedNoteRequest $request, QuotePrintedNote $quotePrintedNote)
    {
        try {
            $this->quotePrintedNoteRepository->update($request->only('quote_printed_notes_name'), $quotePrintedNote->id);
            return response()->json(['status' => 'success', 'msg' => 'Quote Printed Note updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote Printed Note: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Quote Printed Note.']);
        }
    }

    public function destroy($id)
    {
        try {
            $aboutUsOption = $this->quotePrintedNoteRepository->findOrFail($id);
            if ($aboutUsOption) {
                $this->quotePrintedNoteRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Printed Note deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Quote Printed Note not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Quote Printed Note: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Printed Note.']);
        }
    }

    public function getQuotePrintedNoteDataTableList(Request $request)
    {
        return $this->quotePrintedNoteRepository->dataTable($request);
    }
}
