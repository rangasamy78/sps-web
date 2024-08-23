<div class="modal fade" id="countryModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="countryForm" name="countryForm" class="form-horizontal">
                    <input type="hidden" name="country_id" id="country_id">
                    <div class="form-group">
                        <label for="country_name" class="col-sm-6 control-label">Country Name <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="country_name" name="country_name"
                                placeholder="Enter Country Name" value="">
                        </div>
                        <span class="text-danger error-text country_name_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="country_code" class="col-sm-6 control-label">Country Code </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="country_code" name="country_code"
                                placeholder="Enter Country Name" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="lead_time" class="col-sm-6 control-label">Lead Time</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="lead_time" name="lead_time"
                                placeholder="Enter Lead Time" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Country</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showCountrymodal" tabindex="-1" aria-labelledby="show-country-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-country-modal-label">Show Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showCountryForm" name="showCountryForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="country_name" class="col-sm-6 control-label">Country Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="country_name" name="country_name"
                                placeholder="" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="country_code" class="col-sm-6 control-label">Country Code</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="country_code" name="country_code"
                                placeholder="" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="lead_time" class="col-sm-6 control-label">Lead Time</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="lead_time" name="lead_time"
                                placeholder="" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
