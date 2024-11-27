<?php

namespace App\Http\Controllers\Opportunity;

use Exception;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\OpportunityContact;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Opportunity\ContactRepository;
use App\Http\Requests\Opportunity\Contact\CreateContactRequest;

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
            $data = $request->only('opportunity_id', 'contact_id');
            $this->contactRepository->save($data);
            $contacts = OpportunityContact::where('opportunity_id', $data['opportunity_id'])
                ->with('contact')
                ->get();
            $formattedContacts = $contacts->map(function ($contact) {
                return [
                    'id' => $contact->contact->id,
                    'name' => $contact->contact->contact_name,
                    'opportunity_contact_id' => $contact->id,
                ];
            });
            return response()->json([
                'status' => 'success',
                'msg' => 'Opportunity Contact saved successfully.',
                'contacts' => $formattedContacts
            ]);
        } catch (Exception $e) {
            Log::error('Error saving Opportunity Contact: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the Opportunity Contact.'
            ]);
        }
    }

    public function billTodestroy($id)
    {
        try {
            $opportunityBilltoContact = Contact::findOrFail($id);
            $opportunityBilltoContact->delete();
            $opportunityContact = OpportunityContact::where('contact_id', $id)->firstOrFail();
            $opportunityContact->delete();
            return response()->json(['status' => 'success', 'msg' => 'Contact deleted successfully.', 'id' => $opportunityContact->id]);
        } catch (Exception $e) {
            Log::error('Error deleting Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Contact.']);
        }
    }

    public function destroy($id)
    {
        try {
            $opportunityContact = $this->contactRepository->findOrFail($id);
            if ($opportunityContact) {
                $this->contactRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Opportunity Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Opportunity Contact not found.']);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error deleting Opportunity Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Opportunity Contact.']);
        }
    }

    public function getOpportunityContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTable($request, $id);
    }
    public function getOpportunityBillToContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTableBilltoContact($request, $id);
    }
}
