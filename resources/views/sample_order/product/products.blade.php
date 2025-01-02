<div class="tab-pane fade show active" id="sampleOrderProduct" role="tabpanel">
    <div class="row">
        <input type="text" class="form-control" hidden name="sample_order_id" id="sample_order_id" value="{{$sampleOrder->id}}">
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-basic table tables-basic border-top table-striped" id="sampleOrderProductDataTable">
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

    <div class="row mt-3">
        <div class="col">
            <div class="d-flex justify-content-end">
                <label class="text-dark fw-bold mt-2">Sub Total:</label>
                <span class="mt-2 ms-4 fw-bold" id="sample_order_sub_total">$</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-end">
                <label class="text-dark fw-bold mt-2">
                    Tax
                    @if(!empty($taxCode?->tax_code_label))
                    ({{ $taxCode->tax_code_label }} - {{ $taxAmount?->tax_code_total ?? '0' }}%):
                    @else
                    ()
                    @endif
                </label>
                <input type="hidden" readonly class="form-control  border-0 w-25" id="tax_code_amount" name="tax_code_amount" value="{{$taxAmount?->tax_code_total ?? '0' }}">
                <span class="mt-2 ms-4 fw-bold" id="tax_code_amount_label">$</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-end">
                <label class="text-dark fw-bold mt-2">Total:</label>
                <span class="mt-2 ms-4 fw-bold" id="sample_order_total">$</span>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-secondary btn-sm"> + Visit</button>
            <button class="btn btn-secondary btn-sm"> + Ouote</button>
            <button class="btn btn-secondary btn-sm"> + Hold</button>
            <button class="btn btn-secondary btn-sm"> + Sale Order</button>
        </div>
    </div>
</div>