<div class="tab-pane fade" id="product" role="tabpanel">
    <h5>Add Product</h5>
    <table class="datatables-basic table table-striped" id="prePurchaseRequestProduct">
        <thead class="table-header-bold">
            <tr>
                <th>Sl.No</th>
                <th>Product Sku</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Bundles</th>
                <th>Alt Qty</th>
                <th>Quantity</th>
                <th>Purchasing Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="prePurchaseRequestProductModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="prePurchaseRequestProductModelForm" name="prePurchaseRequestProductModelForm" class="form-horizontal">
                    <input type="hidden" name="pre_purchase_request_product_id" id="pre_purchase_request_product_id">
                    <input type="hidden" name="pre_purchase_request_id" id="pre_purchase_request_id" value="{{ $pre_purchase_request->id }}">
                    <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $pre_purchase_request->supplier_id }}">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_no" class="form-label">S.No</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="s_no" name="s_no" placeholder="Enter S.No" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="product_id" class="form-label">Product Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <div class="col-sm-12">
                                    <select id="product_id" class="form-select select2" name="product_id" data-allow-clear="true">
                                        <option value="">--Select Product Name--</option>
                                        @foreach($data['products'] as $key => $product)
                                            <option value="{{ $key }}">{{ $product }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="form-control" id="product_sku" name="product_sku" placeholder="Enter Product sku" value="">
                                    <input type="hidden" class="form-control" id="avg_est_cost" name="avg_est_cost" placeholder="Enter avg cost" value="">
                                </div>
                                <span class="text-danger error-text product_id_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="purchasing_note" class="form-label">Supplier / Purchasing Note</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="purchasing_note" name="purchasing_note" placeholder="Enter Supplier / Purchasing Note" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2" style="display: none" id="pur_uom">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pur_qty" class="form-label">Pur. Qty</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="pur_qty" name="pur_qty" placeholder="Enter Qty" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="pur_uom" class="form-label">pur.UOM</label>
                                <div class="col-sm-12">
                                    <select id="pur_uom_id" class="form-select select2" name="pur_uom_id" data-allow-clear="true">
                                        <option value="">--Select UOM--</option>
                                        @foreach($data['uoms'] as $key => $uom)
                                            <option value="{{ $key }}">{{ $uom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="length" class="form-label">Min. Length:</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="length" name="length" placeholder="Enter Length" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="width" class="form-label">Min. Width:</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="width" name="width" placeholder="Enter Width" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="picking_qty" class="form-label">Bundles</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="picking_qty" name="picking_qty" placeholder="Enter Bundles" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="picking_unit" class="form-label">Slabs/Bundle</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="picking_unit" name="picking_unit" placeholder="Enter Slabs/Bundle" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="slab" class="form-label">Slabs</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="slab" name="slab" placeholder="Enter Slabs" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="qty" class="form-label">Quantity: <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Quantity" value="">
                                    <span class="text-danger error-text qty_error"></span>
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
