<div class="modal fade" id="supplierPortModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supplierPortForm" name="supplierPortForm" class="form-horizontal">
                    <input type="hidden" name="supplier_port_id" id="supplier_port_id">
                    <div class="form-group">
                        <label for="supplier-port-name" class="control-label">Supplier Port Name <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="supplier_port_name" name="supplier_port_name" placeholder="Enter Supplier Port Name" value="">
                        </div>
                        <span class="text-danger error-text supplier_port_name_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="avg_days" class="control-label">Avg days <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="avg_days" name="avg_days" placeholder="Enter Avg days" value="">
                        </div>
                        <span class="text-danger error-text avg_days_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="country_id" class="col-sm-6 control-label">Country <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <select id="country_id" class="form-select" name="country_id">
                                <option value="">--Select--</option>
                                @foreach($countries as $key => $country)
                                    <option value="{{ $key }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text country_id_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Supplier Port</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSupplierPortModal" tabindex="-1" aria-labelledby="show-supplier-port-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-supplier-port-modal-label">Show Supplier Port</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSupplierPortForm" name="showSupplierPortForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="supplier-port-name" class="control-label">Supplier Port Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="supplier_port_name" disabled name="supplier_port_name" placeholder="Enter Supplier Port Name" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="avg_days" class="control-label">Avg days </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="avg_days" disabled name="avg_days" placeholder="Enter Avg days" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="country_id" class="col-sm-6 control-label">Country </label>
                        <div class="col-sm-12">
                            <select id="country_id" disabled class="form-select" name="country_id">
                                <option value="">--Select--</option>
                                @foreach($countries as $key => $country)
                                    <option value="{{ $key }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
