<div class="tab-pane fade show" id="files" role="tabpanel">
    <h5>Add File</h5>
    <table class="datatables-basic table table-striped" id="prePurchaseRequestFile">
        <thead class="table-header-bold">
            <tr>
                <th>Sl.No</th>
                <th>Image</th>
                <th>Title</th>
                <th>Notes</th>
                <th>User Name</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="prePurchaseRequestFileModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="prePurchaseRequestFileModelForm" name="prePurchaseRequestFileModelForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="pre_purchase_request_file_id" id="pre_purchase_request_file_id">
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="pre_purchase_request_id" id="pre_purchase_request_id" value="{{ $pre_purchase_request->id }}">
                    <div class="row mb-2">
                        <div class="col-md-12" id="image">
                            <div class="form-group">
                                <label for="image" class="form-label">Files <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" id="images" name="images[]" placeholder="Select Image" multiple>
                                </div>
                                <span class="text-danger error-text images_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12" id="note" style="display: none;">
                            <div class="form-group">
                                <label for="notes" class="form-label">Notes</label>
                                <div class="col-sm-12">
                                    <textarea name="notes" class="form-control" id="notes" cols="50" rows="2"></textarea>
                                </div>
                            </div>
                            <span class="text-danger error-text notes_error"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveFileData" value="create">Save File</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="file_popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <img src="#" class="file_modal_img" alt="Modal Image" style="width: 100%;border : 5px solid #fff;">
        </div>
    </div>
</div>
