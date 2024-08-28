<div class="card mb-6">
    <div class="card-header header-elements">
        <h5 class="mb-0 me-2">Sales</h5>
    </div>
    <div class="card-body">
        <form id="saleAccountForm" name="saleAccountForm" class="form-horizontal" method="POST">
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-customer-ar">Customer - AR</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="{{ $data['sale']['id'] ?? '' }}">
                            <select id="customer_ar_id" class="form-select select2" name="customer_ar_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['sale']['customer_ar_id']) ? $data['sale']['customer_ar_id'] : '') @endphp
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
                        <label class="col-sm-3 text-sm-end" for="formtabs-sales-income-product">Sales Income - Product</label>
                        <div class="col-sm-9">
                            <select id="sales_income_product_id" class="form-select select2" name="sales_income_product_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['sale']['sales_income_product_id']) ? $data['sale']['sales_income_product_id'] : '') @endphp
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
                        <label class="col-sm-3 text-sm-end" for="formtabs-sales-income-service">Sales Income - Service</label>
                        <div class="col-sm-9">
                            <select id="sales_income_service_id" class="form-select select2" name="sales_income_service_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['sale']['sales_income_service_id']) ? $data['sale']['sales_income_service_id'] : '') @endphp
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
                        <label class="col-sm-3 text-sm-end" for="formtabs-cogs-account">COGS Account</label>
                        <div class="col-sm-9">
                            <select id="cogs_account_id" class="form-select select2" name="cogs_account_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['sale']['cogs_account_id']) ? $data['sale']['cogs_account_id'] : '') @endphp
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
                        <label class="col-sm-3 text-sm-end" for="formtabs-restocking-fee-income-account">Restocking Fee Income Account</label>
                        <div class="col-sm-9">
                            <select id="restocking_fee_income_account_id" class="form-select select2" name="restocking_fee_income_account_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['sale']['restocking_fee_income_account_id']) ? $data['sale']['restocking_fee_income_account_id'] : '') @endphp
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
                        <label class="col-sm-3 text-sm-end" for="formtabs-sales-tax-liability-account">Sales Tax liability Account</label>
                        <div class="col-sm-9">
                            <select id="sales_tax_liability_account_id" class="form-select select2" name="sales_tax_liability_account_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['sale']['sales_tax_liability_account_id']) ? $data['sale']['sales_tax_liability_account_id'] : '') @endphp
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
                        <label class="col-sm-3 text-sm-end" for="formtabs-sales-discounts">Sales Discounts</label>
                        <div class="col-sm-9">
                            <select id="sales_discount_id" class="form-select select2" name="sales_discount_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['sale']['sales_discount_id']) ? $data['sale']['sales_discount_id'] : '') @endphp
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
