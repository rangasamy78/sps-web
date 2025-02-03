@extends('layouts.admin')

@section('title', 'Create Hold')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 text-dark"><span class="text-primary">Add Hold for Opportunity # {{$opportunity->opportunity_code}}</span> {{$customer->customer_name}}@ {{$company->company_name}}</h4>
        <div class="app-ecommerce">
            <form id="addNewHoldForm">
                <div class="row">
                    <div class="col-12">
                        <div class="card  mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <input type="hidden" class="form-control" id="hold_id" name="hold_id" value="">
                                        <input type="hidden" class="form-control" id="opportunity_id" name="opportunity_id" value="{{ $opportunity->id }}">
                                        <label class="form-label" for="hold_code">Hold# <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="text" class="form-control" id="hold_code" readonly name="hold_code" aria-label="date" value="{{$holdCount+1}}" />
                                        <span class="text-danger error-text hold_code_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="hold_date">Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="hold_date" name="hold_date" aria-label="date" value="{{$opportunity->opportunity_date}}" />
                                        <span class="text-danger error-text hold_date_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="hold_time">Time</label>
                                        <input type="time" class="form-control" id="hold_time" name="hold_time" aria-label="date" value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Kolkata')->format('h:i') }}" />
                                        <span class="text-danger error-text hold_time_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="expiry_date">Expiry Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="expiry_date" name="expiry_date" aria-label="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                        <span class="text-danger error-text expiry_date_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="customer_po">Customer P.O#</label>
                                        <input type="text" class="form-control" id="customer_po" name="customer_po" aria-label="date" />
                                        <span class="text-danger error-text customer_po_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="project_type_id">Project Type</label>
                                        <select id="project_type_id" name="project_type_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['projectTypes'] as $id => $project_type_name)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->project_type_id == $id ? 'selected' : '' }}>{{ $project_type_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text project_type_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="location_id">Location <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="location_id" name="location_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach ($data['companies'] as $company)
                                            <option value="{{ $company->id }}" {{ isset($opportunity) && $opportunity->location_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text location_id_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-8 col-md-12 pt-sm-2">
                                        <label class="form-label" for="pick_ticket_restriction">PickTicket Restriction</label>
                                        <div class="d-flex align-items-center flex-wrap gap-1 p-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pick_ticket_restriction" id="radio1" checked value="Exact Slab">
                                                <label class="form-check-label" for="radio1">Exact Slab</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pick_ticket_restriction" id="radio2" value="Within Lot">
                                                <label class="form-check-label" for="radio2">Within Lot</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pick_ticket_restriction" id="radio3" value="Within Product">
                                                <label class="form-check-label" for="radio3">Within Product</label>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text pick_ticket_restriction_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- First column-->
                    <div class="col-12 col-lg-6">
                        <!-- Account Information -->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Bill To</h5>
                                <button type="button" class="btn btn-border bg-primary btn-sm text-white ms-auto fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewCustomer">Add New</button>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <label class="form-label" for="billing_customer_id">Billing Customer <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="hidden" class="form-control bg-label-secondary" readonly id="billing_customer_id" name="billing_customer_id" value="{{$customer->id}}" />
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-label-secondary" readonly id="billing_customer_name" name="billing_customer_name" value="{{$customer->customer_name}}" aria-label="Biiling Customer" />
                                            <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                data-bs-target="#searchCustomer">
                                                <i class="fi fi-rr-search text-white"></i>
                                            </span>
                                        </div>
                                        <span class="text-danger error-text billing_customer_id_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_attn">Attn</label>
                                        <input type="text" class="form-control" id="bill_to_attn" name="bill_to_attn" aria-label="attn" value="{{$opportunity->attn}}" />
                                        <span class="text-danger error-text bill_to_attn_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_address">Address </label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="bill_to_address" name="bill_to_address" aria-label="attn" value="{{$customer->address}}" />
                                        <span class="text-danger error-text address_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_suite">Suite / Unit#</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="bill_to_suite" name="bill_to_suite" aria-label="suite / Unit#" value="{{$customer->address_2}}" />
                                        <span class="text-danger error-text suite_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_city">City</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="bill_to_city" name="bill_to_city" value="{{$customer->city}}" aria-label="bill_to_city" />
                                        <span class="text-danger error-text city_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_state">State</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="bill_to_state" name="bill_to_state" value="{{$customer->state}}" aria-label="bill_to_state" />
                                        <span class="text-danger error-text state_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_zip">Zip</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="bill_to_zip" name="bill_to_zip" value="{{$customer->zip}}" aria-label="bill_to_zip" />
                                        <span class="text-danger error-text zip_error"></span>
                                    </div>

                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_country">Country</label>
                                        <select id="bill_to_country" name="bill_to_country" class="select2 form-select" disabled data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['countries'] as $id => $country_name)
                                            <option value="{{ $id }}" {{ isset($customer) && $customer->country_id == $id ? 'selected' : '' }}>{{ $country_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text country_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_phone">Phone</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="bill_to_phone" name="bill_to_phone" value="{{$customer->phone}}" aria-label="bill_to_phone" />
                                        <span class="text-danger error-text phone_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_fax">Fax</label>
                                        <input type="text" class="form-control" id="bill_to_fax" name="bill_to_fax" value="{{$customer->fax}}" aria-label="bill_to_fax" />
                                        <span class="text-danger error-text bill_to_fax_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="bill_to_mobile">Mobile</label>
                                        <input type="text" class="form-control" id="bill_to_mobile" name="bill_to_mobile" value="{{$customer->mobile}}" aria-label="bill_to_mobile" />
                                        <span class="text-danger error-text bill_to_mobile_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label class="form-label" for="bill_to_email">Email</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="bill_to_email" name="bill_to_email" value="{{$customer->email}}" aria-label="bill_to_email" />
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="payment_term_id">Payment Terms</label>
                                        <select id="payment_term_id" name="payment_term_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['paymentTerms'] as $payment)
                                            <option value="{{ $payment->id }}">{{ $payment->payment_label }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text payment_term_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="price_level_label_id">Price Level <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="price_level_label_id" name="price_level_label_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['priceListLabels'] as $id => $label)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->price_level_label_id == $id ? 'selected' : '' }}>{{ $label}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text price_level_label_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="primary_sales_person_id">Primary Sales Person <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="primary_sales_person_id" name="primary_sales_person_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $name)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->primary_sales_person_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text primary_sales_person_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="secondary_sales_person_id">Secondary Sales Person</label>
                                        <select id="secondary_sales_person_id" name="secondary_sales_person_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $name)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->secondary_sales_person_id == $id ? 'selected' : '' }}>{{ $name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text secondary_sales_person_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="sales_tax_id">Sales Tax <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="sales_tax_id" name="sales_tax_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['salesTaxs'] as $id => $tax_name)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->sales_tax_id == $id ? 'selected' : '' }}>{{ $tax_name}}</option>
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
                                                <label class="form-label mb-1" for="instructions">Instructions</label>
                                                <textarea id="instructions" name="instructions" class="form-control" rows="3" placeholder="Enter Special / Delivery Instruction" style="resize:none">{{$opportunity->special_instructions}}</textarea>
                                                <span class="text-danger error-text instructions_error"></span>
                                            </div>

                                            <div class="mb-3 col-12">
                                                <label class="form-label mb-1" for="internal_notes">Internal Notes</label>
                                                <textarea id="internal_notes" name="internal_notes" class="form-control" rows="3" placeholder="Enter Internal Notes" style="resize:none">{{$opportunity->internal_notes}}</textarea>
                                                <span class="text-danger error-text internal_notes_error"></span>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label mb-1" for="printed_notes">Printed Notes</label>
                                                <textarea id="printed_notes" name="printed_notes" class="form-control" rows="3" placeholder="Enter Printed Notes" style="resize:none">{{$opportunity->printed_notes}}</textarea>
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
                    <div class="col-12 col-lg-6">
                        <!-- Contact Information Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Job Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label class="form-label" for="hold_label">Hold Label</label>
                                        <input type="text" class="form-control" id="hold_label" name="hold_label" placeholder="Enter Hold Label" />
                                        <span class="text-danger error-text hold_label_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <label class="form-label" for="job_name">
                                            End Customer / Job Name
                                            <button type="button" id="copy_bill_to" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Bill To)</button>
                                        </label>
                                        <input type="text" class="form-control" id="job_name" name="job_name" vlaue="{{$opportunity->ship_to_job_name}}" placeholder="Enter End Customer / Job Name" />
                                        <span class="text-danger error-text job_name_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="attn">Attn</label>
                                        <input type="text" class="form-control" id="attn" name="attn" placeholder="Enter Attn" value="{{$opportunity->ship_to_attn}}" />
                                        <span class="text-danger error-text attn_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address" aria-label="Address" value="{{$opportunity->ship_to_address}}" />
                                        <span class="text-danger error-text address_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="suite">Suite / Unit#</label>
                                        <input type="text" class="form-control" id="suite" placeholder="Enter Suite / Unit" name="suite" value="{{$opportunity->ship_to_suite}}" aria-label="Suite / Unit" />
                                        <span class="text-danger error-text suite_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <label class="form-label" for="city">City</label>
                                        <input type="text" class="form-control" id="city" placeholder="Enter City" name="city" value="{{$opportunity->ship_to_city}}" aria-label="City" />
                                        <span class="text-danger error-text ship_to_city_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="state">State</label>
                                        <input type="text" class="form-control" id="state" placeholder="Enter State" name="state" value="{{$opportunity->ship_to_state}}" aria-label="State" />
                                        <span class="text-danger error-text ship_to_state_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="zip">Zip </label>
                                        <input type="text" class="form-control" id="zip" placeholder="Enter Zip" name="zip" value="{{$opportunity->ship_to_zip}}" aria-label="Zip" />
                                        <span class="text-danger error-text ship_to_zip_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <label class="form-label" for="country_id">Country</label>
                                        <select id="country_id" name="country_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['countries'] as $id => $country_name)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->ship_to_country_id == $id ? 'selected' : '' }}>{{ $country_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text ship_to_country_id_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="{{$opportunity->ship_to_phone}}" />
                                        <span class="text-danger error-text ship_to_phone_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="fax">Fax</label>
                                        <input type="text" class="form-control" id="fax" placeholder="Enter Fax" name="fax" value="{{$opportunity->ship_to_fax}}" aria-label="ship_to_Fax" />
                                        <span class="text-danger error-text ship_to_fax_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <label class="form-label" for="mobile">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile" name="mobile" value="{{$opportunity->ship_to_mobile}}" aria-label="Mobile" />
                                        <span class="text-danger error-text ship_to_mobile_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" value="{{$opportunity->ship_to_email}}" aria-label="Email" />
                                        <span class="text-danger error-text ship_to_email_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="delivery_type">Delivery Type </label>
                                        <select id="delivery_type" name="delivery_type" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            <option value="Pick Up" {{ isset($opportunity) && $opportunity->ship_to_type == 'Pick Up' ? 'selected' : '' }}>Pick Up</option>
                                            <option value="Delivery" {{ isset($opportunity) && $opportunity->ship_to_type == 'Delivery' ? 'selected' : '' }}>Delivery</option>
                                        </select>
                                        <span class="text-danger error-text delivery_type_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <label class="form-label" for="how_did_hear_about_us_id">How did you hear about us? <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="how_did_hear_about_us_id" name="how_did_hear_about_us_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['aboutUsOptions'] as $id => $how_did_you_hear_option)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->how_did_hear_about_us_id == $id ? 'selected' : '' }}>{{ $how_did_you_hear_option}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text how_did_hear_about_us_id_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Remit to address Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Associates:</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="row">
                                    <div class="mb-2 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="fabricator_id">Fabricator</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly name="fabricator_name" id="fabricator_name" value="{{$fabricator->associate_name??''}}" />
                                                <input type="hidden" id="fabricator_id" name="fabricator_id" value="{{$fabricator->id??null}}" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                    data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearFabricator" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="fabricator"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text fabricator_id_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="designer_id">Designer</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly id="designer_name" name="designer_name" value="{{$designer->associate_name??''}}" />
                                                <input type="hidden" id="designer_id" name="designer_id" value="{{$designer->id??null}}" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                    data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearDesigner" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="designer"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text designer_id_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="general_contractor_id">General Contractor</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly name="general_contractor_name" id="general_contractor_name" />
                                                <input type="hidden" id="general_contractor_id" name="general_contractor_id" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal" data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearGeneralContractor" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="general_contractor"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text general_contractor_id_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="builder_id">Builder</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly name="builder_name" id="builder_name" value="{{$builder->associate_name??''}}" />
                                                <input type="hidden" id="builder_id" name="builder_id" value="{{$builder->id??null}}" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal" data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearBuilder" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="builder"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text builder_id_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="brand_id">Brand</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly name="brand_name" id="brand_name" />
                                                <input type="hidden" id="brand_id" name="brand_id" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                    data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearBrand" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="brand"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text brand_id_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="referred_by_id">Referred By</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly name="referred_by_name" id="referred_by_name" />
                                                <input type="hidden" id="referred_by_id" name="referred_by_id" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal" data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearReferredBy" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="referred_by"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text referred_by_id_error"></span>
                                    </div>
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
                        <button type="submit" class="btn btn-primary btn-md" id="nextStepAddProductBtn" name="nextStepAddProductBtn">Go To Next Step To Add Products</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton" name="cancelButton">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
    @include('hold.create.__model')
</div>

@endsection
@section('scripts')
@include('hold.create.__script')
@endsection