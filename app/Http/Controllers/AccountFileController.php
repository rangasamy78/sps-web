<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\AccountFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\AccountFileRepository;

class AccountFileController extends Controller
{
    private AccountFileRepository $accountFileRepository;
    public function __construct(AccountFileRepository $accountFileRepository)
    {
        $this->accountFileRepository = $accountFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->accountFileRepository->store($request->only('file_name', 'notes', 'account_id'));
            return response()->json(['status' => 'success', 'msg' => 'Account File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Account File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Account File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, AccountFile $accountFile)
    {
        try {
            $this->accountFileRepository->update($request->only('notes',), $accountFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Account File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Account File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Account File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $accountFile = $this->accountFileRepository->findOrFail($id);
            if ($accountFile) {
                $this->accountFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Account File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Account File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Account File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Account File.']);
        }
    }

    public function getAccountFileDataTableList(Request $request)
    {
        return $this->accountFileRepository->dataTable($request);
    }
}
