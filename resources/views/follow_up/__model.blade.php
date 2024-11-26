<div class="modal fade" id="visitCalendarModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Visit Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="visitCalendarForm" name="visitCalendarForm" class="form-horizontal">
                    <input type="hidden" name="visit_id" id="visit_id">
                    <div class="form-group">
                        <label for="printed_notes" class="col-sm-6 form-label">Printed Notes</label>
                        <div class="col-sm-12">
                            <textarea id="printed_notes" name="printed_notes" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Changes</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

