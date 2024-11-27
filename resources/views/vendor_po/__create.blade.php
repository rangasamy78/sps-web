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
                <h4 class="py-3 mb-4"><a href="{{route('vendor_pos.index')}}"
                        class="text-decoration-none text-dark"><span class="text-muted fw-light">Vendor Po
                            /</span><span> Add Vendor Po </span></a></h4>
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
                                            <input type="hidden" class="form-control" id="vendor_po_id"
                                                name="vendor_po_id">
                                            <label class="form-label" for="Transaction #">Transaction #</label>
                                            </label>
                                            <input type="text" class="form-control" id="transaction_number"
                                                placeholder="" name="transaction_number" aria-label="Transaction #" />
                                            <span class="text-danger error-text transaction_number_error"></span>
                                        </div>
                                        <div class="col">
                                            <label class="form-label" for="Vendor">Vendor<sup
                                                    style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                            <select class="form-select select2" name="vendor_id" id="vendor_id"
                                                data-allow-clear="true">
                                                <option value="">--Select Vendor--</option>
                                                @foreach($expendure as $exp)
                                                <option value="{{ $exp->id }}">{{ $exp->expenditure_name  }}</option>
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
                                                <option value="{{ $loc->id }}">{{ $loc->company_name  }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text location_id_error"></span>
                                        </div>
                                        <div class="col">
                                            <label class="form-label" for="transaction_date">Transaction Date
                                                <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                            <input type="date" class="form-control" id="transaction_date"
                                                name="transaction_date" aria-label="Transaction Date"
                                                value="{{ now()->format('Y-m-d') }}" />
                                            <span class="text-danger error-text transaction_date_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-label" for="eta_date">ETA Date</label>
                                            <input type="date" class="form-control" id="eta_date" name="eta_date"
                                                aria-label="ETA Date" />
                                        </div>
                                        <div class="col">
                                            <label class="form-label" for="payment_term_id">Payment Terms<sup
                                                    style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                            <select class="form-select select2" name="payment_term_id"
                                                id="payment_term_id" data-allow-clear="true">
                                                <option value="">--Select Payment Terms--</option>
                                                @foreach($payment_terms as $terms)
                                                <option value="{{ $terms->id }}">{{ $terms->payment_label  }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text payment_term_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-label" for="Printed Notes">Printed Notes</label>
                                            <textarea class="form-control" id="printed_notes" name="printed_notes"
                                                aria-label="Supplier Since"></textarea>
                                        </div>
                                        <div class="col">
                                            <label class="form-label" for="Internal Notes">Internal Notes</label>
                                            <textarea class="form-control" id="internal_notes" name="internal_notes"
                                                aria-label="Supplier Since"></textarea>
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
                                            <input type="text" class="form-control" id="address"
                                                placeholder="Enter Address" name="address" aria-label="Address" />

                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="Address2">Address2</label>
                                            <input type="text" class="form-control" id="address2"
                                                placeholder="Enter Address2" name="address2" aria-label="Address2" />

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="form-label" for="City">City</label>
                                            <input type="text" class="form-control" id="city" placeholder="Enter City"
                                                name="city" aria-label="City" />

                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="fax">State</label>
                                            <input type="text" class="form-control" id="state" placeholder="Enter State"
                                                name="state" aria-label="State" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="form-label" for="email">Zip</label>
                                            <input type="text" class="form-control" id="zip" placeholder="Enter Zip"
                                                name="zip" aria-label="Zip" />
                                            <span class="text-danger error-text zip_error"></span>

                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="Country">Country</label>
                                            <select class="form-select select2" name="country_id" id="country_id"
                                                data-allow-clear="true">
                                                <option value="">--Select Country--</option>
                                                @foreach($country as $cntry)
                                                <option value="{{ $cntry->id }}">{{ $cntry->country_name  }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="form-label" for="Phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" placeholder="Enter Phone"
                                                name="phone" aria-label="Phone" />
                                            <span class="text-danger error-text phone_error"></span>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="Fax">Fax</label>
                                            <input type="text" class="form-control" id="fax" placeholder="Enter Fax"
                                                name="fax" aria-label="Fax" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="form-label" for="email">Email Address</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Enter Email" name="email" aria-label="Email" />
                                            <span class="text-danger error-text email_error"></span>

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
                                            @for ($i = 0; $i < 15; $i++) <tr>
                                                <td style="position: relative; display: flex; align-items: center;">
                                                    <input type="text"
                                                        class="form-control form-control-sm service-input"
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
                                                <td><span id="alt_ucost_{{$i}}" name="items[{{$i}}][alt_ucost]"></span>
                                                </td>
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
                                                <td><input type="text"
                                                        class="form-control form-control-sm extended-input"
                                                        name="items[{{$i}}][extended]"></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger removeRow">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                                </tr>
                                                @endfor
                                                <tr>
                                                    <td colspan="9" class="text-end"><strong>Total:</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="totalExtended" name="extended_total" readonly>
                                                    </td>
                                                    <td></td>
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
                            <button type="submit" class="btn btn-primary btn-md" id="savedata" name="savedata">Save &
                                View Vendor PO</button>
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
