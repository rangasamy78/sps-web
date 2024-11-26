<?php

namespace App\Http\Controllers;
use Exception;

use App\Models\MyEvent;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\EventCalendarRepository;
use App\Http\Requests\EventCalendar\UpdateEventCalendarRequest;

class EventCalendarController extends Controller
{
    private EventCalendarRepository $eventCalendarRepository;

    public function __construct(EventCalendarRepository $eventCalendarRepository)
    {
        $this->eventCalendarRepository = $eventCalendarRepository;
    }

    public function index()
    {
        $eventCalendars = MyEvent::join('event_types', 'events.event_type_id', '=', 'event_types.id')
        ->join('users', 'events.entered_by_id', '=', 'users.id')
        ->select('events.id', 'events.product_id','events.event_title', \DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS full_name") , 'event_types.event_type_name', \DB::raw("CONCAT(COALESCE(events.schedule_date, ''),' ', COALESCE(events.schedule_time, '')) AS my_event_date_time"), 'events.party_name', 'events.price', \DB::raw('CASE
        WHEN party_name = "customer" THEN (SELECT customer_name FROM customers WHERE id = events.party_name_id)
        WHEN party_name = "associate" THEN (SELECT associate_name FROM associates WHERE id = events.party_name_id)
        WHEN party_name = "expenditure" THEN (SELECT expenditure_name FROM expenditures WHERE id = events.party_name_id)
        WHEN party_name = "supplier" THEN (SELECT supplier_name FROM suppliers WHERE id = events.party_name_id)
        ELSE NULL END AS party_name_value'))
        ->get();

        foreach($eventCalendars as $event) {
                $product_value = '';  // Initialize an empty string
                $price_vaue = '';
                // Replace '~' with ',' to get the correct format for whereIn
                $product_ids = explode('~', $event->product_id);  // Convert the event_id into an array of IDs

                // Fetch the products where the id is in the $product_ids array
                $products = Product::whereIn('id', $product_ids)
                    ->select('product_name')
                    ->get();  // Get the results

                foreach ($products as $product) {
                    if($product_value == '') {
                        $product_value .= '</b>Products: <b>';  // Append the product name to
                    }
                    $product_value .= $product->product_name . '<br /> ';  // Concatenate product names with a comma
                }
                if($product_value != '') {
                    if(!empty($event->price) ){ $price_vaue = '$'.$event->price.' / SF' ;}
                    $product_value = $product_value. $price_vaue;
                }


            $events[] = [
                'id'                => $event->id,
                'title'             => '<span style="float:right;"><b>'.$event->event_type_name.'</b>&nbsp;&nbsp;</span><br />Tit: <b>'. $event->event_title.'<br /></b>'. $event->party_name.' <b>'. $event->party_name_value.'<br />'. $product_value.'<br /><i class="bx bx-user bx-sm"></i> '. $event->full_name. "<br />",
                'content'           => $event->event_type_name,
                'start'             => $event->my_event_date_time,
                'end'               => $event->my_event_date_time,
                'color'             => '#03C3EC',
                'backgroundColor'   => '#D7F5FC',
                'url'               => url('/my_events').'/'.$event->id,
            ];
        }

        return view('event_calendar.event', ['events' => $events]);
    }

    public function update(UpdateEventCalendarRequest $request, VisitCalendar $eventCalendar)
    {
        try {
            $eventCalendar->update($request->only('printed_notes')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Event Calendar updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating event calendar: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the event calendar.']);
        }
    }
}
