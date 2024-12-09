<?php

namespace App\Http\Controllers\Opportunity;

use Exception;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Opportunity\EventRepository;
use App\Http\Requests\Opportunity\Event\CreateEventRequest;

class EventController extends Controller
{
    private $eventRepository;
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function store(CreateEventRequest $request)
    {
        try {
            $this->eventRepository->store($request->only('entered_by_id', 'event_type_id', 'schedule_date', 'schedule_time', 'assigned_to_id', 'follower_id', 'event_title', 'party_name', 'product_id', 'price', 'description', 'type', 'type_id',));
            return response()->json(['status' => 'success', 'msg' => 'CRM Event saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving CRM Event: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the CRM Event.']);
        }
    }

    public function update(Request $request, Event $event)
    {
        try {
            $this->eventRepository->update($request->only('mark_as_complete'), $event->id);
            return response()->json(['status' => 'success', 'msg' => 'CRM Event updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating CRM Event: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the CRM Event.']);
        }
    }

    public function destroy($id)
    {
        try {
            $opportunityContact = $this->eventRepository->findOrFail($id);
            if ($opportunityContact) {
                $this->eventRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Opportunity Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Opportunity Contact not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Opportunity Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Opportunity Contact.']);
        }
    }

    public function getAllProductDataTableList(Request $request)
    {
        return $this->eventRepository->dataTableGetProduct($request);
    }

    public function getEventDataTableList(Request $request, $id)
    {
        return $this->eventRepository->dataTable($request, $id);
    }
}
