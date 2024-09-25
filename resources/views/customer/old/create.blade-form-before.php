@extends('layouts.admin')

@section('title', 'Add Customer')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Add Customer</span></h4>

            <div class="app-ecommerce">
                <form id="customerForm" name="customerForm" method="POST" action="{{ route('customers.store') }}"
                    class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <!-- Product Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-tile mb-0">Customer information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <label class="form-label" for="customer-name">Customer Name</label>
                                                {!! Form::text('customer_name', null, ['class' => 'form-control' . ($errors->has('customer_name') ? ' is-invalid' : ''), 'id' => 'customer_name', 'placeholder' => 'Enter Customer Name']) !!}
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label" for="customer-code">Customer Code</label>
                                            <input type="text" class="form-control" id="customer_code"
                                                placeholder="Enter Customer Code" name="customer_code" />
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label" for="customer-type">Customer Type</label>
                                            <select class="form-control select2" id="customer_type_id"
                                                name="customer_type_id" data-allow-clear="true">
                                                <option value="">--Select Customer Type-- </option>
                                                @foreach ($customerTypes as $key => $customerType)
                                                    <option value="{{ $key }}">{{ $customerType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label" for="contact-name">Contact Name</label>
                                            <input type="text" class="form-control" id="contact_name"
                                                placeholder="Enter Contact Name" name="contact_name" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <label class="form-label" for="print_name">Print Name</label>
                                            <input type="text" class="form-control" id="print_name"
                                                placeholder="Enter Print Name" name="print_name" />
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label" for="parent_customer_id">parent_customer:</label>
                                            <select class="form-control select2" id="parent_customer_id"
                                                name="parent_customer_id" data-allow-clear="true">
                                                <option value="">--Select Customer-- </option>
                                                @foreach ($customers as $key => $customer)
                                                    <option value="{{ $key }}">{{ $customer }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label" for="referred_by">Referred By</label>
                                            <select class="form-control select2" id="referred_by_id" name="referred_by_id"
                                                data-allow-clear="true">
                                                <option value="">--Select Customer-- </option>
                                                @foreach ($customers as $key => $customer)
                                                    <option value="{{ $key }}">{{ $customer }}</option>
                                                @endforeach
                                            </select>
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
                                            <input type="text" class="form-control" id="phone"
                                                placeholder="Enter Primary Phone" name="phone" />
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="phone2">Secondary Phone</label>
                                            <input type="text" class="form-control" id="phone_2"
                                                placeholder="Enter Secondary Phone" name="phone_2" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Mobile and Fax in the same row -->
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="mobile">Mobile</label>
                                            <input type="text" class="form-control" id="mobile"
                                                placeholder="Enter Mobile" name="mobile" />
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="fax">Fax</label>
                                            <input type="text" class="form-control" id="fax"
                                                placeholder="Enter Fax" name="fax" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-12">
                                            <label class="form-label" for="email">Email Address</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Enter Email" name="email" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-12">
                                            <label class="form-label" for="accounting_email">Accounting Email</label>
                                            <input type="text" class="form-control" id="accounting_email"
                                                placeholder="Enter Accounting Email" name="accounting_email" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-12">
                                            <label class="form-label" for="url">Website</label>
                                            <input type="text" class="form-control" id="url"
                                                placeholder="Enter Website" name="url" />
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
                                            <input type="text" class="form-control" id="address"
                                                placeholder="Enter Address" name="address" />
                                        </div>
                                        <div class="col-12 col-lg-12 mb-3">
                                            <label class="form-label" for="address_2">Suite / Unit#</label>
                                            <input type="text" class="form-control" id="address_2"
                                                placeholder="Enter Suite / Unit" name="address_2" />
                                        </div>
                                        <div class="col-12 col-lg-4 mb-3">
                                            <label class="form-label" for="city">City</label>
                                            <input type="text" class="form-control" id="city"
                                                placeholder="Enter City" name="city" />
                                        </div>
                                        <div class="col-12 col-lg-4 mb-3">
                                            <label class="form-label" for="state">State</label>
                                            <input type="text" class="form-control" id="state"
                                                placeholder="Enter State" name="state" />
                                        </div>
                                        <div class="col-12 col-lg-4 mb-3">
                                            <label class="form-label" for="zip">Zip</label>
                                            <input type="text" class="form-control" id="zip"
                                                placeholder="Enter Zip" name="zip" />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label class="form-label" for="county">County</label>
                                            <input type="text" class="form-control" id="county"
                                                placeholder="Enter County" name="county" />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label class="form-label" for="country">Country</label>
                                            <select class="form-control select2" id="country_id" name="country_id"
                                                data-allow-clear="true">
                                                <option value="">--Select Country-- </option>
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $key }}">{{ $country }}</option>
                                                @endforeach
                                            </select>
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
                                            <input type="checkbox" id="same_as_address" name="same_as_address"
                                                value="1" />
                                            <label class="form-label" for="shipping_address"> Copy Bill to Address</label>
                                        </div>
                                        <div class="col-12 col-lg-12 mb-3">
                                            <label class="form-label" for="shipping_address">Address</label>
                                            <input type="text" class="form-control" id="shipping_address"
                                                placeholder="Enter Address" name="shipping_address" />
                                        </div>
                                        <div class="col-12 col-lg-12 mb-3">
                                            <label class="form-label" for="shipping_address_2">Suite / Unit#</label>
                                            <input type="text" class="form-control" id="shipping_address_2"
                                                placeholder="Enter Suite / Unit" name="shipping_address_2" />
                                        </div>
                                        <div class="col-12 col-lg-4 mb-3">
                                            <label class="form-label" for="shipping_city">City</label>
                                            <input type="text" class="form-control" id="shipping_city"
                                                placeholder="Enter City" name="shipping_city" />
                                        </div>
                                        <div class="col-12 col-lg-4 mb-3">
                                            <label class="form-label" for="shipping_state">State</label>
                                            <input type="text" class="form-control" id="shipping_state"
                                                placeholder="Enter State" name="shipping_state" />
                                        </div>
                                        <div class="col-12 col-lg-4 mb-3">
                                            <label class="form-label" for="shipping_zip">Zip</label>
                                            <input type="text" class="form-control" id="shipping_zip"
                                                placeholder="Enter Zip" name="shipping_zip" />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label class="form-label" for="shipping_county">County</label>
                                            <input type="text" class="form-control" id="shipping_county"
                                                placeholder="Enter County" name="shipping_county" />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label class="form-label" for="shipping_country">country</label>
                                            <select class="form-control select2" id="shipping_country_id"
                                                name="shipping_country_id" data-allow-clear="true">
                                                <option value="">--Select Country--</option>
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $key }}">{{ $country }}</option>
                                                @endforeach
                                            </select>
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
                                            <label class="form-label" for="phone">Parent Location</label>
                                            <select class="form-control select2" id="parent_location_id"
                                                name="parent_location_id" data-allow-clear="true">
                                                <option value="">--Select Company-- </option>
                                                @foreach ($companies as $key => $company)
                                                    <option value="{{ $key }}">{{ $company }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Mobile and Fax in the same row -->
                                        <div class="col-12 col-lg-6 mt-3">
                                            <input type="checkbox" id="multi_location" name="multi_location"
                                                value="1" />
                                            <label class="form-label" for="multi_location">Multi Location Customer</label>
                                        </div>
                                        <div class="col-12 col-lg-6 mt-3">
                                            <input type="checkbox" id="generic_customer" name="generic_customer"
                                                value="1" />
                                            <label class="form-label" for="generic_customer">Generic Customer</label>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="email">Route Location:</label>
                                            <select class="form-control select2" id="route_location_id"
                                                name="route_location_id" data-allow-clear="true">
                                                <option value="">Select County</option>
                                                @foreach ($counties as $key => $county)
                                                    <option value="{{ $key }}">{{ $county }}</option>
                                                @endforeach
                                            </select>
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
                                        <!-- Mobile and Fax in the same row -->
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="sales_person_id">Primary Sales Person:</label>
                                            <select class="form-control select2" id="sales_person_id"
                                                name="sales_person_id" data-allow-clear="true">
                                                <option value="">--Select User-- </option>
                                                @foreach ($users as $key => $user)
                                                    <option value="{{ $key }}">{{ $user }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="secondary_sales_person_id">Secondary Sales
                                                Person:</label>
                                            <select class="form-control select2" id="secondary_sales_person_id"
                                                name="secondary_sales_person_id" data-allow-clear="true">
                                                <option value="">--Select User-- </option>
                                                @foreach ($users as $key => $user)
                                                    <option value="{{ $key }}">{{ $user }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Mobile and Fax in the same row -->
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="price_list_label_id">Price Level:</label>
                                            <select class="form-control select2" id="price_list_label_id"
                                                name="price_list_label_id" data-allow-clear="true">
                                                <option value="">Select Referred By</option>
                                                @foreach ($priceListLabels as $key => $priceListLabel)
                                                    <option value="{{ $key }}">{{ $priceListLabel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Mobile and Fax in the same row -->
                                        <div class="col-12 col-lg-6">
                                            <input type="checkbox" id="is_tax_exempt" name="is_tax_exempt"
                                                value="1" />
                                            <label class="form-label" for="is_tax_exempt">Tax Exempt</label>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="tax_exempt_reason_id">Tax Exempt
                                                Reason:</label>
                                            <select class="form-control select2" id="tax_exempt_reason_id"
                                                name="tax_exempt_reason_id" data-allow-clear="true">
                                                <option value="">Select Referred By</option>
                                                @foreach ($taxExemptReasons as $key => $taxExemptReason)
                                                    <option value="{{ $key }}">{{ $taxExemptReason }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Mobile and Fax in the same row -->
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="sales_tax_id">Sales Tax:</label>
                                            <select class="form-control select2" id="sales_tax_id" name="sales_tax_id"
                                                data-allow-clear="true">
                                                <option value="">Select Referred By</option>
                                                @foreach ($taxExemptReasons as $key => $taxExemptReason)
                                                    <option value="{{ $key }}">{{ $taxExemptReason }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label class="form-label" for="payment_terms_id">Payment Terms:</label>
                                            <select class="form-control select2" id="payment_terms_id"
                                                name="payment_terms_id" data-allow-clear="true">
                                                <option value="">Select Payment Terms</option>
                                                @foreach ($accountPaymentTerms as $key => $accountPaymentTerm)
                                                    <option value="{{ $key }}">{{ $accountPaymentTerm }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Mobile and Fax in the same row -->
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="multi_location">Exempt Certificate #:</label>
                                            <input type="text" class="form-control" id="exempt_certificate_no"
                                                placeholder="Enter Hold Days" name="exempt_certificate_no" />
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="exempt_expiry_date">Exempt Expiry Date:</label>
                                            <input type="date" class="form-control" id="exempt_expiry_date"
                                                placeholder="Enter Hold Days" name="exempt_expiry_date" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="multi_location">How did you hear about
                                                us?</label>
                                            <select class="form-control select2" id="about_us_option_id"
                                                name="about_us_option_id" data-allow-clear="true">
                                                <option value="">Select About us</option>
                                                @foreach ($aboutUsOptions as $key => $aboutUsOption)
                                                    <option value="{{ $key }}">{{ $aboutUsOption }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="project_type_id">Project Type:</label>
                                            <select class="form-control select2" id="project_type_id"
                                                name="project_type_id" data-allow-clear="true">
                                                <option value="">Select Project Type</option>
                                                @foreach ($projectTypes as $key => $projectType)
                                                    <option value="{{ $key }}">{{ $projectType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="multi_location">End use Segment:</label>
                                            <select class="form-control select2" id="end_use_segment_id"
                                                name="end_use_segment_id" data-allow-clear="true">
                                                <option value="">Select Referred By</option>
                                                @foreach ($endUseSegments as $key => $endUseSegment)
                                                    <option value="{{ $key }}">{{ $endUseSegment }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="default_fulfillment_method_id">Default
                                                Fulfillment Method:</label>
                                            <select class="form-control select2" id="default_fulfillment_method_id"
                                                name="default_fulfillment_method_id" data-allow-clear="true">
                                                <option value="">Select Referred By</option>
                                                <option value="delivery">Delivery</option>
                                                <option value="pickup">Pickup</option>
                                            </select>
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
                                                    <input type="checkbox" id="is_po_required" name="is_po_required"
                                                        value="1" />
                                                    <label class="form-label" for="is_po_required">PO REQUIRED: A PO is
                                                        required to process any Sales Orders for this customer.</label>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-12">
                                                    <input type="checkbox" id="apply_finance_charge"
                                                        name="apply_finance_charge" value="1" />
                                                    <label class="form-label" for="apply_finance_charge">APPLY FINANCE
                                                        CHARGES: Finance charges will be applied for late payments from this
                                                        customer.</label>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-12">
                                                    <label class="form-label" for="po_required">The preferred way of
                                                        sending documents to this customer is:</label>
                                                    <select class="form-control select2" id="preferred_document_id"
                                                        name="preferred_document_id" data-allow-clear="true">
                                                        <option value="">Select Preferred Document</option>
                                                        <option value="Fax">Fax</option>
                                                        <option value="Email">Email</option>
                                                        <option value="Mail">Mail</option>
                                                        <option value="Text">Text</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-12">
                                                    <label class="form-label" for="grace_period"># of days for Grace
                                                        Period after which the invoices are considered for past due
                                                        lock:</label>
                                                    <input type="text" class="form-control" id="grace_period"
                                                        placeholder="Enter Grace Period" name="grace_period" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <label class="form-label" for="hold_days"># of days for hold:</label>
                                                    <input type="text" class="form-control" id="hold_days"
                                                        placeholder="Enter Hold Days" name="hold_days" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <label class="form-label" for="po_required">Customer Since:</label>
                                                    <input type="date" class="form-control" id="since_date"
                                                        placeholder="Enter Legacy ID" name="since_date" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <label class="form-label" for="po_required">EIN Number:</label>
                                                    <input type="text" class="form-control" id="tax_number"
                                                        placeholder="Enter EIN Number" name="tax_number" />
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
                                            <h5 class="card-tile mb-0">Customer Login:</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-12 col-lg-12">
                                                <input type="checkbox" id="is_allow_login" name="is_allow_login"
                                                    value="1" />
                                                <label class="form-label" for="is_allow_login">Allow access to Customer
                                                    Login Module</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-12">
                                                    <label class="form-label" for="username">Username:</label>
                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                                                        placeholder="Enter Username" name="username" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-12">
                                                    <label class="form-label" for="password">Password:</label>
                                                    <input type="text" class="form-control @error('password') is-invalid @enderror" id="password"
                                                        placeholder="Enter Password" name="password" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Credit Controls:</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <label class="form-label" for="credit_limit">Credit Limit:</label>
                                                    <input type="text" class="form-control" id="credit_limit"
                                                        placeholder="Enter Credit Limit" name="credit_limit" />
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <input type="checkbox" id="is_credit_lock" name="is_credit_lock"
                                                        value="1" />
                                                    <label class="form-label" for="is_credit_lock">Is Credit Lock
                                                        Exempt</label>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-12">
                                                    <label class="form-label" for="sales_alert_note">Sales Alert
                                                        Note:</label>
                                                    <input type="text" class="form-control" id="sales_alert_note"
                                                        placeholder="Enter Sales Alert Note" name="sales_alert_note" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-12">
                                                    <label class="form-label" for="sales_lock_note">Sales Lock
                                                        Note:</label>
                                                    <input type="text" class="form-control" id="sales_lock_note"
                                                        placeholder="Enter Sales Lock Note" name="sales_lock_note" />
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
                                            <label class="form-label" for="delivery_instructions">Special / Delivery
                                                Instructions:</label>
                                            <textarea class="form-control" id="delivery_instructions" placeholder="Enter Credit Limit"
                                                name="delivery_instructions"></textarea>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="collection_notes">Collection Notes:</label>
                                            <textarea class="form-control" id="collection_notes" placeholder="Enter Credit Limit" name="collection_notes"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="checkbox" id="is_copy_sale_order" name="is_copy_sale_order"
                                                value="1" />
                                            <label class="form-label" for="is_copy_sale_order">Copy to all Sale Orders /
                                                Quotes for this customer</label>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label" for="internal_notes">Internal Notes:</label>
                                            <textarea class="form-control" id="internal_notes" placeholder="Enter Credit Limit" name="internal_notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                </form>
                <div class="content-backdrop fade"></div>
            </div>
        @endsection
        @section('scripts')

            <script type="text/javascript">
                $(function() {
                    $('#customer_type_id').select2({
                        placeholder: 'Select Customer Type',
                        dropdownParent: $('#customer_type_id').parent()
                    });

                    $('#parent_customer_id').select2({
                        placeholder: 'Select Parent Customer',
                        dropdownParent: $('#parent_customer_id').parent()
                    });

                    $('#referred_by_id').select2({
                        placeholder: 'Select Referred By',
                        dropdownParent: $('#referred_by_id').parent()
                    });

                    $('#country_id').select2({
                        placeholder: 'Select Country',
                        dropdownParent: $('#country_id').parent()
                    });

                    $('#shipping_country_id').select2({
                        placeholder: 'Select Shipping Country',
                        dropdownParent: $('#shipping_country_id').parent()
                    });

                    $('#parent_location_id').select2({
                        placeholder: 'Select Parent Location',
                        dropdownParent: $('#parent_location_id').parent()
                    });

                    $('#route_location_id').select2({
                        placeholder: 'Select Route Location',
                        dropdownParent: $('#route_location_id').parent()
                    });

                    $('#preferred_document_id').select2({
                        placeholder: 'Select Preferred Document',
                        dropdownParent: $('#preferred_document_id').parent()
                    });

                    $('#sales_person_id').select2({
                        placeholder: 'Select Sales Person',
                        dropdownParent: $('#sales_person_id').parent()
                    });

                    $('#secondary_sales_person_id').select2({
                        placeholder: 'Select Secondary Sales Person',
                        dropdownParent: $('#secondary_sales_person_id').parent()
                    });

                    $('#price_list_label_id').select2({
                        placeholder: 'Select Price List Label',
                        dropdownParent: $('#price_list_label_id').parent()
                    });

                    $('#tax_exempt_reason_id').select2({
                        placeholder: 'Select Tax Exempt Reason',
                        dropdownParent: $('#tax_exempt_reason_id').parent()
                    });

                    $('#sales_tax_id').select2({
                        placeholder: 'Select Sales Tax',
                        dropdownParent: $('#sales_tax_id').parent()
                    });

                    $('#payment_terms_id').select2({
                        placeholder: 'Select Payment Terms',
                        dropdownParent: $('#payment_terms_id').parent()
                    });

                    $('#about_us_option_id').select2({
                        placeholder: 'Select How You Heard About Us',
                        dropdownParent: $('#about_us_option_id').parent()
                    });

                    $('#project_type_id').select2({
                        placeholder: 'Select Project Type',
                        dropdownParent: $('#project_type_id').parent()
                    });

                    $('#end_use_segment_id').select2({
                        placeholder: 'Select End Use Segment',
                        dropdownParent: $('#end_use_segment_id').parent()
                    });

                    $('#default_fulfillment_method_id').select2({
                        placeholder: 'Select Default Fulfillment Method',
                        dropdownParent: $('#default_fulfillment_method_id').parent()
                    });


                    $('#same_as_address').change(function() {
                        toggleShippingAddress(this);  // Pass the checkbox object to the function
                    });

                    function toggleShippingAddress(obj) {
                        var isChecked = $(obj).is(':checked');
                        $('#shipping_address').val(isChecked ? $('#address').val() : '');
                        $('#shipping_address_2').val(isChecked ? $('#address_2').val() : '');
                        $('#shipping_city').val(isChecked ? $('#city').val() : '');
                        $('#shipping_state').val(isChecked ? $('#state').val() : '');
                        $('#shipping_zip').val(isChecked ? $('#zip').val() : '');
                        $('#shipping_country_id').val(isChecked ? $('#country_id').val() : null).trigger('change');
                        if (isChecked) {
                            $('#shipping_zip').trigger('blur');
                        }
                        $('#shipping_county').val(isChecked ? $('#county').val() : '');
                    }

                    // On change event of Select2 dropdown
                    $('#parent_customer_id').change(function() {
                        var billingAddressUrl = "{{ route('customers.billing-address') }}";
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to fill the billing address fields with the selected customer's address?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var selectedCustomerId = $(this).val();
                                $.ajax({
                                    url: billingAddressUrl,
                                    method: 'GET',
                                    data: { id: selectedCustomerId },
                                    success: function(response) {
                                        $('#address').val(response.address);
                                        $('#address_2').val(response.address_2);
                                        $('#city').val(response.city);
                                        $('#state').val(response.state);
                                        $('#zip').val(response.zip);
                                        $('#country_id').val(response.country_id).trigger('change');
                                        $('#county').val(response.county);
                                    },
                                    error: function() {
                                        Swal.fire('Error', 'Failed to fetch customer address', 'error');
                                    }
                                });
                            }
                        });
                    });

                    $('#is_allow_login').change(function() {
                        if ($(this).is(':checked')) {
                            $('#username, #password').closest('.form-group').show();
                        } else {
                            $('#username, #password').closest('.form-group').hide();
                        }
                    });

                    // Trigger the change event on page load if checkbox is already checked
                    $('#is_allow_login').trigger('change');

                });
            </script>
        @endsection
