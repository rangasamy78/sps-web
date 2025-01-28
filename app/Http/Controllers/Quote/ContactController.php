<?php

namespace App\Http\Controllers\Quote;

use Exception;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\QuoteContact;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Quote\ContactRepository;
use App\Http\Requests\Quote\Contact\CreateContactRequest;

class ContactController extends Controller
{
    private $contactRepository;
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function store(CreateContactRequest $request)
    {
        try {
            $data = $request->only('quote_id', 'contact_id');
            $this->contactRepository->store($data);
            $contacts = QuoteContact::where('quote_id', $data['quote_id'])
                ->with('contact')
                ->get();
            $formattedContacts = $contacts->map(function ($contact) {
                return [
                    'id' => $contact->contact->id,
                    'name' => $contact->contact->contact_name,
                    'quote_contact_id' => $contact->id,
                ];
            });
            return response()->json([
                'status' => 'success',
                'msg' => 'Quote Contact saved successfully.',
                'contacts' => $formattedContacts
            ]);
        } catch (Exception $e) {
            // Log the error and return an error response
            dd($e->getMessage());
            Log::error('Error saving Quote Contact: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the Quote Contact.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $opportunityContact = $this->contactRepository->findOrFail($id);
            if ($opportunityContact) {
                $this->contactRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Quote Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Quote Contact not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Quote Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote Contact.']);
        }
    }

    public function customerContactDestroy($id)
    {
        try {
            $quoteCustomerContact = Contact::findOrFail($id);
            $quoteCustomerContact->delete();

            $quoteContact = QuoteContact::where('contact_id', $id)->first();
            if ($quoteContact) {
                $quoteContact->delete();
            }

            return response()->json(['status' => 'success', 'msg' => 'Contact deleted successfully.', 'id' => $quoteContact->id ?? null]);
        } catch (Exception $e) {
            Log::error('Error deleting Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Contact.']);
        }
    }

    public function getAllQuoteContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTable($request, $id);
    }

    public function getCustomerContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTableCustomerContact($request, $id);
    }
}
