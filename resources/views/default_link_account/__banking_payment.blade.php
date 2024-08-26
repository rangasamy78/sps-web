<div class="card mb-6">
    <div class="card-header header-elements">
        <h5 class="mb-0 me-2">Banking - Payments</h5>
    </div>
    <div class="card-body">
        <form id="bankingPaymentForm" name="bankingPaymentForm" class="form-horizontal" method="POST">
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-supplier-payment-cash-account">Retained Earnings</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="{{ $data['bankingPayment']['id'] ?? '' }}">
                            <select id="supplier_payment_cash_account_id" class="form-select select2" name="supplier_payment_cash_account_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['bankingPayment']['supplier_payment_cash_account_id']) ? $data['bankingPayment']['supplier_payment_cash_account_id'] : '') @endphp
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
                        <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-vendor-payment-cash-account">Vendor Payment - Cash Account</label>
                        <div class="col-sm-9">
                            <select id="vendor_payment_cash_account_id" class="form-select select2" name="vendor_payment_cash_account_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['bankingPayment']['vendor_payment_cash_account_id']) ? $data['bankingPayment']['vendor_payment_cash_account_id'] : '') @endphp
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
                        <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-customer-payment-cash-account">Customer Payment - Cash Account</label>
                        <div class="col-sm-9">
                            <select id="customer_payment_cash_account_id" class="form-select select2" name="customer_payment_cash_account_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['bankingPayment']['customer_payment_cash_account_id']) ? $data['bankingPayment']['customer_payment_cash_account_id'] : '') @endphp
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
                        <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-miscellaneous-expense">Miscellaneous Expense</label>
                        <div class="col-sm-9">
                            <select id="miscellaneous_expense_id" class="form-select select2" name="miscellaneous_expense_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['bankingPayment']['miscellaneous_expense_id']) ? $data['bankingPayment']['miscellaneous_expense_id'] : '') @endphp
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