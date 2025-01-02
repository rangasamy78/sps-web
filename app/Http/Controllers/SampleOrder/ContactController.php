<?php

namespace App\Http\Controllers\SampleOrder;

use Exception;
use Illuminate\Http\Request;
use App\Models\SampleOrderContact;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SampleOrder\ContactRepository;
use App\Http\Requests\SampleOrder\Contact\CreateContactRequest;

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
            $data = $request->only('sample_order_id', 'contact_id');
            $this->contactRepository->save($data);
            $contacts = SampleOrderContact::where('sample_order_id', $data['sample_order_id'])
                ->with('contact')
                ->get();
            $formattedContacts = $contacts->map(function ($contact) {
                return [
                    'id' => $contact->contact->id,
                    'name' => $contact->contact->contact_name,
                    'sample_order_contact_id' => $contact->id,
                ];
            });
            return response()->json([
                'status' => 'success',
                'msg' => 'Sample Order Contact saved successfully.',
                'contacts' => $formattedContacts
            ]);
        } catch (Exception $e) {
            // Log the error and return an error response
            Log::error('Error saving Sample Order Contact: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the Sample Order Contact.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $opportunityContact = $this->contactRepository->findOrFail($id);
            if ($opportunityContact) {
                $this->contactRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sample Order Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sample Order Contact not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Sample Order Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Sample Order Contact.']);
        }
    }

    public function getCustomerContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTable($request, $id);
    }
}
