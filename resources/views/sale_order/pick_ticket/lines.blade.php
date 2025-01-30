<div class="tab-pane fade show active" id="line" role="tabpanel">
    <h5 class="">Products/Services</h5>
    <form id="pickTicketForm" name="pickTicketForm" class="form-horizontal">
    <div class="row">
        <input type="text" class="form-control" hidden name="sales_order_id" id="sales_order_id" value="{{ $sale_order->id }}">
    </div>
    <table class="datatables-basic table tables-basic border-top table-striped" id="salesOrderline">
        <thead class="table-header-bold">
            <tr>
                <th><input type="checkbox" class="form-check-input"
                    style="transform:scale(1.2)" id="select-all" checked></th>
                <th>SO</th>
                <th>Product/Service</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>UnInvoiced Qty</th>
                <th>Pick Qty</th>
                <th>Unit Price</th>
                <th>Extended</th>
                <th>Tax</th>
                <th>Hide<input type="checkbox" class="form-check-input"
                    style="transform:scale(1.2)" id="hide-all"></th>
            </tr>
        </thead>
        <tbody id="opportunityFileUploadRow">
        </tbody>
    </table>
</div>

