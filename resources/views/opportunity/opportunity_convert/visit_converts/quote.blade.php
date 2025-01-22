@extends('layouts.admin')

@section('title', 'Create Quote')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 text-dark"><span class="text-primary">Add Quote for Opportunity # {{$opportunity->opportunity_code}}</span> {{$customer->customer_name}}@ {{$company->company_name}}</h4>
        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 fw-bold">
                                <span>{{$opportunity_date}}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Job Name:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$customer->customer_name??''}}</span>
                                    </h6>
                                    <!-- <label class="form-label text-primary" style="font-size:8pt">Job Name: <span class="text-dark">{{$customer->customer_name}}</span></label> -->
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold">{{$opportunity->ship_to_job_name??''}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$opportunity->ship_to_address??''}}&nbsp;{{$opportunity->ship_to_city??''}}&nbsp;{{$opportunity->ship_to_state??''}}&nbsp;{{$opportunity->ship_to_zip??''}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Bill To:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$customer->customer_name??''}}</span>
                                    </h6>
                                    <!-- <label class="form-label text-primary">Bill To</label> -->
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold">{{$customer->customer_name??''}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$customer->address??''}}&nbsp;{{$customer->city??''}}&nbsp;{{$customer->state??''}}&nbsp;{{$customer->zip??''}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    @if (optional($price_list)->price_label)
                                    <div class="row">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Price Level</label>
                                            <span id="print_name_value" class="d-block text-dark fw-bold">
                                                {{$price_list->price_label}}-{{$price_list->price_code??''}}
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    @if (optional($taxcode)->tax_code)
                                    <div class="row">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Sales Tax</label>
                                            <span id="print_name_value" class="d-block text-dark fw-bold">
                                                {{ $taxcode->tax_code }}
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    @if (optional($payment_term)->payment_label)
                                    <div class="row">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Payment Terms</label>
                                            <span id="print_name_value" class="d-block text-dark fw-bold">
                                                {{ $payment_term->payment_label ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    @if (optional($opportunity)->tax_code)
                                    <div class="row">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Delivery Type</label>
                                            <span class="d-block text-dark fw-bold">
                                                {{$opportunity->ship_to_type}}
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    @if (optional($howDidHear)->how_did_you_hear_option)
                                    <div class="row">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">How did you hear about us?</label>
                                            <span class="d-block text-dark fw-bold">
                                                {{$howDidHear->how_did_you_hear_option}}
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($opportunity->is_do_not_send_email==0)
                                    <div class="row">
                                        <div class="col">
                                            <span class="d-block text-primary fw-bold">
                                                Do not send any email updates
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row border-bottom border-dark mt-3">
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="row">
                                                <label class="">Location</label>
                                                <span class="text-dark fw-bold">{{$company->company_name??''}}</span>
                                            </div>
                                            @if(optional($primarySale)->first_name)
                                            <div class="row">
                                                <span class="text-dark"><i class="fi fi-rr-user-tag"></i>{{$primarySale->first_name??''}}&nbsp;{{$primarySale->last_name??''}}</span>
                                            </div>
                                            @endif
                                            @if(optional($secondarySale)->first_name)
                                            <div class="row">
                                                <span class="text-dark"><i class="fi fi-rr-user-tag"></i>{{$secondarySale->first_name ??''}}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            @if(optional($fabricator)->associate_name)
                                            <div class="row">
                                                <label class="">Fabricator</label>
                                                <span style="font-size:9pt" class="text-dark fw-bold">{{$fabricator->associate_name??''}}</span>
                                            </div>
                                            @endif
                                            @if(optional($designer)->associate_name)
                                            <div class="row mt-1">
                                                <label class="">Designer</label>
                                                <span style="font-size:9pt" class="text-dark fw-bold">{{$designer->associate_name??''}}</span>
                                            </div>
                                            @endif
                                            @if(optional($builder)->associate_name)
                                            <div class="row mt-1">
                                                <label class="">Builder</label>
                                                <span style="font-size:9pt" class="text-dark fw-bold">{{$builder->associate_name??''}}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$opportunity->internal_notes}}</textarea>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-dark">Printed Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="printed_notes_input">{{$opportunity->printed_notes}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Special Instructions</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="special_notes_input">{{$opportunity->special_instructions}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /first column -->
            </div>
            <!-- buttons for visit,holds,sample order,quotes -->
            <!-- //Quote Details -->
            <form id="formConvertAddNewQuote">
                <div class="row mt-3">
                    <div class="col-lg-7 col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="text-primary fw-bold">Quote Details</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <input type="date" class="form-control" hidden name="status_update_date" id="status_update_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        <input type="text" class="form-control" hidden name="status_update_user_id" id="status_update_user_id" value="{{auth()->id()}}">
                                        <input type="text" class="form-control" hidden name="status" id="status" value="open">
                                        <input type="hidden" class="form-control" name="opportunity_id" id="opportunity_id" value="{{$opportunity->id}}">
                                        <input type="hidden" class="form-control" name="quote_id" id="quote_id" value="">
                                        <label class="form-label" for="quote_label">Quote Label</label>
                                        <input type="text" class="form-control" name="quote_label" id="quote_label" placeholder="Enter Quote Label" value="{{$visit->visit_label}}">
                                        <span class="text-danger error-text quote_label_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="secondary_sales_person_id">Secondary Sales Person if any </label>
                                        <select class="form-control" id="secondary_sales_person_id" name="secondary_sales_person_id">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $name)
                                            <option value="{{ $id }}" {{ isset($visit) && $visit->sales_person_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text secondary_sales_person_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-6">
                                        <label class="form-label" for="quote_date">Quote Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" value="{{$visit->visit_date}}" name="quote_date" id="quote_date">
                                        <span class="text-danger error-text quote_date_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label class="form-label" for="quote_time">Quote Time</label>
                                        <input type="time" class="form-control" name="quote_time" id="quote_time" value="{{$visit->visit_time}}">
                                        <span class="text-danger error-text quote_time_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="expiry_date">Expiry Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" name="expiry_date" id="expiry_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        <span class="text-danger error-text expiry_date_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="customer_po">Customer P.O#</label>
                                        <input type="text" class="form-control" name="customer_po" id="customer_po" placeholder="Enter Customer P.O">
                                        <span class="text-danger error-text customer_po_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="price_level_id">Price Level <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="select2 form-select" id="price_level_id" name="price_level_id">
                                            <option value="">--select--</option>
                                            @foreach($data['priceListLabels'] as $id => $label)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->price_level_label_id == $id ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text price_level_id_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="delivery_attn">End-use Segment</label>
                                        <select class="select2 form-select" id="end_use_segment_id" name="end_use_segment_id">
                                            <option value="">--select--</option>
                                            @foreach($data['endUseSegments'] as $id => $end_use_segment)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->end_use_segment_id == $id ? 'selected' : '' }}>{{ $end_use_segment }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text end_use_segment_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="project_type_id">Project Type</label>
                                        <select class="select2 form-select" id="project_type_id" name="project_type_id">
                                            <option value="">--select--</option>
                                            @foreach($data['projectTypes'] as $id => $project_type_name)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->project_type_id == $id ? 'selected' : '' }}>{{ $project_type_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text project_type_id_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="eta_date">ETA Date</label>
                                        <input type="date" class="form-control" id="eta_date" name="eta_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" aria-label="Address" />
                                        <span class="text-danger error-text eta_date_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="payment_terms_id">Payment Terms <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="select2 form-select" id="payment_terms_id" name="payment_terms_id">
                                            <option value="">--select--</option>
                                            @foreach($data['paymentTerms'] as $paymentTerm)
                                            <option value="{{ $paymentTerm->id }}">{{ $paymentTerm->payment_label }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text payment_terms_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="sales_tax_id">Sales Tax <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="select2 form-select" id="sales_tax_id" name="sales_tax_id">
                                            <option value="">--select--</option>
                                            @foreach($data['salesTaxs'] as $id => $tax_name)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->sales_tax_id == $id ? 'selected' : '' }}>{{ $tax_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text sales_tax_id_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="quote_header_id">Quote Header</label>
                                        <select class="select2 form-select" id="quote_header_id" name="quote_header_id">
                                            <option value="">--select--</option>
                                            @foreach($data['quoteHeader'] as $id => $quote_header_name)
                                            <option value="{{ $id }}">{{ $quote_header_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text quote_header_id_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="quote_footer_id">Quote Footer</label>
                                        <select class="select2 form-select" id="quote_footer_id" name="quote_footer_id">
                                            <option value="">--select--</option>
                                            @foreach($data['quoteFooter'] as $id => $quote_footer_name)
                                            <option value="{{ $id }}">{{ $quote_footer_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text quote_footer_id_error"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="text-primary fw-bold">Instructions & Notes</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Append new Special Instructions for this Opportunity</label>
                                        <textarea class="form-control" rows="2" name="special_instructions" id="special_instructions" placeholder="Enter Special Instructions">{{$opportunity->special_instructions}}</textarea>
                                        <span class="text-danger error-text special_instructions_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Append new Internal Notes for this Opportunity</label>
                                        <textarea class="form-control" rows="2" name="internal_notes" id="internal_notes" placeholder="Enter Internal Notes">{{$opportunity->internal_notes}}</textarea>
                                        <span class="text-danger error-text internal_notes_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Internal Notes for this Quote</label>
                                        <textarea class="form-control" rows="2" name="quote_internal_note" id="quote_internal_note" placeholder="Enter Internal Notes"></textarea>
                                        <span class="text-danger error-text quote_internal_note_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="quote_printed_notes_id">Printed Notes for this Quote</label>
                                        <select id="quote_printed_notes_id" name="quote_printed_notes_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['quotePrintedNote'] as $id => $quote_printed_notes_name)
                                            <option value="{{ $id }}">{{ $quote_printed_notes_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text quote_printed_notes_id_error"></span>
                                    </div>
                                    <div class="col-lg-8 col-sm-12">
                                        <label class="form-label" for="quote_printed_note">Printed Notes for this Quote</label>
                                        <textarea class="form-control" rows="2" name="quote_printed_note" id="quote_printed_note" placeholder="Enter Printed Notes"></textarea>
                                        <span class="text-danger error-text quote_printed_note_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="card-datatable table-responsive">
                        <table class="datatables-basic table table-light table-hover" id="convertQuoteDatatable">
                            <thead class="table-header-bold table-active">
                                <tr>
                                    <th>Header/Product/Service</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Extended</th>
                                    <th>Tax</th>
                                    <th>Hide</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($visitProducts as $visitProduct)
                                <tr class="product-row">
                                    <td>
                                        <span>{{ $visitProduct->product->product_name }}</span>
                                        <input type="hidden" name="product_id[]" value="{{ $visitProduct->product_id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="form-check-input me-2" name="is_sold_as[]" id="is_sold_as" value="1"
                                                {{ $visitProduct->is_sold_as ? 'checked' : '' }}>
                                            <label class="me-2 mb-0" style="font-size: 7pt;">Sold As:</label>
                                            <input type="text" class="form-control form-control-sm" name="description[]"
                                                value="{{ $visitProduct->description }}" style="width: 150px;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="number" class="form-control form-control-sm quantity" value="{{ $visitProduct->product_quantity }}" name="product_quantity[]" id="product_quantity[]" style="width: 90px;">
                                            <span>{{ $visitProduct->product->unit_measure->unit_measure_name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-1">$</span>
                                            <input type="text" class="form-control form-control-sm unit-price" value="{{ $visitProduct->product_unit_price }}"
                                                id="product_unit_price[]" name="product_unit_price[]" style="width: 90px;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">$</span>
                                            <input type="text" class="form-control form-control-sm amount" name="product_amount[]"
                                                value="{{ $visitProduct->product_amount }}" readonly style="width: 90px;">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input tax" name="is_tax[]" id="is_tax" value="1"
                                            {{ $visitProduct->is_tax ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input tax" name="is_hide_line[]" id="is_hide_line" value="1">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-border p-0 btnClear delete-row" style="width: 30px; height: 30px;">
                                            <i class="fi fi-rr-cross text-danger fw-bold" style="font-size: 13px;"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach

                                @foreach ($visitServices as $visitService)
                                <tr class="service-row">
                                    <td>
                                        <span>{{$visitService->service->service_name}}</span>
                                        <input type="hidden" name="service_id[]" id="service_id[]" value="{{ $visitService->service_id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="form-check-input me-2" name="is_sold_as[]" id="is_sold_as" value="1"
                                                {{ $visitService->is_sold_as ? 'checked' : '' }}>
                                            <label class="me-2 mb-0" style="font-size: 7pt;">Sold As:</label>
                                            <input type="text" class="form-control form-control-sm" name="description[]"
                                                value="{{ $visitService->description }}" style="width: 150px;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <input type="number" class="form-control form-control-sm quantity" name="service_quantity[]"
                                                value="{{ $visitService->service_quantity }}" style="width: 90px;">
                                            <span>{{ $visitService->service->unit_measure->unit_measure_name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <span>$</span>
                                            <input type="number" class="form-control form-control-sm unit-price" name="service_unit_price[]"
                                                value="{{ $visitService->service_unit_price }}" style="width: 90px;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <span>$</span>
                                            <input type="number" class="form-control form-control-sm amount" name="service_amount[]"
                                                value="{{ $visitService->service_amount }}" readonly style="width: 90px;">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input tax" name="is_tax[]" value="1"
                                            {{ $visitService->is_tax ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input tax" name="is_hide_line[]" id="is_hide_line" value="1">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-border p-0 btnClear delete-row"
                                            style="width: 30px; height: 30px;">
                                            <i class="fi fi-rr-cross text-danger fw-bold" style="font-size: 13px;"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <label class="text-dark fw-bold mt-2">Sub Total:</label>
                                <span class="mt-2 ms-4 fw-bold" id="sub_total">$</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <label class="text-dark fw-bold mt-2">
                                    Tax
                                    @if(!empty($taxcode?->tax_code_label))
                                    ({{ $taxcode->tax_code_label }} - {{ $taxAmount?->tax_code_total ?? '0' }}%):
                                    @else
                                    ()
                                    @endif
                                </label>
                                <input type="hidden" readonly class="form-control  border-0 w-25" id="tax_code_amount" name="tax_code_amount" value="{{$taxAmount?->tax_code_total ?? '0' }}">
                                <span class="mt-2 ms-4 fw-bold" id="tax_code_amount_label">$</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <input type="hidden" readonly class="form-control  border-0 w-25" id="total" name="total" value="">
                                <label class="text-dark fw-bold mt-2">Total:</label>
                                <span class="mt-2 ms-4 fw-bold" id="grand_total">$</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary me-lg-2" name="saveCreateQuote" id="saveCreateQuote">Create Quote</button>
                        <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@include('opportunity.opportunity_convert.__script_quote')
@endsection