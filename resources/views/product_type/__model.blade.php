<div class="modal fade" id="productTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productTypeForm" name="productTypeForm" class="form-horizontal">
                    <input type="hidden" name="product_type_id" id="product_type_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product-type" class="form-label">Product Type <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="product_type" name="product_type" placeholder="Enter Product Type" value="">
                                </div>
                                <span class="text-danger error-text product_type_error"></span>
                            </div>
                            <div class="form-group mt-2">
                                <label class="form-check-label" for="indivisible">Default Values</label>
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="checkbox" id="indivisible" name="indivisible" value="1" />
                                    <label class="form-check-label" for="indivisible">Indivisible</label>
                                    <div class="mt-2">
                                        <small><i>"Inventory detail lines CANNOT be partially sold."</i></small>
                                    </div>
                                </div>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="non_serialized" name="non_serialized" value="1" />
                                    <label class="form-check-label" style="color:red" for="non_serialized">Non Serialized</label>
                                    <div class="mt-2">
                                        <small><i>"Inventory is NOT tracked by Serial Number."</i></small>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="Inventory GL Account">Inventory GL Account <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <select id="inventory_gl_account_id" class="form-select select2" name="inventory_gl_account_id" data-allow-clear="true">
                                    <option value="">--Select Inventory GL Account--</option>
                                    @foreach($inventories as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text inventory_gl_account_id_error"></span>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label" for="Sales GL Account">Sales GL Account <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <select id="sales_gl_account_id" class="form-select select2" name="sales_gl_account_id" data-allow-clear="true">
                                    <option value="">--Select Sales GL Account--</option>
                                    @foreach($sales as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text sales_gl_account_id_error"></span>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label" for="Cogs GL Account">Cogs GL Account <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <select id="cogs_gl_account_id" class="form-select select2" name="cogs_gl_account_id" data-allow-clear="true">
                                    <option value="">--Select Cogs GL Account--</option>
                                    @foreach($cogs as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                    @endforeach
                                                    </select>
                                <span class="text-danger error-text cogs_gl_account_id_error"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product Type</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showProductTypeModal" tabindex="-1" aria-labelledby="show-product-type-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-product-type-modal-label">Show Product Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProductTypeForm" name="showProductTypeForm" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Product Type" class="form-label">Product Type</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="product_type" disabled name="product_type" placeholder="Enter Product Type" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="indivisible">Default Values</label>
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" disabled type="checkbox" id="indivisibles" name="indivisibles" value="1" />
                                    <label class="form-check-label" for="indivisible">Indivisible</label>
                                </div>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" disabled type="checkbox" id="non_serializeds" name="non_serializeds" value="1" />
                                    <label class="form-check-label" style="color:red" for="non_serialized">Non Serialized</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="Inventory GL Account">Inventory GL Account</label>
                                <div class="input-group input-group-merge">
                                    <select id="inventory_gl_accounts" disabled class="form-select" name="inventory_gl_accounts">
                                        <option value="">--Select Inventory GL Account--</option>
                                        @foreach($inventories as $key => $inventory)
                                            <option value="{{ $inventory['value'] }}">{{ $inventory['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="Sales GL Account">Sales GL Account</label>
                                <div class="input-group input-group-merge">
                                    <select id="sales_gl_accounts" disabled class="form-select" name="sales_gl_accounts">
                                        <option value="">--Select Sales GL Account--</option>
                                        @foreach($sales as $key => $sale)
                                            <option value="{{ $sale['value'] }}">{{ $sale['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="Cogs GL Account">Cogs GL Account</label>
                                <div class="input-group input-group-merge">
                                    <select id="cogs_gl_accounts" disabled class="form-select" name="cogs_gl_accounts">
                                        <option value="">--Select Cogs GL Account--</option>
                                        @foreach($cogs as $key => $cog)
                                            <option value="{{ $cog['value'] }}">{{ $cog['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
