<?php

namespace App\Http\Controllers\Hold;

use Exception;
use App\Models\HoldContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Hold\ContactRepository;
use App\Http\Requests\Hold\Contact\CreateContactRequest;

class ContactController extends Controller
{
    private $contactRepository;
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function save(CreateContactRequest $request)
    {
        try {
            $data = $request->only('hold_id', 'contact_id');
            $this->contactRepository->save($data);
            $contacts = HoldContact::where('hold_id', $data['hold_id'])
                ->with('contact')
                ->get();
            $formattedContacts = $contacts->map(function ($contact) {
                return [
                    'id' => $contact->contact->id,
                    'name' => $contact->contact->contact_name,
                    'hold_contact_id' => $contact->id,
                ];
            });
            return response()->json([
                'status' => 'success',
                'msg' => 'Hold Contact saved successfully.',
                'contacts' => $formattedContacts
            ]);
        } catch (Exception $e) {
            // Log the error and return an error response
            Log::error('Error saving Hold Contact: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the Hold Contact.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $holdContact = $this->contactRepository->findOrFail($id);
            if ($holdContact) {
                $this->contactRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Hold Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Hold Contact not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Hold Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Hold Contact.']);
        }
    }

    public function getCustomerContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTable($request, $id);
    }
}
