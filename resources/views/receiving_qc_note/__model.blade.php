<div class="modal fade" id="receivingQcNoteModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="receivingQcNoteForm" name="receivingQcNoteForm" class="form-horizontal">
                    <input type="hidden" name="code_id" id="code_id">
                    <div class="form-group">
                        <label for="code" class="col-sm-4 form-label">Code <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code" value="">
                        </div>
                        <span class="text-danger error-text code_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="notes" class="col-sm-4 form-label">Notes <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="notes" name="notes" placeholder="Enter Notes" value="">
                        </div>
                        <span class="text-danger error-text notes_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Receiving Qc Note</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showReceivingQcNoteModal" tabindex="-1" aria-labelledby="show-receiving-qc-note-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-receiving-qc-note-modal-label">Show Receiving Qc Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showReceivingQcNoteForm" name="showReceivingQcNoteForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="code" class="col-sm-4 form-label">Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="code" name="code" disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="notes" class="col-sm-4 form-label">Notes</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="notes" name="notes" disabled value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




