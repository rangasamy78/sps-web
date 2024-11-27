<div class="tab-pane fade show active" id="VisitProduct" role="tabpanel">
    <div class="row">
        <input type="text" class="form-control" hidden name="visit_id" id="visit_id" value="{{$visit->id}}">
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-basic table tables-basic border-top table-striped" id="visitProductDataTable">
            <thead class="table-header-bold">
                <tr>
                    <th>Item - Serial Num / Barcode Num / Lot/Block / Bundle / Supp. Ref </th>
                    <th>Slab Status</th>
                    <th>Serial Num</th>
                    <th>Location(Bin)</th>
                    <th><i class='bx bx-barcode fs-2'></i></th>
                    <th>Lot/Block</th>
                    <th>Bundle</th>
                    <th>Supp. Ref</th>
                    <th>Quantity</th>
                    <th>Curr. Quantity </th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                    <th>Tax</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>