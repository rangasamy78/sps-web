<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitCalendar\UpdateVisitCalendarRequest;
use App\Models\VisitProduct;
use App\Repositories\VisitCalendarRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

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
            ->leftjoin('companies', 'opportunities.location_id', '=', 'companies.id')
            ->leftjoin('customers', 'opportunities.billing_customer_id', '=', 'customers.id')
            ->leftjoin('users as primary_user', 'opportunities.primary_sales_person_id', '=', 'primary_user.id')
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

        if (count($visitCalendars) > 0) {
            foreach ($visitCalendars as $visit) {
                $secondary_sales_person = "";
                $product_details = "";
                if (!empty(trim($visit->secondary_sales_person_name))) {
                    $secondary_sales_person = "<i class='bx bx-group bx-sm'></i><sup>2</sup> $visit->secondary_sales_person_name ";
                }
                $ship_to_address = (!empty($visit->customer_name) ? $visit->customer_name : null) . '<br />' . (!empty($visit->shipping_address) ? $visit->shipping_address : null) . '<br />' . (!empty($visit->shipping_city) ? $visit->shipping_city : null) . ' ' . (!empty($visit->shipping_state) ? $visit->shipping_state : null) . ' ' . (!empty($visit->shipping_zip) ? $visit->shipping_zip : null) . '<br />' . (!empty($visit->shipping_county) ? $visit->shipping_county : null);
                $visit_products = VisitProduct::where('visit_id', $visit->id)
                    ->join('products', 'visit_products.product_id', '=', 'products.id')
                    ->select('visit_products.*', 'products.product_name as product_name')
                    ->get();
                if (count($visit_products) > 0) {
                    $product_details = '<div class="mt-3"><table class="table table-bordered">
                            <thead class="table-header-bold">
                                <tr>
                                    <th style="color: black; font-weight: bold;">Product Name</th>
                                    <th style="color: black; font-weight: bold;">Serial Num</th>
                                    <th style="color: black; font-weight: bold;">Lot/ Block</th>
                                    <th style="color: black; font-weight: bold;">Bundle</th>
                                    <th style="color: black; font-weight: bold;">Supp. Ref</th>
                                    <th style="color: black; font-weight: bold;">Quantity</th>
                                    <th style="color: black; font-weight: bold;">Unit Price</th>
                                    <th style="color: black; font-weight: bold;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>';
                    foreach ($visit_products as $visit_product) {
                        $product_details .= '<tr>
                                                        <td>' . $visit_product->product_name . '</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>' . $visit_product->product_quantity . '</td>
                                                        <td>' . $visit_product->product_unit_price . '</td>
                                                        <td>' . $visit_product->product_amount . '</td>
                                                    </tr>';
                    }
                    $product_details .= '</tbody></table></div>';
                }

                $events[] = [
                    'id' => $visit->id,
                    'title' => '<span style="float:right;"> Visit # ' . '<B>' . (!empty($visit->opportunity_code) ? $visit->opportunity_code : null) . '&nbsp;&nbsp;</span><br /><span style="white-space:break-spaces; color: black"> ' . (!empty($visit->ship_to_job_name) ? $visit->ship_to_job_name : null) . '</B></span><br />Location: <B>' . (!empty($visit->company_name) ? $visit->company_name : null) . '</B></span><br />BIll To: <B>' . (!empty($visit->customer_name) ? $visit->customer_name : null) . '<br /><i class="bx bx-user bx-sm"></i><sup>1</sup> ' . (!empty($visit->primary_sales_person_name) ? $visit->primary_sales_person_name : null) . "<br />" . $secondary_sales_person . '</B>',
                    'opportunity_id' => $visit->opportunity_id,
                    'opportunity_code' => !empty($visit->opportunity_code) ? $visit->opportunity_code : null,
                    'visit_printed_notes' => !empty($visit->visit_printed_notes) ? $visit->visit_printed_notes : null,
                    'internal_notes' => !empty($visit->internal_notes) ? $visit->internal_notes : null,
                    'ship_to_job_name' => !empty($visit->ship_to_job_name) ? $visit->ship_to_job_name : null,
                    'primary_sales_person_name' => !empty($visit->primary_sales_person_name) ? $visit->primary_sales_person_name : null,
                    'secondary_sales_person_name' => !empty($visit->secondary_sales_person_name) ? $visit->secondary_sales_person_name : null,
                    'ship_to_address' => !empty($ship_to_address) ? $ship_to_address : null,
                    'company_name' => !empty($visit->company_name) ? $visit->company_name : null,
                    'product_details' => !empty($product_details) ? $product_details : null,
                    'start' => !empty($visit->visit_date_time) ? $visit->visit_date_time : null,
                    'end' => !empty($visit->visit_date_time) ? $visit->visit_date_time : null,
                    'color' => '#03C3EC',
                    'backgroundColor' => '#D7F5FC',
                    'formattedDate' => Carbon::parse($visit->visit_date_time)->format('M d, Y - h:i A'),
                ];
            }
        } else {
            $events = [];
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
            Log::error('Error updating visit calendar: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the visit calendar.']);
        }
    }
}
