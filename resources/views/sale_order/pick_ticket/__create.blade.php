@extends('layouts.admin')

@section('title', 'PickTicket')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <form id="saleOrderForm">
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="py-3 mb-4"><a href="{{ route('sale_orders.index') }}" class="text-decoration-none text-dark"><span
                            class="text-muted fw-light">Sale Order /</span>
                        PickTicket</span>
                    </a></h4>
                <div class="app-ecommerce">
                    <div class="row">
                        <!-- first column -->
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0 fw-bold">
                                        <span class="text-dark fw-bold">PickTicket for SO #
                                            {{ $sale_order->sales_order_code }} : {{ $sale_order->ship_to_job_name }}
                                        </span>
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-4 col-md-6 col-lg-3">
                                            <div class="row mb-2">
                                                <div class="row">
                                                    <div class="col-12 col-sm-3">
                                                        <span style="font-size:9pt"> Type </span>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label text-dark fw-bold font-size"
                                                            style="font-size:8pt">{{ $sale_order->ship_to_type }}</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-3">
                                                        <span style="font-size:9pt"> Bill to </span>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label text-dark fw-bold font-size"
                                                            style="font-size:8pt">{{ $customer->customer_name }}</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-3">
                                                        <span style="font-size:9pt"> Location </span>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label text-dark fw-bold font-size"
                                                            style="font-size:8pt">{{ $company->company_name }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-md-6 col-lg-3">
                                            <div class="row mb-2">
                                                <div class="row">
                                                    <div class="col-12 col-sm-3">
                                                        <span style="font-size:9pt"> Ship to</span>
                                                    </div>
                                                    <div class="col-12 col-sm-9">
                                                        <label
                                                            class="text-dark fw-bold font-size">{{ $sale_order->ship_to_name }}</label><br />
                                                        {{ $sale_order->ship_to_address }}<br />
                                                        {{ $sale_order->ship_to_city }} {{ $sale_order->ship_to_state }}
                                                        {{ $sale_order->ship_to_zip }}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-1 mb-2">
                                            <span style="font-size:9pt">PickTicket #</span><br />
                                            <label class="form-label text-dark fw-bold"
                                                style="font-size:9pt">{{ $sale_order->sales_order_code }}</label>
                                        </div>
                                        <div class="col-12 col-sm-2 mb-2">
                                            <span style="font-size:9pt">PickTicket Date</span><br />
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-12 col-sm-2 mb-2">
                                            <span style="font-size:9pt">Payment Terms</span><br />
                                            <select id="payment_term_id" name="payment_term_id" class="form-select select2"
                                                data-allow-clear="true">
                                                <option value="">--select--</option>
                                                @foreach ($data['paymentTerms'] as $payment_term)
                                                    <option value="{{ $payment_term->id }}">
                                                        {{ $payment_term->payment_label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-1 mb-2">
                                            <!-- Empty column to maintain spacing (if required) -->
                                        </div>
                                        <div class="col-12 col-sm-6 mt-2">
                                            <div class="alert alert-info">
                                                This is a Delivery - {{ $sale_order->is_cod == 1 ? 'COD' : '' }} Sale.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="form-label mb-0 fw-bold text-dark">Additional Info</label>
                                        <div class="col-12 col-sm-2">
                                            <span style="font-size:9pt">Cust. Req. Date</span><br />
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <span style="font-size:9pt">Est. Ship Date</span><br />
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <span style="font-size:9pt">Fulfilled Date</span><br />
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-2">
                                            <label class="form-label fw-bold text-dark">Printed Notes</label>
                                            <textarea class="form-control" rows="1" id="printed_notes" name="printed_notes">{{ $sale_order->printed_notes }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-2 mb-2">
                                            <span style="font-size:9pt">Freight Carrier</span><br />
                                            <select id="freight_carrier_id" name="freight_carrier_id"
                                                class="form-select select2" data-allow-clear="true">
                                                <option value="">--select--</option>
                                                @foreach ($data['expenditures'] as $expenditure)
                                                    <option value="{{ $expenditure->id }}">
                                                        {{ $expenditure->expenditure_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-2 mb-2">
                                            <span style="font-size:9pt">Route</span><br />
                                            <select id="route_id" name="route_id" class="form-select select2"
                                                data-allow-clear="true">
                                                <option value="">--select--</option>
                                                @foreach ($data['counties'] as $id => $label)
                                                    <option value="{{ $id }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-2 mb-2">
                                            <span style="font-size:9pt">Tracking</span><br />
                                            <input type="text" class="form-control" id="shipping_tracking_number"
                                                name="shipping_tracking_number" aria-label="shipping_tracking_number"
                                                value="{{ $sale_order->shipping_tracking_number }}" />
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label fw-bold text-dark">Special / Delivery
                                                Instructions</label>
                                            <textarea class="form-control" rows="1" id="special_instructions" name="special_instructions">{{ $sale_order->special_instructions }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-2 mb-2">
                                            <span style="font-size:9pt">Commission Amt</span><br />
                                            <input class="form-control" type="number" id="commission_amount"
                                                name="commission_amount" value="{{ $sale_order->commission_amount }}" />
                                        </div>
                                        <div class="col-12 col-sm-4 mb-2">
                                            <span style="font-size:9pt">Commission Notes</span><br />
                                            <input class="form-control" type="text" id="commission_notes"
                                                name="commission_notes" value="{{ $sale_order->commission_notes }}" />
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control" id="internal_notes_input" rows="2">{{ $sale_order->internal_notes }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="form-label mb-0 fw-bold text-dark">Secondary Commission</label>
                                        <div class="col-12 col-sm-2">
                                            <span style="font-size:9pt">Amount</span><br />
                                            <input class="form-control" type="number" id="commission_notes"
                                                name="commission_notes" value="{{ $sale_order->commission_notes }}" />
                                        </div>
                                        <div class="col-12 col-sm-4 mb-4">
                                            <span style="font-size:9pt">Notes</span><br />
                                            <textarea class="form-control" type="text" rows="3" id="commission_notes" name="commission_notes"
                                                value="{{ $sale_order->commission_notes }}"></textarea>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-12 pt-4 pt-md-0">
                                                    <div class="tab-content p-0 pe-md-5 ps-md-3">
                                                        @include('sale_order.pick_ticket.lines')
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
                                                                <th>Service</th>
                                                                <th>Account</th>
                                                                <th>Description</th>
                                                                <th style="text-align: right;">Extended</th>
                                                                <th style="text-align: center;">Tax</th>
                                                                <th style="text-align: center;">Hide</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="pickTicketItemsBody">
                                                            @for ($i = 0; $i < 3; $i++)
                                                                <tr>
                                                                    <td>
                                                                        <select class="form-control" id="item_id"
                                                                            name="item_id">
                                                                            <option value="">Select Service</option>
                                                                            @foreach ($data['services'] as $id => $service_name)
                                                                                <option value="{{ $id }}">
                                                                                    {{ $service_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" id="item_id"
                                                                            name="item_id">
                                                                            <option value="">Select Account</option>
                                                                            @foreach ($data['accounts'] as $account)
                                                                                <option value="{{ $account->id }}">
                                                                                    {{ $account->account_number }} -
                                                                                    {{ $account->account_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text"
                                                                            class="form-control item_description-input"
                                                                            name="items[{{ $i }}][item_item_description]">
                                                                    </td>
                                                                    <td><input type="text"
                                                                            class="form-control form-control-sm extended-input"
                                                                            name="items[{{ $i }}][extended]"
                                                                            style="width: 80%;float: right;"></td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <input type="checkbox" class="is_tax"
                                                                                name="items[{{ $i }}][is_tax]"
                                                                                style="width: 100%">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <input type="checkbox" class="is_hideon_print"
                                                                                name="items[{{ $i }}][is_hideon_print]"
                                                                                style="width: 100%">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <button type="button" class="btn btn-success" id="addRow"
                                                        style="background-color: black; border-color: black; margin: 10px;">
                                                        Add 3 more lines
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /first column -->
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary btn-md" id="savedata" name="savedata">Create
                                PickTicket</button>
                            <button type="button" class="btn btn-secondary btn-md" id="cancelButton"
                                name="cancelButton">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        {{-- @include('sale_order.create.__model') --}}
    </div>
@endsection
@section('scripts')
    {{-- @include('sale_order.create.__script') --}}
    {{-- @include('sale_order.__script') --}}

    @include('sale_order.pick_ticket.__script')
@endsection
