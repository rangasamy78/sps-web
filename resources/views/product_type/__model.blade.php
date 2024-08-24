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
                        <div class="form-group">
                        <small class="text-light fw-medium d-block">Default Values</small>
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="checkbox" id="indivisible" name="indivisible" value="1" />
                            <label class="form-check-label" for="indivisible">Indivisible</label>
                            <div class="mt-2">
                                <small>"Inventory detail lines CANNOT be partially sold."</small>
                            </div>
                        </div>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="non_serialized" name="non_serialized" value="1" />
                            <label class="form-check-label" style="color:red" for="non_serialized">Non Serialized</label>
                            <div class="mt-2">
                                <small>"Inventory is NOT tracked by Serial Number."</small>
                            </div>
                        </div>
                    </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Inventory GL Account">Inventory GL Account</label>
                            <div class="input-group input-group-merge">
                                <select id="inventory_gl_account" class="form-select" name="inventory_gl_account">
                                    <option value="">--Select--</option>
                                    <option value="12000-Inventory">12000-Inventory</option>
                                    <option value="12100-Inventory Asset">12100-Inventory Asset</option>
                                    <option value="12200-Inventory in Transit">12200-Inventory in Transit</option>
                                    <option value="12300-Intransit Accrued Freight">12300-Intransit Accrued Freight</option>
                                    <option value="12400-Inventory Freight Adjustment">12400-Inventory Freight Adjustment</option>
                                    <option value="47918-SUPPLIER CREDIT - Inventory Damage">47918-SUPPLIER CREDIT - Inventory Damage</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Sales GL Account">Sales GL Account</label>
                            <div class="input-group input-group-merge">
                                <select id="sales_gl_account" class="form-select" name="sales_gl_account">
                                    <option value="">--Select--</option>
                                    <option value="47900-Sales">47900-Sales</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Cogs GL Account">Cogs GL Account</label>
                            <div class="input-group input-group-merge">
                                <select id="cogs_gl_account" class="form-select" name="cogs_gl_account">
                                    <option value="">--Select--</option>
                                    <option value="50000-Cost of Goods Sold">50000-Cost of Goods Sold</option>
                                    <option value="50010-Inventory Adjustment">50010-Inventory Adjustment</option>
                                    <option value="50016-Sales Discounts">50016-Sales Discounts</option>
                                    <option value="50300-Commissions Paid">50300-Commissions Paid</option>
                                    <option value="50302-Commissions Paid - Employees Sales">50302-Commissions Paid - Employees Sales</option>
                                    <option value="50304-Commissions Paid - 3rd Party">50304-Commissions Paid - 3rd Party</option>
                                </select>
                            </div>
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
                                <small class="text-light fw-medium d-block">Default Values</small>
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
                                        <option value="">--Select--</option>
                                        <option value="12000-Inventory">12000-Inventory</option>
                                        <option value="12100-Inventory Asset">12100-Inventory Asset</option>
                                        <option value="12200-Inventory in Transit">12200-Inventory in Transit</option>
                                        <option value="12300-Intransit Accrued Freight">12300-Intransit Accrued Freight</option>
                                        <option value="12400-Inventory Freight Adjustment">12400-Inventory Freight Adjustment</option>
                                        <option value="47918-SUPPLIER CREDIT - Inventory Damage">47918-SUPPLIER CREDIT - Inventory Damage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="Sales GL Account">Sales GL Account</label>
                                <div class="input-group input-group-merge">
                                    <select id="sales_gl_accounts" disabled class="form-select" name="sales_gl_accounts">
                                        <option value="">--Select--</option>
                                        <option value="47900-Sales">47900-Sales</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="Cogs GL Account">Cogs GL Account</label>
                                <div class="input-group input-group-merge">
                                    <select id="cogs_gl_accounts" disabled class="form-select" name="cogs_gl_accounts">
                                        <option value="">--Select--</option>
                                        <option value="50000-Cost of Goods Sold">50000-Cost of Goods Sold</option>
                                        <option value="50010-Inventory Adjustment">50010-Inventory Adjustment</option>
                                        <option value="50016-Sales Discounts">50016-Sales Discounts</option>
                                        <option value="50300-Commissions Paid">50300-Commissions Paid</option>
                                        <option value="50302-Commissions Paid - Employees Sales">50302-Commissions Paid - Employees Sales</option>
                                        <option value="50304-Commissions Paid - 3rd Party">50304-Commissions Paid - 3rd Party</option>
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
