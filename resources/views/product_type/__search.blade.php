<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-2">
            <input type="text" class="form-control dt-input dt-full-name" id="productTypeFilter" placeholder="Product Type">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-control select2" id="inventoryGLAccountFilter" name="inventoryGLAccountFilter" data-allow-clear="true">
                <option value="">--Select Inventory GL Account--</option>
                <option value="12000-Inventory">12000-Inventory</option>
                <option value="12100-Inventory Asset">12100-Inventory Asset</option>
                <option value="12200-Inventory in Transit">12200-Inventory in Transit</option>
                <option value="12300-Intransit Accrued Freight">12300-Intransit Accrued Freight</option>
                <option value="12400-Inventory Freight Adjustment">12400-Inventory Freight Adjustment</option>
                <option value="47918-SUPPLIER CREDIT - Inventory Damage">47918-SUPPLIER CREDIT - Inventory Damage</option>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select id="salesGLAccountFilter" class="form-select select2" name="salesGLAccountFilter" data-allow-clear="true">
                <option value="">--Select Sales GL Account--</option>
                <option value="47900-Sales">47900-Sales</option>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select id="cogsGLAccountFilter" class="form-select select2" name="cogsGLAccountFilter" data-allow-clear="true">
                <option value="">--Select Cogs GL Account--</option>
                <option value="50000-Cost of Goods Sold">50000-Cost of Goods Sold</option>
                <option value="50010-Inventory Adjustment">50010-Inventory Adjustment</option>
                <option value="50016-Sales Discounts">50016-Sales Discounts</option>
                <option value="50300-Commissions Paid">50300-Commissions Paid</option>
                <option value="50302-Commissions Paid - Employees Sales">50302-Commissions Paid - Employees Sales</option>
                <option value="50304-Commissions Paid - 3rd Party">50304-Commissions Paid - 3rd Party</option>
            </select>
        </div>
    </div>
</div>&nbsp;