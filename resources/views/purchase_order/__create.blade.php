@extends('layouts.admin')

@section('title', 'Purchase Order')
@section('styles')
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/editor.css')}}" />
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Purchase Order / </span>Create</h4>
        <form id="purchaseOrderForm" name="purchaseOrderForm" class="form-horizontal" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="P.O.#">P.O.#:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <input type="text" class="form-control" id="po_number" placeholder="P.O.#"
+                                        name="po_number" aria-label="P.O.#" value="{{$newPo}}"  readonly />
                                    <span class="text-danger error-text po_number_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="P.O.Date">P.O.Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <input type="date" class="form-control" id="po_date" placeholder="P.O. Date"
                                        name="po_date" aria-label="P.O.Date" value="{{ now()->format('Y-m-d') }}" />
                                    <span class="text-danger error-text po_date_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Supplier SO#">Supplier SO#:
                                    </label>
                                    <input type="text" class="form-control" id="supplier_so_number"
                                        placeholder="Supplier SO#" name="supplier_so_number" aria-label="Supplier SO#" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Required Ship Date">Required Ship Date:
                                    </label>
                                    <input type="date" class="form-control" id="po_date"
                                        placeholder="Required Ship Date" name="po_date"
                                        aria-label="Required Ship Date" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Referred By">ETA Date:
                                    </label>
                                    <input type="date" class="form-control" id="eta_date" placeholder="ETA Date"
                                        name="eta_date" aria-label="Required Ship Date" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="P.O Expiry Date">P.O Expiry Date:
                                    </label>
                                    <input type="date" class="form-control" id="po_expiry_date"
                                        placeholder="P.O Expiry Date" name="po_expiry_date"
                                        aria-label="P.O Expiry Date" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Container#">Container#:
                                    </label>
                                    <input type="text" class="form-control" id="container_number"
                                        placeholder="Container#" name="container_number" aria-label="Container#" />
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="Shipment Terms">Shipment Terms:
                                    </label>
                                    <select class="form-select select2" name="shipment_term_id" id="shipment_term_id"
                                        data-allow-clear="true">
                                        <option value="">--Select Shipment Terms--</option>
                                        @foreach($shipment_terms as $ship)
                                        <option value="{{ $ship->id }}">{{ $ship->shipment_term_name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">
                                Supplier</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Supplier">Supplier:<sup
                                            style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <select class="form-select select2" name="supplier_id" id="supplier_id"
                                        data-allow-clear="true">
                                        <option value="">--Select Supplier--</option>
                                        @foreach($supplier as $supply)
                                        <option value="{{ $supply->id }}">{{ $supply->supplier_name  }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text supplier_id_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Weight">Select Address:
                                    </label>
                                    <select class="form-select select2" name="supplier_address_id"
                                        id="supplier_address_id" data-allow-clear="true">
                                        <option value="">--Select Supplier--</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Address">Address:
                                    </label>
                                    <input type="text" class="form-control" readonly id="supplier_address" placeholder="Address"
                                        name="supplier_address" aria-label="Address" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Suite / Unit#">Suite / Unit#: </label>
                                    <input type="text" class="form-control" readonly id="supplier_suite"
                                        placeholder="Suite / Unit#" name="supplier_suite" aria-label="Suite / Unit#" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="City">City:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly id="supplier_city" placeholder="City"
                                            name="supplier_city" aria-label="City" />
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="State"> State:
                                    </label>
                                    <input type="text" class="form-control" readonly id="supplier_state" placeholder="State"
                                        name="supplier_state" aria-label="State" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Zip">Zip:</label>
                                    <input type="text" class="form-control" readonly id="supplier_zip" placeholder="Zip" name="supplier_zip"
                                        aria-label="Zip" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Country">Country:
                                    </label>
                                    <select class="form-select select2" readonly name="supplier_country_id" id="supplier_country_id"
                                        data-allow-clear="true">
                                        <option value="">--Select Country--</option>
                                        @foreach($country as $cntry)
                                        <option value="{{ $cntry->id }}">{{ $cntry->country_name  }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col">
                                    <label class="form-label" for="Payment Terms">Payment Terms:<sup
                                            style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                    </label>
                                    <select class="form-select select2" name="payment_term_id" id="payment_term_id"
                                        data-allow-clear="true">
                                        <option value="">--Select Payment Terms--</option>
                                        @foreach($payment_terms as $terms)
                                        <option value="{{ $terms->id }}">{{ $terms->payment_label  }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text payment_term_id_error"></span>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">
                                Purchase Location
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Location">Location: <sup
                                            style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <select class="form-select select2" name="purchase_location_id"
                                        id="purchase_location_id" data-allow-clear="true">
                                        <option value="">--Select Location --</option>
                                        @foreach($consignment_location as $loc)
                                        <option value="{{ $loc->customer->id }}">{{ $loc->customer->customer_name  }}</option>
                                        @endforeach

                                    </select>
                                    <span class="text-danger error-text purchase_location_id_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Address">Address:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="purchase_location_address"
                                            placeholder="Address" name="purchase_location_address"
                                            aria-label="Address" />
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Size">Suite / Unit#:

                                    </label>
                                    <input type="text" class="form-control" id="purchase_location_suite"
                                        placeholder="Suite / Unit#" name="purchase_location_suite"
                                        aria-label="Suite / Unit#" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="City">City:</label>
                                    <input type="text" class="form-control" id="purchase_location_city"
                                        placeholder="City" name="purchase_location_city" aria-label="City" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="State">State: </label>
                                    <input type="text" class="form-control" id="purchase_location_state"
                                        placeholder="State" name="purchase_location_state" aria-label="State" />

                                </div>
                                <div class="col">
                                    <label class="form-label" for="Zip">Zip:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="purchase_location_zip"
                                            placeholder="Zip" name="purchase_location_zip" aria-label="Zip" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Country">Country:

                                    </label>
                                    <select class="form-select select2" name="purchase_location_country_id"
                                        id="purchase_location_country_id" data-allow-clear="true">
                                        <option value="">--Select Country --</option>
                                        @foreach($country as $cntry)
                                        <option value="{{ $cntry->id }}">{{ $cntry->country_name  }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">
                                Ship To Location
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Ship To Location">Ship To Location:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <select class="form-select select2" name="ship_to_location_id"
                                        id="ship_to_location_id" data-allow-clear="true">
                                        <option value="">--Select Ship To Location--</option>
                                        @foreach($consignment_location as $loc)
                                        <option value="{{ $loc->customer->id }}">{{ $loc->customer->customer_name  }}</option>
                                        @endforeach

                                    </select>
                                    <span class="text-danger error-text ship_to_location_id_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Weight">Attn:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ship_to_location_attn"
                                            placeholder="Attn" name="ship_to_location_attn" aria-label="Attn" />
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Address">Address:

                                    </label>
                                    <input type="text" class="form-control" id="ship_to_location_address"
                                        placeholder="Address" name="ship_to_location_address" aria-label="Address" />
                                </div>


                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Size">Suite / Unit#: 

                                    </label>
                                    <input type="text" class="form-control" id="ship_to_location_suite"
                                        placeholder="Suite / Unit#" name="ship_to_location_suite"
                                        aria-label="Suite / Unit#" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="City">City: </label>
                                    <input type="text" class="form-control" id="ship_to_location_city"
                                        placeholder="City" name="ship_to_location_city" aria-label="Size" />

                                </div>
                                <div class="col">
                                    <label class="form-label" for="State">State:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ship_to_location_state"
                                            placeholder="State" name="ship_to_location_state" aria-label="State" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">



                                <div class="col-4">
                                    <label class="form-label" for="Zip">Zip:

                                    </label>
                                    <input type="text" class="form-control" id="ship_to_location_zip" placeholder="Zip"
                                        name="ship_to_location_zip" aria-label="Zip" />
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="Country">Country:
                                    </label>
                                    <select class="form-select select2" name="ship_to_location_country_id"
                                        id="ship_to_location_country_id" data-allow-clear="true">
                                        <option value="">--Select Location --</option>
                                        @foreach($country as $cntry)
                                        <option value="{{ $cntry->id }}">{{ $cntry->country_name  }}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">
                                P.O.Terms
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Units of Measure">P.O.Terms:
                                    </label>
                                    <select class="form-select select2" name="pre_purchase_term_id"
                                        id="pre_purchase_term_id" data-allow-clear="true">
                                        <option value="">--Select P.O.Terms--</option>
                                        @foreach($printdoc as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title  }}</option>
                                        @endforeach

                                    </select>

                                </div>
                                <div class="form-group mb-2 p-1">
                        <label for="description" class="col-sm-6 form-label pb-1">Description</label>
                        <div class="col-12">
                            <div id="descriptionEditor">&nbsp;</div>
                        </div>
                        <span class="text-danger error-text description_error"></span>
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="terms" name="terms" rows="2" style="resize:none;display:none" placeholder="Enter Description"></textarea>
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
                            <h5 class="card-tile mb-0">
                                Additional Info</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="Preferred Supplier">Freight Forwarder:</label>
                                <select class="form-select select2" name="freight_forwarder_id"
                                    id="freight_forwarder_id" data-allow-clear="true">
                                    <option value="">--Select Freight Forwarder--</option>
                                    @foreach($freight as $fr)
                                        <option value="{{ $fr->id }}">{{ $fr->expenditure_name  }}</option>
                                        @endforeach

                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="vessel">Vessel:</label>
                                <input type="text" class="form-control" id="vessel" placeholder="vessel" name="vessel"
                                    aria-label="vessel" />

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Air Bill#">Air Bill#:</label>
                                <input type="text" class="form-control" id="air_bill" placeholder="Air Bill#"
                                    name="air_bill" aria-label="Air Bill#" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Planned Ex Factory Date">Planned Ex Factory Date:

                                </label>
                                <input type="date" class="form-control" id="planned_ex_factory"
                                    placeholder="Planned Ex Factory Date" name="planned_ex_factory"
                                    aria-label="Planned Ex Factory Date" />

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Ex Factory DateT">Ex Factory Date:
                                </label>
                                <input type="date" class="form-control" id="ex_factory_date"
                                    placeholder="Ex Factory Date" name="ex_factory_date" aria-label="Ex Factory Date" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Departure Port">Departure Port:</label>
                                <select class="form-select select2" name="departure_port_id" id="departure_port_id"
                                    data-allow-clear="true">
                                    <option value="">--Select Departure Port--</option>
                                    @foreach($departure as $port)
                                        <option value="{{ $port->id }}">{{ $port->supplier_port_name  }}</option>
                                    @endforeach

                                </select>


                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="ETD Port">ETD Port:</label>
                                <input type="date" class="form-control" id="etd_port" placeholder="ETD Port"
                                    name="etd_port" aria-label="ETD Port" />

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Arrival Port">Arrival Port:</label>
                                <select class="form-select select2" name="arrival_port_id" id="arrival_port_id"
                                    data-allow-clear="true">
                                    <option value="">--Select Departure Port--</option>
                                    @foreach($arrival as $port)
                                        <option value="{{ $port->id }}">{{ $port->supplier_port_name  }}</option>
                                    @endforeach

                                </select>


                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="ETA Port">ETA Port:</label>
                                <input type="date" class="form-control" id="eta_port" placeholder="ETA Port"
                                    name="eta_port" aria-label="ETA Port" />

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Discharge Port">Discharge Port:</label>
                                <select class="form-select select2" name="discharge_port_id" id="discharge_port_id"
                                    data-allow-clear="true">
                                    <option value="">--Select Departure Port--</option>
                                    @foreach($discharge as $port)
                                        <option value="{{ $port->id }}">{{ $port->supplier_port_name  }}</option>
                                    @endforeach

                                </select>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Wiring Instructions">Wiring Instructions:</label>
                                <input type="text" class="form-control" id="wiring_instruction_id"
                                    placeholder="Wiring Instructions" name="wiring_instruction_id" aria-label="" />

                            </div>
                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-header">
                            <label class="form-label" for="Country">Notes
                            </label>
                        </div>
                        <div class="card-body">
                            <label class="form-label" for="Country">Printed Notes:
                            </label>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <textarea type="text" class="form-control" id="printed_notes"
                                        placeholder="Printed Notes" name="printed_notes" aria-label=""></textarea>

                                </div>

                            </div>
                            <label class="form-label" for="Country">Internal Notes:

                            </label>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <textarea type="text" class="form-control" id="internal_notes"
                                        placeholder="Internal Notes" name="internal_notes" aria-label=""></textarea>

                                </div>

                            </div>
                            <label class="form-label" for="Country">Special Instructions:
                            </label>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <select class="form-select select2" name="special_instruction_id"
                                        id="special_instruction_id" data-allow-clear="true">
                                        <option value="">--Select Special Instructions--</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="form-label" for="Country">&nbsp;
                                </label>
                                <div class="col-md-12">
                                    <textarea type="text" class="form-control" id="special_instructions" name="special_instructions"
                                        aria-label=""></textarea>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label class="form-label" for="Country">
                                    Exchange Rate: 1$ =:
                                    <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="conversion_rate"
                                        placeholder="Exchange Rate" name="conversion_rate" aria-label="" value="1" />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" id="savedata" value="create">Go To Next Step To Add
                        Products</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('public/assets/vendor/libs/quill/katex.js')}}"></script>
<script src="{{asset('public/assets/vendor/libs/quill/quill.js')}}"></script>
@include('purchase_order.__scripts')
@endsection