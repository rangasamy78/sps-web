<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Contact\{CreateContactRequest, UpdateContactRequest};
use App\Models\Contact;
use App\Repositories\Customer\ContactRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function contactSave(CreateContactRequest $request)
    {
        try {
            $this->contactRepository->save($request->only('contact_name', 'title', 'type', 'type_id', 'address', 'address_2', 'city', 'state', 'zip', 'county_id', 'lot', 'sub_division', 'country_id', 'mobile', 'primary_phone', 'secondary_phone', 'fax', 'email', 'is_ship_to_address', 'tax_code_id', 'internal_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Contact saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Contact.']);
        }
    }

    public function contactUpdate(UpdateContactRequest $request, $id)
    {
        try {
            $this->contactRepository->update($request->only('contact_name', 'title', 'type', 'type_id', 'address', 'address_2', 'city', 'state', 'zip', 'county_id', 'lot', 'sub_division', 'country_id', 'mobile', 'primary_phone', 'secondary_phone', 'fax', 'email', 'is_ship_to_address', 'tax_code_id', 'internal_notes'), $id);
            return response()->json(['status' => 'success', 'msg' => 'Contact updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Contact: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Contact.']);
        }
    }

    public function contactEdit($id)
    {
        // $model = Contact::findOrFail($id);
        $model = $this->contactRepository->findOrFail($id);
        return response()->json($model);
    }

    public function getContactDataTableList(Request $request, $type_id)
    {

        return $this->contactRepository->dataTable($request, $type_id);
    }
}
