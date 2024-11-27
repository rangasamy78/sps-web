
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
                        {!! Form::hidden('pre_purchase_request_id', $pre_purchase_request_id ?? '', ['class' => 'form-control', 'id' => 'pre_purchase_request_id']) !!}
                        <span class="text-danger error-text supplier_id_error"></span>
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
                    <div class="col-6">
                        <label class="form-label" for="required_ship_date">Required Ship Date:</label>
                        {!! Form::date('required_ship_date', null, ['class' => 'form-control', 'id' => 'required_ship_date', 'placeholder' => 'Enter Required Ship Date']) !!}
                        <span class="text-danger error-text required_ship_date_error"></span>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="requested_by">Requested By:</label>
                        {!! Form::select('requested_by_id', $data['users'], null, ['class' => 'form-control select2', 'id' => 'requested_by_id', 'placeholder' => '--Select Requested By--', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text requested_by_id_error"></span>
                    </div>
                    <div class="col-12 col-lg-12 mt-3">
                        {!! Form::textarea('pre_purchase_terms', null, ['class' => 'form-control', 'id' => 'pre_purchase_terms', 'placeholder' => 'Enter Pre-Purchase Terms', 'rows' => 14, 'cols' => 50]) !!}
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
                    <div class="col-12 col-lg-12 mt-3">
                        <label class="form-label" for="requested_by">Requested By:</label>
                        <div>ULTRA STONES LLC - NY</div>
                    </div>
                    <div class="col-12 col-lg-12 mt-3">
                        <label class="form-label" for="shipment_terms">Shipment Terms:</label>
                        <div>{{ $pre_purchase_supplier_request->shipment_term ? $pre_purchase_supplier_request->shipment_term->shipment_term_name : ''}}</div>
                        {!! Form::hidden('shipment_term_id', $pre_purchase_supplier_request->shipment_term->id, ['class' => 'form-control', 'id' => 'shipment_term_id', 'placeholder' => 'Enter shipment term id']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-12 mb-3" id="email_contact" style="display: none;">
                        {!! Form::select('email_contact_id', [], '', ['class' => 'form-control select2', 'id' => 'email_contact_id', 'placeholder' => '--Select Email Contact--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mt-3">
                        <label class="form-label" for="requested_by">Email:</label>
                        {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter Email']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mt-3">
                        <label class="form-label" for="requested_by">Email Body:</label>
                        {!! Form::textarea('email_body', null, ['class' => 'form-control', 'id' => 'email_body', 'placeholder' => 'Enter Email Body', 'rows' => 4, 'cols' => 50]) !!}
                        {!! Form::hidden('resend_request', 1, ['class' => 'form-control', 'id' => 'resend_request', 'placeholder' => 'Enter Request']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mt-3">
                        <label class="form-label" for="requested_by">Is checked only email send :</label>
                        {!! Form::hidden('is_check_email', 0) !!}
                        {!! Form::checkbox('is_check_email', 1, null, ['id' => 'is_check_email']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Products</span>:</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Sku</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Bundles</th>
                                    <th>Slabs</th>
                                    <th>Quantity</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reqProducts as $key => $reqProduct)
                                <tr>
                                        <td>{{ $reqProduct->product->generic_sku ?? '' }}</td>
                                        <td>{{ $reqProduct->product->product_name }}</td>
                                        <td>{!! Form::text("product[$key][description]", $reqProduct->description, ['class' => 'form-control', 'id' => 'description_' . $key, 'placeholder' => 'Enter description']) !!}
                                            <span class="text-danger error-text product_{{$key}}_description_error"></span>
                                        </td>
                                        <td>{{ $reqProduct->picking_qty}}</td>
                                        <td>{{ $reqProduct->slab }}</td>
                                        <td>{{ $reqProduct->qty." $" }}</td>
                                        <td>
                                            {!! Form::hidden("product[$key][product_id]", $reqProduct->product_id, ['class' => 'form-control', 'id' => 'product_id_' . $key, 'placeholder' => 'Enter Product id']) !!}
                                            {!! Form::hidden("product[$key][pre_purchase_request_id]", $pre_purchase_request_id, ['class' => 'form-control', 'id' => 'pre_purchase_request_id_' . $key, 'placeholder' => 'Enter Product id']) !!}
                                            {!! Form::text("product[$key][purchasing_note]", $reqProduct->purchasing_note, ['class' => 'form-control', 'id' => 'purchasing_note_' . $key, 'placeholder' => 'Enter Purchasing Note']) !!}
                                            <span class="text-danger error-text product_{{$key}}_purchasing_note_error"></span>
                                            {!! Form::hidden("product[$key][product_name]", $reqProduct->product->product_name, ['class' => 'form-control', 'id' => 'product_name_' . $key, 'placeholder' => 'Enter product name']) !!}
                                            {!! Form::hidden("product[$key][product_sku]", $reqProduct->product->product_sku, ['class' => 'form-control', 'id' => 'product_sku_' . $key, 'placeholder' => 'Enter product sku']) !!}
                                            {!! Form::hidden("product[$key][generic_name]", $reqProduct->product->generic_name, ['class' => 'form-control', 'id' => 'generic_name_' . $key, 'placeholder' => 'Enter generic Name']) !!}
                                            {!! Form::hidden("product[$key][generic_sku]", $reqProduct->product->generic_sku, ['class' => 'form-control', 'id' => 'generic_sku_' . $key, 'placeholder' => 'Enter generic Name']) !!}
                                            {!! Form::hidden("product[$key][avg_est_cost]", $reqProduct->avg_est_cost, ['class' => 'form-control', 'id' => 'avg_est_cost_' . $key, 'placeholder' => 'Enter avg_est_cost']) !!}
                                            {!! Form::hidden("product[$key][pur_qty]", $reqProduct->pur_qty, ['class' => 'form-control', 'id' => 'pur_qty_' . $key, 'placeholder' => 'Enter pur qty']) !!}
                                            {!! Form::hidden("product[$key][pur_uom_id]", $reqProduct->pur_uom_id, ['class' => 'form-control', 'id' => 'pur_uom_id_' . $key, 'placeholder' => 'Enter uom id']) !!}
                                            {!! Form::hidden("product[$key][length]", $reqProduct->length, ['class' => 'form-control', 'id' => 'length_' . $key, 'placeholder' => 'Enter length']) !!}
                                            {!! Form::hidden("product[$key][width]", $reqProduct->width, ['class' => 'form-control', 'id' => 'width_' . $key, 'placeholder' => 'Enter width']) !!}
                                            {!! Form::hidden("product[$key][picking_qty]", $reqProduct->picking_qty, ['class' => 'form-control', 'id' => 'picking_qty_' . $key, 'placeholder' => 'Enter picking_qty']) !!}
                                            {!! Form::hidden("product[$key][picking_unit]", $reqProduct->picking_unit, ['class' => 'form-control', 'id' => 'picking_unit_' . $key, 'placeholder' => 'Enter picking_unit']) !!}
                                            {!! Form::hidden("product[$key][slab]", $reqProduct->slab, ['class' => 'form-control', 'id' => 'slab_' . $key, 'placeholder' => 'Enter slab']) !!}
                                            {!! Form::hidden("product[$key][qty]", $reqProduct->qty, ['class' => 'form-control', 'id' => 'qty_' . $key, 'placeholder' => 'Enter qty']) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
