<div class="tab-pane fade" id="quoteContact" role="tabpanel">
    <h5 class="">Contacts</h5>
    <div class="row">
        <input type="text" class="form-control" hidden name="quote_id" id="quote_id" value="{{ $quote->id }}">
    </div>
    <table class="datatables-basic table tables-basic border-top table-striped" id="quoteContactDatatable">
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
        <tbody>
        </tbody>
    </table>
</div>