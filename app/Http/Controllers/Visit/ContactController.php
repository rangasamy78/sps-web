<?php

namespace App\Http\Controllers\Visit;

use Exception;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\VisitContact;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Visit\ContactRepository;
use App\Http\Requests\Visit\Contact\CreateContactRequest;

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
            $data = $request->only('visit_id', 'contact_id');
            $this->contactRepository->save($data);
            $contacts = VisitContact::where('visit_id', $data['visit_id'])
                ->with('contact')
                ->get();
            $formattedContacts = $contacts->map(function ($contact) {
                return [
                    'id' => $contact->contact->id,
                    'name' => $contact->contact->contact_name,
                    'visit_contact_id' => $contact->id,
                ];
            });
            return response()->json([
                'status' => 'success',
                'msg' => 'Visit Contact saved successfully.',
                'contacts' => $formattedContacts
            ]);
        } catch (Exception $e) {
            // Log the error and return an error response
            Log::error('Error saving Visit Contact: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the Visit Contact.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $opportunityContact = $this->contactRepository->findOrFail($id);
            if ($opportunityContact) {
                $this->contactRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Visit Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Visit Contact not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Visit Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Visit Contact.']);
        }
    }

    public function getCustomerContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTable($request, $id);
    }
}
