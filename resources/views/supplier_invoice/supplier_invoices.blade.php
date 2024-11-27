@extends('layouts.admin')

@section('title', 'Purchase Order')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light"> </span>Add New Supplier Invoice </h4>
        <form id="supplierInvoiceForm" name="supplierInvoiceForm" class="form-horizontal" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="SIPL/Bill#">SIPL/Bill#:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <input type="hidden" name="po_id" id="po_id" value="{{$po_id}}">
                                    <input type="text" class="form-control" id="sipl_bill" placeholder="SIPL/Bill#"
                                        name="sipl_bill" aria-label="SIPL/Bill#" />
                                    <span class="text-danger error-text sipl_bill_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="P.O. Date">Entry Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <input type="date" class="form-control" id="entry_date" placeholder="Entry Date"
                                        name="entry_date" aria-label="Entry Date"
                                        value="{{ now()->format('Y-m-d') }}" />
                                    <span class="text-danger error-text entry_date_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Invoice#">Invoice#:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                    </label>
                                    <input type="text" class="form-control" id="invoice" placeholder="Invoice#"
                                        name="invoice" aria-label="Invoice#" />
                                    <span class="text-danger error-text invoice_error"></span>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="Supplier SO#">Supplier SO#:
                                    </label>
                                    <input type="text" class="form-control" id="supplier_so" placeholder="Supplier SO#"
                                        name="supplier_so" aria-label="Supplier SO#" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Ship(B/L) Date">Ship(B/L) Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                    </label>
                                    <input type="date" class="form-control" id="ship_date" placeholder="Ship(B/L) Date"
                                        name="ship_date" aria-label="Ship(B/L) Date" />
                                    <span class="text-danger error-text ship_date_error"></span>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Base Colors">Invoice Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong> :
                                    </label>
                                    <input type="date" class="form-control" id="invoice_date" placeholder="Invoice Date"
                                        name="invoice_date" aria-label="Invoice Date" />
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
                                        @foreach($payment_terms as $terms)
                                        <option value="{{ $terms->id }}">{{ $terms->payment_label  }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text payment_term_id_error"></span>
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="Due Date">Due Date:
                                        <sup style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                    </label>
                                    <input type="date" class="form-control" id="due_date" placeholder="Due Date"
                                        name="due_date" aria-label="Due Date" />
                                    <span class="text-danger error-text due_date_error"></span>
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="ETA Date">ETA Date:
                                    </label>
                                    <input type="date" class="form-control" id="eta_date" placeholder="ETA Date"
                                        name="eta_date" aria-label="ETA Date" />
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
                                    <label class="form-label" for="Shipment Terms">Delivery Method:
                                    </label>
                                    <select class="form-select select2" name="delivery_method_id"
                                        id="delivery_method_id" data-allow-clear="true">
                                        <option value="">--Select Shipment Terms--</option>
                                        @foreach($shipment_terms as $ship)
                                        <option value="{{ $ship->id }}">{{ $ship->shipment_term_name  }}</option>
                                        @endforeach
                                    </select>
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
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Shipment Terms">Payment Hold:
                                    </label>
                                    <input type="checkbox" id="payment_hold" name="payment_hold"
                                        aria-label="Payment Hold" />
                                </div>

                                <div class="col-4">
                                    <label class="form-label" for="Shipment Terms">Payment Hold Reason:
                                    </label>
                                    <input type="text" class="form-control" id="payment_hold_reason"
                                        placeholder="Payment Hold Reason" name="payment_hold_reason"
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
                                        <option value="{{ $supply->id }}">{{ $supply->supplier_name  }}</option>
                                        @endforeach

                                    </select>
                                    <span class="text-danger error-text supplier_id_error"></span>
                                </div>

                                <div class="col">
                                    <label class="form-label" for="Address">Address:
                                    </label>
                                    <input type="text" class="form-control" id="supplier_address" placeholder="Address"
                                        name="supplier_address" aria-label="Address" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Suite / Unit#">Suite / Unit#: </label>
                                    <input type="text" class="form-control" id="supplier_suite"
                                        placeholder="Suite / Unit#" name="supplier_suite" aria-label="Suite / Unit#" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="City">City:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="supplier_city" placeholder="City"
                                            name="supplier_city" aria-label="City" />
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="State"> State:
                                    </label>
                                    <input type="text" class="form-control" id="supplier_state" placeholder="State"
                                        name="supplier_state" aria-label="State" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="Zip">Zip:</label>
                                    <input type="text" class="form-control" id="supplier_zip" placeholder="Zip"
                                        name="supplier_zip" aria-label="Zip" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label" for="Country">Country:
                                    </label>
                                    <select class="form-select select2" name="supplier_country_id"
                                        id="supplier_country_id" data-allow-clear="true">
                                        <option value="">--Select Country--</option>
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
                                    <select class="form-select select2" name="purchase_location_id"
                                        id="purchase_location_id" data-allow-clear="true">
                                        <option value="">--Select Location --</option>
                                        @foreach($location as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->company_name  }}</option>
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
                                    <label class="form-label" for="City">City:

                                    </label>
                                    <input type="text" class="form-control" id="purchase_location_city"
                                        placeholder="City" name="purchase_location_city" aria-label="City" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="State">State </label>
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
                                        <option value="">--Select Location --</option>
                                        @foreach($country as $cntry)
                                        <option value="{{ $cntry->id }}">{{ $cntry->country_name  }}</option>
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
                                        @foreach($location as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->company_name  }}</option>
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
                                    <label class="form-label" for="Size">Suite / Unit#: :

                                    </label>
                                    <input type="text" class="form-control" id="ship_to_location_suite"
                                        placeholder="Suite / Unit#" name="ship_to_location_suite"
                                        aria-label="Suite / Unit#" />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="City">City </label>
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
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="vessel">Vessel</label>
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
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 pt-4 pt-md-0">
                                <div class="tab-content p-0 pe-md-5 ps-md-3">
                                    <div class="" id="product_details">
                                        <table class="datatables-basic table tables-basic border-top table-striped"
                                            id="productFile">
                                            <thead class="table-header-bold">
                                                <tr>
                                                    <th>PO# </th>
                                                    <th>Product</th>
                                                    <th>Description</th>
                                                    <th>Supp./Pur. Note </th>
                                                    <th>Alt.Qty </th>
                                                    <th>Pr./Alt.UOM </th>
                                                    <th>Qty</th>
                                                    <th>Unit Price </th>
                                                    <th></th>
                                                    <th>Extended</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productData">
                                            </tbody>
                                        </table>
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
                                        <table class="datatables-basic table tables-basic border-top table-striped"
                                            id="productFile">
                                            <thead class="table-header-bold">
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Account</th>
                                                    <th>Description</th>
                                                    <th>Extended</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fileUploadRow">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" id="savedata" value="create">Add Supplier
                        Invoice</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@include('supplier_invoice.__scripts')
@endsection