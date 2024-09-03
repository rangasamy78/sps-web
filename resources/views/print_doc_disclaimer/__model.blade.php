<div class="modal fade" id="printDocDisclaimerModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printDocDisclaimerForm" name="printDocDisclaimerForm" class="form-horizontal">
                    <input type="hidden" name="print_doc_disclaimer_id" id="print_doc_disclaimer_id">
                    <div class="form-group">
                        <label for="Title" class="col-sm-4 form-label">Title <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="">
                        </div>
                        <span class="text-danger error-text title_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-4 form-label">Select Type Category <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select class="form-select select_type_category_id select2" name="select_type_category_id" id="select_type_category_id" data-allow-clear="true">
                                <option value="">--Select Type Category Name--</option>
                                @foreach($select_type_categories as $key => $select_type_category)
                                <option value="{{ $key }}">{{ $select_type_category }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text select_type_category_id_error"></span>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-4 form-label">Select Type Sub Category <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select class="form-select select_type_sub_category_id select2" name="select_type_sub_category_id" id="select_type_sub_category_id" data-allow-clear="true">
                               
                            </select>
                            <span class="text-danger error-text select_type_sub_category_id_error"></span>
                        </div>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="policy" class="col-sm-6 form-label pb-1">Policy</label>
                        <div class="col-12">
                            <div id="descriptionEditor">&nbsp;</div>
                        </div>
                        <span class="text-danger error-text policy_error"></span>
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="policy" name="policy" rows="2" style="resize:none;display:none"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Policies And Print Forms</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showPrintDocDisclaimerModal" tabindex="-1" aria-labelledby="show-print-doc-disclaimer-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-print-doc-disclaimer-modal-label">Show Policies And Print Forms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showPrintDocDisclaimerForm" name="showPrintDocDisclaimerForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Title" class="col-sm-4 form-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-6 form-label">Select Type Category</label>
                        <div class="col-sm-12">
                            <select class="form-control select2" id="select_type_category_id" disabled name="select_type_category_id">
                            <option value="">--Select Type Category--</option>
                                @foreach($select_type_categories as $key => $select_type_category)
                                <option value="{{ $key }}">{{ $select_type_category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-6 form-label">Select Type Sub Category</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="select_type_sub_category_id" disabled name="select_type_sub_category_id">
                                <option value="">--Select Type Sub Category--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="policy" class="col-sm-6 form-label pb-1">Policy</label>
                        <div class="col-12">
                            <div id="showDescriptionEditor">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="policy" name="policy" rows="2" style="resize:none;display:none"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
