<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Pre Purchase Request information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    @if(isset($pre_purchase_request))
                    <div class="{{ isset($pre_purchase_request) ? 'col-4' : 'col-4' }}">
                        <label class="form-label" for="transaction_number">Pre-Purchase #:</label>
                        {!! Form::text('transaction_number', null, ['class' => 'form-control', 'id' => 'transaction_number', 'placeholder' => 'Enter Pre Purchase', 'disabled']) !!}
                    </div>
                    @endif
                    <div class="{{ isset($pre_purchase_request) ? 'col-4' : 'col-6' }}">
                        <label class="form-label" for="pre_purchase_date">Pre Purchase Date:</label>
                        {!! Form::date('pre_purchase_date', null, ['class' => 'form-control', 'id' => 'pre_purchase_date', 'placeholder' => 'Enter Pre Purchase Date']) !!}
                        <span class="text-danger error-text pre_purchase_date_error"></span>
                    </div>
                    <div class="{{ isset($pre_purchase_request) ? 'col-4' : 'col-6' }}">
                        <label class="form-label" for="required_ship_date">Required Ship Date:</label>
                        {!! Form::date('required_ship_date', null, ['class' => 'form-control', 'id' => 'required_ship_date', 'placeholder' => 'Enter Required Ship Date']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label" for="eta_date">ETA Date:</label>
                        {!! Form::date('eta_date', null, ['class' => 'form-control', 'id' => 'eta_date', 'placeholder' => 'Enter ETA Date']) !!}
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="shipment_term_id">Shipment Terms:</label>
                        {!! Form::select('shipment_term_id', $data['shipmentTerms'], null, ['class' => 'form-control select2', 'id' => 'shipment_term_id', 'placeholder' => '--Select Shipment Term--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="requested_by">Requested By:</label>
                        {!! Form::select('requested_by_id', $data['users'], null, ['class' => 'form-control select2', 'id' => 'requested_by_id', 'placeholder' => '--Select Requested By--', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text requested_by_id_error"></span>
                   </div>
                </div>
            </div> <!-- card -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Supplier:</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="supplier">Supplier:</label>
                        {!! Form::select('supplier_id', $data['suppliers'], null, ['class' => 'form-control select2', 'id' => 'supplier_id', 'placeholder' => '--Select Supplier--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="supplier_primary_address">Select Address:</label>
                        {!! Form::select('supplier_primary_address', [], '', ['class' => 'form-control select2', 'id' => 'supplier_primary_address', 'placeholder' => '--Select Supplier--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="supplier_address">Address:</label>
                        {!! Form::text('supplier_address', null, ['class' => 'form-control', 'id' => 'supplier_address', 'placeholder' => 'Enter Address']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="supplier_suite">Suite / Unit#:</label>
                        {!! Form::text('supplier_suite', null, ['class' => 'form-control', 'id' => 'supplier_suite', 'placeholder' => 'Enter Suite / Unit']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="supplier_city">City:</label>
                        {!! Form::text('supplier_city', null, ['class' => 'form-control', 'id' => 'supplier_city', 'placeholder' => 'Enter City']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="supplier_state">State:</label>
                        {!! Form::text('supplier_state', null, ['class' => 'form-control', 'id' => 'supplier_state', 'placeholder' => 'Enter State']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="supplier_zip">Zip:</label>
                        {!! Form::text('supplier_zip', null, ['class' => 'form-control', 'id' => 'supplier_zip', 'placeholder' => 'Enter Zip']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="supplier_country_id">Country:</label>
                        {!! Form::select('supplier_country_id', $data['countries'], null, ['class' => 'form-control select2', 'id' => 'supplier_country_id', 'placeholder' => 'Select County', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="payment_term_id">Payment Terms:</label>
                        {!! Form::select('payment_term_id', $data['accountPaymentTerms'], null, ['class' => 'form-control select2', 'id' => 'payment_term_id', 'placeholder' => 'Select County', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Purchase Location:</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="supplier">Location:</label>
                        {!! Form::select('purchase_location_id', $data['companies'], null, ['class' => 'form-control select2', 'id' => 'purchase_location_id', 'placeholder' => '--Select Supplier--', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text purchase_location_id_error"></span>
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="purchase_location_address">Address:</label>
                        {!! Form::text('purchase_location_address', null, ['class' => 'form-control', 'id' => 'purchase_location_address', 'placeholder' => 'Enter Address']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="purchase_location_suite">Suite / Unit#:</label>
                        {!! Form::text('purchase_location_suite', null, ['class' => 'form-control', 'id' => 'purchase_location_suite', 'placeholder' => 'Enter Suite / Unit']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="purchase_location_city">City:</label>
                        {!! Form::text('purchase_location_city', null, ['class' => 'form-control', 'id' => 'purchase_location_city', 'placeholder' => 'Enter City']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="purchase_location_state">State:</label>
                        {!! Form::text('purchase_location_state', null, ['class' => 'form-control', 'id' => 'purchase_location_state', 'placeholder' => 'Enter State']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="purchase_location_zip">Zip:</label>
                        {!! Form::text('purchase_location_zip', null, ['class' => 'form-control', 'id' => 'purchase_location_zip', 'placeholder' => 'Enter Zip']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="purchase_location_country_id">Country:</label>
                        {!! Form::select('purchase_location_country_id', $data['countries'],  null, ['class' => 'form-control select2', 'id' => 'purchase_location_country_id', 'placeholder' => 'Select County', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Ship To Location:</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="supplier">Location:</label>
                        {!! Form::select('ship_to_location_id', $data['companies'], null, ['class' => 'form-control select2', 'id' => 'ship_to_location_id', 'placeholder' => '--Select Supplier--', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text ship_to_location_id_error"></span>
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="ship_to_location_attn">Attn:</label>
                        {!! Form::text('ship_to_location_attn', null, ['class' => 'form-control', 'id' => 'ship_to_location_attn', 'placeholder' => 'Enter Attn']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="ship_to_location_address">Address:</label>
                        {!! Form::text('ship_to_location_address', null, ['class' => 'form-control', 'id' => 'ship_to_location_address', 'placeholder' => 'Enter Address']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="ship_to_location_suite">Suite / Unit#:</label>
                        {!! Form::text('ship_to_location_suite', null, ['class' => 'form-control', 'id' => 'ship_to_location_suite', 'placeholder' => 'Enter Suite / Unit']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="ship_to_location_city">City:</label>
                        {!! Form::text('ship_to_location_city', null, ['class' => 'form-control', 'id' => 'ship_to_location_city', 'placeholder' => 'Enter City']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="ship_to_location_state">State:</label>
                        {!! Form::text('ship_to_location_state', null, ['class' => 'form-control', 'id' => 'ship_to_location_state', 'placeholder' => 'Enter State']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="ship_to_location_zip">Zip:</label>
                        {!! Form::text('ship_to_location_zip', null, ['class' => 'form-control', 'id' => 'ship_to_location_zip', 'placeholder' => 'Enter Zip']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="ship_to_location_country_id">Country:</label>
                        {!! Form::select('ship_to_location_country_id', $data['countries'], null, ['class' => 'form-control select2', 'id' => 'ship_to_location_country_id', 'placeholder' => 'Select County', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-7">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        {!! Form::label('printed_notes', 'Printed Notes:', ['class' => 'form-label']) !!}
                        {!! Form::textarea('printed_notes', null, ['class' => 'form-control', 'id' => 'printed_notes', 'placeholder' => 'Enter Printed Notes', 'rows' => 4, 'cols' => 50]) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::label('internal_notes', 'Internal Notes:', ['class' => 'form-label']) !!}
                        {!! Form::textarea('internal_notes', null, ['class' => 'form-control', 'id' => 'internal_notes', 'placeholder' => 'Enter Internal Notes', 'rows' => 4, 'cols' => 50]) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="special_instruction_id">Special Instructions:</label>
                        {!! Form::select('special_instruction_id', $data['specialInstructions'], null, ['class' => 'form-control select2', 'id' => 'special_instruction_id', 'placeholder' => 'Select Special Instruction', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::textarea('special_instructions', null, ['class' => 'form-control', 'id' => 'special_instructions', 'placeholder' => 'Enter Special Instruction', 'rows' => 4, 'cols' => 50]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-12">
                        <label class="form-label" for="pre_purchase_term_id">Pre-Purchase Terms:</label>
                        {!! Form::select('pre_purchase_term_id', $data['printDocDisclaimers'], null, ['class' => 'form-control select2', 'id' => 'pre_purchase_term_id', 'placeholder' => 'Select Special Instruction', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-12 mb-3">
                        {!! Form::textarea('terms', null, ['class' => 'form-control', 'id' => 'terms', 'placeholder' => 'Enter Terms', 'rows' => 4, 'cols' => 50]) !!}
                    </div>

                    <div class="col-12 col-lg-6 mb-3">
                        {{-- <label class="form-label" for="conversion_rate">Exchange Rate: 1$ =:</label> --}}
                        {{-- {!! Form::number('conversion_rate', null, ['class' => 'form-control', 'id' => 'conversion_rate', 'placeholder' => 'Exchange Rate: 1$ =:']) !!} --}}
                        <div class="input-group">
                            {!! Form::text('conversion_rate', null, ['class' => 'form-control', 'id' => 'conversion_rate', 'placeholder' => 'Exchange Rate: 1$ =:']) !!}
                            <span class="input-group-text">$</span>
                        </div>
                        <span class="text-danger error-text conversion_rate_error"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

