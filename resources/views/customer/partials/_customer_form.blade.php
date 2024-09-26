<div class="row">
    <div class="col-12 col-lg-12">
        <!-- Product Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Customer information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="{{ isset($customer) ? 'col-3' : 'col-4' }}">
                        <label class="form-label" for="customer-name">Customer Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        {!! Form::text('customer_name', null, ['class' => 'form-control' . ($errors->has('customer_name') ? ' is-invalid' : ''), 'id' => 'customer_name', 'placeholder' => 'Enter Customer Name']) !!}
                        <span class="text-danger error-text customer_name_error"></span>
                    </div>
                    @if(isset($customer))
                    <div class="col-3">
                        <label class="form-label" for="customer-code">Customer Code</label>
                        {!! Form::text('customer_code', null, ['class' => 'form-control', 'id' => 'customer_code', 'placeholder' => 'Enter Customer Code', 'disabled']) !!}
                    </div>
                    @endif
                    <div class="{{ isset($customer) ? 'col-3' : 'col-4' }}">
                        <label class="form-label" for="customer-type">Customer Type</label>
                        {!! Form::select('customer_type_id', $data['customerTypes'], null, ['class' => 'form-control select2', 'id' => 'customer_type_id', 'placeholder' => '--Select Customer Type--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="{{ isset($customer) ? 'col-3' : 'col-4' }}">
                        <label class="form-label" for="contact-name">Contact Name</label>
                        {!! Form::text('contact_name', null, ['class' => 'form-control', 'id' => 'contact_name', 'placeholder' => 'Enter Contact Name']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <label class="form-label" for="print_name">Print Name</label>
                        {!! Form::text('print_name', null, ['class' => 'form-control', 'id' => 'print_name', 'placeholder' => 'Enter Print Name']) !!}
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="parent_customer_id">parent_customer:</label>
                        {!! Form::select('parent_customer_id', $data['customers'], null, ['class' => 'form-control select2', 'id' => 'parent_customer_id', 'placeholder' => '--Select Customer--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="referred_by">Referred By</label>
                        {!! Form::select('referred_by_id', $data['customers'], null, ['class' => 'form-control select2', 'id' => 'referred_by_id', 'placeholder' => '--Select Customer--', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
            </div> <!-- card -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-4">
        <!-- Product Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Contact Information:</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <!-- Phone and Phone 2 in the same row -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="phone">Primary Phone</label>
                        {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Enter Primary Phone']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="phone2">Secondary Phone</label>
                        {!! Form::text('phone_2', null, ['class' => 'form-control', 'id' => 'phone_2', 'placeholder' => 'Enter Secondary Phone']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- Mobile and Fax in the same row -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="mobile">Mobile</label>
                        {!! Form::text('mobile', null, ['class' => 'form-control', 'id' => 'mobile', 'placeholder' => 'Enter Mobile']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="fax">Fax</label>
                        {!! Form::text('fax', null, ['class' => 'form-control', 'id' => 'fax', 'placeholder' => 'Enter Fax']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-12">
                        <label class="form-label" for="email">Email Address</label>
                        {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter Email']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-12">
                        <label class="form-label" for="accounting_email">Accounting Email</label>
                        {!! Form::text('accounting_email', null, ['class' => 'form-control', 'id' => 'accounting_email', 'placeholder' => 'Enter Accounting Email']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-12">
                        <label class="form-label" for="url">Website</label>
                        {!! Form::text('url', null, ['class' => 'form-control', 'id' => 'url', 'placeholder' => 'Enter Website']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <!-- Product Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Bill-To Address:</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <!-- Mobile and Fax in the same row -->
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="address">Address</label>
                        {!! Form::text('address', null, ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Enter Address']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="address_2">Suite / Unit#</label>
                        {!! Form::text('address_2', null, ['class' => 'form-control', 'id' => 'address_2', 'placeholder' => 'Enter Suite / Unit']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="city">City</label>
                        {!! Form::text('city', null, ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'Enter City']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="state">State</label>
                        {!! Form::text('state', null, ['class' => 'form-control', 'id' => 'state', 'placeholder' => 'Enter State']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="zip">Zip</label>
                        {!! Form::text('zip', null, ['class' => 'form-control', 'id' => 'zip', 'placeholder' => 'Enter Zip']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="county">County</label>
                        {!! Form::text('county', null, ['class' => 'form-control', 'id' => 'county', 'placeholder' => 'Enter County']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="country">Country</label>
                        {!! Form::select('country_id', $data['countries'], null, ['class' => 'form-control select2', 'id' => 'country_id', 'placeholder' => '--Select Country--', 'data-allow-clear' => 'true']) !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <!-- Product Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Shipping Address:</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-12 mb-3">
                        {!! Form::checkbox('same_as_address', 1, null, ['id' => 'same_as_address']) !!}
                        <label class="form-label" for="shipping_address"> Copy Bill to Address</label>
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="shipping_address">Address</label>
                        {!! Form::text('shipping_address', null, ['class' => 'form-control', 'id' => 'shipping_address', 'placeholder' => 'Enter Address']) !!}
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <label class="form-label" for="shipping_address_2">Suite / Unit#</label>
                        {!! Form::text('shipping_address_2', null, ['class' => 'form-control', 'id' => 'shipping_address_2', 'placeholder' => 'Enter Suite / Unit']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="shipping_city">City</label>
                        {!! Form::text('shipping_city', null, ['class' => 'form-control', 'id' => 'shipping_city', 'placeholder' => 'Enter City']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="shipping_state">State</label>
                        {!! Form::text('shipping_state', null, ['class' => 'form-control', 'id' => 'shipping_state', 'placeholder' => 'Enter State']) !!}
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <label class="form-label" for="shipping_zip">Zip</label>
                        {!! Form::text('shipping_zip', null, ['class' => 'form-control', 'id' => 'shipping_zip', 'placeholder' => 'Enter Zip']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="shipping_county">County</label>
                        {!! Form::text('shipping_county', null, ['class' => 'form-control', 'id' => 'shipping_county', 'placeholder' => 'Enter County']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="shipping_country">country</label>
                        {!! Form::select('shipping_country_id', $data['countries'], null, ['class' => 'form-control select2', 'id' => 'shipping_country_id', 'placeholder' => '--Select Country--', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-4">
        <!-- Product Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Location Info:</h5>
            </div>
            <div class="card-body">
                <div class="row ">
                    <!-- Phone and Phone 2 in the same row -->
                    <div class="col-12 col-lg-12">
                        <label class="form-label" for="parent_location_id">Parent Location <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        {!! Form::select('parent_location_id', $data['companies'], null, ['class' => 'form-control' . ($errors->has('parent_location_id') ? ' is-invalid' : '') . ' select2',  'id' => 'parent_location_id', 'placeholder' => '--Select Company--', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text parent_location_id_error"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- Mobile and Fax in the same row -->
                    <div class="col-12 col-lg-6 mt-3">
                        {!! Form::checkbox('multi_location', 1, null, ['id' => 'multi_location']) !!}
                        <label class="form-label" for="multi_location">Multi Location Customer</label>
                    </div>
                    <div class="col-12 col-lg-6 mt-3">
                        {!! Form::checkbox('generic_customer', 1, null, ['id' => 'generic_customer']) !!}
                        <label class="form-label" for="generic_customer">Generic Customer</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="email">Route Location:</label>
                        {!! Form::select('route_location_id', $data['counties'], null, ['class' => 'form-control select2', 'id' => 'route_location_id', 'placeholder' => 'Select County', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Sales Info:</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="sales_person_id">Primary Sales Person:</label>
                        {!! Form::select('sales_person_id', $data['users'], null, ['class' => 'form-control select2', 'id' => 'sales_person_id', 'placeholder' => '--Select User--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::label('secondary_sales_person_id', 'Secondary Sales Person:', ['class' => 'form-label']) !!}
                        {!! Form::select('secondary_sales_person_id', $data['users'], null, ['class' => 'form-control select2', 'id' => 'secondary_sales_person_id', 'placeholder' => '--Select User--', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- Mobile and Fax in the same row -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="price_list_label_id">Price Level: <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        {!! Form::select('price_list_label_id', $data['priceListLabels'], null, ['class' => 'form-control' . ($errors->has('price_list_label_id') ? ' is-invalid' : '') . ' select2', 'id' => 'price_list_label_id', 'placeholder' => 'Select Price Level', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text price_list_label_id_error"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- Mobile and Fax in the same row -->
                    <div class="col-12 col-lg-6">
                        {!! Form::checkbox('is_tax_exempt', 1, null, ['id' => 'is_tax_exempt']) !!}
                        {!! Form::label('is_tax_exempt', 'Tax Exempt', ['class' => 'form-label']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::label('tax_exempt_reason_id', 'Tax Exempt Reason:', ['class' => 'form-label']) !!}
                        {!! Form::select('tax_exempt_reason_id', $data['taxExemptReasons'], null, ['class' => 'form-control select2', 'id' => 'tax_exempt_reason_id', 'placeholder' => 'Select Reason', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- Mobile and Fax in the same row -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label" for="sales_tax_id">Sales Tax:</label>
                        {!! Form::label('sales_tax_id', 'Sales Tax:', ['class' => 'form-label']) !!}
                        {!! Form::select('sales_tax_id', $data['users'], null, ['class' => 'form-control select2', 'id' => 'sales_tax_id', 'placeholder' => 'Select Sales Tax', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="form-label" for="payment_terms_id">Payment Terms: <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        {!! Form::select('payment_terms_id', $data['accountPaymentTerms'], null, ['class' => 'form-control' . ($errors->has('payment_terms_id') ? ' is-invalid' : '') . ' select2', 'id' => 'payment_terms_id', 'placeholder' => 'Select Payment Terms', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text payment_terms_id_error"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- Mobile and Fax in the same row -->
                    <div class="col-12 col-lg-6">
                        {!! Form::label('exempt_certificate_no', 'Exempt Certificate #:', ['class' => 'form-label']) !!}
                        {!! Form::text('exempt_certificate_no', null, ['class' => 'form-control', 'id' => 'exempt_certificate_no', 'placeholder' => 'Enter Certificate Number']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::label('exempt_expiry_date', 'Exempt Expiry Date:', ['class' => 'form-label']) !!}
                        {!! Form::date('exempt_expiry_date', null, ['class' => 'form-control', 'id' => 'exempt_expiry_date']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        {!! Form::label('about_us_option_id', 'How did you hear about us?', ['class' => 'form-label']) !!}
                        {!! Form::select('about_us_option_id', $data['aboutUsOptions'], null, ['class' => 'form-control select2', 'id' => 'about_us_option_id', 'placeholder' => 'Select Option', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::label('project_type_id', 'Project Type:', ['class' => 'form-label']) !!}
                        {!! Form::select('project_type_id', $data['projectTypes'], null, ['class' => 'form-control select2', 'id' => 'project_type_id', 'placeholder' => 'Select Project Type', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        {!! Form::label('end_use_segment_id', 'End Use Segment:', ['class' => 'form-label']) !!}
                        {!! Form::select('end_use_segment_id', $data['endUseSegments'], null, ['class' => 'form-control select2', 'id' => 'end_use_segment_id', 'placeholder' => 'Select Segment', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::label('default_fulfillment_method_id', 'Default Fulfillment Method:', ['class' => 'form-label']) !!}
                        {!! Form::select('default_fulfillment_method_id', [
                            '' => 'Select Fulfillment Method',
                            'delivery' => 'Delivery',
                            'pickup' => 'Pickup'
                        ], null, ['class' => 'form-control select2', 'id' => 'default_fulfillment_method_id', 'data-allow-clear' => 'true']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Accounting Controls:</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12 col-lg-12">
                                {!! Form::checkbox('is_po_required', 1, null, ['id' => 'is_po_required']) !!}
                                {!! Form::label('is_po_required', 'PO REQUIRED: A PO is required to process any Sales Orders for this customer.', ['class' => 'form-label']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-12">
                                {!! Form::checkbox('apply_finance_charge', 1, null, ['id' => 'apply_finance_charge']) !!}
                                {!! Form::label('apply_finance_charge', 'APPLY FINANCE CHARGES: Finance charges will be applied for late payments from this customer.', ['class' => 'form-label']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-12">
                                {!! Form::label('preferred_document_id', 'The preferred way of sending documents to this customer is:', ['class' => 'form-label']) !!}
                                {!! Form::select('preferred_document_id', [
                                    '' => 'Select Preferred Document',
                                    'Fax' => 'Fax',
                                    'Email' => 'Email',
                                    'Mail' => 'Mail',
                                    'Text' => 'Text'
                                ], null, ['class' => 'form-control select2', 'id' => 'preferred_document_id', 'data-allow-clear' => 'true']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-12">
                                {!! Form::label('grace_period', '# of days for Grace Period after which the invoices are considered for past due lock:', ['class' => 'form-label']) !!}
                                {!! Form::text('grace_period', null, ['class' => 'form-control', 'id' => 'grace_period', 'placeholder' => 'Enter Grace Period']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('hold_days', '# of days for hold:', ['class' => 'form-label']) !!}
                                {!! Form::text('hold_days', null, ['class' => 'form-control', 'id' => 'hold_days', 'placeholder' => 'Enter Hold Days']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('since_date', 'Customer Since:', ['class' => 'form-label']) !!}
                                {!! Form::date('since_date', null, ['class' => 'form-control', 'id' => 'since_date']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('tax_number', 'EIN Number:', ['class' => 'form-label']) !!}
                                {!! Form::text('tax_number', null, ['class' => 'form-control', 'id' => 'tax_number', 'placeholder' => 'Enter EIN Number']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Credit Controls:</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('credit_limit', 'Credit Limit:', ['class' => 'form-label']) !!}
                                {!! Form::text('credit_limit', null, ['class' => 'form-control', 'id' => 'credit_limit', 'placeholder' => 'Enter Credit Limit']) !!}
                            </div>
                            <div class="col-12 col-lg-6">
                                {!! Form::checkbox('is_credit_lock', 1, null, ['id' => 'is_credit_lock']) !!}
                                {!! Form::label('is_credit_lock', 'Is Credit Lock Exempt', ['class' => 'form-label']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-12">
                                {!! Form::label('sales_alert_note', 'Sales Alert Note:', ['class' => 'form-label']) !!}
                                {!! Form::text('sales_alert_note', null, ['class' => 'form-control', 'id' => 'sales_alert_note', 'placeholder' => 'Enter Sales Alert Note']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-12">
                                {!! Form::label('sales_lock_note', 'Sales Lock Note:', ['class' => 'form-label']) !!}
                                {!! Form::text('sales_lock_note', null, ['class' => 'form-control', 'id' => 'sales_lock_note', 'placeholder' => 'Enter Sales Lock Note']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Customer Login:</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-12 col-lg-12">
                            {!! Form::checkbox('is_allow_login', 1, null, ['id' => 'is_allow_login']) !!}
                            {!! Form::label('is_allow_login', 'Allow access to Customer Login Module', ['class' => 'form-label']) !!}
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-12">
                                {!! Form::label('username', 'Username:', ['class' => 'form-label']) !!}
                                {!! Form::text('username', null, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'id' => 'username', 'placeholder' => 'Enter Username']) !!}
                                <span class="text-danger error-text username_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-12">
                                {!! Form::label('password', 'Password:', ['class' => 'form-label']) !!}
                                {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Enter Password']) !!}
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        {!! Form::label('delivery_instructions', 'Special / Delivery Instructions:', ['class' => 'form-label']) !!}
                        {!! Form::textarea('delivery_instructions', null, ['class' => 'form-control', 'id' => 'delivery_instructions', 'placeholder' => 'Enter Special / Delivery Instructions', 'rows' => 4, 'cols' => 50]) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::label('collection_notes', 'Collection Notes:', ['class' => 'form-label']) !!}
                        {!! Form::textarea('collection_notes', null, ['class' => 'form-control', 'id' => 'collection_notes', 'placeholder' => 'Enter Collection Notes','rows' => 4, 'cols' => 50]) !!}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        {!! Form::checkbox('is_copy_sale_order', 1, null, ['id' => 'is_copy_sale_order']) !!}
                        {!! Form::label('is_copy_sale_order', 'Copy to all Sale Orders / Quotes for this customer', ['class' => 'form-label']) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        {!! Form::label('internal_notes', 'Internal Notes:', ['class' => 'form-label']) !!}
                        {!! Form::textarea('internal_notes', null, ['class' => 'form-control', 'id' => 'internal_notes', 'placeholder' => 'Enter Internal Notes', 'rows' => 4, 'cols' => 50]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

