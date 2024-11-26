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
                    <input type="hidden" name="opportunity_id" id="opportunity_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Visit # <span id="opportunity_code" style="color: black; font-weight: bold;"></span></label>
                        </div>
                        <div class="col-sm-6">
                            <label >Date: <span id="dataval" style="color: black; font-weight: bold;"></span></label>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-6">
                            <label>Job Name: <span id="ship_to_job_name" style="color: black; font-weight: bold;"></span></label>
                            <label>Company Name: <span id="company_name" style="color: black; font-weight: bold;"></span></label>
                            <label>Sales Rep: <span id="primary_sales_person_name" style="color: black; font-weight: bold;"></span></label>
                            <label>Sales Rep2: <span id="secondary_sales_person_name" style="color: black; font-weight: bold;"></span></label>
                        </div>
                        <div class="col-sm-6 mt-2">
                            <label>Bill To: <span id="ship_to_address" style="color: black; font-weight: bold;"></span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="visit_printed_notes" class="col-sm-6 form-label mt-2">Printed Notes</label>
                        <div class="col-sm-12">
                            <textarea id="visit_printed_notes" name="visit_printed_notes" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="internal_notes" class="col-sm-6 form-label mt-2">Internal Notes</label>
                        <div class="col-sm-12">
                            <textarea id="internal_notes" name="internal_notes" class="form-control"></textarea>
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

