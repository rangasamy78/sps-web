<div class="modal fade" id="AddNewCustomer" tabindex="-1" aria-hidden="true">
    <form id="formAddNewCustomer">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Setup New Customer</h5>
                    <div class="ms-auto d-flex align-items-center">
                        <button type="button" class="btn btn-dark me-2"
                            onclick="window.location.href='{{ route('customers.create') }}';">Click to add full New
                            Customer</button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 col-lg-4 mb-3">
                            <label for="customer_name" class="form-label">Customer Name <sup
                                    style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <input type="text" id="customer_name" name="customer_name" class="form-control"
                                placeholder="Enter Customer Name" />
                            <span class="text-danger error-text customer_name_error"></span>
                        </div>
                        <div class="col-6 col-lg-4 mb-3">
                            <label for="customer_code" class="form-label">Cust.ID / Code</label>
                            <input type="text" id="customer_code" readonly name="customer_code" class="form-control"
                                value="{{ $data['customerCount'] + 1 }}" />
                            <span class="text-danger error-text customer_code_error"></span>
                        </div>
                        <div class="col-6 col-lg-4 mb-3">
                            <label for="customer_type_id" class="form-label">Customer Type</label>
                            <select id="customer_type_id" name="customer_type_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['customerTypes'] as $key => $customerType)
                                    <option value="{{ $customerType->id }}">{{ $customerType->customer_type_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text customer_type_id_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-4 mb-3">
                            <label for="contact_name" class="form-label">Contact Name</label>
                            <input type="text" id="contact_name" name="contact_name" class="form-control"
                                placeholder="Enter Contact Name" />
                            <span class="text-danger error-text contact_name_error"></span>
                        </div>
                        <div class="col-6 col-lg-4 mb-3">
                            <label for="nameExLarge" class="form-label">Parent Customer</label>
                            <select id="parent_customer_id" name="parent_customer_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['customers'] as $key => $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text parent_customer_id_error"></span>
                        </div>
                        <div class="col-6 col-lg-4 mb-3">
                            <label for="referred_by_id" class="form-label">Referred By</label>
                            <select id="referred_by_id" name="referred_by_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['customers'] as $key => $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text referred_by_id_error"></span>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-lg-4 mb-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Contact Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="phone" class="form-label">Primary Phone</label>
                                            <input type="text" id="phone" name="phone" class="form-control"
                                                placeholder="Enter Primary Phone" />
                                            <span class="text-danger error-text phone_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="phone_2" class="form-label">Secondary Phone</label>
                                            <input type="text" id="phone_2" name="phone_2" class="form-control"
                                                placeholder="Enter Secondary Phone" />
                                            <span class="text-danger error-text phone_2_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="text" id="mobile" name="mobile" class="form-control"
                                                placeholder="Enter Mobile" />
                                            <span class="text-danger error-text _error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="fax" class="form-label">Fax</label>
                                            <input type="text" id="fax" name="fax" class="form-control"
                                                placeholder="Enter Fax" />
                                            <span class="text-danger error-text mobile_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="email" class="form-label">Eamil Address</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Enter Email" />
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Bill-To Address</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" id="address" name="address" class="form-control"
                                                placeholder="Enter Address" />
                                            <span class="text-danger error-text address_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="address_2" class="form-label">Suite / Unit#</label>
                                            <input type="text" id="address_2" name="address_2"
                                                class="form-control" placeholder="Enter Suite / Unit" />
                                            <span class="text-danger error-text address_2_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="emailExLarge" class="form-label">City</label>
                                            <input type="text" id="city" name="city" class="form-control"
                                                placeholder="Enter City" />
                                            <span class="text-danger error-text city_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="state" class="form-label">State</label>
                                            <input type="text" id="state" name="state" class="form-control"
                                                placeholder="Enter State" />
                                            <span class="text-danger error-text state_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="zip" class="form-label">Zip</label>
                                            <input type="text" id="zip" name="zip" class="form-control"
                                                placeholder="Enter Zip" />
                                            <span class="text-danger error-text zip_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Shipping Address</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="shipping_address"
                                                class="form-label d-flex align-items-center"> Address <input
                                                    type="checkbox" id="sameAsBillTo"
                                                    class="form-check-input ms-2" />&nbsp;&nbsp;same as Bill To
                                                Address</label>
                                            <input type="text" id="shipping_address" name="shipping_address"
                                                class="form-control" placeholder="Enter Address" />
                                            <span class="text-danger error-text shipping_address_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="shipping_address_2" class="form-label">Suite / Unit#</label>
                                            <input type="text" id="shipping_address_2" name="shipping_address_2"
                                                class="form-control" placeholder="Enter Suite/Unit" />
                                            <span class="text-danger error-text shipping_address_2_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="shipping_city" class="form-label">City</label>
                                            <input type="text" id="shipping_city" name="shipping_city"
                                                class="form-control" placeholder="Enter City" />
                                            <span class="text-danger error-text _error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="shipping_state" class="form-label">State</label>
                                            <input type="text" id="shipping_state" name="shipping_state"
                                                class="form-control" placeholder="Enter State" />
                                            <span class="text-danger error-text shipping_state_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="shipping_zip" class="form-label">Zip</label>
                                            <input type="text" id="shipping_zip" name="shipping_zip"
                                                class="form-control" placeholder="Enter Zip" />
                                            <span class="text-danger error-text shipping_zip_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6 col-lg-4">
                            <label for="parent_location_id" class="form-label">Parent Location <sup
                                    style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <select id="parent_location_id" name="parent_location_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['companies'] as $key => $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text parent_location_id_error"></span>
                        </div>
                        <div class="col-6 col-lg-4">
                            <label for="sales_person_id" class="form-label">Primary Sales Person</label>
                            <select id="sales_person_id" name="sales_person_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['users'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text sales_person_id_error"></span>
                        </div>
                        <div class="col-6 col-lg-4 pt-sm-2 pt-lg-0">
                            <label for="secondary_sales_person_id" class="form-label">Secondary Sales Person</label>
                            <select id="secondary_sales_person_id" name="secondary_sales_person_id"
                                class="select2 form-select" data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['users'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text secondary_sales_person_id_error"></span>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6 col-lg-4">
                            <label for="payment_terms_id" class="form-label">Payment Terms <sup
                                    style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <select id="payment_terms_id" name="payment_terms_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['paymentTerms'] as $key => $paymentTerm)
                                    <option value="{{ $paymentTerm->id }}">{{ $paymentTerm->payment_label }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text payment_terms_id_error"></span>
                        </div>
                        <div class="col-6 col-lg-4">
                            <label for="sales_tax_id" class="form-label">Sales Tax</label>
                            <select id="sales_tax_id" name="sales_tax_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['salesTaxs'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text sales_tax_id_error"></span>
                        </div>
                        <div class="col-6 col-lg-4 pt-sm-2 pt-lg-0">
                            <label for="price_list_label_id" class="form-label">Price Level <sup
                                    style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <select id="price_list_label_id" name="price_list_label_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['priceListLabels'] as $id => $label)
                                    <option value="{{ $id }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text price_list_label_id_error"></span>
                        </div>
                    </div>
                    <input type="hidden" id="since_date" name="since_date" class="form-control"
                        placeholder="Enter Zip" />
                    <input type="hidden" id="exempt_expiry_date" name="exempt_expiry_date" class="form-control"
                        placeholder="Enter Zip" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveCustomer" name="saveCustomer">Save
                        Customer</button>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="AddNewAssociate" tabindex="-1" aria-hidden="true">
    <form id="formAddNewAssociate">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Setup New Associate</h5>
                    <div class="ms-auto d-flex align-items-center">
                        <button type="button" class="btn btn-dark me-2"
                            onclick="window.location.href='{{ route('associates.create') }}';">Click to add full New
                            Associate</button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="associate_name" class="form-label">Associate Name <sup
                                    style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <input type="text" id="associate_name" name="associate_name" class="form-control"
                                placeholder="Enter Customer Name" />
                            <span class="text-danger error-text associate_name_error"></span>
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="associate_code" class="form-label">Associate ID / Code</label>
                            <input type="text" id="associate_code" name="associate_code" class="form-control" />
                            <span class="text-danger error-text associate_code_error"></span>
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="associate_type_id" class="form-label">Associate Type</label>
                            <select id="associate_type_id" name="associate_type_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['customerTypes'] as $key => $customerType)
                                    <option value="{{ $customerType->id }}">{{ $customerType->customer_type_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text associate_type_id_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="contact_name" class="form-label">Contact Name</label>
                            <input type="text" id="contact_name" name="contact_name" class="form-control"
                                placeholder="Enter Contact Name" />
                            <span class="text-danger error-text contact_name_error"></span>
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="referred_by_id" class="form-label">Referred By</label>
                            <select id="referred_by_id" name="referred_by_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['associates'] as $key => $associate)
                                    <option value="{{ $associate->id }}">{{ $associate->associate_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text referred_by_id_error"></span>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-lg-6 mb-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Contact Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="primary_phone" class="form-label">Primary Phone</label>
                                            <input type="text" id="primary_phone" name="primary_phone"
                                                class="form-control" placeholder="Enter Primary Phone" />
                                            <span class="text-danger error-text primary_phone_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="secondary_phone" class="form-label">Secondary Phone</label>
                                            <input type="text" id="secondary_phone" name="secondary_phone"
                                                class="form-control" placeholder="Enter Secondary Phone" />
                                            <span class="text-danger error-text secondary_phone_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="text" id="mobile" name="mobile" class="form-control"
                                                placeholder="Enter Mobile" />
                                            <span class="text-danger error-text mobile_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="fax" class="form-label">Fax</label>
                                            <input type="text" id="fax" name="fax" class="form-control"
                                                placeholder="Enter Fax" />
                                            <span class="text-danger error-text fax_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="email" class="form-label">Eamil Address</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Enter Email" />
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="text" id="website" name="website" class="form-control"
                                                placeholder="Enter Email" />
                                            <span class="text-danger error-text website_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mb-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Address</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" id="address" name="address" class="form-control"
                                                placeholder="Enter Address" />
                                            <span class="text-danger error-text address_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="suite" class="form-label">Suite / Unit#</label>
                                            <input type="text" id="suite" name="suite" class="form-control"
                                                placeholder="Enter Suite / Unit" />
                                            <span class="text-danger error-text suite_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="emailExLarge" class="form-label">City</label>
                                            <input type="text" id="city" name="city" class="form-control"
                                                placeholder="Enter City" />
                                            <span class="text-danger error-text city_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="state" class="form-label">State</label>
                                            <input type="text" id="state" name="state" class="form-control"
                                                placeholder="Enter State" />
                                            <span class="text-danger error-text state_error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="zip" class="form-label">Zip</label>
                                            <input type="text" id="zip" name="zip" class="form-control"
                                                placeholder="Enter Zip" />
                                            <span class="text-danger error-text zip_error"></span>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="country_id" class="form-label">Country</label>
                                            <select id="country_id" name="country_id" class="select2 form-select"
                                                data-allow-clear="true">
                                                <option value="">--select--</option>
                                                @foreach ($data['countries'] as $id => $country_name)
                                                    <option value="{{ $id }}">{{ $country_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text country_id_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-lg-4">
                            <label for="location_id" class="form-label">Location</label>
                            <select id="location_id" name="location_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['companies'] as $key => $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text location_id_error"></span>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="primary_sales_id" class="form-label">Sales Rep</label>
                            <select id="primary_sales_id" name="primary_sales_id" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="">--select--</option>
                                @foreach ($data['users'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text primary_sales_id_error"></span>
                        </div>
                        <div class="col-12 col-lg-4 pt-sm-2 pt-lg-0">
                            <label for="internal_notes" class="form-label">Internal Notes</label>
                            <textarea id="internal_notes" name="internal_notes" class="form-control" rows="1"
                                placeholder="Enter Internal Notes" style="resize:none"></textarea>
                            <span class="text-danger error-text internal_notes_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveAssociate" name="saveAssociate">Save
                        Associate</button>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- /end add ASSOCIATE -->

<!-- pop up billing customer -->
<div class="modal fade" id="searchCustomer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">List of Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row accountFilter">
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Customer Name:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" name="customerNameFilter"
                            id="customerNameFilter" data-allow-clear="true" placeholder="Search by Customer Name">
                    </div>
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Customer Code:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" id="customerCodeFilter"
                            name="customerCodeFilter" data-allow-clear="true" placeholder="Search by Customer Code">
                    </div>
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Contact:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" id="contactFilter"
                            name="contactFilter" data-allow-clear="true" placeholder="Search by Contact">
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="customerListTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Name</th>
                                <th>Code</th>
                                <th>Phone</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="searchAssociate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">List of Associate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row accountFilter">
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Name:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" name="nameFilter"
                            id="nameFilter" data-allow-clear="true" placeholder="Search by Associate Name">
                    </div>
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Code:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" id="codeFilter"
                            name="codeFilter" data-allow-clear="true" placeholder="Search by Associate Code">
                    </div>
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Contact:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" id="phoneFilter"
                            name="phoneFilter" data-allow-clear="true" placeholder="Search by Contact">
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="associateListTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Name</th>
                                <th>Code</th>
                                <th>Phone</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="searchShipTo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row shipToFilter">
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Name:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" name="shipToNameFilter"
                            id="shipToNameFilter" data-allow-clear="true" placeholder="Search by Name">
                    </div>
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Code:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" id="shipToCodeFilter"
                            name="shipToCodeFilter" data-allow-clear="true" placeholder="Search by Code">
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="shipToListTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Name</th>
                                <th>Code</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
