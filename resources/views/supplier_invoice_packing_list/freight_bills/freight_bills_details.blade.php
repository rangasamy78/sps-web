<div class="tab-pane fade show active" id="freight_bills" role="tabpanel">
    <h5 class="mb-4">Freight Bills</h5>
    <table class="datatables-basic table tables-basic border-top table-striped" id="freight_bills">
        <thead class="table-header-bold">
            <tr>
            <th>Invoice #</th>
                <th>Invoice Date</th>
                <th>Vendor	</th>
                <th>By Qty./Weight</th>
                <th>Freight Extended</th>
                
            </tr>
        </thead>
        <tbody id="freightBills">
        </tbody>
    </table>
</div><br><br>
<div class="tab-pane fade show active" id="freight_bills" role="tabpanel">
    <h5 class="mb-4">Item Freight Allocation (Based on Billed Quantities)</h5>
    <table class="datatables-basic table tables-basic border-top table-striped" id="freight_bills">
        <thead class="table-header-bold">
            <tr>
            <th>Item</th>
                <th>Quantity
                (A)</th>
                <th>Unit Cost
                (B)	</th>
                <th>FOB Extended
                (C)</th>
                <th>By Qty./Weight</th>
                <th>Total Freight
                (D)</th>
                <th>Unit Freight
                (E = D/A)</th>
                <th>Unit Landed Cost
                (F=B+E)</th>
                
            </tr>
        </thead>
        <tbody id="productDataFreight">
        </tbody>
    </table>
</div>
