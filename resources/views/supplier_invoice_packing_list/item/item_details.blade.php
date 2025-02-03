<div class="tab-pane fade show active" id="items" role="tabpanel">
    <h5 class="mb-4">Items</h5>
    <table class="datatables-basic table tables-basic border-top table-striped" id="items">
        <thead class="table-header-bold">
            <tr>
                <th>Product (SKU)</th>
                <th>PO Details</th>
                <th>Alt. Qty</th>
                <th>Billed Qty</th>
                <th>Packinglist Qty</th>
                <th>Received Qty</th>
                <th>Unit Cost</th>
                <th>Total Cost</th>
                <th>Unit Landed Cost</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="productData">
           
        </tbody>
    </table>
</div>
<br><br>
<div class="tab-pane fade show active" id="items" role="tabpanel">
    <table class="datatables-basic table tables-basic border-top table-striped" id="items">
        <thead class="table-header-bold">
            <tr>
                <th>Serial Num</th>
                <th></th>
                <th>Lot/Block</th>
                <th>Bundle</th>
                <th>Supp. Ref</th>
                <th>Present Location</th>
                <th>Bin</th>
                <th>Packinglist Sizes</th>
                <th>Received Sizes</th>
                <th>P</th>
                <th>N</th>
                <th>D</th>
                <th>S</th>
            </tr>
        </thead>
        <tbody id="OtherCharge">
           
        </tbody>
    </table>
</div>

<!-- Summary Section -->
<div class="summary-section mt-4" style="text-align: right;">
    <div>
        <strong>Sub Total:</strong> $<span id="subTotal">0.00</span>
    </div>
    <div>
        <strong>Total:</strong> $<span id="total">0.00</span>
    </div>
    <div>
        <strong>Balance Due:</strong> $<span id="balanceDue">0.00</span>
    </div>
    <button class="btn btn-primary mt-2">Make Payment</button>
</div>
