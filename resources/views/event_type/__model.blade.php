<div class="modal fade" id="eventTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventTypeForm" name="eventTypeForm" class="form-horizontal">
                    <input type="hidden" name="event_type_id" id="event_type_id">
                    <div class="form-group">
                        <label for="event_type_name" class="pb-1 form-label">Event Type Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="event_type_name" name="event_type_name"
                                placeholder="Enter Event Type Name" value="">
                        </div>
                        <span class="text-danger error-text event_type_name_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="event_type_code" class="pb-1 form-label">Event Type Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="event_type_code" name="event_type_code"
                                placeholder="Enter Event Type Code" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="event_category_id" class="pb-1 form-label">Event Category <sup style="color:red; font-size: 0.9rem;"><strong>*</strong> </label>
                        <div class="col-sm-12">
                            <select id="event_category_id" class="form-select select2" name="event_category_id" data-allow-clear="true">
                                <option value="">Select Event Category</option>
                            @foreach($eventCategories as $key => $eventCategory)
                                <option value="{{ $key }}">{{ $eventCategory }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text event_category_id_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Event Type</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showEventTypeModal" tabindex="-1" aria-labelledby="show-event-type-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-event-type-modal-label">Show Event Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showEventTypeForm" name="showEventTypeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label">Event Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="event_type_name" name="event_type_name"
                                value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="event_type_code" class="form-label">Event Type Code </label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="event_type_code" name="event_type_code"
                                value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="event_category_id" class="form-label">Event Category </label>
                        <div class="col-sm-12">
                            <select disabled id="event_category_id" class="form-select" name="event_category_id">
                                @foreach($eventCategories as $key => $eventCategory)
                                <option value="{{ $key }}">{{ $eventCategory }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
