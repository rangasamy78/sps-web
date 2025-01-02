@extends('layouts.admin')

@section('title', 'Create Sample Order')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
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
                    <div class="card mb-1">
                        <div class="card-header">
                            <h4 class="card-title mb-0 fw-bold">
                                <span class="text-dark fw-bold">{{$opportunity->opportunity_code}}- {{$customer->customer_name}}</span><br>
                            </h4>
                            <div class="row p-1">
                                <span>{{$opportunity_date}}</span>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <!-- <label for="print_name" class="form-label text-dark fw-bold">Print Name / DBA:</label> -->
                                            <label for="created_by" class="form-label" style="font-size:8pt">Delivery Type</label>
                                            <span class="d-block  text-dark fw-bold">
                                                {{$opportunity->ship_to_type}}
                                            </span>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Price Level</label>
                                            <span id="print_name_value" class="d-block  text-dark fw-bold">
                                                {{$price_list->price_label}}-{{$price_list->price_code}}
                                            </span>
                                        </div>
                                    </div>
                                </div>

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

                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Job Name</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold">{{$opportunity->ship_to_job_name}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$opportunity->ship_to_address??''}}&nbsp;{{$opportunity->ship_to_city??''}}&nbsp;{{$opportunity->ship_to_state??''}}&nbsp;{{$opportunity->ship_to_zip??''}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary">Bill To</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold">{{$customer->customer_name}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$customer->address??''}}&nbsp;{{$customer->city??''}}&nbsp;{{$customer->state??''}}&nbsp;{{$customer->zip??''}}</span>
                                    </div>

                                </div>
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary">Ship To</label>
                                    <div class=" row">
                                        <div class="col"><span class="text-dark fw-bold">{{$opportunity->ship_to_name}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$opportunity->ship_to_address??''}}&nbsp;{{$opportunity->ship_to_city??''}}&nbsp;{{$opportunity->ship_to_state??''}}&nbsp;{{$opportunity->ship_to_zip??''}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 p-1">
                                    <label class="form-label text-primary">End-Use Segment</label>
                                    <div class="row">
                                        <div class="col showContact">
                                            <span class="text-dark fw-bold">{{$endUseSegment->end_use_segment??''}}</span>
                                        </div>
                                    </div>
                                    <label class="form-label text-primary">Project Type</label>
                                    <div class="row">
                                        <div class="col showContact">
                                            <span class="text-dark fw-bold">{{$projectType->project_type_name??''}}</span>
                                        </div>
                                    </div>
                                    <label class="form-label text-primary">How did you hear about us?</label>
                                    <div class="row">
                                        <div class="col showContact">
                                            <span class="text-dark fw-bold">{{$howDidHear->how_did_you_hear_option??''}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-bottom border-dark mt-3">
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="row">
                                                <label class="form-label">Location</label>
                                                <span class="text-dark fw-bold">{{$company->company_name??''}}</span>
                                            </div>
                                            <div class="row">
                                                <span class="text-dark"><i class="fi fi-rr-user-tag"></i>{{$primarySale->first_name??''}}&nbsp;{{$primarySale->last_name??''}}</span>
                                            </div>
                                            <div class="row">
                                                <span class="text-dark"><i class="fi fi-rr-user-tag"></i>{{$secondarySale->first_name ??''}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="row">
                                                <label class="form-label">Fabricator</label>
                                                <span class="text-dark fw-bold">{{$fabricator->associate_name??''}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$opportunity->internal_notes}}</textarea>
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
                                        <input type="text" class="form-control" name="sample_order_label" id="sample_order_label" placeholder="Enter Visit Label">
                                        <span class="text-danger error-text sample_order_label_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Sales Person that helped with Sample Order</label>
                                        <select class="form-select select2" name="sales_person_id" id="sales_person_id" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text sales_person_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Sample Order Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" name="sample_order_date" id="sample_order_date">
                                        <span class="text-danger error-text sample_order_date_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Sample Order Time</label>
                                        <input type="time" class="form-control" name="sample_order_time" id="sample_order_time">
                                        <span class="text-danger error-text sample_order_time_error"></span>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="delivery_type" class="form-label">Delivery Type</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="pickup" name="delivery_type" value="pickup">
                                                <label class="form-check-label text-dark fw-bold" for="pickup">Pickup</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="delivery" name="delivery_type" value="delivery">
                                                <label class="form-check-label text-dark fw-bold" for="delivery">Delivery</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Delivery-Specific Fields -->
                                <div id="delivery-fields" class="conditional-fields">
                                    <div class="row mt-2">
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label" for="delivery_attn">Attn</label>
                                            <input type="text" class="form-control" id="delivery_attn" placeholder="Enter Attn" name="delivery_attn" aria-label="ShipTo Name" />
                                            <span class="text-danger error-text delivery_attn_error"></span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label" for="delivery_tracking">Tracking #</label>
                                            <input type="text" class="form-control" id="delivery_tracking" placeholder="Enter Tracking" name="delivery_tracking" aria-label="Address" />
                                            <span class="text-danger error-text delivery_tracking_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_address">Address</label>
                                            <input type="text" class="form-control" id="delivery_address" placeholder="Enter Address" name="delivery_address" aria-label="delivery_Address" />
                                            <span class="text-danger error-text delivery_address_error"></span>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_suite">Address2</label>
                                            <input type="text" class="form-control" id="delivery_suite" placeholder="Enter Address2" name="delivery_suite" aria-label="delivery_Address2" />
                                            <span class="text-danger error-text delivery_suite_error"></span>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_city">City </label>
                                            <input type="text" class="form-control" id="delivery_city" placeholder="Enter City" name="delivery_city" aria-label="delivery_City" />
                                            <span class="text-danger error-text delivery_city_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_state">State</label>
                                            <input type="text" class="form-control" id="delivery_state" placeholder="Enter State" name="delivery_state" aria-label="State" />
                                            <span class="text-danger error-text delivery_state_error"></span>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_zip">Zip</label>
                                            <input type="text" class="form-control" id="delivery_zip" placeholder="Enter Zip" name="delivery_zip" aria-label="delivery_Zip" />
                                            <span class="text-danger error-text delivery_zip_error"></span>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_country_id">Country</label>
                                            <select id="delivery_country_id" name="delivery_country_id" class="select2 form-select" data-allow-clear="true">
                                                <option value="">--select--</option>
                                                @foreach($data['countries'] as $id => $country_name)
                                                <option value="{{ $id }}">{{ $country_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text delivery_country_id_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Other delivery fields here -->

                                <!-- Common Fields -->
                                <div id="common-fields" class="conditional-fields">
                                    <div class="row mt-2">
                                        <div class="col-lg-8 col-sm-12">
                                            <label class="form-label" for="document_footer_id">Document Footer</label>
                                            <select class="form-control" id="document_footer_id" name="document_footer_id">
                                                <option value="">--select--</option>
                                                @foreach($data['documentFooters'] as $id => $policy_name)
                                                <option value="{{ $id }}">{{ $policy_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text document_footer_id_error"></span>
                                        </div>
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
                                        <label class="form-label">Printed Notes for this Sample Order</label>
                                        <textarea class="form-control" rows="3" name="sample_order_printed_notes" id="sample_order_printed_notes" placeholder="Enter Printed Notes"></textarea>
                                        <span class="text-danger error-text sample_order_printed_notes_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Append new Special Instructions for this Opportunity</label>
                                        <textarea class="form-control" rows="3" name="special_instructions" id="special_instructions" placeholder="Enter Special Instructions">{{$opportunity->special_instructions}}</textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Append new Internal Notes for this Opportunity </label>
                                        <textarea class="form-control" rows="3 " name="internal_notes" id="internal_notes" placeholder="Enter Internal Notes">{{$opportunity->internal_notes}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary me-lg-2" name="nextStepAddProduct" id="nextStepAddProductBtn">Go To Next Step To Add Products</button>
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
@include('sample_order.create.__script')
@endsection