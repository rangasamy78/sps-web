<div class="modal" id="surveyRateModel" tabindex="-1" aria-labelledby="surveyrateModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="priceModalLabel">Survey Rating</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Notes</label>
                        <textarea type="text" class="form-control" row="3" id="survey_rating" name="survey_rating">{{$quote->survey_rating}}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveSurvey" name="saveSurvey" data-id="{{$quote->id}}">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- File and iamges show -->
<div class="modal fade" id="listCustomerContact" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Attach an Exsting Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-input opportunity_id" id="opportunity_id" name="opportunity_id" value="{{ $opportunity->id }}">
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="quoteContactListTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th class="form-lg">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="selectAllCheckbox">
                                        <label class="form-check-label" for="selectAllCheckbox">Select All</label>
                                    </div>
                                </th>
                                <th>Name</th>
                                <th>Lot/Subdivision</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#saveCustomerContactModal" id="setupNewContact">Setup New Contact</button>
                <div>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" name="saveQuoteContact" id="saveQuoteContact" data-bs-dismiss="modal">Add Selected Contacts</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- pop up Save Customer contact -->
<div class="modal fade" id="saveCustomerContactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form id="saveCustomerContactForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">SetUp New Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <input type="hidden" class="form-control" name="contact_id" id="contact_id">
                            <label for="contact_name" class="form-label">Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <input type="hidden" class="form-control" name="type" id="type" value="customer">
                            <input type="hidden" class="form-control" name="type_id" id="type_id" value="{{$opportunity->billing_customer_id}}">
                            <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="Enter Name">
                            <span class="text-danger error-text contact_name_error"></span>
                        </div>
                        <div class="col-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title">
                            <span class="text-danger error-text title_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address">
                                    <span class="text-danger error-text address_error"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="address_2" class="form-label">Address2</label>
                                    <input type="text" class="form-control" name="address_2" id="address_2" placeholder="Enter Address2">
                                    <span class="text-danger error-text address_2_error"></span>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
                                    <span class="text-danger error-text city_error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" name="state" id="state" placeholder="Enter State">
                                    <span class="text-danger error-text state_error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="zip" class="form-label">Zip</label>
                                    <input type="text" class="form-control" name="zip" id="zip" placeholder="Enter Zip">
                                    <span class="text-danger error-text zip_error"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label for="phone" class="form-label">County</label>
                                    <select class="form-select" id="county_id" name="county_id">
                                        <option>--select here--</option>
                                        @foreach($data['counties'] as $id => $county_name)
                                        <option value="{{ $id }}">{{ $county_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text county_id_error"></span>
                                </div>
                                <div class="col-6">
                                    <label for="phone" class="form-label">Country</label>
                                    <select class="form-select" id="country_id" name="country_id">
                                        <option>--select here--</option>
                                        @foreach($data['countries'] as $id => $country_name)
                                        <option value="{{ $id }}">{{ $country_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text country_id_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="row  mb-2">
                                <div class="col">
                                    <label for="primary_phone" class="form-label">Primary Phone</label>
                                    <input type="text" class="form-control" name="primary_phone" id="primary_phone" placeholder="Enter Primary Phone">
                                    <span class="text-danger error-text primary_phone_error"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="secondary_phone" class="form-label">Secondary Phone</label>
                                    <input type="text" class="form-control" name="secondary_phone" id="secondary_phone" placeholder="Enter Secondary Phone">
                                    <span class="text-danger error-text secondary_phone_error"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile">
                                    <span class="text-danger error-text mobile_error"></span>
                                </div>
                                <div class="col-6">
                                    <label for="fax" class="form-label">Fax</label>
                                    <input type="text" class="form-control" name="fax" id="fax" placeholder="Enter Fax">
                                    <span class="text-danger error-text fax_error"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email">
                                    <span class="text-danger error-text email_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="phone" class="form-label">Internal Notes</label>
                            <textarea type="text" class="form-control internal_notes" name="internal_notes" id="internal_notes" placeholder="Enter Internal Notes"></textarea>
                            <span class="text-danger error-text internal_notes_error"></span>
                        </div>
                        <div class="col-6">
                            <div class="form-check pt-4">
                                <input type="checkbox" class="form-check-input" id="is_ship_to_address" name="is_ship_to_address" value="1">
                                <label for="is_ship_to_address" class="form-check-label">This is a Shipto address</label>
                                <span class="text-danger error-text is_ship_to_address_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2" id="taxCodeContainer" style="display:none">
                        <div class="col-6">
                            <label for="tax_code_id" class="form-label">Tax Code</label>
                            <select class="form-select" id="tax_code_id" name="tax_code_id">
                                <option value="">--select here--</option>
                                @foreach($data['salesTaxs'] as $id => $tax_name)
                                <option value="{{ $id }}">{{ $tax_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text tax_code_id_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-primary" name="saveCustContact" id="saveCustContact">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end pop up customer contact -->

<!-- quote status -->
<div class="modal" id="statusModel" tabindex="-1" aria-labelledby="statusModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel"> {{ $quote->status == 'close' ? 'Open Quote:' : 'Close Quote' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quoteStatusForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex gap-2 fs-4">
                                <label class="form-label "><span class="update_date">{{ $quote->status == 'close' ? 'Opened Date:' : 'Closed Date:' }}</span> <label class="text-dark fw-bold">{{\Carbon\Carbon::now()->format('d-m-Y')}}</label></label>
                            </div>
                            <input type="date" class="form-control" readonly hidden name="status_update_date" id="status_update_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label class="form-label"><span class="update_by">{{ $quote->status == 'close' ? 'Opened By:' : 'Closed By:' }}</span> <label class="text-dark fw-bold">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</label></label>
                            <input type="hidden" class="form-control" name="status_update_user_id" id="status_update_user_id" value="{{auth()->id()}}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <input type="text" class="form-control" hidden name="status" id="status" value="{{ $quote->status == 'close' ? 'open' : 'close' }}">
                        <div class="col">
                            <label class="form-label">Notes <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <textarea type="text" class="form-control" required row="3" id="notes" name="notes" {{ $quote->status == 'close' ? 'readonly' : '' }} placeholder="Enter Notes">{{$quote->notes}}</textarea>
                            <span class="text-danger error-text notes_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveStatus" name="saveStatus" data-id="{{$quote->id}}">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>