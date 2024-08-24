<div class="modal fade" id="companyModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCompanyForm" name="addCompanyForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="company_id" id="company_id">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name" class="form-label pb-1">Company Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name" value="">
                                <span class="text-danger error-text company_name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label pb-1">Email <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row  mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_line_1" class="form-label pb-1">Address Line 1 <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <textarea class="form-control" id="address_line_1" name="address_line_1" placeholder="Enter Address Line 1" style="resize: none;"></textarea>
                                <span class="text-danger error-text address_line_1_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_line_2" class="form-label pb-1">Address Line 2</label>
                                <textarea class="form-control" id="address_line_2" name="address_line_2" placeholder="Enter Address Line 2" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city" class="form-label pb-1">City <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="">
                                <span class="text-danger error-text city_error"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="state" class="form-label pb-1">State <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="Enter State" value="">
                                <span class="text-danger error-text state_error"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="zip" class="form-label pb-1">ZIP Code <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="Enter ZIP Code" value="">
                                <span class="text-danger error-text zip_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_1" class="form-label pb-1">Phone 1 <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="phone_1" name="phone_1" placeholder="Enter Phone 1" value="">
                                <span class="text-danger error-text phone_1_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_2" class="form-label pb-1">Phone 2</label>
                                <input type="text" class="form-control" id="phone_2" name="phone_2" placeholder="Enter Phone 2" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website" class="form-label pb-1">Website</label>
                                <input type="text" class="form-control" id="website" name="website" placeholder="Enter Website URL" value="">
                                <span class="text-danger error-text website_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo" class="form-label pb-1">Company logo <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="file" class="form-control" id="logo" name="logo">
                                <span class="text-danger error-text logo_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="imagePreview" class="mt-2">
                                    <img id="previewImage" src="{{ asset('public/assets/img/branding/location-logo.png') }}" alt="Your Logo" style="width: 100px;height:100px;" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-check">
                                <input type="checkbox" id="is_bin_pre_defined" name="is_bin_pre_defined" value="1" class="form-check-input">
                                <label for="is_bin_pre_defined" class="form-check-label">Is Bin Pre-Defined</label>
                                <span class="text-danger error-text is_bin_pre_defined_error" style="display: inline-flex;"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="savedata" value="create">Save
                        Company</button>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCompanyModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCompanyForm" name="editCompanyForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="company_id" id="company_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name" class="form-label pb-1">Company Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                    placeholder="Enter Company Name" value="">
                                <span class="text-danger error-text company_name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label pb-1">Email <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_line_1" class="form-label pb-1">Address Line 1 <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <textarea class="form-control" id="address_line_1" name="address_line_1" placeholder="Enter Address Line 1" style="resize:none"></textarea>
                                <span class="text-danger error-text address_line_1_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_line_2" class="form-label pb-1">Address Line 2</label>
                                <textarea class="form-control" id="address_line_2" name="address_line_2" placeholder="Enter Address Line 1" style="resize:none"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city" class="form-label pb-1">City <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="">
                                <span class="text-danger error-text city_error"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="state" class="form-label pb-1">State <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="Enter State" value="">
                                <span class="text-danger error-text state_error"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="zip" class="form-label pb-1">ZIP Code <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="Enter ZIP Code" value="">
                                <span class="text-danger error-text zip_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_1" class="form-label pb-1">Phone 1 <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="text" class="form-control" id="phone_1" name="phone_1" placeholder="Enter Phone 1" value="">
                                <span class="text-danger error-text phone_1_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_2" class="form-label pb-1">Phone 2</label>
                                <input type="text" class="form-control" id="phone_2" name="phone_2" placeholder="Enter Phone 2" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website" class="form-label pb-1">Website</label>
                                <input type="text" class="form-control" id="website" name="website" placeholder="Enter Website URL" value="">
                                <span class="text-danger error-text website_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo" class="form-label pb-1">Company logo <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <input type="file" class="form-control" id="logo" name="logo">
                                <span class="text-danger error-text logo_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="imagePreview" class="mt-2">
                                    <img id="previewImage" src="#" alt="Your Logo" style="width: 100px;height:100px;" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-check">
                                <input type="checkbox" id="is_bin_pre_defined" name="is_bin_pre_defined" class="form-check-input" value="1">
                                <label for="is_bin_pre_defined" class="form-label pb-1">Is Bin Pre-Defined</label>
                                <span class="text-danger error-text is_bin_pre_defined_error" style="display: inline-flex;"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Company</button>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="showCompanyModel" tabindex="-1" aria-labelledby="show-company-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-company-modal-label">Show Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="showCompanyForm" name="showCompanyForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="company_id" id="company_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" disabled class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" disabled class="form-control" id="email" name="email" placeholder="Enter Email" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_line_1" class="form-label">Address Line 1</label>
                                <textarea disabled class="form-control" id="address_line_1" name="address_line_1" placeholder="Enter Address Line 1"  style="resize:none"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_line_2" class="form-label">Address Line 2</label>
                                <textarea disabled class="form-control" id="address_line_2" name="address_line_2" placeholder="Enter Address Line 2"  style="resize:none"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city" class="form-label">City</label>
                                <input type="text" disabled class="form-control" id="city" name="city" placeholder="Enter City" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="state" class="form-label">State</label>
                                <input type="text" disabled class="form-control" id="state" name="state" placeholder="Enter State" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="zip" class="form-label">ZIP Code</label>
                                <input type="text" disabled class="form-control" id="zip" name="zip" placeholder="Enter ZIP Code" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_1" class="form-label">Phone 1</label>
                                <input type="text" disabled class="form-control" id="phone_1" name="phone_1" placeholder="Enter Phone 1" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_2" class="form-label">Phone 2</label>
                                <input type="text" disabled class="form-control" id="phone_2" name="phone_2" placeholder="Enter Phone 2" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website" class="form-label">Website</label>
                                <input type="text" disabled class="form-control" id="website" name="website" placeholder="Enter Website URL" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo" class="form-label">Company logo</label>
                                <input type="file" disabled class="form-control" id="logo" name="logo">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="imagePreview" class="mt-2">
                                    <img id="previewImage" src="#" alt="Your Logo" style="width: 100px;height:100px;" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-check">
                                <input type="checkbox" disabled id="is_bin_pre_defined" class="form-check-input" name="is_bin_pre_defined" value="1">
                                <label for="is_bin_pre_defined" class="form-label">Is Bin Pre-Defined</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
