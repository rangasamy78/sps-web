<div class="modal fade" id="importFileTypeModal" tabindex="-1" aria-labelledby="importFileTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importFileTypeModalLabel">Import File Types</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="importFileTypeForm" name="importFileTypeForm" method="post">
                    <div class="form-group mb-3">
                    <label for="file" class="form-label">Import a file <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <input type="file" class="form-control" name="file" id="file">
                        <span class="text-danger error-text file_error"></span>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    <div id="message" class="mt-3 text-center"></div>
                </form>
            </div>
        </div>
    </div>
</div>
