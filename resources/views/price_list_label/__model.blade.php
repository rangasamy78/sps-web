<div class="modal fade" id="priceListLabelModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="priceListLabelForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="price_list_label_id" id="price_list_label_id">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="price_level" class="form-label">Price Level</label>
                            <input type="text" id="price_level" name="price_level" readonly class="form-control" value="">
                            <span class="text-danger error-text price_level_error"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="price_code" class="form-label">Price Code <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <input type="text" id="price_code" name="price_code" class="form-control" placeholder="Enter Price Code">
                            <span class="text-danger error-text price_code_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="price_label" class="form-label">Price Label <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <input type="text" id="price_label" name="price_label" class="form-control" placeholder="Enter Price Label">
                            <span class="text-danger error-text price_label_error"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="price_notes" class="form-label">Price Notes <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <input type="text" id="price_notes" name="price_notes" class="form-control" placeholder="Enter Price Notes">
                            <span class="text-danger error-text price_notes_error"></span>
                        </div>
                    </div>

                    <div class="row m-3">
                        <div class="col-6  mb-2 mb-md-0">
                            <div class="p-3  shadow">
                                <h5 class="text-success">Customer Type</h5>
                                <div class="row">
                                    <div class="col-6 mb-3  float-end">
                                        <input type="text" id="searchCustomerType" name="searchCustomerType" class="form-control" placeholder="Search for Customer Type">
                                    </div>
                                </div>
                                <div class="container custom-container" id="customerTypeList">
                                    @foreach ($customers as $customer)
                                    <div class="row mb-3 customer-item">
                                        <div class="col-12 col-md-6">
                                            <span class="customer-name">{{$customer->customer_type_name}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="checkbox" class="form-check-input" name="customer_type_id[][customer_type_id]" id="customer_type_id_{{$customer->id}}" value="{{$customer->id}}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-6  mb-2 mb-md-0">
                            <div class="p-3 shadow">
                                <h5 class="text-success">Location</h5>
                                <div class="row">
                                    <div class="col-6 mb-3  float-end">
                                        <input type="hidden" id="searchLocation" name="searchLocation" class="form-control" placeholder="Search for Location">
                                    </div>
                                </div>
                                <div class="container custom-container" id="locationList">
                                    <div class="row">
                                        <div class="col-6 mb-3"><span>Eligible for all Locations</span></div>
                                        <div class="col-6 mb-3">
                                            <input type="checkbox" class="form-check-input" name="location_id[][location_id]" id="location_id_0" value="1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3"><span>ULTRA STONES LLC</span></div>
                                        <div class="col-6 mb-3">
                                            <input type="checkbox" class="form-check-input" name="location_id[][location_id]" id="location_id_1" value="2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 mb-3">
                            <label for="default_discount" class="form-label">Default Discount % off Dealer-Dealer(P1)to use in the Pricing Wizard</label>
                            <input type="text" id="default_discount" name="default_discount" class="form-control">
                            <span class="text-danger error-text default_discount_error"></span>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-3">
                            <label for="sales_person_commission" class="form-label"> Sales Person Commission</label>
                            <span>&nbsp;</span>
                            <input type="text" id="sales_person_commission" name="sales_person_commission" class="form-control">
                            <span class="text-danger error-text sales_person_commission_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="default_margin" class="form-label"> Default Margin for Lot Pricing</label>
                            <input type="text" id="default_margin" name="default_margin" class="form-control">
                            <span class="text-danger error-text default_margin_error"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="default_markup" class="form-label"> Default Markup for Lot Pricing</label>
                            <input type="text" id="default_markup" name="default_markup" class="form-control">
                            <span class="text-danger error-text default_markup_error"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" name="savedata" value="Save">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showPriceListLabelModal" tabindex="-1" aria-labelledby="showPriceListLabelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showPriceListLabelModalLabel">Show Price List Label</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showPriceListLabelForm" name="showPriceListLabelForm" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="price_level" class="form-label">Price Level</label>
                            <input type="text" id="price_level" name="price_level" disabled class="form-control" value="">
                            <span class="text-danger error-text price_level_error"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="price_code" class="form-label">Price Code</label>
                            <input type="text" id="price_code" name="price_code" disabled class="form-control" >
                            <span class="text-danger error-text price_code_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="price_label" class="form-label">Price Label</label>
                            <input type="text" id="price_label" name="price_label" disabled class="form-control" >
                            <span class="text-danger error-text price_label_error"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="price_notes" class="form-label">Price Notes</label>
                            <input type="text" id="price_notes" name="price_notes" disabled class="form-control" >
                            <span class="text-danger error-text price_notes_error"></span>
                        </div>
                    </div>

                    <div class="row m-3">
                        <div class="col-6  mb-2 mb-md-0">
                            <div class="p-3">
                                <h5 class="text-success">Customer Type</h5>
                                <div class="container">
                                    @foreach ($customers as $customer)
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6">
                                            <span>{{$customer->customer_type_name}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="checkbox" class="form-check-input" disabled name="customer_type_id[][customer_type_id]" id="customer_type_id_{{$customer->id}}" value="{{$customer->id}}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-6  mb-2 mb-md-0">
                            <div class="p-3">
                                <h5 class="text-success">Location</h5>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 col-md-8"><span>Eligible for all Locations</span></div>
                                        <div class="col-12 col-md-4">
                                            <input type="checkbox" class="form-check-input" disabled name="location_id[][location_id]" id="location_id_0" value="1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-8"><span>ULTRA STONES LLC</span></div>
                                        <div class="col-12 col-md-4">
                                            <input type="checkbox" class="form-check-input" disabled name="location_id[][location_id]" id="location_id_1" value="2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 mb-3">
                            <label for="default_discount" class="form-label">Default Discount % off Dealer-Dealer(P1)to use in the Pricing Wizard</label>
                            <input type="text" id="default_discount" name="default_discount" disabled class="form-control">
                            <span class="text-danger error-text default_discount_error"></span>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-3">
                            <label for="sales_person_commission" class="form-label"> Sales Person Commission</label>
                            <span>&nbsp;</span>
                            <input type="text" id="sales_person_commission" name="sales_person_commission" disabled class="form-control mt-3">
                            <span class="text-danger error-text sales_person_commission_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="default_margin" class="form-label"> Default Margin for Lot Pricing</label>
                            <input type="text" id="default_margin" name="default_margin" disabled class="form-control">
                            <span class="text-danger error-text default_margin_error"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="default_markup" class="form-label"> Default Markup for Lot Pricing</label>
                            <input type="text" id="default_markup" name="default_markup" disabled class="form-control">
                            <span class="text-danger error-text default_markup_error"></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
