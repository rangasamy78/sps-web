<div class="modal fade" id="prePurchaseSupplierRequestModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="prePurchaseSupplierRequestModelForm" name="prePurchaseSupplierRequestModelForm" class="form-horizontal">
                    <input type="hidden" name="pre_purchase_supplier_request_id" id="pre_purchase_supplier_request_id">
                    <input type="hidden" name="pre_purchase_request_id" id="pre_purchase_request_id" value="{{ $pre_purchase_request->id }}">
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

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveProductData" value="create">Save Product</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
