@extends('layouts.admin')

@section('title', 'Associate')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Associate / </span>Update</h4>
    <form id="associateForm" name="associateForm" class="form-horizontal">
        <input type="hidden" name="associate_id" id="associate_id" value="{{$associate->id}}">
                <div class="row">
                  <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="ecommerce-product-sku">Associate Name</label>
                            <input
                              type="text"
                              class="form-control"
                              id="associate_name"
                              placeholder="Associate Name"
                              name="associate_name"
                              aria-label="Associate Name" value="{{$associate->associate_name}}" />
                              <span class="text-danger error-text associate_name_error"></span>
                          </div>

                          <div class="col">
                            <label class="form-label" for="ecommerce-product-barcode">Associate ID / Code
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="associate_code"
                              placeholder="Associate ID / Code"
                              name="associate_code"
                              aria-label="Associate ID / Code" value="{{$associate->associate_code}}" />
                              <span class="text-danger error-text associate_code_error"></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Associate Type">Associate Type
                            </label>
                            <select class="form-select select2" name="associate_type_id" id="associate_type_id" data-allow-clear="true">
                                <option value="">--Select Associate Type--</option>
                                @foreach($associate_type as $type)
                                    <option value="{{ $type->id }}"
                                        @if($type->id == old('associate_type_id', $associate->associate_type_id))
                                            selected
                                        @endif>
                                        {{ $type->customer_type_name }}
                                    </option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="ecommerce-product-barcode">Contact Name
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="contact_name"
                              placeholder="Contact Name"
                              name="contact_name"
                              aria-label="Contact Name" value="{{$associate->contact_name}}"/>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Referred By">Referred By
                            </label>
                            <select class="form-select select2" name="referred_by_id" id="referred_by_id" data-allow-clear="true">
                                <option value="">--Select Referred By--</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Location">Location</label>
                            <select class="form-select select2" name="location_id" id="location_id" data-allow-clear="true">
                            <option value="">--Select Location--</option>
                            @foreach($company as $cmp)
                                <option value="{{ $cmp->id }}"
                                    @if($cmp->id == old('location_id', $associate->location_id))
                                        selected
                                    @endif>
                                    {{ $cmp->company_name }}
                                </option>
                            @endforeach
                        </select>

                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="Route">Route
                            </label>
                            <select class="form-select select2" name="route_id" id="route_id" data-allow-clear="true">
                            <option value="">--Select Route--</option>
                            @foreach($county as $cnt)
                                <option value="{{ $cnt->id }}"
                                    @if($cnt->id == old('route_id', $associate->route_id))
                                        selected
                                    @endif>
                                    {{ $cnt->county_name }}
                                </option>
                            @endforeach
                        </select>

                          </div>
                          <div class="col">
                            <label class="form-label" for="Primary Sales Person">Primary Sales Person
                            </label>
                            <select class="form-select select2" name="primary_sales_id" id="primary_sales_id" data-allow-clear="true">
                            <option value="">--Select Primary Sales Person--</option>
                            @foreach($primary_sale as $sale)
                                <option value="{{ $sale->id }}"
                                    @if($sale->id == old('primary_sales_id', $associate->primary_sales_id))
                                        selected
                                    @endif>
                                    {{ $sale->name }}
                                </option>
                            @endforeach
                        </select>


                          </div>
                          <div class="col">
                            <label class="form-label" for="Sec. SalesRep">Sec. SalesRep</label>
                            <select class="form-select select2" name="secondary_sales_id" id="secondary_sales_id" data-allow-clear="true">
                            <option value="">--Select Sec. SalesRep--</option>
                            @foreach($secondary_sale as $sales)
                                <option value="{{ $sales->id }}"
                                    @if($sales->id == old('secondary_sales_id', $associate->secondary_sales_id))
                                        selected
                                    @endif>
                                    {{ $sales->name }}
                                </option>
                            @endforeach
                        </select>

                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="Internal Notes">Internal Notes
                            </label>
                            <textarea
                              class="form-control"
                              id="internal_notes"
                              placeholder="Internal Notes"
                              name="internal_notes"
                              aria-label="Internal Notes" >{{$associate->internal_notes}}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">Contact Information</h5>
                      </div>
                      <div class="card-body">
                        <div class="row mb-3">                        
                          <div class="col">
                            <label class="form-label" for="Primary Phone">Primary Phone</label>
                            <input
                              type="text"
                              class="form-control"
                              id="primary_phone"
                              placeholder="Primary Phone"
                              name="primary_phone"
                              aria-label="Primary Phone" value="{{$associate->primary_phone}}"/>
                              <span class="text-danger error-text primary_phone_error" ></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Secondary Phone">Secondary Phone</label>
                            <input
                              type="text"
                              class="form-control"
                              id="secondary_phone"
                              placeholder="Secondary Phone"
                              name="secondary_phone"
                              aria-label="Secondary Phone" value="{{$associate->secondary_phone}}"/>
                              <span class="text-danger error-text secondary_phone_error" ></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Mobile">Mobile
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="mobile"
                              placeholder="Mobile"
                              name="mobile"
                              aria-label="Mobile" value="{{$associate->mobile}}"/>
                              <span class="text-danger error-text mobile_error" ></span>
                          </div>
                        </div>
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Fax">Fax
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="fax"
                              placeholder="Fax"
                              name="fax"
                              aria-label="Fax" value="{{$associate->fax}}"/>
                          </div>
                    
                          <div class="col">
                            <label class="form-label" for="Accounting Email">Email Address
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="email"
                              placeholder="Email"
                              name="email"
                              aria-label="Email" value="{{$associate->email}}"/>
                              <span class="text-danger error-text email_error"></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Accounting Email">Accounting Email
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="accounting_email"
                              placeholder="Accounting Email"
                              name="accounting_email"
                              aria-label="Accounting Email" value="{{$associate->accounting_email}}"/>
                              <span class="text-danger error-text accounting_email_error"></span>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="Website">Website
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="website"
                              placeholder="Website"
                              name="website"
                              aria-label="Website" value="{{$associate->website}}"/>
                              <span class="text-danger error-text website_error"></span>
                          </div>
                          </div>
                          <div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-title mb-0">Address</h5>
                      </div>
                      <div class="card-body">
                        <div class="mb-3">
                          <label class="form-label" for="Address">Address</label>
                          <input
                            type="text"
                            class="form-control"
                            id="address"
                            placeholder="Address"
                            name="address"
                            aria-label="Address" value="{{$associate->address}}"/>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Suite / Unit#">Suite / Unit#</label>
                          <input
                            type="text"
                            class="form-control"
                            id="suite"
                            placeholder="Suite / Unit#"
                            name="suite"
                            aria-label="Suite / Unit#" value="{{$associate->suite}}" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="City">City</label>
                          <input
                            type="text"
                            class="form-control"
                            id="city"
                            placeholder="City"
                            name="city"
                            aria-label="City" value="{{$associate->city}}" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="State">State</label>
                          <input
                            type="text"
                            class="form-control"
                            id="state"
                            placeholder="State"
                            name="state"
                            aria-label="State" value="{{$associate->state}}"/>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Zip">Zip</label>
                          <input
                            type="text"
                            class="form-control"
                            id="zip"
                            placeholder="Zip"
                            name="zip"
                            aria-label="Zip" value="{{$associate->zip}}"/>
                            <span class="text-danger error-text zip_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Country">Country</label>
                          <select class="form-select select2" name="country_id" id="country_id" data-allow-clear="true">
                            <option value="">--Select Country--</option>
                            @foreach($country as $cntry)
                                <option value="{{ $cntry->id }}"
                                    @if($cntry->id == old('country_id', $associate->country_id))
                                        selected
                                    @endif>
                                    {{ $cntry->country_name }}
                                </option>
                            @endforeach
                        </select>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group text-center">
              <button type="submit" class="btn btn-primary" id="savedata" value="create">Update Associate</button>
            </div>
       </div>
  </form>
  </div>
</div>
@endsection
@section('scripts')
@include('associate.__scripts')
@endsection
