@extends('layouts.admin')

@section('title', 'Add Opportunity')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <form id="accountForm">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{route('opportunities.index')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Opportunity /</span>
                    Add Opportunity</span>
                </a></h4>
            <div class="app-ecommerce">

                <div class="row">
                    <div class="col-12">
                        <div class="card  mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <input type="hidden" class="form-control" id="opportunity" name="opportunity">
                                        <label class="form-label" for="opportunity_date">Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="opportunity_date" name="opportunity_date" aria-label="date" />
                                        <span class="text-danger error-text opportunity_date_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="end_use_segment_id">End-use Segment</label>
                                        <select id="end_use_segment_id" name="end_use_segment_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['endUseSegments'] as $id => $end_use_segment)
                                            <option value="{{ $id }}">{{ $end_use_segment}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text end_use_segment_id_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="code">Project Type</label>
                                        <select id="project_type_id" name="project_type_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['projectTypes'] as $id => $project_type_name)
                                            <option value="{{ $id }}">{{ $project_type_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text account_name_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="code">Stage</label>
                                        <select id="stage_id" name="stage_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['opportunityStages'] as $id => $opportunity_stage)
                                            <option value="{{ $id }}">{{ $opportunity_stage}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text account_name_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-8 col-md-12 pt-sm-2">
                                        <label class="form-label" for="code">Contact Mode</label>

                                        <div class="d-flex align-items-center flex-wrap gap-1 p-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact_mode" id="radio1" value="option1">
                                                <label class="form-check-label" for="radio1"><i class="fi fi-ss-walking fs-3"></i></label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact_mode" id="radio2" value="option2">
                                                <label class="form-check-label" for="radio2"><i class="fi fi-ss-phone-call fs-3"></i></label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact_mode" id="radio3" value="option3">
                                                <label class="form-check-label" for="radio3"><i class="fi fi-rs-fax fs-3"></i></label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact_mode" id="radio4" value="option4">
                                                <label class="form-check-label" for="radio4"><i class="fi fi-ss-envelope fs-3"></i></label>
                                            </div>
                                        </div>

                                        <span class="text-danger error-text contact_mode_error"></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- First column-->
                    <div class="col-12 col-lg-5">
                        <!-- Account Information -->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Bill To</h5>
                                <button type="button" class="btn btn-border-0 text-dark ms-auto fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewCustomer">Add New</button>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="billing_customer_id">Billing Customer <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-label-secondary" readonly id="billing_customer_id" name="billing_customer_id" aria-label="Biiling Customer" />
                                            <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                data-bs-target="#searchCustomer">
                                                <i class="fi fi-rr-search text-white"></i>
                                            </span>
                                        </div>
                                        <span class="text-danger error-text account_number_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="attn">Attn</label>
                                        <input type="text" class="form-control" id="attn" name="attn" aria-label="attn" />
                                        <span class="text-danger error-text attn_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="address">Address </label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="address" name="address" aria-label="attn" />
                                        <span class="text-danger error-text address_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="suite">Suite / Unit#</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="suite" name="suite" aria-label="suite / Unit#" />
                                        <span class="text-danger error-text suite_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="city">City</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="city" name="city" aria-label="city" />
                                        <span class="text-danger error-text city_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="state">State</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="state" name="state" aria-label="state" />
                                        <span class="text-danger error-text state_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="zip">Zip</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="zip" name="zip" aria-label="zip" />
                                        <span class="text-danger error-text zip_error"></span>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label" for="country">Country</label>
                                        <select id="country" name="country" class="select2 form-select" disabled data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['countries'] as $id => $country_name)
                                            <option value="{{ $id }}">{{ $country_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text country_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="phone">Phone</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="phone" name="phone" aria-label="phone" />
                                        <span class="text-danger error-text phone_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="fax">Fax</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="fax" name="fax" aria-label="fax" />
                                        <span class="text-danger error-text fax_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="mobile">Mobile</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="mobile" name="mobile" aria-label="mobile" />
                                        <span class="text-danger error-text mobile_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="email" name="email" aria-label="email" />
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="price_level_label_id">Price Level <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="price_level_label_id" name="price_level_label_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['priceListLabels'] as $id => $label)
                                            <option value="{{ $id }}">{{ $label}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text price_level_label_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="primary_sales_person_id">Primary Sales Person <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="primary_sales_person_id" name="primary_sales_person_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $key => $user)
                                            <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text primary_sales_person_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="secondary_sales_person_id">Secondary Sales Person</label>
                                        <select id="secondary_sales_person_id" name="secondary_sales_person_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $key => $user)
                                            <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text secondary_sales_person_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="total_value">Total Value $</label>
                                        <input type="text" class="form-control" id="total_value" name="total_value" aria-label="Total Value" />
                                        <span class="text-danger error-text total_value_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="sales_tax_id">Sales Tax <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="sales_tax_id" name="sales_tax_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['salesTaxs'] as $id => $name)
                                            <option value="{{ $id }}">{{ $name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text sales_tax_id_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Account Information -->
                        <!-- instruction information -->
                        <div class="card mb-4 bankCard">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Notes/Instructions</h5>
                            </div>
                            <div class="card-body">

                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row mb-1">
                                            <div class="mb-3 col">
                                                <label class="form-label mb-1" for="special_instructions">Special / Delivery Instructions</label>
                                                <textarea id="special_instructions" name="special_instructions" class="form-control" rows="2" placeholder="Enter Special / Delivery Instruction" style="resize:none"></textarea>
                                                <span class="text-danger error-text special_instructions_error"></span>
                                            </div>

                                            <div class="mb-3 col-12">
                                                <label class="form-label mb-1" for="branch_name">Internal Notes</label>
                                                <textarea id="internal_notes" name="internal_notes" class="form-control" rows="2" placeholder="Enter Internal Notes" style="resize:none"></textarea>
                                                <span class="text-danger error-text internal_notes_error"></span>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label mb-1" for="printed_notes">Printed Notes</label>
                                                <textarea id="printed_notes" name="printed_notes" class="form-control" rows="2" placeholder="Enter Printed Notes" style="resize:none"></textarea>
                                                <span class="text-danger error-text printed_notes_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /Instruction information -->
                    </div>
                    <!-- /Second column -->

                    <!-- Second column -->
                    <div class="col-12 col-lg-7">
                        <!-- Contact Information Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Ship To</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-pick_up-tab" data-bs-toggle="pill" data-bs-target="#pills-pick_up" type="button" role="tab" aria-controls="pills-pick_up" aria-selected="true">
                                            Pick Up
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-delivery-tab" data-bs-toggle="pill" data-bs-target="#pills-delivery" type="button" role="tab" aria-controls="pills-delivery" aria-selected="false">
                                            Delivery
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade" id="pills-pick_up" role="tabpanel" aria-labelledby="pills-pick_up-tab">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label" for="pick_end_customer">End Customer / Job Name (Copy Bill To)(Copy Lot / Division)</label>
                                                <input type="text" class="form-control" id="pick_end_customer" name="pick_end_customer" aria-label="Statement End Day" />
                                                <span class="text-danger error-text pick_end_customer_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label" for="pick_attn">Attn</label>
                                                <input type="text" class="form-control" id="pick_attn" name="pick_attn" aria-label="Attn" />
                                                <span class="text-danger error-text pick_attn_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="pick_phone">Phone</label>
                                                <input type="text" class="form-control" id="pick_phone" name="pick_phone" aria-label="Phone" />
                                                <span class="text-danger error-text pick_phone_error"></span>
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label" for="pick_fax">Fax</label>
                                                <input type="text" class="form-control" id="pick_fax" name="pick_fax" aria-label="Fax" />
                                                <span class="text-danger error-text pick_fax_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="pick_mobile">Mobile</label>
                                                <input type="text" class="form-control" id="pick_mobile" name="pick_mobile" aria-label="Mobile" />
                                                <span class="text-danger error-text pick_mobile_error"></span>
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label" for="pick_lot">Lot</label>
                                                <input type="text" class="form-control" id="pick_lot" name="pick_lot" aria-label="Lot" />
                                                <span class="text-danger error-text pick_lot_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="pick_sub_division">Subdivision</label>
                                                <input type="text" class="form-control" id="pick_sub_division" placeholder="Enter Subdivision" name="pick_sub_division" aria-label="Statement End Day" />
                                                <span class="text-danger error-text pick_sub_division_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label" for="pick_email">Email</label>
                                                <input type="text" class="form-control" id="pick_email" placeholder="Enter Email" name="pick_email" aria-label="Email" />
                                                <span class="text-danger error-text pick_email_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="pick_how_did_hear_about_us_id">How did you hear about us? <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <select id="pick_how_did_hear_about_us_id" name="pick_how_did_hear_about_us_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['aboutUsOptions'] as $id => $how_did_you_hear_option)
                                                    <option value="{{ $id }}">{{ $how_did_you_hear_option}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text pick_how_did_hear_about_us_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col d-flex align-items-center">
                                                <input class="form-check-input" type="checkbox" value="1" id="pick_is_do_not_send_email" name="pick_is_do_not_send_email" />
                                                <label class="form-label ps-2 mb-0" for="pick_is_do_not_send_email"> Do not send any email updates.
                                                </label>
                                                <span class="text-danger error-text pick_is_do_not_send_email_error ms-2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show active" id="pills-delivery" role="tabpanel" aria-labelledby="pills-delivery-tab">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label" for="delivery_end_customer">End Customer / Job Name (Copy Bill To)(Copy Lot/Division)</label>
                                                <input type="text" class="form-control" id="delivery_end_customer" placeholder="Enter End Customer / Job Name" name="delivery_end_customer" aria-label="End Customer / Job Name" />
                                                <span class="text-danger error-text delivery_end_customer_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label" for="delivery_attn">Attn</label>
                                                <input type="text" class="form-control" id="delivery_attn" placeholder="Enter Attn" name="delivery_attn" aria-label="Attn" />
                                                <span class="text-danger error-text delivery_attn_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="delivery_ship_to">Ship To</label>
                                                <input type="text" class="form-control" id="delivery_ship_to" placeholder="Enter Ship To" name="delivery_ship_to" aria-label="Ship To" />
                                                <span class="text-danger error-text statement_end_day_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label" for="delivery_ship_to_name">ShipTo Name</label>
                                                <input type="text" class="form-control" id="delivery_ship_to_name" placeholder="Enter Ship To Name" name="delivery_ship_to_name" aria-label="ShipTo Name" />
                                                <span class="text-danger error-text delivery_ship_to_name_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="delivery_address">Address</label>
                                                <input type="text" class="form-control" id="delivery_address" placeholder="Enter Address" name="delivery_address" aria-label="Address" />
                                                <span class="text-danger error-text delivery_address_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_suite">Suite / Unit#</label>
                                                <input type="text" class="form-control" id="delivery_suite" placeholder="Enter Suite / Unit" name="delivery_suite" aria-label="Suite / Unit" />
                                                <span class="text-danger error-text delivery_suite_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_city">City</label>
                                                <input type="text" class="form-control" id="delivery_city" placeholder="Enter City" name="delivery_city" aria-label="City" />
                                                <span class="text-danger error-text delivery_city_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_state">State</label>
                                                <input type="text" class="form-control" id="delivery_state" placeholder="Enter State" name="delivery_state" aria-label="State" />
                                                <span class="text-danger error-text delivery_state_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_zip">Zip <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <input type="text" class="form-control" id="delivery_zip" placeholder="Enter Zip" name="delivery_zip" aria-label="Zip" />
                                                <span class="text-danger error-text delivery_zip_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_county_id">County</label>
                                                <select id="delivery_county_id" name="delivery_county_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                </select>
                                                <span class="text-danger error-text delivery_county_id_error"></span>
                                            </div>
                                            <div class="col-4">
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

                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_phone">Phone</label>
                                                <input type="text" class="form-control" id="delivery_phone" placeholder="Enter Phone" name="delivery_phone" aria-label="Phone" />
                                                <span class="text-danger error-text delivery_phone_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_fax">Fax</label>
                                                <input type="text" class="form-control" id="delivery_fax" placeholder="Enter Fax" name="delivery_fax" aria-label="Fax" />
                                                <span class="text-danger error-text delivery_fax_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_mobile">Mobile</label>
                                                <input type="text" class="form-control" id="delivery_mobile" placeholder="Enter Mobile" name="delivery_mobile" aria-label="Mobile" />
                                                <span class="text-danger error-text delivery_mobile_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_lot">Lot</label>
                                                <input type="text" class="form-control" id="delivery_lot" placeholder="Enter Lot" name="delivery_lot" aria-label="Lot" />
                                                <span class="text-danger error-text delivery_lot_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_sub_division">Subdivision</label>
                                                <input type="text" class="form-control" id="delivery_sub_division" placeholder="Enter Subdivision" name="delivery_sub_division" aria-label="Subdivision" />
                                                <span class="text-danger error-text delivery_sub_division_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="delivery_email">Email</label>
                                                <input type="text" class="form-control" id="delivery_email" placeholder="Enter Email" name="delivery_email" aria-label="Email" />
                                                <span class="text-danger error-text delivery_email_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label" for="delivery_how_did_hear_about_us_id">How did you hear about us? <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <select id="delivery_how_did_hear_about_us_id" name="delivery_how_did_hear_about_us_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['aboutUsOptions'] as $id => $how_did_you_hear_option)
                                                    <option value="{{ $id }}">{{ $how_did_you_hear_option}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text delivery_how_did_hear_about_us_id_error"></span>
                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <input class="form-check-input" type="checkbox" value="1" id="delivery_is_do_not_send_email" name="delivery_is_do_not_send_email" />
                                                <label class="form-label ps-2 mb-0" for="delivery_is_do_not_send_email"> Do not send any email updates.
                                                </label>
                                                <span class="text-danger error-text delivery_is_do_not_send_email_error ms-2"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /Contact Card -->
                        <!-- Remit to address Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Associates:</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="row">
                                    <div class="mb-3 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="fabricator_id">Fabricator</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly id="fabricator_id" name="fabricator_id" aria-label="Statement End Day" />
                                                <span class="input-group-text bg-primary">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button class="btn btn-label-danger button ms-2 btn-sm"><i class="fi fi-rr-cross  fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text fabricator_id_error"></span>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="designer_id">Designer</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly id="designer_id" name="designer_id" aria-label="Statement End Day" />
                                                <span class="input-group-text bg-primary">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button class="btn btn-label-danger button ms-2 btn-sm"><i class="fi fi-rr-cross  fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text designer_id_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="builder_id">Builder</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly id="builder_id" name="builder_id" aria-label="Statement End Day" />
                                                <span class="input-group-text bg-primary">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button class="btn btn-label-danger button ms-2 btn-sm"><i class="fi fi-rr-cross  fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text internal_notes_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" class="form-control" id="status" name="status" value="1" aria-label="status" />
                                </div>
                            </div>
                        </div>
                        <!-- /remit to address Card -->
                        <!-- /Organize Card -->
                    </div>
                    <!-- /Second column -->
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary btn-md" id="savedata" name="savedata">Save New Account</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton" name="cancelButton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade">
        </div>
    </form>
    @include('opportunity.create.__model')
</div>
@endsection
@section('scripts')
@include('opportunity.create.__script')
@include('opportunity.__script')
@endsection