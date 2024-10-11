<?php

namespace App\Http\Controllers\Expenditure;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Expenditure\ExpenditureRepository;
use App\Http\Requests\Expenditure\Contact\CreateContactRequest;
use App\Http\Requests\Expenditure\Contact\UpdateContactRequest;

class ContactController extends Controller
{
    public $expenditureRepository;

    public function __construct(ExpenditureRepository $expenditureRepository)
    {
        $this->expenditureRepository = $expenditureRepository;
    }

    public function contactSave(CreateContactRequest $request)
    {
        try {
            $this->expenditureRepository->save($request->only('contact_name', 'title', 'type', 'type_id', 'address', 'address_2', 'city', 'state', 'zip', 'county_id', 'lot', 'sub_division', 'country_id', 'primary_phone', 'secondary_phone', 'fax', 'email', 'internal_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Contact saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Contact.']);
        }
    }

    public function destroy($id)
    {
        try {
            $expenditure = $this->expenditureRepository->findOrFail($id);
            if ($expenditure) {
                $this->expenditureRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Contact not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Expenditure: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Expenditure.']);
        }
    }

    public function edit($id)
    {
        $model = $this->expenditureRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        try {
            $this->expenditureRepository->update($request->only('contact_name'), $contact->id);
            return response()->json(['status' => 'success', 'msg' => 'Contact updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Contact: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Contact.']);
        }
    }

    public function getContactDataTableList(Request $request, $type_id)
    {
        return $this->expenditureRepository->dataTable($request, $type_id);
    }

}
