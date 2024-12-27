<div class="tab-pane" id="BillToContact" role="tabpanel">
    <h5 class="">Bill To Contacts</h5>
    <div class="row">
        <input type="text" class="form-control" hidden name="sales_order_id" id="sales_order_id" value="{{ $sale_order->id }}">
    </div>
    <table class="datatables-basic table tables-basic border-top table-striped" id="sales_orderBillToContact">
        <thead class="table-header-bold">
            <tr>
                <th>&nbsp;</th>
                <th>Name</th>
                <th>Address</th>
                <th>Lot/Subdivision</th>
                <th>Phones</th>
                <th>Fax/Email</th>
                <th>Notes</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="opportunityFileUploadRow">
        </tbody>
    </table>
</div>
