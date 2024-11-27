
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-4 mt-3">
                        <label class="form-label" for="requested_by">Required Ship Date:</label>
                        <div>{{ toDbDateDisplay(date('Y-m-d'))}}
                            @php
                            $pre_purchase_request_id = $id;
                            @endphp
                            {!! Form::hidden('pre_purchase_request_id', $id, ['class' => 'form-control', 'id' => 'pre_purchase_request_id', 'placeholder' => 'id']) !!}
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label class="form-label" for="requested_by">Requested By:</label>
                        {!! Form::select('requested_by_id', $data['users'], auth()->user()->id, ['class' => 'form-control select2', 'id' => 'requested_by_id', 'placeholder' => '--Select Requested By--', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text requested_by_id_error"></span>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label class="form-label" for="requested_by">Ship To:</label>
                        <div>ULTRA STONES LLC - NY</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-12 mt-3">
                        <label class="form-label" for="requested_by">Email Body:</label>
                        {!! Form::textarea('email_body', null, ['class' => 'form-control', 'id' => 'email_body', 'placeholder' => 'Enter Email Body', 'rows' => 4, 'cols' => 50]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-tile mb-0">Ship To Location:</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 mt-3">
                    <label class="form-label" for="supplier_id">Suplier id:</label>
                     <select name="supplier_id[]" id="supplier_id" class="form-control select2" multiple="multiple" data-allow-clear="true">
                        @foreach($data['suppliers'] as $id => $name)
                            <option value="{{ $id }}" {{ in_array($id, $selectedSuppliers) ? 'selected disabled' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text supplier_id_error"></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 mt-3">
                    <table class="datatables-basic table table-striped" id="prePurchaseMultipleRequest">
                        <thead class="table-header-bold">
                            <tr>
                                <th>Supplier</th>
                                <th>Address</th>
                                <th>Payment Terms</th>
                                <th>Email</th>
                                <th>Selected Emails</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
