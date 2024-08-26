<div class="modal fade" id="fileTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fileTypeForm" name="fileTypeForm" class="form-horizontal">
                    <input type="hidden" name="file_type_id" id="file_type_id">
                    <!-- View In -->
                    <div class="form-group">
                        <label for="view_in" class="pb-1 form-label">View In <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select id="view_in" class="form-select select2" name="view_in" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($viewInOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text view_in_error"></span>
                    </div>
                    <!-- File Type -->
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">File Type <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="file_type" name="file_type"
                                placeholder="Enter File Type" value="">
                        </div>
                        <span class="text-danger error-text file_type_error"></span>
                    </div>
                    <!-- Checkboxes for Options -->
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Transactions </label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="file_type_opportunity" name="file_type_opportunity" value="0">
                                        <label class="form-check-label" for="file_type_opportunity">Opportunity</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="file_type_quote" name="file_type_quote" value="0">
                                        <label class="form-check-label" for="file_type_quote">Quote</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="file_type_saleorder" name="file_type_saleorder" value="0">
                                        <label class="form-check-label" for="file_type_saleorder"> SaleOrder</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="file_type_invoice" name="file_type_invoice" value="0">
                                        <label class="form-check-label" for="file_type_invoice">Invoice</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save File Type</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showFileTypeModal" tabindex="-1" aria-labelledby="show-fileType-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-fileType-modal-label">Show File Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fileTypeShowForm" name="fileTypeShowForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="View In" class="col-sm-2 form-label">View In</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="view_in" name="view_in" disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-2 form-label">File Types</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="file_type" name="file_type" disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-group mt-3">
                            <label class="col-sm-2 form-label">Transactions</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="file_type_opportunity" name="file_type_opportunity" value="0">
                                            <label class="form-check-label" for="file_type_opportunity">Opportunity</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="file_type_quote" name="file_type_quote" value="0">
                                            <label class="form-check-label" for="file_type_quote">Quote</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="file_type_saleorder" name="file_type_saleorder" value="0">
                                            <label class="form-check-label" for="file_type_saleorder">SaleOrder</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="file_type_invoice" name="file_type_invoice" value="0">
                                            <label class="form-check-label" for="file_type_invoice">Invoice</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
