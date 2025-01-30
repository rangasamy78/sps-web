<?php
namespace App\Http\Controllers\SaleOrder;

use Exception;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\SaleOrderContact;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleOrder\Contact\CreateContactRequest;
use App\Repositories\SaleOrder\ContactRepository;

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
            $data = $request->only('sales_order_id', 'contact_id');
            $this->contactRepository->save($data);
            $contacts = SaleOrderContact::where('sales_order_id', $data['sales_order_id'])
                ->with('contact')
                ->get();
            $formattedContacts = $contacts->map(function ($contact) {
                return [
                    'id'                     => $contact->contact->id,
                    'name'                   => $contact->contact->contact_name,
                    'sales_order_contact_id' => $contact->id,
                ];
            });
            return response()->json([
                'status'   => 'success',
                'msg'      => 'Sale Order Contact saved successfully.',
                'contacts' => $formattedContacts,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving Sale Order Contact: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg'    => 'An error occurred while saving the Sale Order Contact.',
            ]);
        }
    }

    public function billTodestroy($id)
    {
        try {
            $salesOrderBilltoContact = Contact::findOrFail($id);
            $salesOrderBilltoContact->delete();
            $saleOrderContact = SaleOrderContact::where('contact_id', $id)->firstOrFail();
            $saleOrderContact->delete();
            return response()->json(['status' => 'success', 'msg' => 'Contact deleted successfully.', 'id' => $saleOrderContact->id]);
        } catch (Exception $e) {
            Log::error('Error deleting Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Contact.']);
        }
    }

    public function destroy($id)
    {
        try {
            $saleOrderContact = $this->contactRepository->findOrFail($id);
            if ($saleOrderContact) {
                $this->contactRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sale Order Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sale Order Contact not found.']);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error deleting Sale Order Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Sale Order Contact.']);
        }
    }

    public function getSaleOrderContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTable($request, $id);
    }
    public function getSaleOrderBillToContactDataTableList(Request $request, $id)
    {
        return $this->contactRepository->dataTableBilltoContact($request, $id);
    }
}
