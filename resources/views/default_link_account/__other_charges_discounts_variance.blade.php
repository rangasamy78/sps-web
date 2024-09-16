<div class="card mb-6">
    <div class="card-header header-elements">
        <h5 class="mb-0 me-2">Other Charges, Discounts & Variances</h5>
    </div>
    <div class="card-body">
        <form id="otherChargeAccountForm" name="otherChargeAccountForm" class="form-horizontal" method="POST">
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-other-charges-in-po-sipl">Other Charges in PO & SIPL</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="{{ $data['otherCharge']['id'] ?? '' }}">
                            <select id="other_charges_in_po_sipl_id" class="form-select select2" name="other_charges_in_po_sipl_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['otherCharge']['other_charges_in_po_sipl_id']) ? $data['otherCharge']['other_charges_in_po_sipl_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-payments-discounts">Payments Discounts</label>
                        <div class="col-sm-9">
                            <select id="payments_discount_id" class="form-select select2" name="payments_discount_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['otherCharge']['payments_discount_id']) ? $data['otherCharge']['payments_discount_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-6 mt-3">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-restocking-fees-on-pur-returns">Restocking Fees on Pur. Returns</label>
                        <div class="col-sm-9">
                            <select id="restocking_fees_on_pur_return_id" class="form-select select2" name="restocking_fees_on_pur_return_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['otherCharge']['restocking_fees_on_pur_return_id']) ? $data['otherCharge']['restocking_fees_on_pur_return_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-freight-account-on-purchases">Freight Account on Purchases</label>
                        <div class="col-sm-9">
                            <select id="freight_account_on_purchase_id" class="form-select select2" name="freight_account_on_purchase_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['otherCharge']['freight_account_on_purchase_id']) ? $data['otherCharge']['freight_account_on_purchase_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-supplier-invoice-variance">Supplier Invoice - Variance</label>
                        <div class="col-sm-9">
                            <select id="supplier_invoice_variance_id" class="form-select select2" name="supplier_invoice_variance_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['otherCharge']['supplier_invoice_variance_id']) ? $data['otherCharge']['supplier_invoice_variance_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-supp-credit-memos-variance">Supp. Credit Memos - Variance</label>
                        <div class="col-sm-9">
                            <select id="supp_credit_memos_variance_id" class="form-select select2" name="supp_credit_memos_variance_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['otherCharge']['supp_credit_memos_variance_id']) ? $data['otherCharge']['supp_credit_memos_variance_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
