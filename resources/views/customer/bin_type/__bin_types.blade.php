<div class="tab-pane fade show" id="bin_type" role="tabpanel">
    <h5>Add Bin Type</h5>
    @include('customer.bin_type.__search')
    <table class="datatables-basic table table-striped" id="customerBinType">
        <thead class="table-header-bold">
            <tr>
                <th>S.No</th>
                <th>Label</th>
                <td>X</td>
                <td>Y</td>
                <td>Z</td>
                <td>Length</td>
                <td>Width</td>
                <td>Height</td>
                <th>Zone</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="customerBinTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customerBinTypeModelForm" name="customerBinTypeModelForm" class="form-horizontal">
                    <input type="hidden" name="customer_bin_type_id" id="customer_bin_type_id">
                    <input type="hidden" name="customer_id" id="customer_id" value="1">
                    <input type="hidden" name="type" id="type" value="customer">
                    <input type="hidden" name="entered_by_id" id="entered_by_id" value="{{ auth()->user()->id }}">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="label" class="form-label">Label</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="label" name="label" placeholder="Enter Label" value="">
                                </div>
                            </div>
                            <span class="text-danger error-text label_error"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="x" class="form-label">X</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="x" name="x" placeholder="Enter x" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="y" class="form-label">Y</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="y" name="y" placeholder="Enter y" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="z" class="form-label">Z</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="z" name="z" placeholder="Enter z" value="">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="length" class="form-label">Length</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="length" name="length" placeholder="Enter Length" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="width" class="form-label">Width</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="width" name="width" placeholder="Enter Width" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="height" class="form-label">Height</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="height" name="height" placeholder="Enter Height" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zone" class="form-label">Zone</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="zone" name="zone" placeholder="Enter Zone" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bin_type_id" class="form-label">Event Type </label>
                                <div class="col-sm-12">
                                    <select id="bin_type_id" class="form-select select2" name="bin_type_id" data-allow-clear="true">
                                        <option value="">--Select Event Type--</option>
                                        @foreach ($binTypes as $key => $bin_type)
                                            <option value="{{ $key }}">{{ $bin_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notes" class="form-label">Notes</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Enter Notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveBinTypeData" value="create">Save Bin Type</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showCustomerBinTypemodal" tabindex="-1" aria-labelledby="show-department-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-department-modal-label">Show Bin Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showCustomerBinTypeForm" name="showCustomerBinTypeForm" class="form-horizontal">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="label" class="form-label">Label</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="label" name="label" placeholder="Enter Label" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="x" class="form-label">X</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="x" name="x" placeholder="Enter x" value="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="y" class="form-label">Y</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="y" name="y" placeholder="Enter y" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="z" class="form-label">Z</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="z" name="z" placeholder="Enter z" value="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="length" class="form-label">Length</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="length" name="length" placeholder="Enter Length" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="width" class="form-label">Width</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="width" name="width" placeholder="Enter Width" value="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="height" class="form-label">Height</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="height" name="height" placeholder="Enter Height" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zone" class="form-label">Zone</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="zone" name="zone" placeholder="Enter Zone" value="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bin_type_id" class="form-label">Event Type </label>
                                <div class="col-sm-12">
                                    <select id="bin_type_id" class="form-select select2" name="bin_type_id" data-allow-clear="true" disabled>
                                        <option value="">--Select Event Type--</option>
                                        @foreach ($binTypes as $key => $bin_type)
                                            <option value="{{ $key }}">{{ $bin_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notes" class="form-label">Notes</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Enter Notes" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
