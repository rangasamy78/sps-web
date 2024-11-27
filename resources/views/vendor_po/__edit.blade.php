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
    <form id="vendorPoForm">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{route('vendor_pos.index')}}" class="text-decoration-none text-dark"><span
                        class="text-muted fw-light">Vendor Po /</span><span> Edit Vendor Po </span></a></h4>
            <div class="app-ecommerce">
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Vendor Po Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" class="form-control" id="vendor_po_id" name="vendor_po_id"
                                            value="{{$vendor_po->id}}">
                                        <label class="form-label" for="Transaction #">Transaction #</label>
                                        </label>
                                        <input type="text" class="form-control" id="transaction_number"
                                            value="{{$vendor_po->transaction_number}}" name="transaction_number"
                                            aria-label="Transaction #" />
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
                                        <label class="form-label" for="print_name">Location </label>
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
                                        <label class="form-label" for="transaction_date">Transaction Date
                                            <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="transaction_date"
                                            name="transaction_date" aria-label="Transaction Date"
                                            value="{{$vendor_po->transaction_date}}" />
                                        <span class="text-danger error-text transaction_date_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="eta_date">ETA Date</label>
                                        <input type="date" class="form-control" id="eta_date" name="eta_date"
                                            aria-label="ETA Date" value="{{$vendor_po->eta_date}}" />
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
                                        <label class="form-label" for="Printed Notes">Printed Notes</label>
                                        <textarea class="form-control" id="printed_notes" name="printed_notes"
                                            aria-label="Supplier Since">{{$vendor_po->printed_notes}}</textarea>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Internal Notes">Internal Notes</label>
                                        <textarea class="form-control" id="internal_notes" name="internal_notes"
                                            aria-label="Supplier Since">{{$vendor_po->internal_notes}}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="vendor_po_terms_id">Vendor P.O. Terms</label>
                                        <select class="form-select select2" name="vendor_po_terms_id"
                                            id="vendor_po_terms_id" data-allow-clear="true">
                                            <option value="">--Select Vendor P.O. Terms--</option>
                                        </select>
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
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter Address"
                                            name="address" aria-label="Address" value="{{$vendor_po->address}}" />

                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="Address2">Address2</label>
                                        <input type="text" class="form-control" id="address2"
                                            placeholder="Enter Address2" name="address2" aria-label="Address2"
                                            value="{{$vendor_po->address2}}" />

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="City">City</label>
                                        <input type="text" class="form-control" id="city" placeholder="Enter City"
                                            name="city" aria-label="City" value="{{$vendor_po->city}}" />

                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="fax">State</label>
                                        <input type="text" class="form-control" id="state" placeholder="Enter State"
                                            name="state" aria-label="State" value="{{$vendor_po->state}}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="email">Zip</label>
                                        <input type="text" class="form-control" id="zip" placeholder="Enter Zip"
                                            name="zip" aria-label="Zip" value="{{$vendor_po->zip}}" />
                                        <span class="text-danger error-text zip_error"></span>

                                    </div>
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
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="Phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" placeholder="Enter Phone"
                                            name="phone" aria-label="Phone" value="{{$vendor_po->phone}}" />
                                        <span class="text-danger error-text phone_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="Fax">Fax</label>
                                        <input type="text" class="form-control" id="fax" placeholder="Enter Fax"
                                            name="fax" aria-label="Fax" value="{{$vendor_po->fax}}" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                            name="email" aria-label="Email" value="{{$vendor_po->email}}" />
                                        <span class="text-danger error-text email_error"></span>
                                        <input type="hidden" class="form-control" id="extended_total"
                                            name="extended_total" aria-label=""
                                            value="{{$vendor_po->extended_total}}" />
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
                                            <th>Service/Supplies</th>
                                            <th>Purchased As</th>
                                            <th>Description</th>
                                            <th>Alt.Qty</th>
                                            <th>Alt.UOM</th>
                                            <th>Alt.UCost</th>
                                            <th>Quantity</th>
                                            <th width="100px">UOM</th>
                                            <th>Unit Cost</th>
                                            <th>Extended</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="vendorPoItemsBody">
                                        @foreach ($vendor_po->vendor_po_details->take(10) as $index => $item)
                                        <tr>
                                            <td style="position: relative; display: flex; align-items: center;">
                                                <input type="text" class="form-control form-control-sm service-input"
                                                    name="items[{{$index}}][service]"
                                                    value="{{ $item->service?? 'N/A' }}" placeholder="Search..">
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
                                                        name="items[{{$index}}][purchase]"
                                                        value="{{ $item->purchase }}">
                                                </div>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="items[{{$index}}][description]"
                                                    value="{{ $item->description }}">
                                                <input type="hidden" class="form-control form-control-sm"
                                                    name="items[{{$index}}][service_id]" value="{{ $item->service }}">
                                            </td>

                                            <td><span id="alt_qty_{{$index}}"
                                                    name="items[{{$index}}][alt_qty]">{{ $item->alt_qty }}</span></td>
                                            <td><span id="alt_uom_{{$index}}"
                                                    name="items[{{$index}}][alt_uom]">{{ $item->alt_uom }}</span></td>
                                            <td><span id="alt_ucost_{{$index}}"
                                                    name="items[{{$index}}][alt_ucost]">{{ $item->alt_ucost }}</span>
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
                                                    <input type="button" style="color: #007bff;" value="vp">
                                                </div>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$index}}][extended]" value="{{ $item->extended }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger removeRow">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @for ($i = $vendor_po->vendor_po_details->count(); $i < 15; $i++) <tr>
                                            <td style="position: relative; display: flex; align-items: center;">
                                                <input type="text" class="form-control form-control-sm service-input"
                                                    name="items[{{$i}}][service]" placeholder="Search..">
                                                <ul class="suggestions-list" id="suggestions-{{$i}}"
                                                    style="display: none; position: absolute; left: 35px; top: 82%; width: 75%; background-color: white; border: 1px solid #ccc; z-index: 10;">
                                                </ul>
                                                <span class="delete-service"
                                                    style="display: none; cursor: pointer; color: red; font-size: 18px; margin-left: 10px;">&times;</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="checkbox" class="purchase_check"
                                                        name="items[{{$i}}][purchase_check]" style="width: 80px;">
                                                    <input type="text"
                                                        class="form-control form-control-sm me-2 purchase-input"
                                                        name="items[{{$i}}][purchase]" disabled>
                                                </div>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="items[{{$i}}][description]">
                                                <input type="hidden" class="form-control form-control-sm"
                                                    name="items[{{$i}}][service_id]">
                                            </td>
                                            <td><span id="alt_qty_{{$i}}" name="items[{{$i}}][alt_qty]"></span></td>
                                            <td><span id="alt_uom_{{$i}}" name="items[{{$i}}][alt_uom]"></span></td>
                                            <td><span id="alt_ucost_{{$i}}" name="items[{{$i}}][alt_ucost]"></span></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$i}}][quantity]"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$i}}][uom]" readonly></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control form-control-sm me-2"
                                                        name="items[{{$i}}][unit_cost]" style="width: 80px;">
                                                    <input type="button" style="color: #007bff;" value="vp">
                                                </div>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="items[{{$i}}][extended]"></td>
                                            <td>
                                                <button type="button" class="btn btn-danger removeRow">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            </tr>
                                            @endfor
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
                        <button type="submit" class="btn btn-primary btn-md" id="savedata" name="savedata">Update Vendor
                            PO</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton"
                            name="cancelButton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </form>
</div>

@endsection
@section('scripts')
@include('vendor_po.__scripts')

@endsection