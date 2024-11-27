<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\PrePurchaseRequestEventRepository;
use App\Http\Requests\PrePurchaseRequestEvent\{CreatePrePurchaseRequestEventRequest, UpdatePrePurchaseRequestEventRequest};

class PrePurchaseRequestEventController extends Controller
{
    public $PrePurchaseRequestEventRepository;

    public function __construct(PrePurchaseRequestEventRepository $PrePurchaseRequestEventRepository)
    {
        $this->PrePurchaseRequestEventRepository = $PrePurchaseRequestEventRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrePurchaseRequestEventRequest $request)
    {
        try {
            $this->PrePurchaseRequestEventRepository->store($request->only('entered_by_id', 'event_type_id', 'schedule_date', 'schedule_time', 'assigned_to_id', 'follower_id', 'event_title', 'party_name', 'product_id', 'price', 'description', 'type', 'type_id','pre_purchase_request_id'));
            return response()->json(['status' => 'success', 'msg' => 'Event saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Event: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Event.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->PrePurchaseRequestEventRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->PrePurchaseRequestEventRepository->findOrFail($id);

        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrePurchaseRequestEventRequest $request, Event $PrePurchaseRequestEvent)
    {
        try {
            $this->PrePurchaseRequestEventRepository->update($request->only('entered_by_id', 'event_type_id', 'schedule_date', 'schedule_time', 'assigned_to_id', 'follower_id', 'event_title', 'party_name', 'product_id', 'price', 'description', 'type', 'type_id','pre_purchase_request_id'), $PrePurchaseRequestEvent->id);
            return response()->json(['status' => 'success', 'msg' => 'Event updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Event : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Event .']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $PrePurchaseRequestEvent = $this->PrePurchaseRequestEventRepository->findOrFail($id);
            if ($PrePurchaseRequestEvent) {
                $this->PrePurchaseRequestEventRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Event deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Event not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Event : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Event .']);
        }
    }

    public function getPrePurchaseRequestEventDataTableList(Request $request) {
        return $this->PrePurchaseRequestEventRepository->dataTable($request);
    }
}
