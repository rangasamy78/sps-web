<?php

namespace App\Http\Controllers\SaleOrder;

use Exception;
use App\Models\SaleOrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SaleOrder\LineRepository;
// use App\Http\Requests\SaleOrder\Event\CreateEventRequest;

class LineController extends Controller
{
    private LineRepository $lineRepository;
    public function __construct(LineRepository $lineRepository)
    {
        $this->lineRepository = $lineRepository;
    }
/*
    public function store(CreateEventRequest $request)
    {
        try {
            $this->lineRepository->store($request->only('entered_by_id', 'event_type_id', 'schedule_date', 'schedule_time', 'assigned_to_id', 'follower_id', 'event_title', 'party_name', 'product_id', 'price', 'description', 'type', 'type_id',));
            return response()->json(['status' => 'success', 'msg' => 'CRM Event saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving CRM Event: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the CRM Event.']);
        }
    }

    public function update(Request $request, Event $event)
    {
        try {
            $this->lineRepository->update($request->only('mark_as_complete'), $event->id);
            return response()->json(['status' => 'success', 'msg' => 'CRM Event updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating CRM Event: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the CRM Event.']);
        }
    }

    public function destroy($id)
    {
        try {
            $saleOrderContact = $this->lineRepository->findOrFail($id);
            if ($saleOrderContact) {
                $this->lineRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sales Order Contact deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sales Order Contact not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Sales Order Contact: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Sales Order Contact.']);
        }
    }
*/
    public function getAllProductDataTableList(Request $request)
    {
        return $this->lineRepository->dataTableGetProduct($request);
    }

    public function getLineDataTableList(Request $request, $id)
    {
        return $this->lineRepository->dataTable($request, $id);
    }
}
