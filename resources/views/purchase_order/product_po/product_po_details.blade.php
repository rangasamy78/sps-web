<div class="row">
    <div class="col">
        <input type="hidden" name="po_id" id="po_id" value="{{ $purchase_order->id ?? '' }}">
        <table class="datatables-basic table tables-basic border-top table-striped" id="supplierInvoiceTable">
            <thead class="table-header-bold">
                <tr class="odd gradeX">
                    <th>SKU / Generic SKU</th>
                    <th>Product</th>
                    <th></th>
                    <th></th>
                    <th>Cust/Loc Ref</th>
                    <th>Qty</th>
                    <th>Fulfilled </th>
                    <th>Balance </th>
                    <th>Unit Price </th>
                    <th>Extended </th>
                    <th></th>
                </tr>
            </thead>

        </table>
    </div>
</div>