<?php

namespace App\Http\Controllers\SaleOrder;

use Exception;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SaleOrder\EventRepository;
use App\Http\Requests\SaleOrder\Event\CreateEventRequest;

class EventController extends Controller
{
    private EventRepository $eventRepository;
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
            $saleOrderContact = $this->eventRepository->findOrFail($id);
            if ($saleOrderContact) {
                $this->eventRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sales Order Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sales Order Contact not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Sales Order Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Sales Order Contact.']);
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
