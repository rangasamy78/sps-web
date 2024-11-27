<div class="modal fade" id="myEventModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myEventForm"  class="form-horizontal">
                    <input type="hidden" name="my_event_id" id="my_event_id">
                    <div class="form-group">
                    <label for="name" class="form-label pb-1">Event Title <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup>
                    </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="event_title" name="event_title" placeholder="Enter Event Title" value="">
                        </div>
                        <span class="text-danger error-text event_title_error"></span>
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
<div class="modal fade" id="showmyEventModal" tabindex="-1" aria-labelledby="showmyEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showMyEventModalLabel">Show My Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showMyEventForm" name="showMyEventForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label pb-2">Event Title</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="event_title" name="event_title" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
