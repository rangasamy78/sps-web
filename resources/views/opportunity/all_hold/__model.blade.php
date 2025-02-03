<!-- Modal -->
<div class="modal fade" id="searchListHoldModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="holdModalHeader"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="opportunity_id" name="opportunity_id">
                <div class="table-responsive">
                    <table class="datatables-basic table tables-basic border-top table-striped" id="holdProductListDataTable">
                        <thead class="table-header-bold">
                            <tr>
                                <th>Item</th>
                                <th>Serial Num</th>
                                <th>Bar Code</th>
                                <th>Lot/Block</th>
                                <th>Bundle</th>
                                <th>Supp. Ref</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Amount</th>
                                <th>Tax</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <label class="text-dark fw-bold mt-2">Sub Total:</label>
                            <span class="mt-2 ms-4 fw-bold" id="hold_sub_total">$</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <label class="text-dark fw-bold mt-2" id="taxCodeText">
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
                            <span class="mt-2 ms-4 fw-bold" id="hold_total">$</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" modal-footer">
                <!-- Footer content -->
            </div>
        </div>
    </div>
</div>