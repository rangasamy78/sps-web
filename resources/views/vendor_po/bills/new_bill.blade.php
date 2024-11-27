@extends('layouts.admin')

@section('title', 'Add Vendor Po')

@section('styles')
<style>
.suggestion-item {
    cursor: pointer;
}
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <form id="newBillForm">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{route('vendor_pos.index')}}" class="text-decoration-none text-dark"><span
                        class="text-muted fw-light">Vendor Po /</span><span> Add New Bill </span></a></h4>
            <div class="app-ecommerce">
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="card mb-4">

                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" class="form-control" id="vendor_po_id" name="vendor_po_id"
                                            value="{{ $vendor_po->id}}">
                                        <label class="form-label" for="Transaction #">Transaction #</label>
                                        </label>
                                        <input type="text" class="form-control" id="transaction_number" placeholder=""
                                            name="transaction_number" aria-label="Transaction #" value="" />
                                        <span class="text-danger error-text transaction_number_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Vendor">Vendor<sup
                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select select2" name="vendor_id" id="vendor_id"
                                            data-allow-clear="true">
                                            <option value="">--Select Vendor--</option>
                                            @foreach($expendure as $exp)
                                            <option value="{{ $exp->id }}"
                                                {{ $exp->id == $vendor_po->vendor_id ? 'selected' : '' }}>
                                                {{ $exp->expenditure_name }}
                                            </option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger error-text vendor_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Location">Location <sup
                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select select2" name="location_id" id="location_id"
                                            data-allow-clear="true">
                                            <option value="">--Select Location--</option>
                                            @foreach($location as $loc)
                                            <option value="{{ $loc->id }}"
                                                {{ $loc->id == $vendor_po->location_id ? 'selected' : '' }}>
                                                {{ $loc->company_name }}
                                            </option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger error-text location_id_error"></span>
                                    </div>

                                    <div class="col">
                                        <label class="form-label" for="Invoice#">Invoice#<sup
                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="text" class="form-control" id="invoice_number"
                                            name="invoice_number" aria-label="Invoice" />
                                        <span class="text-danger error-text invoice_number_error"></span>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Invoice Date">Invoice Date
                                            <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="invoice_date" name="invoice_date"
                                            aria-label="Invoice Date" />
                                        <span class="text-danger error-text invoice_date_error"></span>
                                    </div>

                                    <div class="col">
                                        <label class="form-label" for="payment_term_id">Payment Terms<sup
                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select select2" name="payment_term_id" id="payment_term_id"
                                            data-allow-clear="true">
                                            <option value="">--Select Payment Terms--</option>
                                            @foreach($payment_terms as $terms)
                                            <option value="{{ $terms->id }}"
                                                {{ $terms->id == $vendor_po->payment_term_id ? 'selected' : '' }}>
                                                {{ $terms->payment_label }}
                                            </option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger error-text payment_term_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Due Date">Due Date</label>
                                        <input type="date" class="form-control" id="due_date" name="due_date"
                                            aria-label="Due Date" />
                                        <span class="text-danger error-text due_date_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Printed Notes">Printed Notes</label>
                                        <textarea class="form-control" id="printed_notes" name="printed_notes"
                                            aria-label="Printed Notes">{{$vendor_po->printed_notes}}</textarea>
                                    </div>


                                </div>

                                <div class="row mb-3">

                                    <div class="col-6">
                                        <label class="form-label" for="Internal Notes">Internal Notes</label>
                                        <textarea class="form-control" id="internal_notes" name="internal_notes"
                                            aria-label="Internal Notes">{{$vendor_po->internal_notes}}</textarea>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="hold_payment_checkbox"
                                                name="hold_payment_checkbox">
                                            <label class="form-check-label" for="hold_payment_checkbox">
                                                Hold Payment
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label" for="Hold Payment Reason">Hold Payment Reason</label>
                                        <input type="text" class="form-control" id="hold_payment_reason"
                                            name="hold_payment_reason" aria-label="Hold Payment Reason" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Contact Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="Contacts/Locations">Contacts/Locations </label>
                                        <select class="form-select select2" name="contact_location_id"
                                            id="contact_location_id" data-allow-clear="true">
                                            <option value="">--Select --</option>

                                        </select>

                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="Address">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter Address"
                                            name="address" aria-label="Address" value="{{$vendor_po->address}}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="Address2">Address2</label>
                                        <input type="text" class="form-control" id="address2"
                                            placeholder="Enter Address2" name="address2" aria-label="Address2"
                                            value="{{$vendor_po->address2}}" />

                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="City">City</label>
                                        <input type="text" class="form-control" id="city" placeholder="Enter City"
                                            name="city" aria-label="City" value="{{$vendor_po->city}}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="State">State</label>
                                        <input type="text" class="form-control" id="state" placeholder="Enter State"
                                            name="state" aria-label="State" value="{{$vendor_po->state}}" />
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="Zip">Zip</label>
                                        <input type="text" class="form-control" id="zip" placeholder="Enter Zip"
                                            name="zip" aria-label="Zip" value="{{$vendor_po->zip}}" />

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="Country">Country</label>
                                        <select class="form-select select2" name="country_id" id="country_id"
                                            data-allow-clear="true">
                                            <option value="">--Select Country--</option>
                                            @foreach($country as $cntry)
                                            <option value="{{ $cntry->id }}"
                                                {{ $cntry->id == $vendor_po->country_id ? 'selected' : '' }}>
                                                {{ $cntry->country_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="Phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" placeholder="Enter Phone"
                                            name="phone" aria-label="Phone" value="{{$vendor_po->phone}}" />

                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="Fax">Fax</label>
                                        <input type="text" class="form-control" id="fax" placeholder="Enter Fax"
                                            name="fax" aria-label="Fax" value="{{$vendor_po->fax}}" />
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                            name="email" aria-label="Email" value="{{$vendor_po->email}}" />

                                        <input type="hidden" class="form-control" id="extended_total"
                                            name="extended_total" aria-label="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header"></div>
                        <div class="card-body" style="padding: 0;">
                            <div style="overflow-x: auto;">
                                <table class="table table-bordered" id="vendorPoItemsTable">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select_all_services" /></th>
                                            <th>Account</th>
                                            <th>Location</th>
                                            <th>Service/Supplies</th>
                                            <th>Purchased As</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>UOM</th>
                                            <th>Unit Price</th>
                                            <th>Extended</th>
                                        </tr>
                                    </thead>
                                    <tbody id="vendorPoItemsBody">
                                        @foreach ($vendor_po->vendor_po_details->take(10) as $index => $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="checkbox" class="purchase_check"
                                                        name="items[{{$index}}][purchase_check]"
                                                        {{ $item->purchase_check ? 'checked' : '' }}>
                                                    <input type="hidden"
                                                        class="form-control form-control-sm me-2 purchase-input"
                                                        name="items[{{$index}}][purchase]"
                                                        value="{{ $item->purchase }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div style="display: flex; align-items: center;">
                                                    <select class="form-select select2" name="account_id"
                                                        id="account_id" data-allow-clear="true">
                                                        <option value="">--Select --</option>
                                                        @foreach ($payment_methods as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" id="addVendorBtn"
                                                        style="margin-left: 5px; border: none; background: none; color:#53a0cf; font-size: 18px;">+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <select class="form-select select2" name="location_id" id="location_id"
                                                    data-allow-clear="true">
                                                    <option value="">--Select--</option>
                                                    @foreach($location as $loc)
                                                    <option value="{{ $loc->id }}">{{ $loc->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="position: relative; display: flex; align-items: center;">
                                                <input type="text" class="form-control form-control-sm service-input"
                                                    name="items[{{$index}}][service]"
                                                    value="{{ $item->service ?? 'N/A' }}" placeholder="Search..">
                                                <ul class="suggestions-list" id="suggestions-{{$index}}"
                                                    style="display: none; position: absolute; left: 35px; top: 82%; width: 75%; background-color: white; border: 1px solid #ccc; z-index: 10;">
                                                </ul>
                                                <span class="delete-service"
                                                    style="display: none; cursor: pointer; color: red; font-size: 18px; margin-left: 10px;">&times;</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="checkbox" class="purchase_check"
                                                        name="items[{{$index}}][purchase_check]" style="width: 80px;"
                                                        {{ $item->purchase_check ? 'checked' : '' }}>
                                                    <input type="text"
                                                        class="form-control form-control-sm me-2 purchase-input"
                                                        name="items[{{$index}}][purchase]" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="items[{{$index}}][description]"
                                                    value="{{ $item->description }}">
                                                <input type="hidden" class="form-control form-control-sm"
                                                    name="items[{{$index}}][service_id]" value="{{ $item->service }}">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$index}}][quantity]" value="{{ $item->quantity }}">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$index}}][uom]" value="{{ $item->uom }}" readonly>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control form-control-sm me-2"
                                                        name="items[{{$index}}][unit_cost]"
                                                        value="{{ $item->unit_cost }}" style="width: 80px;">
                                                </div>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$index}}][extended]" value="{{ $item->extended }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                        @for ($i = 0; $i < 6; $i++) <tr>
                                            <td><input type="checkbox" id="select_all_services_{{ $i + 10 }}" /></td>
                                            <td>
                                                <div style="display: inline-flex; align-items: center; width: 100%;">
                                                    <select class="form-select select2"
                                                        name="extra_items[{{ $i }}][account_id]"
                                                        id="extra_account_id_{{ $i }}" data-allow-clear="true"
                                                        style="flex: 1;">
                                                        <option value="">--Select--</option>
                                                        @foreach ($payment_methods as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" id="addVendorBtn_{{ $i }}"
                                                        style="margin-left: 5px; border: none; background: none; color: #53a0cf; font-size: 18px; flex-shrink: 0;">+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <select class="form-select select2"
                                                    name="extra_items[{{ $i }}][location_id]"
                                                    id="extra_location_id_{{ $i }}" data-allow-clear="true"
                                                    style="width: 100%;">
                                                    <option value="">--Select--</option>
                                                    @foreach($location as $loc)
                                                    <option value="{{ $loc->id }}">{{ $loc->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td
                                                style="position: relative; display: inline-flex; align-items: center; width: 100%;">
                                                <input type="text" class="form-control form-control-sm service-input"
                                                    name="items[{{$i}}][service]" value="" placeholder="Search.."
                                                    style="flex: 1;">
                                                <ul class="suggestions-list" id="suggestions-{{$i}}"
                                                    style="display: none; position: absolute; left: 35px; top: 82%; width: 75%; background-color: white; border: 1px solid #ccc; z-index: 10;">
                                                </ul>
                                                <span class="delete-service"
                                                    style="display: none; cursor: pointer; color: red; font-size: 18px; margin-left: 10px; flex-shrink: 0;">&times;</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="checkbox" class="purchase_check"
                                                        name="items[{{$i}}][purchase_check]" style="width: 80px;">
                                                    <input type="text"
                                                        class="form-control form-control-sm me-2 purchase-input"
                                                        name="items[{{$i}}][purchase]" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="items[{{$i}}][description]" value="">
                                                <input type="hidden" class="form-control form-control-sm"
                                                    name="items[{{$i}}][service_id]" value="">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$i}}][quantity]" value=""></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$i}}][uom]" value="" readonly></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm me-2"
                                                    name="items[{{$i}}][unit_cost]" value="" style="width: 80px;">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$i}}][extended]" value=""></td>
                                            </tr>
                                            @endfor
                                            <tr>
                                                <td colspan="9" style="text-align: right; font-weight: bold;">Total:
                                                </td>
                                                <td>
                                                    <input type="text" id="totalExtended"
                                                        class="form-control form-control-sm extended-input"
                                                        name="total_extended" value="0" readonly>
                                                </td>
                                            </tr>

                                    </tbody>
                                </table>


                                <br>

                                <button type="button" class="btn btn-success" id="addRow"
                                    style="background-color: black; border-color: black; padding: 10px 20px; margin: 10px;">
                                    <i class="fas fa-plus" style="color: white;"></i>
                                </button>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary btn-md" id="savedata" name="savedata">Save & View
                            Bill</button>
                        <button type="button" class="btn btn-primary btn-md" id="cancelButton" name="cancelButton">Save
                            & Add New Bill</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </form>
</div>

@endsection
@section('scripts')
@include('vendor_po.bills.__scripts')

@endsection