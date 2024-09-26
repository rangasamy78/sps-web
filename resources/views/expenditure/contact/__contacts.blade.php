<div class="tab-pane fade show active" id="contact" role="tabpanel">
    <h5>Add Contact</h5>
    <table class="datatables-basic table table-striped" id="expenditureContact">
        <thead class="table-header-bold">
            <tr>
                <th>Sl.No</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phones</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here -->
        </tbody>
    </table>
</div>

<form name="saveContactForm" id="saveContactForm">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasEndLabel">

        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">Add Contact</h5>
            <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body my-auto">
            <div class="form-group mb-3">
                <input type="hidden" class="form-control" id="type" name="type"
                    placeholder="Enter Title" value="expenditure">
                <input type="hidden" class="form-control" id="type_id" name="type_id"
                    placeholder="Enter Title" value="{{$expenditure->id}}">
                <label for="contact_name" class="form-label">Contact/Loc.Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="contact_name" name="contact_name"
                        placeholder="Enter Contact Name" value="">
                </div>
                <span class="text-danger error-text contact_name_error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="title" class="form-label">Title</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="title" name="title"
                        placeholder="Enter Title" value="">
                </div>
                <span class="text-danger error-text title_error"></span>
            </div>

            <div class="form-group mb-3">
                <label for="address" class="form-label">Address</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="address" name="address"
                        placeholder="Enter Address" value="">
                </div>
                <span class="text-danger error-text address_error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="address_2" class="form-label">Address 2</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="address_2" name="address_2"
                        placeholder="Enter Address 2" value="">
                </div>
                <span class="text-danger error-text address_2_error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="state" class="form-label">State</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="state" name="state"
                        placeholder="Enter State" value="">
                </div>
                <span class="text-danger error-text state_error"></span>
            </div>
            <div class="form-group mb-3 row">
                <div class="col-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city"
                        placeholder="Enter City" value="">
                    <span class="text-danger error-text state_error"></span>
                </div>
                <div class="col-6">
                    <label for="zip" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="zip" name="zip"
                        placeholder="Enter Zip" value="">
                    <span class="text-danger error-text zip_error"></span>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="county_id" class="form-label">County</label>
                <div class="col-sm-12">
                    <select type="text" id="county_id" name="county_id" class="form-select">
                        {{-- @foreach($countyies as $county)
                        <option value="{{ $county->id }}">{{ $county->county_name }}</option>
                        @expenditure --}}
                    </select>
                </div>
                <span class="text-danger error-text county_id_error"></span>
            </div>
            <div class="form-group mb-3 row">
                <div class="col-6">
                    <label for="lot" class="form-label">Lot</label>
                    <input type="text" class="form-control" id="lot" name="lot"
                        placeholder="Enter Lot" value="">
                    <span class="text-danger error-text lot_error"></span>
                </div>
                <div class="col-6">
                    <label for="sub_division" class="form-label">Sub Division</label>
                    <input type="text" class="form-control" id="sub_division" name="sub_division"
                        placeholder="Enter Sub Division" value="">
                    <span class="text-danger error-text sub_division_error"></span>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="country_id" class="form-label">Country</label>
                <div class="col-sm-12">
                    <select type="text" id="country_id" name="country_id" class="form-select">
                        {{-- @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                <span class="text-danger error-text country_id_error"></span>
            </div>
            <div class="form-group mb-3 row">
                <div class="col-6">
                    <label for="primary_phone" class="form-label">Primary Phone</label>
                    <input type="text" class="form-control" id="primary_phone" name="primary_phone"
                        placeholder="Enter Primary Phone" value="">
                    <span class="text-danger error-text primary_phone_error"></span>
                </div>
                <div class="col-6">
                    <label for="secondary_phone" class="form-label">Secondary Phone</label>
                    <input type="text" class="form-control" id="secondary_phone" name="secondary_phone"
                        placeholder="Enter Secondary Phone" value="">
                    <span class="text-danger error-text secondary_phone_error"></span>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="fax" class="form-label">Fax</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="fax" name="fax"
                        placeholder="Enter Fax" value="">
                </div>
                <span class="text-danger error-text fax_error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="col-sm-12">
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter Email" value="">
                </div>
                <span class="text-danger error-text email_error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="internal_notes" class="form-label">Internal Notes</label>
                <div class="col-sm-12">
                    <textarea id="internal_notes" name="internal_notes" class="form-control" rows="2" placeholder="Enter Internal Notes" style="resize:none"></textarea>
                </div>
                <span class="text-danger error-text internal_notes_error"></span>
            </div>
            <div class="row">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="savecontactdata" name="savecontactdata">Save</button>
                    <button type="button" class="btn btn-label-secondary ms-2" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </div>

    </div>
</form>
