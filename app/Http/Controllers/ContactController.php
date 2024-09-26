<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\ContactRepository;
use App\Http\Requests\Contact\CreateContactRequest;

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
            $this->contactRepository->save($request->only('contact_name', 'title', 'type', 'type_id', 'address', 'address_2', 'city', 'state', 'zip', 'county_id', 'lot', 'sub_division', 'country_id', 'primary_phone', 'secondary_phone', 'fax', 'email', 'internal_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Contact saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Contact.']);
        }
    }

    public function getContactDataTableList(Request $request)
    {
        return $this->contactRepository->dataTable($request);
    }
}
