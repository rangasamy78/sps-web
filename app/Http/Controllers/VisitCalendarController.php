<?php

namespace App\Http\Controllers;
use Exception;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\VisitCalendarRepository;
use App\Http\Requests\VisitCalendar\UpdateVisitCalendarRequest;

class VisitCalendarController extends Controller
{
    private VisitCalendarRepository $visitCalendarRepository;

    public function __construct(VisitCalendarRepository $visitCalendarRepository)
    {
        $this->visitCalendarRepository = $visitCalendarRepository;
    }

    public function index()
    {
        $visitCalendars = DB::table('opportunities')
                                    ->join('visits', 'opportunities.id', '=', 'visits.opportunity_id')
                                    ->join('companies', 'opportunities.location_id', '=', 'companies.id')
                                    ->join('customers', 'opportunities.billing_customer_id', '=', 'customers.id')
                                    ->join('users as primary_user', 'opportunities.primary_sales_person_id', '=', 'primary_user.id')
                                    ->leftjoin('users as secondary_user', 'opportunities.secondary_sales_person_id', '=', 'secondary_user.id')
                                    ->select(
                                        'opportunities.id AS opportunity_id',
                                        'opportunities.opportunity_code',
                                        'opportunities.ship_to_job_name',
                                        'visits.id',
                                        DB::raw("CONCAT(COALESCE(visits.visit_date, ''),' ', COALESCE(visits.visit_time, '')) AS visit_date_time"),
                                        'visits.created_at',
                                        'companies.company_name',
                                        'customers.customer_name',
                                        'customers.shipping_address',
                                        'customers.shipping_city',
                                        'customers.shipping_state',
                                        'customers.shipping_zip',
                                        'customers.shipping_county',
                                        DB::raw("CONCAT(COALESCE(primary_user.first_name, ''), ' ', COALESCE(primary_user.last_name, '')) AS primary_sales_person_name"),
                                        DB::raw("CONCAT(COALESCE(secondary_user.first_name, ''), ' ', COALESCE(secondary_user.last_name, '')) AS secondary_sales_person_name"),
                                        'visits.visit_printed_notes',
                                        'opportunities.internal_notes'
                                    )
                                    ->get();

        foreach($visitCalendars as $visit) {
            $secondary_sales_person_icon = "";
            if(!empty(trim($visit->secondary_sales_person_name))) {
                $secondary_sales_person_icon = "<i class='bx bx-group bx-sm'></i><sup>2</sup> ";
            }
            $ship_to_address = $visit->customer_name.'<br />'.$visit->shipping_address.'<br />'.$visit->shipping_city.' '.$visit->shipping_state.' '.$visit->shipping_zip.'<br />'.$visit->shipping_county;
            $events[] = [
                'id'                            => $visit->id,
                'title'                         => '<span style="float:right;"> Visit # '.'<B>'.$visit->opportunity_code.'&nbsp;&nbsp;</span><br /><span style="background-color: white; white-space:break-spaces; color: black"> '.$visit->ship_to_job_name.'</B></span><br />Location: <B>'.$visit->company_name.'</B></span><br />BIll To: <B>'.$visit->customer_name.'<br /><i class="bx bx-user bx-sm"></i><sup>1</sup> '. $visit->primary_sales_person_name. "<br />".$secondary_sales_person_icon.$visit->secondary_sales_person_name. '</B>',
                'opportunity_id'                => $visit->opportunity_id,
                'opportunity_code'              => $visit->opportunity_code,
                'visit_printed_notes'           => $visit->visit_printed_notes,
                'internal_notes'                => $visit->internal_notes,
                'ship_to_job_name'              => $visit->ship_to_job_name,
                'primary_sales_person_name'     => $visit->primary_sales_person_name,
                'secondary_sales_person_name'   => $visit->secondary_sales_person_name,
                'ship_to_address'               => $ship_to_address,
                'company_name'                  => $visit->company_name,
                'start'                         => $visit->visit_date_time,
                'end'                           => $visit->visit_date_time,
                'color'                         => '#03C3EC',
                'backgroundColor'               => '#D7F5FC',
                'formattedDate'                 => Carbon::parse($visit->visit_date_time)->format('M d, Y - h:i A'),
            ];
        }

        return view('visit_calendar.visit', ['events' => $events]);
    }

    public function update(UpdateVisitCalendarRequest $request)
    {
        try {
            $this->visitCalendarRepository->update($request->only('visit_printed_notes'), $request->visit_id); // Use validated data
            $this->visitCalendarRepository->update1($request->only('internal_notes'), $request->opportunity_id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Visit Calendar updated successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error updating visit calendar: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the visit calendar.']);
        }
    }
}
