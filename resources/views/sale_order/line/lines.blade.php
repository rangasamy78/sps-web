<div class="tab-pane fade show active" id="line" role="tabpanel">
    <h5 class="">Items</h5>
    <div class="row">
        <input type="text" class="form-control" hidden name="sales_order_id" id="sales_order_id" value="{{ $sale_order->id }}">
    </div>
    <table class="datatables-basic table tables-basic border-top table-striped" id="salesOrderline">
        <thead class="table-header-bold">
            <tr>
                <th>SO</th>
                <th>Item</th>
                {{-- <th>SKU</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Extended</th>
                <th>Tax</th>
                <th>Hide</th> --}}
            </tr>
        </thead>
        <tbody id="opportunityFileUploadRow">
        </tbody>
    </table>
</div>
