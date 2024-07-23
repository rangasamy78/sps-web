<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\EventTypeRepository;
use App\Http\Requests\EventType\{CreateEventTypeRequest, UpdateEventTypeRequest};

class EventTypeController extends Controller
{
    private EventTypeRepository $eventTypeRepository;

    public function __construct(EventTypeRepository $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function index()
    {
        $eventCategories = EventType::getEventCategory();
        return view('event_type.event_types', compact('eventCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEventTypeRequest $request)
    {
        try {
            $this->eventTypeRepository->store($request->only('event_type_name','event_type_code','event_category_id'));
            return response()->json(['status' => 'success', 'msg' => 'Event Type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Event Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Event Type.']);
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
        $eventCategories = EventType::getEventCategory();
        $model = $this->eventTypeRepository->findOrFail($id);
        return response()->json(compact('model', 'eventCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->eventTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventTypeRequest $request, EventType $eventType)
    {
        try {
            $eventType->update($request->only('event_type_name','event_type_code','event_category_id')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Event Type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Event Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the department.']);
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
            $this->eventTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Event Type deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Event Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the department.']);
        }
    }

    public function getEventTypeDataTableList(Request $request) {
        return $this->eventTypeRepository->dataTable($request);
    }

}
