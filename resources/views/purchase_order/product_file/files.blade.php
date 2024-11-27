<div class="tab-pane" id="files" role="tabpanel">
    <form id="uploadFileForm" enctype="multipart/form-data">
        <div class="row">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">Select File</span>
                        <i class="bx bx-upload d-block d-sm-none"></i>
                        <input type="file" id="upload" class="product-file-input" hidden
                            accept="image/png, image/jpeg, application/pdf, image/jpg, image/gif, image/bmp" multiple />
                    </label>
                    <button type="submit" class="btn btn-secondary account-image-reset mb-4" data-id='' id="saveFile"
                        name="saveFile">
                        <i class="bx bx-reset d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload File</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <input type="text" class="form-control" hidden name="product_id" id="product_id" value="">
        </div>
        <table class="datatables-basic table tables-basic border-top table-striped" id="productFile">
            <thead class="table-header-bold">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="fileUploadRow">
            </tbody>
        </table>
    </form>
</div>