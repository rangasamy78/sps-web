<div class="tab-pane fade show active" id="line" role="tabpanel">
    <h5 class="">Items</h5>
    <div class="row">
        <input type="text" class="form-control" hidden name="sales_order_id" id="sales_order_id"
            value="{{ $sale_order->id }}">
    </div>
    <table class="datatables-basic table tables-basic border-top table-striped" id="salesOrderline">
        <thead class="table-header-bold">
            <tr>
                <th>SO</th>
                <th>Item</th>
                <th>SKU</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Extended</th>
                <th>Tax</th>
                <th>Hide</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="opportunityFileUploadRow">
        </tbody>
    </table>

    <div class="table-responsive">
        <table class="table m-0 table-borderless">
            <tbody>
                <tr>
                    <td class="align-top pe-6 ps-0 py-6 text-body">

                    </td>
                    <td class="px-0 py-6 w-px-100">
                        <p class="mb-2">Subtotal:</p>
                        <p class="mb-2">Discount:</p>
                        <p class="mb-2">Merchant Fee:</p>
                        <p class="mb-2 border-bottom pb-2">Delivery Fee:</p>
                        <p class="mb-0">Total:</p>
                    </td>
                    <td class="text-end px-0 py-6 w-px-100 fw-medium text-heading">
                        <p class="fw-medium mb-2">$374.00</p>
                        <p class="fw-medium mb-2">$0.00</p>
                        <p class="fw-medium mb-2">$0.00</p>
                        <p class="fw-medium mb-2 border-bottom pb-2">$0.00</p>
                        <p class="fw-medium mb-0">$374.00</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
