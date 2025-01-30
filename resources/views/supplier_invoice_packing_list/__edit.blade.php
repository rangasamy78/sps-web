@extends('layouts.admin')

@section('title', 'Supplier Invoice')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light"> </span>Edit Supplier Invoice </h4>
        <form id="supplierInvoicePackingForm" name="supplierInvoicePackingForm" class="form-horizontal" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="SIPL/Bill#">SIPL/Bill#:
                                        <sup style="color:red; font-size: 0.9rem;"></label>
                                        

                                        <input type="hidden" name="supplier_invoice_id" id="supplier_invoice_id" value="{{$supplier_invoice->id}}">
                                    <input type="text" class="form-control" id="sipl_bill" value="{{$supplier_invoice->sipl_bill}}"  readonly 
                                        name="sipl_bill" aria-label="SIPL/Bill#" />
                                    
                                </div>
                                <div class="col">
                                    <label class="form-label" for="P.O. Date">Entry Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <input type="date" class="form-control" id="entry_date" placeholder="Entry Date"
                                        name="entry_date" aria-label="Entry Date"
                                        value="{{$supplier_invoice->entry_date}}" />
                                        
                                    <span class="text-danger error-text entry_date_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Invoice#">Invoice#:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                    </label>
                                    <input type="text" class="form-control" id="invoice" placeholder="Invoice#"
                                        name="invoice" aria-label="Invoice#"  value="{{$supplier_invoice->invoice}}"/>
                                    <span class="text-danger error-text invoice_error"></span>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Supplier SO#">Supplier SO#:
                                    </label>
                                    <input type="text" class="form-control" id="supplier_so" placeholder="Supplier SO#"
                                        name="supplier_so" aria-label="Supplier SO#" value="{{$supplier_invoice->supplier_so}}" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Ship(B/L) Date">Ship(B/L) Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                    </label>
                                    <input type="date" class="form-control" id="ship_date" placeholder="Ship(B/L) Date"
                                        name="ship_date" aria-label="Ship(B/L) Date"  value="{{$supplier_invoice->ship_date}}" />
                                    <span class="text-danger error-text ship_date_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Base Colors">Invoice Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong> :
                                    </label>
                                    <input type="date" class="form-control" id="invoice_date" placeholder="Invoice Date"
                                        name="invoice_date" aria-label="Invoice Date"  value="{{$supplier_invoice->invoice_date}}"/>
                                    <span class="text-danger error-text invoice_date_error"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Payment Terms">Payment Terms:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                    </label>
                                    <select class="form-select select2" name="payment_term_id" id="payment_term_id"
                                        data-allow-clear="true">
                                        <option value="">--Select Payment Terms--</option>
                                        @foreach($shipment_terms as $ship)
                                        <option value="{{ $ship->id }}" 
                                            {{ $supplier_invoice->shipment_term_id == $ship->id ? 'selected' : '' }}>
                                            {{ $ship->shipment_term_name }}
                                        </option>
                                    @endforeach
                                    </select>
                                    <span class="text-danger error-text payment_term_id_error"></span>
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="Due Date">Due Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                    </label>
                                    <input type="date" class="form-control" id="due_date"  value="{{$supplier_invoice->due_date}}" placeholder="Due Date"
                                        name="due_date" aria-label="Due Date" />
                                    <span class="text-danger error-text due_date_error"></span>
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="ETA Date">ETA Date:
                                    </label>
                                    <input type="date" class="form-control" id="eta_date" value="{{$supplier_invoice->eta_date}}" placeholder="ETA Date"
                                        name="eta_date" aria-label="ETA Date" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Container#">Container#:
                                    </label>
                                    <input type="text" class="form-control" id="container_number"
                                        placeholder="Container#" name="container_number" value="{{$supplier_invoice->container_number}}" aria-label="Container#" />
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="Shipment Terms">Delivery Method:
                                    </label>
                                    <select class="form-select select2" name="delivery_method" id="delivery_method" data-allow-clear="true">
                                        <option value="" {{ $supplier_invoice->delivery_method == '' ? 'selected' : '' }}>--Select Shipment Terms--</option>
                                        <option value="pickup" {{ $supplier_invoice->delivery_method == 'pickup' ? 'selected' : '' }}>Pickup</option>
                                        <option value="delivery" {{ $supplier_invoice->delivery_method == 'delivery' ? 'selected' : '' }}>Delivery</option>
                                        <option value="other" {{ $supplier_invoice->delivery_method == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>

                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="Shipment Terms">Shipment Terms:
                                    </label>
                                    <select class="form-select select2" name="shipment_term_id" id="shipment_term_id"
                                        data-allow-clear="true">
                                        <option value="">--Select Shipment Terms--</option>
                                        @foreach($shipment_terms as $ship)
                                        <option value="{{ $ship->id }}" 
                                            {{ $supplier_invoice->shipment_term_id == $ship->id ? 'selected' : '' }}>
                                            {{ $ship->shipment_term_name }}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Shipment Terms">Payment Hold:
                                    </label>
                                    <input 
                                        type="checkbox" 
                                        id="payment_hold" 
                                        name="payment_hold" 
                                        aria-label="Payment Hold" 
                                        value="on"  
                                        {{ $supplier_invoice->payment_hold === 'on' ? 'checked' : '' }}
                                    />
                                </div>

                                <div class="col-4">
                                    <label class="form-label" for="Shipment Terms">Payment Hold Reason:
                                    </label>
                                    <input type="text" class="form-control" id="payment_hold_reason"
                                        placeholder="Payment Hold Reason" value="{{$supplier_invoice->payment_hold_reason}}" name="payment_hold_reason"
                                        aria-label=">Payment Hold Reason" />
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
                                    <label class="form-label" for="Units of Measure">Supplier <sup
                                            style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <select class="form-select select2" name="supplier_id" id="supplier_id"
                                        data-allow-clear="true">
                                        <option value="">--Select Supplier--</option>
                                        @foreach($supplier as $supply)
                                                <option value="{{ $supply->id }}" 
                                                    {{ $supplier_invoice->supplier_id == $supply->id ? 'selected' : '' }}>
                                                    {{ $supply->supplier_name }}
                                                </option>
                                            @endforeach

                                    </select>
                                    <span class="text-danger error-text supplier_id_error"></span>
                                </div>

                                <div class="col">
                                    <label class="form-label" for="Address">Address:
                                    </label>
                                    <input type="text" class="form-control" value="{{$supplier_invoice->supplier_address}}" id="supplier_address" placeholder="Address"
                                        name="supplier_address" aria-label="Address" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Suite / Unit#">Suite / Unit#: </label>
                                    <input type="text" class="form-control" id="supplier_suite"
                                        placeholder="Suite / Unit#" name="supplier_suite"  value="{{$supplier_invoice->supplier_suite}}"  aria-label="Suite / Unit#" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="City">City:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="supplier_city"  value="{{$supplier_invoice->supplier_city}}"  placeholder="City"
                                            name="supplier_city" aria-label="City" /> 
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="State"> State:
                                    </label>
                                    <input type="text" class="form-control" id="supplier_state"  value="{{$supplier_invoice->supplier_state}}" placeholder="State"
                                        name="supplier_state" aria-label="State" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Zip">Zip:</label>
                                    <input type="text" class="form-control" id="supplier_zip"  value="{{$supplier_invoice->ship_to_location_zip}}" placeholder="Zip"
                                        name="supplier_zip" aria-label="Zip" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Country">Country:
                                    </label>
                                    <select class="form-select select2" name="supplier_country_id"
                                        id="supplier_country_id" data-allow-clear="true">
                                        @foreach($country as $cntry)
                                        <option value="{{ $cntry->id }}" 
                                            {{ $supplier_invoice->supplier_country_id == $cntry->id ? 'selected' : '' }}>
                                            {{ $cntry->country_name }}
                                        </option>
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
                                Purchase Location
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Location">Location <sup
                                            style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                            <select name="purchase_location_id" class="form-control">
                                            @foreach($consignment_location as $loc)
                                                <option value="{{ $loc->customer->id }}" 
                                                    {{ $supplier_invoice->purchase_location_id == $loc->customer->id ? 'selected' : '' }}>
                                                    {{ $loc->customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    <span class="text-danger error-text purchase_location_id_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Address">Address:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="purchase_location_address"
                                            placeholder="Address" value="{{$supplier_invoice->purchase_location_address}}" name="purchase_location_address"
                                            aria-label="Address" readonly/>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Size">Suite / Unit#:

                                    </label>
                                    <input type="text" class="form-control" id="purchase_location_suite"
                                        placeholder="Suite / Unit#" value="{{$supplier_invoice->purchase_location_suite}}" name="purchase_location_suite"
                                        aria-label="Suite / Unit#" readonly/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="City">City:

                                    </label>
                                    <input type="text" class="form-control" id="purchase_location_city"
                                        placeholder="City" name="purchase_location_city" readonly value="{{$supplier_invoice->purchase_location_city}}"  aria-label="City" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="State">State </label>
                                    <input type="text" class="form-control" id="purchase_location_state"
                                        placeholder="State" name="purchase_location_state" readonly value="{{$supplier_invoice->purchase_location_state}}"  aria-label="State" />

                                </div>
                                <div class="col">
                                    <label class="form-label" for="Zip">Zip:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="purchase_location_zip"
                                            placeholder="Zip" name="purchase_location_zip" readonly value="{{$supplier_invoice->purchase_location_zip}}" aria-label="Zip" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Country">Country:

                                    </label>
                                    <select class="form-select select2" name="purchase_location_country_id"
                                        id="purchase_location_country_id" data-allow-clear="true">
                                        <option value="">--Select Location --</option>
                                        @foreach($country as $cntry)
                                        <option value="{{ $cntry->id }}" 
                                            {{ $supplier_invoice->purchase_location_country_id == $cntry->id ? 'selected' : '' }}>
                                            {{ $cntry->country_name }}
                                        </option>
                                    @endforeach

                                    </select>
                                </div>
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
                                                <option value="{{ $loc->customer->id }}" 
                                                    {{ $supplier_invoice->ship_to_location_id == $loc->customer->id ? 'selected' : '' }}>
                                                    {{ $loc->customer->customer_name }}
                                                </option>
                                            @endforeach

                                    </select>
                                    <span class="text-danger error-text ship_to_location_id_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Weight">Attn:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ship_to_location_attn"
                                            placeholder="Attn" value="{{$supplier_invoice->ship_to_location_attn}}" name="ship_to_location_attn" aria-label="Attn" />
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Address">Address:

                                    </label>
                                    <input type="text" class="form-control" id="ship_to_location_address"
                                        placeholder="Address" value="{{$supplier_invoice->ship_to_location_address}}" name="ship_to_location_address" aria-label="Address" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Size">Suite / Unit#: :

                                    </label>
                                    <input type="text" class="form-control" id="ship_to_location_suite"
                                        placeholder="Suite / Unit#" value="{{$supplier_invoice->ship_to_location_suite}}" name="ship_to_location_suite"
                                        aria-label="Suite / Unit#" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="City">City </label>
                                    <input type="text" class="form-control" id="ship_to_location_city"
                                        placeholder="City" name="ship_to_location_city" value="{{$supplier_invoice->ship_to_location_city}}" aria-label="Size" />

                                </div>
                                <div class="col">
                                    <label class="form-label" for="State">State:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ship_to_location_state"
                                            placeholder="State" name="ship_to_location_state" value="{{$supplier_invoice->ship_to_location_state}}" aria-label="State" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Zip">Zip:
                                    </label>
                                    <input type="text" class="form-control" id="ship_to_location_zip" value="{{$supplier_invoice->ship_to_location_zip}}"  placeholder="Zip"
                                        name="ship_to_location_zip" aria-label="Zip" />
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="Country">Country:
                                    </label>
                                    <select class="form-select select2" name="ship_to_location_country_id"
                                        id="ship_to_location_country_id" data-allow-clear="true">
                                        <option value="">--Select Country --</option>
                                        @foreach($country as $cntry)
                                        <option value="{{ $cntry->id }}" 
                                            {{ $supplier_invoice->ship_to_location_country_id == $cntry->id ? 'selected' : '' }}>
                                            {{ $cntry->country_name }}
                                        </option>
                                    @endforeach
                                    </select>
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
                                        <option value="{{ $fr->id }}" {{ $supplier_invoice->freight_forwarder_id == $fr->id ? 'selected' : '' }}>
                                            {{ $fr->expenditure_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="vessel">Vessel</label>
                                <input type="text" class="form-control" id="vessel" value="{{$supplier_invoice->vessel}}" placeholder="vessel" name="vessel"
                                    aria-label="vessel" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Air Bill#">Air Bill#:</label>
                                <input type="text" class="form-control" id="air_bill" value="{{$supplier_invoice->air_bill}}" placeholder="Air Bill#"
                                    name="air_bill" aria-label="Air Bill#" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Planned Ex Factory Date">Planned Ex Factory Date:

                                </label>
                                <input type="date" class="form-control" id="planned_ex_factory"
                                    placeholder="Planned Ex Factory Date"  value="{{$supplier_invoice->planned_ex_factory}}" name="planned_ex_factory"
                                    aria-label="Planned Ex Factory Date" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Ex Factory DateT">Ex Factory Date:
                                </label>
                                <input type="date" class="form-control" id="ex_factory_date"
                                    placeholder="Ex Factory Date" name="ex_factory_date"  value="{{$supplier_invoice->ex_factory_date}}" aria-label="Ex Factory Date" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Departure Port">Departure Port:</label>
                                <select class="form-select select2" name="departure_port_id" value="{{$supplier_invoice->departure_port_id}}" id="departure_port_id"
                                    data-allow-clear="true">
                                    <option value="">--Select Departure Port--</option>
                          
                                    @foreach($departure as $port)
                                    <option value="{{ $port->id }}" {{ $supplier_invoice->departure_port_id == $port->id ? 'selected' : '' }}>
                                        {{ $port->supplier_port_name }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="ETD Port">ETD Port:</label>
                                <input type="date" class="form-control" id="etd_port"  value="{{$supplier_invoice->etd_port}}"  placeholder="ETD Port"
                                    name="etd_port" aria-label="ETD Port" />

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Arrival Port">Arrival Port:</label>
                                <select class="form-select select2" name="arrival_port_id" id="arrival_port_id"
                                    data-allow-clear="true">
                                    <option value="">--Select Departure Port--</option>
                                    @foreach($arrival as $port)
                                    <option value="{{ $port->id }}" {{ $supplier_invoice->arrival_port_id == $port->id ? 'selected' : '' }}>
                                        {{ $port->supplier_port_name }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="ETA Port">ETA Port:</label>
                                <input type="date" class="form-control" id="eta_port"  value="{{$supplier_invoice->eta_port}}"  placeholder="ETA Port"
                                    name="eta_port" aria-label="ETA Port" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Discharge Port">Discharge Port:</label>
                                <select class="form-select select2" name="discharge_port_id" id="discharge_port_id"
                                    data-allow-clear="true">
                                    <option value="">--Select Departure Port--</option>
                              
                                    @foreach($arrival as $port)
                                    <option value="{{ $port->id }}" {{ $supplier_invoice->arrival_port_id == $port->id ? 'selected' : '' }}>
                                        {{ $port->supplier_port_name }}
                                    </option>
                                @endforeach

                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Wiring Instructions">Wiring Instructions:</label>
                                <input type="text" class="form-control" id="wiring_instruction_id"
                                    placeholder="Wiring Instructions" name="wiring_instruction_id" value="{{$supplier_invoice->wiring_instruction_id}}"  aria-label="" />
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <label class="form-label" for="Country">Printed Notes:
                            </label>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <textarea type="text" class="form-control" id="printed_notes"
                                        placeholder="Printed Notes" name="printed_notes" aria-label="">{{$supplier_invoice->printed_notes}}</textarea>
                                </div>
                            </div>
                            <label class="form-label" for="Country">Internal Notes:
                            </label>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <textarea type="text" class="form-control" id="internal_notes"
                                        placeholder="Internal Notes" name="internal_notes" aria-label="">{{$supplier_invoice->internal_notes}}</textarea>
                                </div>
                            </div>
                            <label class="form-label" for="Country">Terms:
                            </label>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                <select class="form-select select2" name="pre_purchase_term_id"
                                        id="pre_purchase_term_id" data-allow-clear="true">
                                        <option value="">--Select Terms--</option>

                                    </select>
                                </div>
                            </div>
                         
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <textarea type="text" class="form-control" id="terms_value"
                                        placeholder="" name="terms_value" aria-label="">{{$supplier_invoice->terms_value}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 pt-4 pt-md-0">
                                <div class="tab-content p-0 pe-md-5 ps-md-3">
                                    <div class="" id="product_details">
                                    
                                        <!-- Your existing table -->
                                    <table class="datatables-basic table tables-basic border-top table-striped" id="supplierProducts">
                                        <thead class="table-header-bold">
                                            <tr>
                                            <input type="hidden" class="form-control" id="po_id"  value="{{$supplier_invoice->po_id}}" name="po_id" />
                                                <td><input type="checkbox" class="form-check-input"  id="selectAll"  name="product_check_ids" /></td>
                                                <th>PO#</th>
                                                <th>Product</th>
                                                <th>Description</th>
                                                <th>Supp./Pur. Note</th>
                                                <th>Alt.Qty</th>
                                                <th>Pr./Alt.UOM</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th></th>
                                                <th>Extended</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_supplier_products">
                                            @foreach($products as $index => $prd)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="product[{{$index}}][po_id]" value="{{$supplier_invoice->po_id}}" />
                                                        <input type="hidden" name="product[{{$index}}][id]" value="{{$prd->pid}}" />
                                                        <input type="checkbox" name="product[{{$index}}][selected]" value="1" />
                                                    </td>
                                                    <td>{{$prd->po_id}}</td>
                                                    <td>
                                                        <select name="product[{{$index}}][product_id]" class="form-select">
                                                            @foreach($product as $prds)
                                                                <option value="{{ $prds->id }}" @if($prds->id == $prd->product_id) selected @endif>
                                                                    {{ $prds->product_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="product[{{$index}}][description]" value="{{$prd->description}}" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="product[{{$index}}][supplier_purchasng_note]" value="{{$prd->supplier_purchasng_note}}" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="product[{{$index}}][slab]" value="{{$prd->slab}}" />
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <input type="number" class="form-control" name="product[{{$index}}][quantity]" value="{{$prd->quantity}}" oninput="calculateExtended(this)" />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="product[{{$index}}][unit_price]" value="{{$prd->unit_price}}" oninput="calculateExtended(this)" />
                                                    </td>
                                                    <td><input type="button" style="color: #007bff;" value="SP" /></td>
                                                    <td>
                                                        <input type="text" class="form-control" name="product[{{$index}}][extended]" value="{{$prd->extended}}" readonly />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>


                                    </table>
                                    <div>
                                <button type="button" class="btn btn-primary mt-3" id="addMoreEdit">Add More</button>
                            </div>                              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>       

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 pt-4 pt-md-0">
                                <div class="tab-content p-0 pe-md-5 ps-md-3">
                                    <div class="" id="product_details">
                                    <table class="datatables-basic table tables-basic border-top table-striped" id="productFile">
                                        <thead class="table-header-bold">
                                            <tr>
                                                <th>Service</th>
                                                <th>Account</th>
                                                <th>Description</th>
                                                <th>Extended</th>
                                            </tr>
                                        </thead>
                                        <tbody id="fileUploadRow">
                                            @foreach($other_charges as $index => $charge)
                                            <tr>
                                                <td>  <input type="hidden" name="other_charges[{{$index}}][charge_id]" id="charge_id" value="{{ $charge->id}}" />
                                                    <select class="form-select" name="other_charges[{{$index}}][service_id]" id="service_id{{ $index }}" data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        @foreach($service as $ser)
                                                        <option value="{{ $ser->id }}" @if($ser->id == $charge->service_id) selected @endif>
                                                            {{ $ser->service_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="other_charges[{{$index}}][account_id]" id="account_id{{ $index }}" data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        @foreach($account as $acc)
                                                        <option value="{{ $acc->id }}" @if($acc->id == $charge->account_id) selected @endif>
                                                            {{ $acc->account_number }} - {{ $acc->account_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="description_{{ $index }}" placeholder="Description" name="other_charges[{{$index}}][description]" value="{{ old('other_charges.' . $index . '.description', $charge->description) }}" />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control extended" id="extended_{{ $index }}" placeholder="" name="other_charges[{{$index}}][extended]" value="{{ old('other_charges.' . $index . '.extended', $charge->extended) }}" oninput="calculateTotal()" />
                                                </td>
                                            </tr>
                                            @endforeach

                                            @for ($i = 0; $i < 3; $i++)
                                            <tr>
                                                <td>
                                                    <select class="form-select" name="other_charges[{{$i}}][service_id]" id="service_id{{ $i }}" data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        @foreach($service as $ser)
                                                        <option value="{{ $ser->id }}">{{ $ser->service_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="other_charges[{{$i}}][account_id]" id="account_id{{ $i }}" data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        @foreach($account as $acc)
                                                        <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="description_{{ $i }}" placeholder="Description" name="other_charges[{{$i}}][description]" aria-label="Description" />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control extended" id="extended_{{ $i }}" placeholder="" name="other_charges[{{$i}}][extended]" aria-label="" oninput="calculateTotal()" />
                                                </td>
                                            </tr>
                                            @endfor
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;"><strong>Items Total:</strong></td>
                                                <td id="itemTotal">$00.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: right;"><strong>Other Total:</strong></td>
                                                <td id="otherTotal">$00.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                                                <td id="total">$00.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" id="savedata" value="create">Update Supplier
                        Invoice</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@include('supplier_invoice_packing_list.__scripts')
@endsection