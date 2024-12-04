                                <div class="tab-pane fade show active" id="product_details" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <label class="form-label me-2" for="searchInput"
                                                style="flex: 0 0 auto;">Name / SKU / Alt. Name:</label>
                                            <select class="form-select select2" name="product_id" id="product_id"
                                                data-allow-clear="true"
                                                style="font-size: 1.25rem; padding: 10px 15px; flex: 1 1 auto; margin-right: 10px;">
                                                <option value="">--Select Product--</option>
                                                @foreach($product as $prd)
                                                <option value="{{ $prd->id }}">{{ $prd->product_name }}</option>
                                                @endforeach
                                            </select>&nbsp;&nbsp;&nbsp;

                                            <a href="#" data-bs-toggle="modal" data-bs-target="#newProductModal"
                                                style="flex: 0 0 auto; text-decoration: none; color: #007bff;">Setup New
                                                Product</a>
                                        </div>
                                    </div>
                                    <div id="product_data">
                                        <form id="poProductForm" method="post">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Product :</h5>
                                            </div>

                                            <input type="hidden" name="po_id" id="po_id"
                                                value="{{ $purchase_order->id }}">
                                            <input type="hidden" name="product_id" id="product_id_hid">
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <label for="SO" class="form-label pb-1">SO </label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" id="so" name="so"
                                                            aria-label="" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" placeholder="Product"
                                                            id="product_name" name="product_name" aria-label="" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="Purchased as" class="form-label pb-1">Purchased
                                                            as</label>
                                                        <input type="checkbox" id="purchase_as">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control"
                                                            placeholder="Description" id="description"
                                                            name="description" aria-label="" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Supplier/ Purchasing Note"
                                                            id="supplier_purchasng_note" name="supplier_purchasng_note"
                                                            aria-label="" />
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="product_name" class="form-label pb-1">Min. L X
                                                        W:</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" id="length"
                                                            name="length" aria-label="" />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="product_name" class="form-label pb-1"> X </label>

                                                    </div>

                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" id="width"
                                                            name="width" aria-label=""
                                                            style="margin-left: -54px;" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" id="bundles"
                                                            name="bundles" aria-label="" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="Bundles" class="form-label pb-1"> Bundles </label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" id="slab_bundles"
                                                            name="slab_bundles" aria-label="" />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="product_name" class="form-label pb-1"> Slabs/Bundle
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label for="product_name" class="form-label pb-1">&nbsp;
                                                        </label>
                                                        <input type="text" class="form-control" id="slab" name="slab"
                                                            aria-label="" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="SF" class="form-label pb-1">&nbsp;</label>
                                                        <div class="mt-2">
                                                            <label for="SF" class="form-label pb-1">Slabs</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="Quantity" class="form-label pb-1">Quantity <sup
                                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                        <input type="text" + class="form-control" id="quantity"
                                                            name="quantity" aria-label="" />
                                                        <span class="text-danger error-text quantity_error"></span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="SF" class="form-label pb-1">&nbsp;</label>
                                                        <div class="mt-2">
                                                            <label for="SF" class="form-label pb-1">SF</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="Unit Price" class="form-label pb-1">Unit Price($):
                                                            <sup
                                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                        <input type="text" class="form-control" id="unit_price"
                                                            name="unit_price" aria-label="" />
                                                        <span class="text-danger error-text unit_price_error"></span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="Extended" class="form-label pb-1">Extended($): <sup
                                                                style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                                        </label>
                                                        <input type="text" class="form-control" id="extended"
                                                            name="extended" aria-label="" />
                                                        <span class="text-danger error-text extended_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-secondary" id="canceldata"
                                                        value="create">Cancel/ New Search</button>
                                                    <button type="submit" class="btn btn-primary" id="savedataProduct"
                                                        value="create">Add Product</button>
                                                </div>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                                <div id="product_data_update">
                                    <form id="poProductFormUpdate" method="post">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Product :</h5>
                                        </div>
                                        <input type="hidden" name="edit_id" id="edit_id">
                                        <input type="hidden" name="po_id" id="edit_po_id">
                                        <input type="hidden" name="product_id" id="edit_product_id_hid">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label for="SO" class="form-label pb-1">SO </label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" id="edit_so" name="so"
                                                        aria-label="" />
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="Product"
                                                        id="edit_product_name" name="product_name" aria-label="" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="Purchased as" class="form-label pb-1">Purchased
                                                        as</label>
                                                    <input type="checkbox" id="edit_purchase_as">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="Description"
                                                        id="edit_description" name="description" aria-label="" />
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Supplier/ Purchasing Note"
                                                        id="edit_supplier_purchasng_note" name="supplier_purchasng_note"
                                                        aria-label="" />
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="product_name" class="form-label pb-1">Min. L X W:</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" id="edit_length"
                                                        name="length" aria-label="" />
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="product_name" class="form-label pb-1"> X </label>

                                                </div>

                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" id="edit_width"
                                                        name="width" aria-label=""
                                                        style="margin-left: -54px;" />
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" id="edit_bundles"
                                                        name="bundles" aria-label="" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="Bundles" class="form-label pb-1"> Bundles </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" id="edit_slab_bundles"
                                                        name="slab_bundles" aria-label="" />
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="product_name" class="form-label pb-1"> Slabs/Bundle
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="product_name" class="form-label pb-1">&nbsp; </label>
                                                    <input type="text" class="form-control" id="edit_slabs" name="slab"
                                                        aria-label="" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="SF" class="form-label pb-1">&nbsp;</label>
                                                    <div class="mt-2">
                                                        <label for="SF" class="form-label pb-1">Slabs</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="Quantity" class="form-label pb-1">Quantity <sup
                                                            style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                    <input type="text" + class="form-control" id="edit_quantity"
                                                        name="quantity" aria-label="" />
                                                    <span class="text-danger error-text quantity_error"></span>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="SF" class="form-label pb-1">&nbsp;</label>
                                                    <div class="mt-2">
                                                        <label for="SF" class="form-label pb-1">SF</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="Unit Price" class="form-label pb-1">Unit Price($): <sup
                                                            style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                    <input type="text" class="form-control" id="edit_unit_price"
                                                        name="unit_price" aria-label="" />
                                                    <span class="text-danger error-text unit_price_error"></span>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="Extended" class="form-label pb-1">Extended($): <sup
                                                            style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="edit_extended"
                                                        name="extended" aria-label="" />
                                                    <span class="text-danger error-text extended_error"></span>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-secondary" id="canceldata"
                                                    value="create">Cancel/ New Search</button>
                                                <button type="submit" class="btn btn-primary" id="updatedataProduct"
                                                    value="create">Update Product</button>
                                            </div>
                                        </div>
                                </div>
                                </form>
                                </div>
                                <div class="modal fade" id="newProductModal" tabindex="-1"
                                    aria-labelledby="newProductModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newProductModalLabel">Setup New Product</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                            </div>
                                        </div>
                                    </div>
                                </div>