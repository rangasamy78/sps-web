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
                                    <input type="text" class="form-control" id="customer_name" placeholder="Enter Customer Name" name="customer_name" />
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="customer-code">Customer Code</label>
                                    <input type="text" class="form-control" id="customer_code" placeholder="Enter Customer Code" name="customer_code" />
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="customer-type">Customer Type</label>
                                    <select class="form-control" id="customer_type_id" name="customer_type_id">
                                        <option value="">Select Customer Type</option>
                                        <option value="1">Type 1</option>
                                        <option value="2">Type 2</option>
                                        <option value="3">Type 3</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="contact-name">Contact Name</label>
                                    <input type="text" class="form-control" id="contact_name" placeholder="Enter Contact Name" name="contact_name" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label" for="print_name">Print Name</label>
                                    <input type="text" class="form-control" id="print_name" placeholder="Enter Print Name" name="print_name" />
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="legacy_id">Legacy ID</label>
                                    <input type="text" class="form-control" id="legacy_id" placeholder="Enter Legacy ID" name="legacy_id" />
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="referred_by">Referred By</label>
                                    <select class="form-control" id="referred_by" name="referred_by">
                                        <option value="">Select Referred By</option>
                                        <option value="1">Referral 1</option>
                                        <option value="2">Referral 2</option>
                                        <option value="3">Referral 3</option>
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
                                    <input type="text" class="form-control" id="phone" placeholder="Enter Primary Phone" name="phone" />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="phone2">Secondary Phone</label>
                                    <input type="text" class="form-control" id="phone2" placeholder="Enter Secondary Phone" name="phone2" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Mobile and Fax in the same row -->
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="mobile">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile" name="mobile" />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="fax">Fax</label>
                                    <input type="text" class="form-control" id="fax" placeholder="Enter Fax" name="fax" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <label class="form-label" for="email">Email Address</label>
                                    <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <label class="form-label" for="accounting_email">Accounting Email</label>
                                    <input type="text" class="form-control" id="accounting_email" placeholder="Enter Accounting Email" name="accounting_email" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <label class="form-label" for="url">Website</label>
                                    <input type="text" class="form-control" id="url" placeholder="Enter Website" name="url" />
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
                                    <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address" />
                                </div>
                                <div class="col-12 col-lg-12 mb-3">
                                    <label class="form-label" for="address_2">Suite / Unit#</label>
                                    <input type="text" class="form-control" id="address_2" placeholder="Enter Suite / Unit" name="address_2" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control" id="city" placeholder="Enter City" name="city" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3">
                                    <label class="form-label" for="state">State</label>
                                    <input type="text" class="form-control" id="state" placeholder="Enter State" name="city" />
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="county">County</label>
                                    <input type="text" class="form-control" id="county" placeholder="Enter County" name="county" />
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="country">Country</label>
                                    <select class="form-control" id="country_id" name="country_id">
                                        <option value="">Select Country</option>
                                        <option value="1">Type 1</option>
                                        <option value="2">Type 2</option>
                                        <option value="3">Type 3</option>
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
                                <!-- Shipping Address and Suite/Unit in the same row -->
                                <div class="col-12 col-lg-12 mb-3">
                                    <label class="form-label" for="shipping_address">Address</label>
                                    <input type="text" class="form-control" id="shipping_address" placeholder="Enter Address" name="shipping_address" />
                                </div>
                                <div class="col-12 col-lg-12 mb-3">
                                    <label class="form-label" for="shipping_address_2">Suite / Unit#</label>
                                    <input type="text" class="form-control" id="shipping_address_2" placeholder="Enter Suite / Unit" name="shipping_address_2" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3">
                                    <label class="form-label" for="shipping_city">City</label>
                                    <input type="text" class="form-control" id="shipping_city" placeholder="Enter City" name="shipping_city" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3">
                                    <label class="form-label" for="shipping_state">State</label>
                                    <input type="text" class="form-control" id="shipping_state" placeholder="Enter State" name="shipping_state" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3">
                                    <label class="form-label" for="shipping_zip">Zip</label>
                                    <input type="text" class="form-control" id="shipping_zip" placeholder="Enter Zip" name="shipping_zip" />
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="shipping_county">County</label>
                                    <input type="text" class="form-control" id="shipping_county" placeholder="Enter County" name="shipping_county" />
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="shipping_country">country</label>
                                    <select class="form-control" id="shipping_country_id" name="shipping_country_id">
                                        <option value="">Select Country</option>
                                        <option value="1">Type 1</option>
                                        <option value="2">Type 2</option>
                                        <option value="3">Type 3</option>
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
                                    <select class="form-control" id="parent_location_id" name="parent_location_id">
                                        <option value="">Select Referred By</option>
                                        <option value="1">Referral 1</option>
                                        <option value="2">Referral 2</option>
                                        <option value="3">Referral 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Mobile and Fax in the same row -->
                                <div class="col-12 col-lg-6">
                                    <input type="checkbox" id="multi_location" name="multi_location" />
                                    <label class="form-label" for="multi_location">Multi Location Customer</label>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <input type="checkbox" id="generic_customer" name="generic_customer" />
                                    <label class="form-label" for="fax">Generic Customer</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="email">Route Location:</label>
                                    <select class="form-control" id="route_location_id" name="route_location_id">
                                        <option value="">Select Referred By</option>
                                        <option value="1">Referral 1</option>
                                        <option value="2">Referral 2</option>
                                        <option value="3">Referral 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Accounting Controls:</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <input type="checkbox" id="is_po_required" name="is_po_required" />
                                    <label class="form-label" for="is_po_required">PO REQUIRED: A PO is required to process any Sales Orders for this customer.</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <input type="checkbox" id="apply_finance_charge" name="apply_finance_charge" />
                                    <label class="form-label" for="apply_finance_charge">APPLY FINANCE CHARGES: Finance charges will be applied for late payments from this customer.</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <label class="form-label" for="po_required">The preferred way of sending documents to this customer is:</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <label class="form-label" for="grace_period"># of days for Grace Period after which the invoices are considered for past due lock:</label>
                                    <input type="text" class="form-control" id="grace_period" placeholder="Enter Grace Period" name="grace_period" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="hold_days"># of days for hold:</label>
                                    <input type="text" class="form-control" id="hold_days" placeholder="Enter Hold Days" name="hold_days" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="po_required">Customer Since:</label>
                                    <input type="text" class="form-control" id="since_date" placeholder="Enter Legacy ID" name="since_date" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="po_required">EIN Number:</label>
                                    <input type="text" class="form-control" id="tax_number" placeholder="Enter EIN Number" name="tax_number" />
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
                            <div class="row mb-3">
                                <!-- Mobile and Fax in the same row -->
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="sales_rep_id">Primary Sales Person:</label>
                                    <select class="form-control" id="sales_rep_id" name="sales_rep_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="fax">Secondary Sales Person:</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Mobile and Fax in the same row -->
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="multi_location">Multi Location Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Mobile and Fax in the same row -->
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="multi_location">Multi Location Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="fax">Generic Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Mobile and Fax in the same row -->
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="multi_location">Multi Location Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="fax">Generic Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Mobile and Fax in the same row -->
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="multi_location">Multi Location Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="fax">Generic Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Mobile and Fax in the same row -->
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="multi_location">Multi Location Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="fax">Generic Customer</label>
                                    <select class="form-control" id="preferred_document_id" name="preferred_document_id">
                                        <option value="">Select Referred By</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Email">Email</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="content-backdrop fade"></div>
    </div>
@endsection
@section('scripts')


@endsection
