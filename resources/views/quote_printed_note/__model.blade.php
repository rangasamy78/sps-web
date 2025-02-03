<div class="modal fade" id="showQuotePrintedNoteForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quotePrintedNoteForm" class="form-horizontal">
                    <input type="hidden" name="quote_printed_notes_id" id="quote_printed_notes_id">
                    <div class="form-group">
                        <label for="name" class="form-label pb-1">Quote Printed Note <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup>
                        </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="quote_printed_notes_name" name="quote_printed_notes_name" placeholder="Enter Quote Printed Note Name" value="">
                        </div>
                        <span class="text-danger error-text quote_printed_notes_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" name="savedata" value="Save">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showQuotePrintedNoteModal" tabindex="-1" aria-labelledby="showQuoteHeaderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showQuoteHeaderModalLabel">Show Quote Printed Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showQuotePrintedNoteForm" name="showQuotePrintedNoteForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label pb-2">Quote Printed Note Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="quote_printed_notes_name" name="quote_printed_notes_name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>