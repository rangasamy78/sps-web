@extends('layouts.admin')

@section('title', 'Create Sample Order')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4 text-dark">Add Sample Order for Opportunity <span class="text-primary"> # {{$opportunity->opportunity_code}}</span></h4>

        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-0 fw-bold">
                                <span class="text-dark fw-bold">{{$opportunity->opportunity_code}}- {{$customer->customer_name}}</span><br>
                            </h6>
                            <div class="row">
                                <span style="font-size:9pt">{{$opportunity_date}}</span>
                            </div>
                            <div class=" row mt-2">
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <!-- <label for="print_name" class="form-label text-dark fw-bold">Print Name / DBA:</label> -->
                                            <label for="created_by" class="form-label" style="font-size:8pt">Delivery Type</label>
                                            <span class="d-block  text-dark fw-bold">
                                                {{$opportunity->ship_to_type??''}}
                                            </span>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    @if(optional($price_list)->price_label)
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Price Level</label>
                                            <span id="print_name_value" class="d-block  text-dark fw-bold">
                                                {{$price_list->price_label??''}}-{{$price_list->price_code??''}}
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                @if(optional($taxcode)->tax_code)
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Sales Tax</label>
                                            <span id="print_name_value" class="d-block text-dark fw-bold">
                                                {{ $taxcode->tax_code ?? '0%' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(optional($payment_term)->payment_label)
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Payment Terms</label>
                                            <span id="print_name_value" class="d-block text-dark fw-bold">
                                                {{ $payment_term->payment_label ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Job Name</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold">{{$opportunity->ship_to_job_name??''}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$opportunity->ship_to_address??''}}&nbsp;{{$opportunity->ship_to_city??''}}&nbsp;{{$opportunity->ship_to_state??''}}&nbsp;{{$opportunity->ship_to_zip??''}}</span>
                                    </div>
                                    @if(optional($opportunity)->ship_to_attn)
                                    <div class="row mt-1">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-ss-user fs-5"></i>{{$opportunity->ship_to_attn??''}}</span>
                                    </div>
                                    @endif
                                    @if(optional($opportunity)->ship_to_phone)
                                    <div class="row mt-1">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-ss-phone-call"></i>{{$opportunity->ship_to_phone??''}}&nbsp;&nbsp;&nbsp;{{$opportunity->ship_to_mobile??''}}</span>
                                    </div>
                                    @endif
                                    @if(optional($opportunity)->ship_to_fax)
                                    <div class="row mt-1">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-ss-fax"></i>{{$opportunity->ship_to_fax??''}}</span>
                                    </div>
                                    @endif
                                    @if(optional($opportunity)->ship_to_email)
                                    <div class="row mt-1">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-ss-envelope"></i>{{$opportunity->ship_to_email??''}}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary">Bill To</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold">{{$customer->customer_name??''}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$customer->address??''}}&nbsp;{{$customer->city??''}}&nbsp;{{$customer->state??''}}&nbsp;{{$customer->zip??''}}</span>
                                    </div>

                                </div>
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary">Ship To</label>
                                    <div class=" row">
                                        <div class="col"><span class="text-dark fw-bold">{{$opportunity->ship_to_name??''}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$opportunity->ship_to_address??''}}&nbsp;{{$opportunity->ship_to_city??''}}&nbsp;{{$opportunity->ship_to_state??''}}&nbsp;{{$opportunity->ship_to_zip??''}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 p-1">
                                    @if(optional($endUseSegment)->end_use_segment)
                                    <div class="row">
                                        <label class="form-label text-primary">End-Use Segment <div class="text-dark fw-bold">{{$endUseSegment->end_use_segment??''}}</div></label>
                                    </div>
                                    @endif
                                    @if(optional($projectType)->project_type_name)
                                    <div class="row">
                                        <label class="form-label text-primary">Project Type <div class="text-dark fw-bold">{{$projectType->project_type_name??''}}</div></label>
                                    </div>
                                    @endif
                                    @if(optional($howDidHear)->how_did_you_hear_option)
                                    <div class="row mt-1">
                                        <label class="form-label text-primary">How did you hear about us?<div class="text-dark fw-bold">{{$howDidHear->how_did_you_hear_option??''}}</div></label>
                                    </div>
                                    @endif
                                    @if ($opportunity->is_do_not_send_email==0)
                                    <div class="row">
                                        <div class="col">
                                            <span class="d-block text-danger fw-bold">
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
                                            @if(optional($company)->company_name)
                                            <div class="row">
                                                <label class="">Location</label>
                                                <span class="text-dark fw-bold">{{$company->company_name??''}}</span>
                                            </div>
                                            @endif
                                            @if(optional($primarySale)->first_name)
                                            <div class="row mt-1">
                                                <span class="text-dark"><i class="fi fi-rr-user-tag"></i>{{$primarySale->first_name??''}}&nbsp;{{$primarySale->last_name??''}}</span>
                                            </div>
                                            @endif
                                            @if(optional($secondarySale)->first_name)
                                            <div class="row mt-1">
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
                                        <div class="col-sm-6">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$opportunity->internal_notes}}</textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label fw-bold text-dark">Printed Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="printed_notes">{{$visit->visit_printed_notes}}</textarea>
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
            <!-- //visit Details -->
            <form id="formAddNewSampleOrder">
                <div class="row mt-3">
                    <div class="col-lg-7 col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="text-primary fw-bold">Sample Order Details</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <input type="hidden" class="form-control" name="opportunity_id" id="opportunity_id" value="{{$opportunity->id}}">
                                        <label class="form-label">Sample Order Label</label>
                                        <input type="text" class="form-control" name="sample_order_label" id="sample_order_label" placeholder="Enter Sample Order Label" value="{{$visit->visit_label}}">
                                        <span class="text-danger error-text sample_order_label_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Sales Person that helped with Sample Order</label>
                                        <select class="form-select select2" name="sales_person_id" id="sales_person_id" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $name)
                                            <option value="{{ $id }}" {{ isset($visit) && $visit->sales_person_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text sales_person_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Sample Order Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" name="sample_order_date" id="sample_order_date" value="{{$visit->visit_date}}">
                                        <span class="text-danger error-text sample_order_date_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Sample Order Time</label>
                                        <input type="time" class="form-control" name="sample_order_time" id="sample_order_time" value="{{$visit->visit_time}}">
                                        <span class="text-danger error-text sample_order_time_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">Price Level <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select select2" name="price_level_id" id="price_level_id" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['priceListLabels'] as $id => $label)
                                            <option value="{{ $id }}" {{ isset($visit) && $visit->price_level_id == $id ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text price_level_id_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">End-use Segment</label>
                                        <select class="form-select select2" name="end_use_segment_id" id="end_use_segment_id" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['endUseSegments'] as $id => $end_use_segment)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->end_use_segment_id == $id ? 'selected' : '' }}>{{ $end_use_segment }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text end_use_segment_id_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">Project Type</label>
                                        <select class="form-select select2" name="project_type_id" id="project_type_id" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['projectTypes'] as $id => $project_type_name)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->project_type_id == $id ? 'selected' : '' }}>{{ $project_type_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text saproject_type_id_error"></span>
                                    </div>
                                </div>
                                <h5 class="text-primary fw-bold mt-2">Instructions & Notes</h5>
                                <div class="row mt-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Printed Notes for this Sample Order</label>
                                        <textarea class="form-control" rows="2" name="sample_order_printed_notes" id="sample_order_printed_notes" placeholder="Enter Printed Notes">{{$opportunity->printed_notes}}</textarea>
                                        <span class="text-danger error-text sample_order_printed_notes_error"></span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Append new Internal Notes for this Opportunity </label>
                                        <textarea class="form-control" rows="2" name="internal_notes" id="internal_notes" placeholder="Enter Internal Notes">{{$opportunity->internal_notes}}</textarea>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-8 col-sm-12">
                                        <label class="form-label">Append new Special Instructions for this Opportunity</label>
                                        <textarea class="form-control" rows="2" name="special_instructions" id="special_instructions" placeholder="Enter Special Instructions">{{$opportunity->special_instructions}}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-12">
                        <div class="card mb-1">
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="delivery_type" class="form-label">Delivery Type</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="pickup" name="delivery_type" value="pickup" {{ $opportunity->ship_to_type=='Pick Up' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark fw-bold" for="pickup">Pickup</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="delivery" name="delivery_type" {{ $opportunity->ship_to_type=='Delivery' ? 'checked' : '' }} value="delivery">
                                                <label class="form-check-label text-dark fw-bold" for="delivery">Delivery</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Delivery-Specific Fields -->
                                <div id="delivery-fields" class="conditional-fields">
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_attn">Attn</label>
                                            <input type="text" class="form-control" id="delivery_attn" placeholder="Enter Attn" name="delivery_attn" value="{{$opportunity->ship_to_attn}}" aria-label="ShipTo Name" />
                                            <span class="text-danger error-text delivery_attn_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_tracking">Tracking #</label>
                                            <input type="text" class="form-control" id="delivery_tracking" placeholder="Enter Tracking" name="delivery_tracking" aria-label="Address" />
                                            <span class="text-danger error-text delivery_tracking_error"></span>
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_shipping_ui">Shipping UI #</label>
                                            <input type="text" class="form-control" id="delivery_shipping_ui" placeholder="Enter Shipping UI" name="shipping_ui" aria-label="Shipping UI" />
                                            <span class="text-danger error-text delivery_shipping_ui_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_address">Address</label>
                                            <input type="text" class="form-control" id="delivery_address" placeholder="Enter Address" name="delivery_address" value="{{$opportunity->ship_to_address}}" aria-label="delivery_Address" />
                                            <span class="text-danger error-text delivery_address_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_suite">Address2</label>
                                            <input type="text" class="form-control" id="delivery_suite" placeholder="Enter Address2" name="delivery_suite" value="{{$opportunity->ship_to_suite}}" aria-label="delivery_Address2" />
                                            <span class="text-danger error-text delivery_suite_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_city">City </label>
                                            <input type="text" class="form-control" id="delivery_city" placeholder="Enter City" name="delivery_city" value="{{$opportunity->ship_to_city}}" aria-label="delivery_City" />
                                            <span class="text-danger error-text delivery_city_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_state">State</label>
                                            <input type="text" class="form-control" id="delivery_state" placeholder="Enter State" name="delivery_state" value="{{$opportunity->ship_to_state}}" aria-label="State" />
                                            <span class="text-danger error-text delivery_state_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_zip">Zip</label>
                                            <input type="text" class="form-control" id="delivery_zip" placeholder="Enter Zip" name="delivery_zip" value="{{$opportunity->ship_to_zip}}" aria-label="delivery_Zip" />
                                            <span class="text-danger error-text delivery_zip_error"></span>
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_country_id">Country</label>
                                            <select id="delivery_country_id" name="delivery_country_id" class="select2 form-select" data-allow-clear="true">
                                                <option value="">--select--</option>
                                                @foreach($data['countries'] as $id => $country_name)
                                                <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->ship_to_country_id == $id ? 'selected' : '' }}>{{ $country_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text delivery_country_id_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_phone">Phone</label>
                                            <input type="text" class="form-control" id="delivery_phone" placeholder="Enter Phone" name="delivery_phone" value="{{$opportunity->ship_to_phone}}" aria-label="State" />
                                            <span class="text-danger error-text delivery_phone_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_fax">Fax</label>
                                            <input type="text" class="form-control" id="delivery_fax" placeholder="Enter Fax" name="delivery_fax" value="{{$opportunity->ship_to_fax}}" aria-label="delivery_fax" />
                                            <span class="text-danger error-text delivery_fax_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label" for="delivery_country_id">Email</label>
                                            <input type="text" class="form-control" id="delivery_email" placeholder="Enter Email" name="delivery_email" value="{{$opportunity->ship_to_email}}" aria-label="delivery_email" />
                                            <span class="text-danger error-text delivery_email_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Other delivery fields here -->

                                <!-- Common Fields -->
                                <div id="common-fields" class="conditional-fields">

                                </div>




                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="card-datatable table-responsive">
                        <table class="datatables-basic table table-light table-hover" id="convertSampleOrderDatatable">
                            <thead class="table-header-bold table-active">
                                <tr>
                                    <th>Header/Product/Service</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Extended</th>
                                    <th>Tax</th>
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
                                            <input type="text" class="form-control form-control-sm" name="product_description[]"
                                                value="{{ $visitProduct->product_description }}" style="width: 80px;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="number" class="form-control form-control-sm quantity" value="{{ $visitProduct->product_quantity }}" name="product_quantity[]" id="product_quantity[]" style="width: 90px;">
                                            <span>{{ $visitProduct->product->unit_measure->unit_measure_name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center p-2">
                                            <label class="text-dark fw-bold me-1 mb-0" style="font-size: 7pt;white-space: nowrap;">Sample Qty.:</label>
                                            <input type="text" class="form-control form-control-sm" value=""
                                                id="sample_quantity[]" name="sample_quantity[]" style="width: 60px;">
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
                                        <input type="text" class="form-control form-control-sm" name="service_description[]"
                                            value="{{ $visitService->service_description }}">
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
                        <button type="submit" class="btn btn-primary me-lg-2" name="saveCreateSampleOrder" id="saveCreateSampleOrder">Create Sample Order</button>
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
@include('opportunity.opportunity_convert.__script_sample_order')
@endsection