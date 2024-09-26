<?php

namespace App\Http\Controllers\Customer;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Customer\ContactRepository;
use App\Http\Requests\Customer\Contact\CreateContactRequest;

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
            $this->contactRepository->save($request->only('contact_name', 'title', 'type', 'type_id', 'address', 'address_2', 'city', 'state', 'zip', 'county_id', 'lot', 'sub_division', 'country_id', 'primary_phone', 'secondary_phone', 'fax', 'email', 'internal_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Contact saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Contact.']);
        }
    }

    public function getContactDataTableList(Request $request, $type_id)
    {
        return $this->contactRepository->dataTable($request, $type_id);
    }

}
