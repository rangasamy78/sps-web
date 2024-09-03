<div class="card mb-6">
    <div class="card-header header-elements">
        <h5 class="mb-0 me-2">Banking - Receipts</h5>
    </div>
    <div class="card-body">
        <form id="bankingReceiptForm" name="bankingReceiptForm" class="form-horizontal" method="POST">
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-receipt-cash-account">Account for New Products</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="{{ $data['bankingReceipt']['id'] ?? '' }}">
                            <select id="receipt_cash_account_id" class="form-select select2" name="receipt_cash_account_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['bankingReceipt']['receipt_cash_account_id']) ? $data['bankingReceipt']['receipt_cash_account_id'] : '') @endphp
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
                        <label class="col-sm-3 text-sm-end" for="formtabs-miscellaneous-income">Miscellaneous Income</label>
                        <div class="col-sm-9">
                            <select id="miscellaneous_income_id" class="form-select select2" name="miscellaneous_income_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['bankingReceipt']['miscellaneous_income_id']) ? $data['bankingReceipt']['miscellaneous_income_id'] : '') @endphp
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
