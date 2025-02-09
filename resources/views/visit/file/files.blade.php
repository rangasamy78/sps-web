<div class="tab-pane" id="file" role="tabpanel">
    <h5 class="">Files</h5>
    <form id="uploadvisitFileForm" enctype="multipart/form-data">
        <div class="row">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">Select File</span>
                        <i class="bx bx-upload d-block d-sm-none"></i>
                        <input
                            type="file"
                            id="upload"
                            class="account-file-input"
                            hidden
                            accept="image/png, image/jpeg, application/pdf, image/jpg, image/gif, image/bmp" multiple />
                    </label>
                    <button type="submit" class="btn btn-secondary account-image-reset mb-4" data-id='{{ $visit->id }}' id="saveFile" name="saveFile">
                        <i class="bx bx-reset d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload File</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="text" class="form-control" hidden name="visit_id" id="visit_id" value="{{ $visit->id }}">
        </div>
        <table class="datatables-basic table tables-basic border-top table-striped" id="visitFile">
            <thead class="table-header-bold">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>File Type</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="visitFileUploadRow">
            </tbody>
        </table>
    </form>
</div>