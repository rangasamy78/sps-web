<div class="tab-pane fade" id="Contact" role="tabpanel">
    <h5 class="">Contacts</h5>
    <div class="row">
        <input type="text" class="form-control" hidden name="sample_order_id" id="sample_order_id" value="{{ $sampleOrder->id }}">
        <input type="text" class="form-control" hidden name="customer_id" id="customer_id" value="{{ $customer->id }}">
    </div>
    <table class="datatables-basic table tables-basic border-top table-striped" id="sampleOrderContact">
        <thead class="table-header-bold">
            <tr>
                <th>&nbsp;</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phones</th>
                <th>Notes</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>